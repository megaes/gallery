<template>
    <div id="gallery">
        <frame v-for="(frame, index) in frames" :path="path" :frame="frame" :key="frame.id" @showGallery="onShowGallery(index)" @delete="onDelete(index)"></frame>
        <modal-window id="delete-confirmation-modal" :options="modal_options" @clickAcceptBtn="onConfirmDelete"></modal-window>
    </div>
</template>

<script>
    import { event } from '../app.js';

    export default {
        data() {
            return {
                frames: [],
                path: '',
                isotope: null,
                framesPerPage: 150,
                page: 1,
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
        mounted() {
            event.$on('turnThePage', page => {
                this.page = page;
                this.updateImageLoad();
                this.$nextTick(() => this.updateIsotope());
            });
            event.$on('removeSelectedFrames', () => {
                let framesDOM = document.querySelectorAll('#gallery .gallery-frame');
                let selectedFramesDOM = [];
                let frames = [];

                this.frames.forEach( (frame, i) => {
                    if(frame.activity & 1) {
                        selectedFramesDOM.push(framesDOM[i]);
                    } else {
                        frames.push(frame);
                    }
                });

                this.isotope.remove(selectedFramesDOM);
                this.frames = frames;

                const pageCount = Math.ceil(this.frames.length / this.framesPerPage);

                event.$emit('setPageCount', pageCount);
                event.$emit('turnThePage', Math.min(this.page, pageCount));
            });
            event.$on('loadAlbum', id => this.initGallery(id));
            event.$on('requestSelectedFrames', () => {
                event.$emit('responseSelectedFrames', this.frames.filter(frame => frame.activity & 1).map(frame => frame.id));
            });
        },
        methods: {
            updateImageLoad() {
                let min = (this.page - 1)*this.framesPerPage;
                let max = this.page * this.framesPerPage;
                let counter = -1;
                this.frames.forEach( frame => {
                    frame.load |= (++counter >= min) && (counter < max);
                });
            },
            updateIsotope() {
                let min = (this.page - 1)*this.framesPerPage;
                let max = this.page * this.framesPerPage;
                let counter = -1;
                this.isotope.arrange({
                    filter: function() {
                        return (++counter >= min) && (counter < max);
                    }
                });
            },
            clear() {
                if(this.isotope) {
                    this.isotope.destroy();
                    this.isotope = null;
                }
                this.frames = [];
                this.page = 1;
                this.path = '';
                event.$emit('setPageCount', 1);
            },
            initGallery(album_id) {
                if(!album_id) {
                    this.clear();
                    return;
                }
                axios.get('/albums/' + album_id).then(response => {
                    this.clear();

                    this.path = response.data.path;

                    response.data.frames.forEach(item => {
                        this.frames.push({
                            id: item.id,
                            name: item.name,
                            tn_aspect_ratio: item.tn_aspect_ratio,
                            caption: item.caption,
                            activity: 0,
                            load: false
                        });
                    });

                    this.$nextTick( () => {
                        this.isotope = new Isotope( document.getElementById('gallery'), {
                            initLayout: false,
                            itemSelector: '.gallery-frame',
                            layoutMode: 'masonry',
                            percentPosition: true
                        });
                        event.$emit('setPageCount', Math.ceil(this.frames.length / this.framesPerPage));
                        event.$emit('turnThePage', 1);
                    });

                });
            },
            onShowGallery(id) {
                let $lightGallery = $('#gallery');
                let data = [];
                let newIndex = 0;
                let selectedFrames = this.frames.filter(frame => frame.activity);
                let frames = (selectedFrames.find( frame => frame.activity & 1) === 'undefined') ? this.frames : selectedFrames;

                frames.forEach((frame, index) => {
                    data.push({
                        "src": this.path + frame.name + '.jpg',
                        'thumb': this.path + frame.name + '-tn.jpg',
                        'subHtml': '<h4>' + frame.caption + '</h4>'
                    });
                    if (this.frames[id].id == frame.id) {
                        newIndex = index;
                    }
                });

                $lightGallery.lightGallery({
                    dynamic: true,
                    index: newIndex,
                    thumbnail: true,
                    share: false,
                    dynamicEl: data
                });
                $lightGallery.one("onCloseAfter.lg", function() {
                    $lightGallery.data('lightGallery').destroy(true);
                });
            },
            onDelete(index) {
                this.modal_options = {
                    title: 'Confirm',
                    body: 'Are you sure you want to delete?',
                    textAcceptBtn: 'Yes',
                    textCancelBtn: 'No',
                    isCancelBtn: 'yes',
                    data: { index: index }
                };
                $('#delete-confirmation-modal').modal('show');
            },
            onConfirmDelete(data) {
                let framesDOM = document.querySelectorAll('#gallery .gallery-frame');
                let selectedFramesDOM = [];
                let frames = [];
                let selectedIDs = [];

                this.frames.forEach( (frame, i) => {
                    if(frame.activity || (i === data.index)) {
                        selectedFramesDOM.push(framesDOM[i]);
                        selectedIDs.push(frame.id);
                    } else {
                        frames.push(frame);
                    }
                });

                axios.post('/resources/delete', {
                    ids: selectedIDs
                }).then(() => {
                    this.isotope.remove(selectedFramesDOM);
                    this.frames = frames;

                    const pageCount = Math.ceil(this.frames.length / this.framesPerPage);

                    event.$emit('setPageCount', pageCount);
                    event.$emit('turnThePage', Math.min(this.page, pageCount));
                });
            }
        }
    }
</script>
