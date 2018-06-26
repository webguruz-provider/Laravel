<template>
    <section class="onboarding-categories u-container">
        <div class="onboarding-category"  v-for="category in categories" :style="{ backgroundImage: 'url(' + category.image_url + ')' }" @click="toggleClass(category)" :class="{'is-selected': isSelected}">
            <span class="onboarding-category__name">
                {{ category.name }}
            </span>
            <div class="onboading-category__screen"></div>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['categories'],
        data() {
            return {
                isSelected: false
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
            toggleClass(category) {
                category.isSelected = true;
            }
        }
    }
</script>
