<template>
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
</template>

<script>
import SortHeader from "../BaseComponents/SortHeader";
import RowContainer from "./RowContainer";
import DraggableUuid from "./Elements/DraggableUuid";
import DeployButton from "./Elements/DeployButton";

export default {
    components: {SortHeader, RowContainer, DeployButton, DraggableUuid},
    props: {
        gridData: Array,
        columns: Array,
        filterKey: String,
        uuid: String,
    },
    data() {
        const sortOrders = {};
        this.columns.forEach(function (key) {
            sortOrders[key] = 1
        });
        return {
            sortKey: '',
            sortOrders: sortOrders,
        }
    },
    computed: {
        filteredTableRows: function () {
            const sortKey = this.sortKey;
            const filterKey = this.filterKey && this.filterKey.toLowerCase();
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
        handleSort(sort) {
            this.sortKey = sort.key;
            this.sortOrders = sort.orders;
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
