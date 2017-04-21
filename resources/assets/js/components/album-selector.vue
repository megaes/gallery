<template>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-lg" :class="[(type == 'photo') ? 'fa-file-image-o' : 'fa-file-video-o']" aria-hidden="true" @click.prevent.stop="type = (type == 'photo') ? 'video' : 'photo'"></i>
            Album
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="#" @click.prevent="newAlbum">New</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" @click.prevent="deleteAlbum">Delete</a></li>
            <li role="separator" class="divider"></li>
            <li v-for="album in filteredAlbums" :key="album.id"><a href="#" @click.prevent="loadAlbum(album)">{{ album.name }}</a></li>
        </ul>
        <modal-window id="album-size-modal" :options="modal_options" @clickAcceptBtn="onClickAcceptBtn"></modal-window>
    </li>
</template>

<script>
    import { event } from '../app.js';
    import Album from '../classes/Album.js';
    import ModalOptions from '../classes/ModalOptions.js';

    export default {
        data() {
            return {
              albums: [],
              type: 'photo',
              current_album: new Album('photo', -1),
              modal_options: new ModalOptions()
            };
        },
        computed: {
            filteredAlbums: function () {
                return this.albums.filter(album => album.type == this.type);
            }
        },
        mounted() {
            event.$on('updateAlbumName', name => {
                if(name) {
                    axios.patch('/albums/' + this.current_album.id, {
                        name: name
                    }).then(() => {
                        this.current_album.name = name;
                    }).catch(() => {
                        event.$emit('setAlbumName', this.current_album.name);
                    });
                } else {
                    event.$emit('setAlbumName', this.current_album.name);
                }
            });
            axios.get('/albums').then(response => {
                this.albums = response.data;
                this.loadAlbum(this.albums.find(album => album.type == this.type) || new Album(this.type));
            });
        },
        methods: {
            loadAlbum(newAlbum) {
                if(newAlbum.id == this.current_album.id) {
                    return;
                }
                event.$once('responseSelectedFrames', frames => {
                    if(frames.length) {
                        if(newAlbum.type != this.current_album.type) {
                            return;
                        }
                        axios.patch('/albums/' + newAlbum.id, {
                            frames: frames
                        }).then(() => {
                            event.$emit('removeSelectedFrames');
                        }).catch(error => {
                            this.modal_options = new ModalOptions('Error', error.response.data ? error.response.data : error.message, 'Ok');
                            $('#album-size-modal').modal('show');
                        });
                    } else {
                        this.current_album = newAlbum;
                        event.$emit('loadAlbum', newAlbum);
                        event.$emit('setAlbumName', newAlbum.name);
                    }
                });
                event.$emit('requestSelectedFrames');
            },
            newAlbum() {
                event.$once('responseSelectedFrames', frames => {
                    if(frames.length && (this.type != this.current_album.type)) {
                        return;
                    }
                    axios.post('/albums/create', {
                        type: this.type,
                        frames: frames
                    }).then(response => {
                        this.albums.push(response.data);
                        this.current_album = response.data;
                        event.$emit('loadAlbum', response.data);
                        event.$emit('setAlbumName', response.data.name);
                    });
                });
                event.$emit('requestSelectedFrames');
            },
            deleteAlbum() {
                if(this.current_album.id < 1) {
                    return;
                }
                this.modal_options = new ModalOptions('Confirm', 'Are you sure you want to delete the album?', 'Yes', 'No', true);
                $('#album-size-modal').modal('show');
            },
            onClickAcceptBtn() {
                if(!this.modal_options.isCancelBtn) {
                    return;
                }
                axios.delete('/albums/' + this.current_album.id).then(() => {
                    this.albums = this.albums.filter(album => album.id != this.current_album.id);
                    this.current_album = this.albums.find(album => album.type == this.type) || new Album(this.type);
                    event.$emit('loadAlbum', this.current_album);
                    event.$emit('setAlbumName', this.current_album.name);
                });
            }
        }
    }
</script>