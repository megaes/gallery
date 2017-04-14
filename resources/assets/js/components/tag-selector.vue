<template>
    <li>
        <form class="navbar-form select2-tags">
            <div class="input-group select2-bootstrap-append">
                <select id="select2-tags" class="form-control" multiple="multiple" disabled></select>
                <span class="input-group-btn">
                <button id="select2-button" class="btn btn-default disabled" type="button" @click="click">
                    <span v-show="selected_frame_counter">Apply</span>
                    <span v-show="!selected_frame_counter">Filter</span>
                </button>
            </span>
            </div>
        </form>
    </li>
</template>

<script>
    import { event } from '../app.js';

    export default {
        data() {
            return {
                selected_frame_counter : 0
            }
        },
        mounted() {
            $('#select2-tags').select2({
                tags: true,
                allowClear: true,
                placeholder: 'Select tags',
                maximumInputLength: 25,
                maximumSelectionLength: 5,
                width: '',
                createTag: params => {
                    let term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    }
                }
            }).on('select2:select', event => {
                if(event.params.data.newTag) {
                    document.querySelector('#select2-tags option[value="' + event.params.data.id + '"]').removeAttribute('data-select2-tag');
                }
            });
            event.$on('loadAlbum', album => {
                axios.get('/albums/' + album.id + '/tags').then(response => {
                    let select = document.getElementById('select2-tags');
                    $(select).val(null).trigger('change');
                    $(select).prop("disabled", !album.id);
                    while(select.childNodes.length) { select.removeChild(select.childNodes[0]); }
                    if(album.id) {
                        response.data.forEach(name => select.appendChild(new Option(name, name)));
                        document.getElementById('select2-button').classList.remove('disabled');
                    } else {
                        document.getElementById('select2-button').classList.add('disabled');
                    }
                    this.selected_frame_counter = 0;
                });
            });
            event.$on('frameSelect', selection => this.selected_frame_counter += selection ? 1 : -1);
            event.$on('frameSelectAllResult',(selection, count) => this.selected_frame_counter = selection ? count : 0);
            event.$on('removeSelectedFrames',() => this.selected_frame_counter = 0);
        },
        methods: {
            click() {
                if(document.getElementById('select2-button').classList.contains('disabled')) {
                    return;
                }
                event.$emit(this.selected_frame_counter ? 'applyTags' : 'filterFrames', $('#select2-tags').val());
            }
        }
    }
</script>
