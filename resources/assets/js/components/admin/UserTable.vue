<template>
    <table class="admin-content__table">
        <thead>
            <tr>
                <th v-for="column in columns" @click="sortBy(column)" :class="{'is-active': column.active}">
                        {{ column.name }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="clickable-row" v-for="user in users" @click="showQuestion(user.id)">
                <td>
                    {{ user.handle }}
                </td>
                <td>
                    {{ user.first_name }} {{ user.last_name }}
                </td>
                <td>
                    {{ user.name }}
                </td>
                <td>
                    {{ user.name }} 
                </td>
                <td>
                    {{ user.name }}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['data'],
        data: function() {
            return {
                users: this.data,
                order: ['asc'],
                columns: [
                    { name: 'User', data: 'user.handle', active: false },
                    { name: 'First Name', data: 'user.name', active: false },
                    { name: 'Last Name', data: 'user.name', active: false },
                    { name: 'Location', data: 'user.name', active: false  },
                    { name: 'Interests', data: 'user.name', active: false },
                ]
            }
        },
        filters: {
            formatDate: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY')
                }
            }
        },
        methods: {
            sortBy: function(column) {
                if (column.active) {
                    this.order = (this.order == ["asc"]["0"]) ? ["desc"] : ["asc"]
                }
                this.debates = _.orderBy(this.debates, [column.data], this.order);
                this.columns.forEach(function(column){
                    column.active = false;
                });
                column.active = true;
            },
            showQuestion: function(id) {
                window.location.href = '../debates/' + id;
            }
        }
    }
</script>
