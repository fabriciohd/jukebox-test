<template>
    <v-dialog v-model="dialog" width="500">
        <v-card>
            <v-card-title style="background-color: var(--primary);color: #fdfdfd">Adicionar Tarefa</v-card-title>
            <v-card-text class="my-5">
                <ErrorList v-if="errors" :errors="errors"/>
                <v-row>
                    <v-col>
                        <v-text-field
                            label="Título"
                            outlined
                            v-model="form.title"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="md-8">
                        <v-text-field
                            type="date"
                            label="Data"
                            outlined
                            v-model="form.date"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            type="time"
                            label="Hora"
                            outlined
                            v-model="form.time"
                            clearable
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-textarea
                            label="Descrição"
                            outlined
                            v-model="form.description"
                        ></v-textarea>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text @click="dialog = false">Cancelar</v-btn>
                <v-btn dark color="primary" @click="confirm">Cadastrar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import taskApi from "@api/task";
import ErrorList from "@components/ErrorList"

export default {
    components: {
		ErrorList,
	},
    data () {
        return {
            form: {},
            dialog: false,
            errors: null,
        }
    },
    methods:{
        show(date, title) {
            this.form.date = date;
            this.form.title = title;
            this.dialog = true;
        },
        confirm(){
            this.errors = null;
            taskApi.insert(this.form).then(() => {
                this.$emit('confirm', this.form);
                this.dialog = false;
            }).catch(errors => {
                if(errors.response.status === 422){
                    this.errors = errors.response.data.errors;
                }
            })
        },
    },
};
</script>
