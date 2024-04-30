<template>
    <v-alert type="error" class="my-2 mx-4">
        <ul class="px-0">
            <li v-for="(error, i) in errors">
                <ul class="px-0">
                    <li v-for="msg in error">{{ msg }}</li>
                </ul>
            </li>
        </ul>
    </v-alert>
</template>

<script>
module.exports = {
    props: ['errors']
};
</script>

<style>
    ul{
        list-style: none;
    }
</style>
