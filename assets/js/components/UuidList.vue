<template>
  <div>
    <label :for="createId('select_uuid')">UUID list</label>
    <select name="uuid-list" v-model="selectedUuid" :id="createId('select_uuid')">
      <option v-for="uuidItem in uuidList" :value="uuidItem">{{ uuidItem }}</option>
    </select>
    <button @click="save()">Save Connection</button>
  </div>
</template>

<script>
export default {
  name: "UuidList",
  props: {
    uuid: String,
  },
  data(){
    return {
      uuidList: [],
      selectedUuid: '',
    }
  },
  created() {
      this.axios.get(`http://${this.$BASE_HOST}/get-all-uuids/`)
        .then(
            x => {
              this.uuidList = x.data;
            }
        )
      ;
  },
  methods: {
    createId(field) {
      const separator = "_";
      return this.uuid + separator + field;
    },
    save() {
        this.axios.get(`http://${this.$BASE_HOST}/connect/${this.uuid}/${this.selectedUuid}`);
    },
  },
}
</script>

<style scoped>

</style>
