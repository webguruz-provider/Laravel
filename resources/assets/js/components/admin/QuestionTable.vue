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
            <tr class="clickable-row" v-for="question in questions" @click="showQuestion(question.id)">
                <td>
                    {{ question.text }}
                </td>
                <td>
                    {{ question.author.name }}
                </td>
                <td>
                    {{ question.category.name }}
                </td>
                <td class="admin-table__large-cell">
                    12
                </td>
                <td class="admin-table__large-cell">
                    120
                </td>
                <td>
                    in 10 Days
                    <!--{{ question.expire_at | formatDate }}-->
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
                questions: this.data,
                order: ['asc'],
                columns: [
                    { name: 'Question', data: 'text', active: false },
                    { name: 'Author', data: 'author.first_name', active: false },
                    { name: 'Category', data: 'category.name', active: false },
                    { name: 'Impressions', data: 'publish_at', active: false  },
                    { name: 'Engagement', data: 'publish_at', active: false  },
                    { name: 'Expires', data: 'expires_at', active: false },
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
                this.questions = _.orderBy(this.questions, [column.data], this.order);
                this.columns.forEach(function(column){
                    column.active = false;
                });
                column.active = true;
            },
            showQuestion: function(id) {
                window.location.href =  id;
            }
        }
    }
</script>
