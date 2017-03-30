<template>
    <li>
        <a href="#" @click.prevent="showModal"><i class="fa fa-lg fa-upload" aria-hidden="true"></i>Upload</a>
        <div id="upload" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="dropzone"></form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </li>
</template>

<script>
    import { event } from '../app.js';

    export default {
        data() {
            return {
                dropzone: null
            }
        },
        mounted() {
            document.getElementById('dropzone').classList.add('dropzone');
            this.dropzone = new Dropzone('#dropzone', {url: '/', maxFilesize: 200, headers: {'X-CSRF-TOKEN' : Laravel.csrfToken}});
            this.dropzone.on('success', (file, response) => event.$emit('addFrame', response));
        },
        methods: {
            showModal() {
                event.$once('responseCurrentAlbum', album => {
                    if(album.id < 1) {
                        return;
                    }
                    this.dropzone.options.url = '/albums/' + album.id + '/' + album.type;
                    this.dropzone.options.acceptedFiles = (album.type == 'video') ? '.mp4' : '.jpg, .jpeg, .png, .bmp, .tif';
                    $('#upload').modal('show');
                });
                event.$emit('requestCurrentAlbum');
            },
            closeModal() {
                this.dropzone.removeAllFiles(true);
            }
        }
    }
</script>
