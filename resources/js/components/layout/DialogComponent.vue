<template>
    <div>
        <vue-modaltor 
            :visible="isOpen" @hide="hideModal"
            :animation-panel="'modal-slide-top'"
            :default-width="modalWidth">
            <div class="row no-margin m-b-15">
                <div class="col-md-12">
                    <h5 class="text-success text-center">{{title}}</h5>
                </div>
            </div>
            <div class="content">
                <div class="row no-margin">
                    <div class="col-md-12">
                        <slot></slot>
                    </div>
                    
                </div>
            </div>
        </vue-modaltor>
        
    </div>    
</template>
<script>
export default {
    props: {
    // this is for toggle show modal
    // :visible:false
        isOpen: {
            type : Boolean,
            default : false
        },
        dialogTitle: {
            type : String,
            default : 'title'
        },
        visible: {
            type: Boolean,
            required: false,
            default: false
        },
        // this is for responsive modal and
        // :resize-width='{1200:"50%",992:"70%",768:"90%"}'
        resizeWidth:{
            type:Object,
        },
        // this is for anaimating modal
        // :animation-panel='modal-slide-right'
        // :animation-panel='modal-slide-left'
        // :animation-panel='modal-slide-top'
        // :animation-panel='modal-slide-bottom'
        animationPanel:{
            type: String,
            required: false,
            default: 'modal-fade'
        },
        // this is for anaimating animationParent modal
        // :animation-parent='modal-scale'
        animationParent:{
            type: String,
            required: false,
            default: 'modal-fade'
        },
        // this is for bgcolor overlay
        bgOverlay:{
            type: String,
            required: false,
            default: '#fff'
        },
        // this is for bgcolor panel
        bgPanel:{
            type: String,
            required: false,
            default: '#fff'
        },
        //set default width modal
        // :default-width="'50%'"
        // :default-width="'495px'"
        // :default-width="'40em'"
        modalWidth:{
            type: String,
            required: false,
            default: '100%'
        },
        // this is option for close scroll body when show modal
        // :close-scroll="false"  // if true close scroll body
        closeScroll:{
            type: Boolean,
            required: false,
            default: true
        },
        // this is option for showing/hiding close button on modal
        // :show-close-button="false"  // if true close button will show
        showCloseButton:{
            type: Boolean,
            required: false,
            default: true
        },
        // this is option for space in content slot
        // u can castumize this
        zeroSpace: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    data(){
        return {
            link : '',
            title : '',
        }
    },
    watch:{
        dialogTitle: {
            handler(newVal) {
                this.title = newVal;
            },
            immediate: true
        }
    },
    methods: {
        hideModal() {
            this.$emit('isClose',true);
        },
    },
};
</script>
