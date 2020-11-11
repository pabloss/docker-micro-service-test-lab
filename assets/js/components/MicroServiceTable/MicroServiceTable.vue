<template>
    <table>
        <thead>
        <tr>
            <th v-for="key in columns"
                @click="sortBy(key)"
                :class="{ active: sortKey == key }">
                {{ key | capitalize }}
                <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'">
          </span>
            </th>
        </tr>
        </thead>
        <tbody>
          <Row v-for="entry in filteredHeroes" :entry="entry" v-bind:key="entry.uuid" ></Row>
        </tbody>
    </table>
</template>

<script>
    import _ from "lodash";
    import Row from "./Row";
    export default {
      name: "micro-service-table",
      components: {Row},
      props: {
            testData: Array,
            heroes: Array,
            columns: Array,
            filterKey: String,
            uuid: String,
        },
        watch: {
            // whenever question changes, this function will run
            testData: function (newQuestion, oldQuestion) {
                let that = this;
                const filteredTestData = _.find(this.testData, function(row) { return row['headers'] ===that.uuid});
                const filteredGridData = _.find(this.filteredHeroes, function(row) { return row['uuid'] === that.uuid});
                if(
                    filteredTestData && filteredGridData &&
                    filteredTestData['request'] === filteredGridData['test']
                ){
                    console.log('Passed!')
                } else if (
                    filteredTestData && filteredGridData &&
                    filteredTestData['request'] !== filteredGridData['test']
                ) {
                    console.log('Failed!!')
                }
            }
        },
        data: function () {
            const sortOrders = {};
            this.columns.forEach(function (key) {
                sortOrders[key] = 1
            });
            return {
                sortKey: '',
                sortOrders: sortOrders,
                testResult: {},
            }
        },
        computed: {
            filteredHeroes: function () {
                const sortKey = this.sortKey;
                const filterKey = this.filterKey && this.filterKey.toLowerCase();
                const order = this.sortOrders[sortKey] || 1;
                let heroes = this.heroes;
                if (filterKey) {
                    heroes = heroes.filter(function (row) {
                        return Object.keys(row).some(function (key) {
                            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                        })
                    })
                }
                if (sortKey) {
                    heroes = heroes.slice().sort(function (a, b) {
                        a = a[sortKey];
                        b = b[sortKey];
                        return (a === b ? 0 : a > b ? 1 : -1) * order
                    })
                }
                return heroes
            }
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        methods: {
            sortBy: function (key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1
            },
            buttonText: function(progress,max){
                if(this.error) {
                    return 'Error!';
                } else if(progress === max){
                    return 'Deployed!';
                } else {
                    return 'Deploy';
                }
            },
        }
    }
</script>

<style scoped>
    body {
        font-family: Helvetica Neue, Arial, sans-serif;
        font-size: 14px;
        color: #444;
    }

    table {
        border: 2px solid #42b983;
        border-radius: 3px;
        background-color: #fff;
    }

    th {
        background-color: #42b983;
        color: rgba(255, 255, 255, 0.66);
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    td {
        background-color: #f9f9f9;
    }

    th, td {
        min-width: 120px;
        padding: 10px 20px;
    }

    th.active {
        color: #fff;
    }

    th.active .arrow {
        opacity: 1;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: 0.66;
    }

    .arrow.asc {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-bottom: 4px solid #fff;
    }

    .arrow.dsc {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #fff;
    }
</style>
