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

    export default {
        data() {
            return {
              albums: [],
              type: 'photo',
              current_album_id: -1,
              modal_options: {
                  title: '',
                  body: '',
                  textAcceptBtn: '',
                  textCancelBtn: '',
                  isCancelBtn: '',
                  data: {}
              }
            };
        },
        computed: {
            filteredAlbums: function () {
                return this.albums.filter(album => album.type == this.type);
            }
        },
        mounted() {
            event.$on('updateAlbumName', name => {
                let album = this.albums.find(album => album.id == this.current_album_id);
                if(name) {
                    axios.patch('/albums/' + this.current_album_id, {
                        name: name
                    }).then(() => {
                        album.name = name;
                    }).catch(() => {
                        event.$emit('setAlbumName', album.name);
                    });
                } else {
                    event.$emit('setAlbumName', album.name);
                }
            });
            axios.get('/albums').then(response => {
                let defaultAlbum = response.data.find(album => album.type == this.type);
                this.albums = response.data;
                this.loadAlbum(defaultAlbum === undefined ? {id: 0, name: '', type: this.type} : defaultAlbum);
            });
        },
        methods: {
            loadAlbum(newAlbum) {
                if(newAlbum.id == this.current_album_id) {
                    return;
                }
                event.$once('responseSelectedFrames', frames => {
                    if(frames.length && (newAlbum.type != this.albums.find(album => album.id == this.current_album_id).type)) {
                        return;
                    }
                    if(frames.length) {
                        axios.patch('/albums/' + newAlbum.id, {
                            frames: frames
                        }).then(() => {
                            event.$emit('removeSelectedFrames');
                        }).catch(error => {
                            this.modal_options = {
                                title: 'Error',
                                body: error.response.data ? error.response.data : error.message,
                                textAcceptBtn: 'Ok',
                                textCancelBtn: '',
                                isCancelBtn: '',
                                data: {}
                            };
                            $('#album-size-modal').modal('show');
                        });
                    } else {
                        this.current_album_id = newAlbum.id;
                        event.$emit('loadAlbum', newAlbum.id);
                        event.$emit('setAlbumName', newAlbum.name);
                    }
                });
                event.$emit('requestSelectedFrames');
            },
            newAlbum() {
                event.$once('responseSelectedFrames', frames => {
                    if(frames.length && (this.type != this.albums.find(album => album.id == this.current_album_id).type)) {
                        return;
                    }
                    axios.post('/albums/create', {
                        type: this.type,
                        frames: frames
                    }).then(response => {
                        this.albums.push(response.data);
                        this.current_album_id = response.data.id;
                        event.$emit('loadAlbum', response.data.id);
                        event.$emit('setAlbumName', response.data.name);
                    });
                });
                event.$emit('requestSelectedFrames');
            },
            deleteAlbum() {
                this.modal_options = {
                    title: 'Confirm',
                    body: 'Are you sure you want to delete the album?',
                    textAcceptBtn: 'Yes',
                    textCancelBtn: 'No',
                    isCancelBtn: 'yes',
                    data: {}
                };
                $('#album-size-modal').modal('show');
            },
            onClickAcceptBtn() {
                if(!this.modal_options.isCancelBtn) {
                    return;
                }
                axios.delete('/albums/' + this.current_album_id).then(() => {
                    this.albums = this.albums.filter(album => album.id != this.current_album_id);
                    let defaultAlbum = this.albums.find(album => album.type == this.type);
                    this.current_album_id = (defaultAlbum === undefined) ? 0 : defaultAlbum.id;
                    event.$emit('loadAlbum', this.current_album_id);
                    event.$emit('setAlbumName', this.current_album_id ? defaultAlbum.name : '');
                });
            }
        }
    }
</script>