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
            <tr class="clickable-row" v-for="debate in debates" @click="showQuestion(debate.id)">
                <td>
                    {{ debate.question.text }}
                </td>
                <td>
                    {{ debate.question.author.first_name }} {{ debate.question.author.last_name }}
                </td>
                <td>
                    {{ debate.question.category.name }}
                </td>
                <td>
                    {{ debate.created_at | formatDate }} 
                </td>
                <td>
                    {{ debate.ends_at | formatDate }}
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
                debates: this.data,
                order: ['asc'],
                columns: [
                    { name: 'Debate Question', data: 'question.text', active: false },
                    { name: 'Author', data: 'question.author.first_name', active: false },
                    { name: 'Category', data: 'question.category.name', active: false },
                    { name: 'Starts at', data: 'starts_at', active: false  },
                    { name: 'Ends at', data: 'ends_at', active: false },
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
