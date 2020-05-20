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
        <tr v-for="entry in filteredHeroes">
            <td v-for="key in columns">
                <span v-if="key !== 'progress'">{{entry[key]}}</span>
                <span v-if="key === 'progress'">
                    <button v-if="entry['init']||entry['progress']=== entry['max']" @click="deploy(entry['index'])">{{buttonText(entry['progress'],entry['max'])}}</button>
                    <progress v-else-if="entry['progress']!== entry['max']" :value="entry['progress']" :max="entry['max']"></progress>

                    <button @click="test(entry['index'])">Test</button>
                </span>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Grid",
        props: {
            heroes: Array,
            columns: Array,
            filterKey: String,
        },
        data: function () {
            const sortOrders = {};
            this.columns.forEach(function (key) {
                sortOrders[key] = 1
            });
            return {
                sortKey: '',
                sortOrders: sortOrders
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
            deploy: function (hash) {
                const url = `http://${this.$BASE_HOST}/deploy/`;
                this.axios.post(`http://${this.$BASE_HOST}/deploy`, hash).then(
                    x =>  {
                        console.log(x.data);
                    }
                );
            },
            test: function(targetDir){
                const url = `http://${this.$BASE_HOST}/test/`;
                this.axios.get(url + targetDir).then(x => x.data);
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
