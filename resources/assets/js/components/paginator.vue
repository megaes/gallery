<template>
    <nav v-show="(pageCount > 1)" aria-label="Page navigation">
        <ul class="pagination">
            <li @click.prevent="onClick(0)" :class="{'disabled': (activePage == 1)}">
                <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="index in pageCount" @click.prevent="onClick(index)" :class="{'active': (activePage == index)}"><a href="#"> {{ index }}</a></li>
            <li @click.prevent="onClick(pageCount + 1)" :class="{'disabled': (activePage == pageCount)}">
                <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    import { event } from '../app.js';

    export default {
        data() {
            return {
                pageCount: 1,
                activePage: 1,
            }
        },
        computed: {
        },
        created() {
            event.$on('turnThePage', page => {
                this.activePage = page;
            });
            event.$on('setPageCount', pageCount => {
                this.activePage = Math.min(this.activePage, pageCount);
                this.pageCount = pageCount;
            });
        },
        methods: {
            onClick(clickedPage) {
                if(clickedPage == 0) {
                    clickedPage = this.activePage - 1;
                } else if(clickedPage == this.pageCount + 1) {
                    clickedPage = this.activePage + 1;
                }

                if((this.activePage == clickedPage) || (clickedPage == 0) || (clickedPage == this.pageCount + 1)) {
                    return;
                }

                event.$emit('turnThePage', clickedPage);
            }
        }
    }
</script>
