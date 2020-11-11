<template>
  <tr>
    <td>
      <uuid :micro-service-uuid="entry['uuid']"  ></uuid>
    </td>
    <td>
      {{ entry['created'] }}
    </td>
    <td>
      {{ entry['updated'] }}
    </td>
  </tr>
</template>

<script>
import _ from "lodash";
import Uuid from "./Uuid";

export default {
  components: {Uuid},
  props: {
    entry: Object,
  },
  methods: {
    createId(field) {
      const separator = "_";
      return this.uuid + separator + field;
    },
    deploy: function () {
      this.axios.post(`http://${this.$BASE_HOST}/deploy`, this.entry['uuid']).then(
          x =>  {
            console.log(x.data);
          }
      );
    },
    deleteService: function () {
      // let that =this;
      // this.axios.post(
      //     `http://${this.$BASE_HOST}/delete/${uuid}`,
      //     JSON.stringify(this.getRow(uuid))
      // ).then(
      //     x => {that.filteredHeroes[_.findIndex(that.filteredHeroes, function (o) {return o.uuid === uuid})].test = x.data}
      // );
    }
  },
}
</script>

<style scoped>
body {
  font-family: 'Lato', sans-serif;
}
label {
  display: block;
  margin-top: 12px;
  font-family: 'Lato', sans-serif;
  font-weight: bold;
}

fieldset {
  padding: 5px 10px;
  border-color: #f9f9f9;
  border-width: 1px;
}

legend {
  font-family: 'Lato', sans-serif;
  padding: 0 5px;
}

fieldset > button {
  display: block;
  margin: 10px 0;
}

body {
  margin: 20px;
}

.something {
  height: 200px;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
  width: 400px;
}

.arrow-right {
  background-color: #444;
  box-shadow: 0 0 3px 2px rgba(0, 0, 0, 0.8);
  height: 100px;
  left: -50px;
  position: absolute;
  top: -50px;
  width: 100px;

  -webkit-transform: rotate(-45deg);
}

/*.arrow-right {
  width: 0;
  height: 0;
  border-bottom: 80px solid transparent;

  border-left: 80px solid #444;
  margin-left: 0;
  position: absolute;
  top: 0;
}*/

/*.arrow-right::after {
  background-color: transparent;
  box-shadow: 0 6px 6px 1px black;
  content: "";
  display: block;
  height: 0px;
  left: -102px;
  position: absolute;
  top: 39px;
  width: 115px;


  -webkit-transform: rotate(-45deg);
}*/

.arrow-right span {
  color: #f5f5f5;
  font-family: sans-serif;
  font-size: 1.005em;
  left: 28px;
  top: 78px;
  position: absolute;
  width: 80px;
}
</style>
