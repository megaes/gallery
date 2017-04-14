<template>
    <div id="gallery">
        <frame v-for="frame in frames" :path="path" :video="current_album.type == 'video'" :frame="frame" :key="frame.id" @showGallery="onShowGallery(frame.id)" @delete="onDelete(frame.id)"></frame>
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
                current_album: null,
                tags: [],
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
                let min = (this.page - 1)*this.framesPerPage;
                let max = this.page * this.framesPerPage;
                let counter = -1;
                this.frames.forEach(frame => {
                    frame.visible = this.hasTags(frame) ? (++counter >= min) && (counter < max) : false;
                    frame.load |= frame.visible;
                });
                this.$nextTick(() => this.isotope.arrange());
            });
            event.$on('addFrame', frame => {
                this.frames.push({
                    id: frame.id,
                    name: frame.name,
                    tn_aspect_ratio: frame.tn_aspect_ratio,
                    caption: frame.caption,
                    activity: 0,
                    visible: false,
                    load: false
                });
                this.$nextTick(() => {
                    let framesDOM = document.querySelectorAll('#gallery .gallery-frame');
                    this.isotope.appended(framesDOM[this.frames.length - 1]);
                    this.setPageCount();
                    event.$emit('turnThePage', this.page);
                });
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

                event.$emit('turnThePage', Math.min(this.page, this.setPageCount()));
            });
            event.$on('loadAlbum', album => this.initGallery(album));
            event.$on('requestSelectedFrames', () => {
                event.$emit('responseSelectedFrames', this.frames.filter(frame => frame.activity & 1).map(frame => frame.id));
            });
            event.$on('frameSelectAll', selection => {
                let count = 0;
                if(selection) {
                    this.frames.forEach(frame => {
                        if(this.hasTags(frame)) {
                            ++count;
                            frame.activity = (frame.activity & ~1) | selection;
                        }
                    });
                } else {
                    count = this.frames.length;
                    this.frames.forEach(frame => frame.activity &= ~1);
                }
                event.$emit('frameSelectAllResult', selection, count);
            });
            event.$on('filterFrames', tags => {
                this.tags = tags;
                this.setPageCount();
                event.$emit('turnThePage', 1);
            });
            event.$on('applyTags', tags => {
                let selectedFrames = this.frames.filter(frame => frame.activity & 1);
                axios.patch('/resources', {
                    frames: selectedFrames.map(frame => frame.id),
                    tags: tags
                }).then(() => {
                    selectedFrames.forEach(frame => frame.tags = tags);
                });
            });
        },
        methods: {
            clear() {
                if(this.isotope) {
                    this.isotope.destroy();
                    this.isotope = null;
                }
                this.frames = [];
                this.page = 1;
                this.tags = [];
                this.path = '';
                event.$emit('setPageCount', 1);
            },
            hasTags(frame) {
                let i = this.tags.length;
                while((--i >= 0) && (frame.tags.indexOf(this.tags[i]) != -1));
                return (i < 0);
            },
            setPageCount() {
                let frameCount = 0;
                this.frames.forEach(frame => frameCount += this.hasTags(frame));
                const pageCount = Math.max(1, Math.ceil(frameCount / this.framesPerPage));
                event.$emit('setPageCount', pageCount);
                return pageCount;
            },
            initGallery(album) {
                this.current_album = album;
                if(!album.id) {
                    this.clear();
                    return;
                }
                axios.get('/albums/' + album.id + '/resources').then(response => {
                    this.clear();

                    this.path = response.data.path;

                    response.data.frames.forEach(item => {
                        this.frames.push({
                            id: item.id,
                            name: item.name,
                            tn_aspect_ratio: item.tn_aspect_ratio,
                            caption: item.caption,
                            tags: item.tags,
                            activity: 0,
                            visible: false,
                            load: false
                        });
                    });

                    this.$nextTick( () => {
                        this.isotope = new Isotope( document.getElementById('gallery'), {
                            initLayout: false,
                            itemSelector: '.gallery-frame',
                            layoutMode: 'masonry',
                            filter: '.visible',
                            percentPosition: true
                        });
                        this.setPageCount();
                        event.$emit('turnThePage', 1);
                    });

                });
            },
            onShowGallery(id) {
                let $lightGallery = $('#gallery');
                let data = [];
                let selectedFrames = this.frames.filter(frame => frame.activity);
                let frames = (selectedFrames.find(frame => frame.activity & 1) === undefined) ? this.frames : selectedFrames;
                let index = frames.findIndex(frame => id == frame.id);

                if(this.current_album.type == 'photo') {
                    frames.forEach(frame => {
                        data.push({
                            "src": this.path + frame.name + '.jpg',
                            'thumb': this.path + frame.name + '-tn.jpg',
                            'subHtml': '<h4>' + frame.caption + '</h4>'
                        });
                    });
                    $lightGallery.lightGallery({
                        dynamic: true,
                        index: index,
                        thumbnail: true,
                        share: false,
                        dynamicEl: data
                    });
                } else {
                    frames.forEach(frame => {
                        data.push({
                            'html': '#video' + frame.id,
                            'poster': this.path + frame.name + '.jpg',
                            'thumb': this.path + frame.name + '-tn.jpg',
                            'subHtml': '<h4>' + frame.caption + '</h4>'
                        });
                    });
                    $lightGallery.lightGallery({
                        dynamic: true,
                        index: index,
                        thumbnail: true,
                        share: false,
                        zoom: false,
                        download: false,
                        fullScreen: false,
                        autoplayControls: false,
                        dynamicEl: data
                    });
                }
                $lightGallery.one("onBeforeClose.lg",() => {
                    let currentVideo = document.querySelector('.lg-video-playing video');
                    if(currentVideo) {
                        currentVideo.pause();
                    }
                });
                $lightGallery.one("onCloseAfter.lg",() => {
                    $lightGallery.data('lightGallery').destroy(true);
                });
            },
            onDelete(id) {
                this.modal_options = {
                    title: 'Confirm',
                    body: 'Are you sure you want to delete?',
                    textAcceptBtn: 'Yes',
                    textCancelBtn: 'No',
                    isCancelBtn: 'yes',
                    data: { id: id }
                };
                $('#delete-confirmation-modal').modal('show');
            },
            onConfirmDelete(data) {
                let framesDOM = document.querySelectorAll('#gallery .gallery-frame');
                let selectedFramesDOM = [];
                let frames = [];
                let selectedIDs = [];

                this.frames.forEach( (frame, i) => {
                    if(frame.activity || (frame.id == data.id)) {
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
                    event.$emit('turnThePage', Math.min(this.page, this.setPageCount()));
                });
            }
        }
    }
</script>
