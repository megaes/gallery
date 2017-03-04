<template>
    <div id="gallery">
        <div v-for = "frame in frames" class="grid-item col-xs-6 col-sm-4 col-md-3 col-lg-2">

            <img class="lazyload" :data-src="path + frame.name + '-tn.jpg'" :data-original="path + frame.name + '.jpg'"> </img>

            <div class="demo-gallery-poster">
                <i class="glyphicon glyphicon-search"></i>
            </div>

            <div class="caption" style="display:none">
                <p>{{ frame.caption }}</p>
            </div>

            <div :style="'padding-top: ' + frame.tn_aspect_ratio + '%'"></div>

        </div>
    </div>
</template>

<script>
    import { eventBus } from '../app.js';

    export default {
        props: ['path', 'data'],
        data() {
            return {
                frames: JSON.parse(this.data),
                isotope: null
            };
        },
        mounted() {
            eventBus.$on('page-turn', (page) => {
                var min = (page - 1)*150;
                var max = page * 150;
                var counter = 0;
                this.isotope.arrange({
                    filter: function() {
                        var result = (counter++ >= min) && (counter < max);
                        return result;
                    }
                });
            });

            var gallery = document.getElementById('gallery');

            this.isotope = new Isotope( gallery, {
                itemSelector: '.grid-item',
                layoutMode: 'masonry',
                percentPosition: true
            });

            var counter = 0;
            this.isotope.arrange({
                filter: function() {
                    return (counter++ >= 0) && (counter < 150);
                }
            });

            eventBus.$emit('pageCount-change', 7);

            lazySizes.init();

        },
        created() {
        },
        methods: {
        }
    }
</script>
