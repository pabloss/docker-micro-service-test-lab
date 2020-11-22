<template>
    <div id="micro-service-table" style="clear: both;">
        <form id="search">
            <label for="query">Search</label>
            <input id="query" v-model="searchQuery" name="query">
        </form>
        <table>
            <thead>
            <SortHeader :columns="columns" @sort-by="handleSort"/>
            </thead>
            <tbody>
            <RowContainer v-for="row in filteredTableRows" :key="row.uuid">
                <template v-slot:microservice-cell>
                    <DraggableUuid :uuid="row['uuid']"/>
                    <DeployButton :uuid="row['uuid']"/>
                </template>
                <template v-slot:created>
                    {{ row['created'] }}
                </template>
                <template v-slot:updated>
                    {{ row['updated'] }}
                </template>
            </RowContainer>
            </tbody>
        </table>

    </div>

</template>

<script>
import SortHeader from "../BaseComponents/SortHeader";
import RowContainer from "./RowContainer";
import DraggableUuid from "./Elements/DraggableUuid";
import DeployButton from "./Elements/DeployButton";
import _ from "lodash";

export default {
    components: {SortHeader, RowContainer, DeployButton, DraggableUuid},
    data() {
        return {
            sortKey: '',
            sortOrders: [],
            searchQuery: '',
            columns: [this.Constants.UUID, this.Constants.CREATED, this.Constants.UPDATED],
            gridData: [],
            uuid: '',
        }
    },
    created() {
        console.log(this);
    },
    mounted() {
        const sortOrders = {};
        this.columns.forEach(function (key) {
            sortOrders[key] = 1
        });
        const url = `http://${this.Constants.BASE_HOST}/api/get-grid-content/`;
        this.axios.get(url).then(
                x => {
                    x.data.forEach((row) => {
                        this.insertRow(row);
                    });
                    console.log(x.data);
                }
        );
    },
    computed: {
        filteredTableRows: function () {
            const sortKey = this.sortKey;
            // const filterKey = this.filterKey && this.filterKey.toLowerCase();
            const filterKey = '';
            const order = this.sortOrders[sortKey] || 1;
            let heroes = this.gridData;
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
    methods: {
        init: function (data) {
            data[this.Constants.INIT_KEY] = true;
            data[this.Constants.PROGRESS_KEY] = 0;
            data[this.Constants.MAX_KEY] = 20;
            data[this.Constants.TEST_KEY] = '';
            return data;
        },
        handleSort(sort) {
            this.sortKey = sort.key;
            this.sortOrders = sort.orders;
        },
        insertRow: function (data) {
            if (!_.find(this.gridData, (row) => {
                return row[this.Constants.INDEX_KEY] === data[this.Constants.INDEX_KEY]
            })) {
                this.gridData.push(this.init(data));
            }
        },
        deleteRow: function (uuid) {
            console.log(uuid);
            _.remove(this.gridData, (o) => {
                        console.log(o.uuid === uuid);
                        return o.uuid === uuid
                    }
            );
        },
        updateRow: function (data) {
            this.gridData = _.map(this.gridData, (row) => {
                if (row[this.Constants.INDEX_KEY] === data[this.Constants.INDEX_KEY]) {
                    if (data.log && row.init) {
                        row[this.Constants.INIT_KEY] = false;
                    }
                    return _.merge(row, data);
                } else {
                    return row;
                }
            });
        },
    }
}
</script>

<style scoped>
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
