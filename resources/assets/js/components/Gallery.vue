<template>
    <div id="gallery">
        <frame v-for="(frame, index) in frames" :path="path" :frame="frame" :key="frame.id" @showGallery="onShowGallery(index)" @delete="onDelete(index)"></frame>
        <confirmation class="confirmation" @accept="onAccept">
            <p slot="body">Are you sure you want to delete?</p>
            <span slot="cancel_button_name">No</span>
            <span slot="accept_button_name">Yes</span>
        </confirmation>
    </div>
</template>

<script>
    import { event } from '../app.js';

    export default {
        props: ['path'],
        data() {
            return {
                frames: [],
                isotope: null,
                framesPerPage: 150,
                remove_id: -1,
                page: 1,
            };
        },
        mounted() {
            event.$on('turnThePage', (page) => {
                this.page = page;
                this.updateImageLoad();

                this.$nextTick( function() {
                    this.updateIsotope();
                });
            });

            this.initGallery(1);
        },
        methods: {
            updateImageLoad() {
                let min = (this.page - 1)*this.framesPerPage;
                let max = this.page * this.framesPerPage;
                let counter = -1;
                this.frames.forEach( (frame) => {
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
            initGallery(album_id) {
                axios.post('/' + album_id).then((response) => {
                    if(response.status != 200) {
                        return;
                    }

                    if(this.isotope) {
                        this.isotope.destroy();
                    }

                    this.frames = [];
                    response.data.forEach( (item) => {
                        this.frames.push({
                            id: item.id,
                            name: item.name,
                            tn_aspect_ratio: item.tn_aspect_ratio,
                            caption: item.caption,
                            selected: false,
                            load: false
                        });
                    });

                    this.$nextTick( function() {
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
                let selected = false;
                let selectedFrames = this.frames.filter( (frame, index) => {
                    selected |= frame.selected;
                    return frame.selected || (index == id);
                });

                let frames = selected ? selectedFrames : this.frames;

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
                this.remove_id = index;
                $('#gallery > .confirmation').modal('show');
            },
            onAccept() {
                $('#gallery > .confirmation').modal('hide');

                let framesDOM = document.getElementById('gallery').getElementsByClassName('gallery-frame');
                let selectedFramesDOM = [];
                let frames = [];
                let selectedIDs = [];

                this.frames.forEach( (frame, index) => {
                    if(frame.selected || (index == this.remove_id)) {
                        selectedFramesDOM.push(framesDOM[index]);
                        selectedIDs.push(frame.id);
                    } else {
                        frames.push(frame);
                    }
                });

                axios.post('/delete', {
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
