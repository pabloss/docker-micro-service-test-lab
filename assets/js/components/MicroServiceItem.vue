<template>
  <tr>
    <td v-for="key in columns">
      <div v-if="key !== 'progress' && key !== 'updated'">{{ entry[key] }}</div>
      <div v-if="key !== 'progress' && key === 'updated'">
        {{ entry[key] }}
        <div>
          <button @click="deleteService()">Remove</button>
        </div>
      </div>
      <div v-if="key === 'connect_with'">
        <uuid-list :uuid="uuid"></uuid-list>
      </div>
      <fieldset v-if="key === 'progress'">
        <legend>Test</legend>
        <fieldset>

          <legend>Request</legend>
          <label :for="createId('script')">
            Script:
          </label>
          <input name="script" :id="createId('script')" v-model="script">

          <label :for="createId('url')">
            Url:
          </label>
          <input name="url" :id="createId('url')" v-model="url">

          <label :for="createId('body')">
            Body:
          </label>
          <input name="body" :id="createId('body')" v-model="body">

          <label :for="createId('header')">
            Header:
          </label>
          <button @click="header = uuid">Copy uuid</button>
          <input name="header" :id="createId('header')" v-model="header">

        </fieldset>

        <label :for="createId('requested_body')">
          Requested body:
        </label>
        <input name="requested_body" :id="createId('requested_body')" v-model="requested_body">
        <button @click="save()">Save</button>
        <button @click="testMicroService()">Test</button>
        {{ test }}
      </fieldset>
    </td>
  </tr>
</template>

<script>
import _ from "lodash";
import UuidList from "./UuidList";

export default {
  name: "MicroServiceItem",
  components: {UuidList},
  props: {
    columns: Array,
    entry: Object,
  },
  data() {
    return {
      uuid: this.entry['uuid'],
      url: this.entry['url'],
      body:  this.entry['body'],
      header: this.entry['header'],
      requested_body: this.entry['requested_body'],
      script: this.entry['script'],
      test: '',
    }
  },
  methods: {
    createId(field) {
      const separator = "_";
      return this.uuid + separator + field;
    },
    deploy: function () {
      this.axios.post(`http://${this.$BASE_HOST}/deploy`, this.uuid).then(
          x =>  {
            console.log(x.data);
          }
      );
    },
    testMicroService: function () {
      this.axios.post(
          `http://${this.$BASE_HOST}/test`,
          JSON.stringify(
              {
                uuid: this.uuid,
                script: this.script,
                url: this.url,
                body: this.body,
                header: this.header,
                requested_body: this.requested_body,
              }
          )
      ).then(
          x => {
            this.test = x.data
          }
      );
    },
    save: function () {
      this.axios.post(
          `http://${this.$BASE_HOST}/save-test/${this.uuid}`,
          JSON.stringify(
              {
                uuid: this.uuid,
                script: this.script,
                url: this.url,
                body: this.body,
                header: this.header,
                requested_body: this.requested_body,
              }
          ),
          {
            headers: {'Content-Type': 'application/json'}
          }
      ).then(x => {
        // x.data
        console.log(this.testData);
      });
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
