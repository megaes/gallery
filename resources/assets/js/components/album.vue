<style lang="scss">
    #album {
        input {
            background-color: transparent;
            border: none;
            outline: none;
            text-align: center;
            width: 98%;
        }
    }
</style>

<template>
    <div id="album">
        <input type="text" maxlength="50" class="h1" v-model="name" v-show="visibility" @keydown.prevent.enter="update"></input>
    </div>
</template>

<script>
    import { event } from '../app.js';

    export default {
        data() {
            return {
                name: '',
                visibility: false
            }
        },
        mounted() {
            event.$on('setAlbumName', name => { this.name = name; this.visibility = !(!name); });
        },
        methods: {
            update() {
                event.$emit('updateAlbumName', this.name);
            }
        }
    }
</script>
