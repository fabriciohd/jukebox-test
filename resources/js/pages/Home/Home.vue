<template>
	<div class="pa-10">
		<AddTaskModal ref="addTaskModal" @confirm="getDataFromApi" />
		<InfoTaskModal ref="infoTaskModal" />
		<v-row>
			<v-col>
				<v-text-field
					v-model="taskName"
					label="Adicionar uma tarefa"
					placeholder="Adicionar uma tarefa..."
					outlined
					append-icon="mdi-plus-thick"
					@click:append="addTask"
				></v-text-field>
			</v-col>
		</v-row>
		<v-row v-for="task in taskList" :key="task.id" class="my-0">
			<v-col class="py-0">
				<div class="taskitem d-flex align-center px-5">
					<v-checkbox
						@change="completeTask(task)"
					></v-checkbox>
					<div class="contenttaskitem d-flex justify-space-between align-center">
						<div class="itemtitle" @click="getInfo(task)">{{task.title}}</div>
						<div>
							{{getFormattedDate(task.date)}} {{task.time ? '| '+getFormattedTime(task.time) : ''}}
							<v-icon @click="cancelTask(task)" color="rgb(255, 103, 103)">mdi-delete-empty</v-icon>
						</div>
					</div>
				</div>
			</v-col>
		</v-row>

		<v-row v-for="task in taskListDone" :key="task.id" class="my-0 pt-8">
			<v-col class="py-0">
				<div class="taskitem d-flex align-center px-5"
					style="background-color: rgb(117, 107, 255);color:white">
					<v-checkbox
						v-model="task.status"
						@change="undoTask(task)"
						color="white"
					></v-checkbox>
					<div class="contenttaskitem d-flex justify-space-between align-center">
						<div class="itemtitle" @click="getInfo(task)">{{task.title}}</div>
						<div>{{getFormattedDate(task.date)}} {{task.time ? '| '+getFormattedTime(task.time) : ''}}</div>
					</div>
				</div>
			</v-col>
		</v-row>

		<v-row v-for="task in taskListCanceled" :key="task.id" class="my-0 pt-8">
			<v-col class="py-0">
				<div class="taskitem d-flex align-center px-5"
					style="background-color: rgb(255, 103, 103);color:white">
					<div class="contenttaskitem d-flex justify-space-between align-center">
						<div class="itemtitle" @click="getInfo(task)">{{task.title}}</div>
						<div>{{getFormattedDate(task.date)}} {{task.time ? '| '+getFormattedTime(task.time) : ''}}</div>
					</div>
				</div>
			</v-col>
		</v-row>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';
import AddTaskModal from "@components/AddTaskModal"
import InfoTaskModal from "@components/InfoTaskModal"
import taskApi from "@api/task";

export default {
	components: {
		AddTaskModal,
		InfoTaskModal,
	},
	data() {
		return {
			taskName: '',
			taskList: [],
			taskListDone: [],
			taskListCanceled: [],
			atualDate: new Date().toISOString().slice(0,10),
		}
	},
	computed: {
		...mapGetters(["getSelectedDate"]),
		selectedDate: {
            get() {
                return this.getSelectedDate;
            },
            set(newValue) {
                this.$store.commit('setSelectedDate', newValue);
            }
        },
	},
	watch: {
		selectedDate() {
			this.getDataFromApi();
		}
	},
	methods: {
		getFormattedDate(date) {
			if (date == this.atualDate) {
				return 'Hoje'
			}
			return date.split('-').reverse().join('/');
		},
		getFormattedTime(time) {
			return time.split(':').slice(0, 2).join(':');
		},
		addTask() {
			this.$refs['addTaskModal'].show(this.selectedDate, this.taskName);
		},
		getDataFromApi() {
			this.taskName = '';
			taskApi.list({
				itemsPerPage: -1,
				date: this.selectedDate
			}).then(result => {
				this.taskList = result.data.data.filter(item => item.status == 1);
				this.taskListDone = result.data.data.filter(item => item.status == 2);
				this.taskListCanceled = result.data.data.filter(item => item.status == 3);
			})
		},
		getInfo(task) {
			this.$refs['infoTaskModal'].show(task);
		},
		completeTask(task) {
			taskApi.update({
				status: 2,
			}, task.id).then(() => {
				this.getDataFromApi();
			})
		},
		undoTask(task) {
			taskApi.update({
				status: 1,
			}, task.id).then(() => {
				this.getDataFromApi();
			})
		},
		cancelTask(task) {
			taskApi.update({
				status: 3,
			}, task.id).then(() => {
				this.getDataFromApi();
			})
		},
	},
	mounted() {
		this.getDataFromApi();
	}
}
</script>

<style scoped>
.contenttaskitem {
	width: 100%;
}
.taskitem {
	background-color: rgb(255, 255, 255);
	border: 1px solid rgb(211, 211, 211);
	border-radius: 5px;
	height: 69px;
}
.taskitem .itemtitle {
	cursor: pointer;
}
</style>