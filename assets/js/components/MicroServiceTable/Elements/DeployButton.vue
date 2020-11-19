<template>
    <button @click="deploy">Deploy</button>
</template>

<script>
export default {
    props: {
        uuid: String,
    },
    methods: {
        deploy: function () {
            this.axios.post(`http://${this.$BASE_HOST}/deploy`, this.uuid).then(
                    x => {
                        console.log(x.data);
                    }
            );
        },
    },
}
</script>

<style scoped>

</style>
