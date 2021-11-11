<template>
    <div>
        <div class="section-container main-content-view bg-white" id="scholars">
            <!-- BEGIN row -->
            <div class="row no-margin mt-2">
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <div class="dataTables_length" id="data-table-default_length">
                        <label>Show 
                            <select 
                                name="data-table-default_length" 
                                aria-controls="data-table-default" 
                                class="custom-select custom-select-sm form-control form-control-sm"
                                v-model="perPage"
                                @change="updateTable()"
                                >
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                            </select> 
                            entries
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <type-component :type="filtersParam.type" @updateType="filtersParam.type = $event"></type-component>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="pull-right">
                        <input name="file" type="file" ref="file" @change="importScholar()" class="hide">
                        <button class="btn btn-primary btn-sm"  @click="addScholar"><i class="fa fa-plus"></i> Add New Scholar </button>
                        <button class="btn btn-warning btn-sm"  @click="$refs.file.click()"><i class="fa fa-plus"></i> Import Scholar </button>
                    </div>
                </div>
            </div>
            <!-- END row -->
           
        </div>
    </div>
</template>
<script lang="ts">
import { TableMixins } from './TableMixins';
import { TableStyle } from './TableStyle.js';
import FieldsDef from "./PlayerFieldsDef.js";
// import PlayerDetailRow from './PlayerDetailRow.vue';
export default {
    mixins : [ TableMixins ],
    data () {
        return {
            fields     : FieldsDef,
            perPage    : 15,
            data       : [],
            import_file: '',
            // detailRow  : PlayerDetailRow,
            sortOrder  : [
                {
                    field    : "type",   // Choose the Defualt Sorted Data by name
                    direction: "desc"    // Sorting Direction
                }
            ],
            css             : TableStyle,
            selected_scholar: {},            
            filtersParam    : {
                type: ""
            },
            addScholarDialog: false,
            actionType      : 'new',
            isLoading       : false,
            fullPage        : true,
        }
    },
    watch : {
        'filtersParam.type' : function(newVal){
            if(newVal)
                this.updateTable();
        }
    },
    // components:{
    //     'scholar-form-component' : ScholarFormComponent
    // },
    methods:{
        addScholar(){
            this.addScholarDialog = true;
            this.actionType = 'new';
            this.selected_scholar = {}
        },
        editScholar(data){
            this.selected_scholar = data;
            this.addScholarDialog = true;
            this.actionType = 'update';
        },
        deleteScholar(id){
            this.$alertify.confirmWithTitle("Delete", "Are you sure to delete this scholar?", 
            ()=> {
                // Axios Request
                this.axios.post('deleteScholar', {
                    id : id,
                })
                .then((response) => {
                    this.updateTable();
                    this.$noty.success(response.data.message);
                })
                .catch((error) => {
                    console.log(error);
                    this.$noty.error("Something went wrong please try again later.")
                });
                // End of Request
            },() =>this.$noty.error("Cancel: Item not removed")
            )            
        },
        importScholar(){
            this.import_file = this.$refs.file.files[0];

            this.$alertify.confirmWithTitle("Import CSV File", "Confirm to upload file"+"</br>"+this.import_file.name, 
            ()=>
                this.uploadFile()
            ,() =>
                this.$alertify.error("Cancel")
            )
            // console.log(this.import_file);
        },
        uploadFile(){
            let formData = new FormData();
            formData.append('file', this.import_file);

            this.axios.post('/importScholar',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                // console.log(response.data);
                this.import_file = '';
                this.$refs.file.value = '';
                this.$noty.success("File Imported");;
                this.updateTable();
            })
        }
    },
    mounted(){
        this.$events.on('update_scholars_table', (data) => {
            this.updateTable();
        });
        this.$root.$on('isClose', (data) => {
            this.addScholarDialog = false;
        });
    }
}
</script>
