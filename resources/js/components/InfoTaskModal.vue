<template>
    <v-dialog v-model="dialog" width="500">
        <v-card>
            <v-card-title style="background-color: var(--primary);color: #fdfdfd">Descrição da Tarefa</v-card-title>
            <v-card-text class="my-5">
                <b>Título: </b>{{ info.title }}<br>
                <b>Descrição: </b><br>{{ info.description }}<br>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text @click="dialog = false">Confirmar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

export default {
    data () {
        return {
            info: {},
            dialog: false,
        }
    },
    methods:{
        show(info) {
            this.info = info;
            this.dialog = true;
        },
    },
};
</script>
