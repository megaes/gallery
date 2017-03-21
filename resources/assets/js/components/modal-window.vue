<template>
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ options.title }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ options.body }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button  v-show="options.isCancelBtn" type="button" class="btn btn-default" data-dismiss="modal" @click="$emit('clickCancelBtn', options.data)">
                        {{ options.textCancelBtn }}
                    </button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="$emit('clickAcceptBtn', options.data)">
                        {{ options.textAcceptBtn }}
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>

<script>
    export default {
        props: ['options']
    }
</script>