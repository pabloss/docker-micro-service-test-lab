<template>
  <div class="test-definition">
    <form >
      <div class="container">
        <RequestContainer :request="setRequest" :uuid="uuid" :legend="'Set Request'" :disabled="null"></RequestContainer>
        <RequestContainer :request="expectedRequest" :uuid="uuid" :legend="'Expected Request'" :disabled="'disabled'"></RequestContainer>
      </div>
      <button v-on:click.stop.prevent="save()" id="save-test">Save Test</button>
      <input type="submit" name="Test" value="Test" @click.prevent.stop="test()" :class="testResult" />
    </form>
  </div>
</template>

<script>
import RequestContainer from "../Requests/RequestContainer";
export default {
  components: {RequestContainer},
  data() {
    return {
      setRequest: {
        url: '',
        script: '',
        header: '',
        body: '',
      },
      expectedRequest: {
        url: '',
        script: '',
        header: '',
        body: '',
      },
      testResult: '',
    };
  },
  props: {
    uuid: String,
  },
  created() {
    this.axios.get(`http://${this.$BASE_HOST}/api/test-definition/${this.uuid}`).then(
        x =>  {
          this.setRequest.body = x.data.body;
          this.setRequest.url = x.data.url;
          this.setRequest.header = x.data.header;
          this.setRequest.script = x.data.script;

          this.expectedRequest.body = x.data.requested_body;
        }
    );
  },
  methods: {
    save: function () {
      this.axios.post(
          `http://${this.$BASE_HOST}/save-test/${this.uuid}`,
          JSON.stringify(
              {
                uuid: this.uuid,
                script: this.setRequest.script,
                url: this.setRequest.url,
                body: this.setRequest.body,
                header: this.setRequest.header,
                requested_body: this.expectedRequest.body,
              }
          ),
          {
            headers: {'Content-Type': 'application/json'}
          }
      ).then(x => {
        // x.data
        console.log(x.data);
      });
    },
    test: function () {
      this.axios.post(
          `http://${this.$BASE_HOST}/test`,
          JSON.stringify(
              {
                uuid: this.uuid,
                script: this.setRequest.script,
                url: this.setRequest.url,
                body: this.setRequest.body,
                header: this.setRequest.header,
                requested_body: this.expectedRequest.body,
              }
          ),
          {
            headers: {'Content-Type': 'application/json'}
          }
      ).then(x => {
        // x.data
        this.testResult = x.data.toString().toLowerCase();
      });
    },
  },
}
</script>

<style scoped>
.test-definition {
  z-index: 999;
}
input[name="Test"], button#save-test {
  width: 100%;
  height: 2em;
  font-size: 1.5em;
  font-weight: 900;
  letter-spacing: 0.65em;
  text-transform: uppercase;
  border-radius: 0.25em;
  color: #d8d8d8;
  border: none;
  margin-top: 0.3em;
  cursor: pointer;
}

input[name="Test"] {
  background-color: #2980b9;
}

input[name="Test"].failed {
  background-color: #f11313;
}
input[name="Test"].passed {
  background-color: #228d29;
}

button#save-test {
  background-color: black;
}
</style>
