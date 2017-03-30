<style lang="scss">
    @import "../../sass/variables";

    .gallery-frame {
        border: 2px solid $body-bg;
        overflow: hidden;
        padding: 0;
        position: relative;

        img {
            opacity: 0.0;
            position: absolute;

            width: 100%;
            height: auto;

            transition: opacity 1.0s ease 0s;
        }

        .lazyloaded {
            opacity: 1.0;
        }

        .controls {
            background-color: rgba(0, 0, 0, 0);
            bottom: 0;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: background-color 0.5s ease 0s;

            * {
                color: rgb(255, 255, 255);
                opacity: 0;
                position: absolute;
                transition: opacity 0.5s ease 0s;
            }

            textarea {
                background-color: transparent;
                resize: none;
                overflow: hidden;
                text-align: center;
                left: 2%;
                top: 40%;
                width: 96%;
                height: 58%;
            }

            i {
                cursor: default;
            }
        }

        &.active .controls {
            background-color: rgba(0, 0, 0, 0.7);

            * {
                opacity: 1.0;
            }
        }
    }
</style>

<template>
        <div class="gallery-frame col-xs-6 col-sm-4 col-md-3 col-lg-2" :class="{'active': frame.activity}" @mouseover="frame.activity |= 10" @mouseleave="frame.activity &= 101">

            <img :class="{'lazyload' : frame.load}" :data-src="path + frame.name + '-tn.jpg'"> </img>

            <div class="controls">
                <textarea maxlength="50" class="form-control" v-model="frame.caption" @click="frame.activity |= 100" @blur="frame.activity &= 11" @keydown.prevent.enter="captionUpdate"></textarea>
                <i class="fa fa-lg" :class="[(frame.activity & 1) ? 'fa-check-square-o' : 'fa-square-o']" style="left: 15%; top: 6px;" @click="frame.activity ^= 1"></i>
                <i class="fa fa-lg fa-search" style="left: 50%; top: 5px; margin-left: -0.5em" @click="$emit('showGallery')"></i>
                <i class="fa fa-lg fa-times" style="right: 15%; top: 5px;" @click="$emit('delete')"></i>
            </div>

            <div :style="'padding-top: ' + frame.tn_aspect_ratio + '%'"></div>

            <div v-if="video" style="display:none;" :id="'video' + frame.id">
                <video class="lg-video-object lg-html5" controls preload="none">
                    <source :src="path + frame.name + '.mp4'" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        </div>
</template>

<script>
    export default {
        props: ['path', 'video', 'frame'],
        methods: {
            captionUpdate() {
                axios.patch('/resources/' + this.frame.id, {
                    caption: this.frame.caption
                });
            }
        }
    }
</script>
