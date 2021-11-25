<template>
    <div>
        <div id="scholars" class="section-container main-content-view bg-white">
            <dialog-component v-bind:isOpen="openDialog" v-on:isClose="openDialog = false" modalWidth="50%" :dialogTitle="actionType == 'new' ? 'Add New Scholar' : 'Update Scholar Information'">
                <scholar-form-component v-bind:scholarData="selected_scholar" v-bind:actionType="actionType" v-on:closeModal="openDialog = false"></scholar-form-component>
            </dialog-component>
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
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <type-component :type="filtersParam.type" @updateType="filtersParam.type = $event"></type-component>
                </div>
                <!-- <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="dataTables_length" id="data-table-default_length">
                        <label>Search 
                            <input type="text" aria-controls="data-table-default" placeholder="Search Scholars" class="custom-input custom-input-sm form-control form-control-sm" v-model="filtersParam.term" @blur="updateTable">
                        </label>
                    </div>
                </div> -->
                <div class="col-lg-4 offset-lg-3 offset-md-3 col-md-4 col-sm-12">
                    <div class="pull-right">
                        <input name="file" type="file" ref="file" @change="importScholar()" class="hide">
                        <button class="btn btn-primary btn-sm"  @click="addScholar"><i class="fa fa-plus"></i> Add New Scholar </button>
                        <button class="btn btn-warning btn-sm"  @click="$refs.file.click()"><i class="fa fa-plus"></i> Import Scholar </button>
                    </div>
                </div>
            </div>
            <!-- END row -->
            <!-- BEGIN row -->
            <div class="row no-margin mt-1">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <loading :active.sync="isLoading" 
                        :can-cancel="true" 
                        :on-cancel="onCancel"
                        :is-full-page="fullPage"></loading>
                    <vuetable ref="vuetable"
                        :api-url="'/getScholars'"
                        :fields="fields"
                        :css="css"
                        :per-page="perPage"
                        data-path="data"
                        pagination-path=""
                        :sort-order="sortOrder"
                        :append-params="filtersParam"
                        @vuetable:pagination-data="onPaginationData"
                        @vuetable:row-clicked="onCellClicked"
                        @vuetable:loading="onLoading"
                        @vuetable:loaded="onLoaded">

                        <div slot="action" slot-scope="props">
                            <div class="btn-group">
                                <button class="btn btn-white btn-xs" @click="editScholar(props.rowData)"><i class="fa fa-pencil-alt"></i> Edit </button>
                                <button class="btn btn-white btn-xs text-danger" @click="deleteScholar(props.rowData.id)"><i class="fa fa-trash"></i> Delete </button>
                                <!-- <button class="btn btn-white btn-xs text-primary" @click="changeScholarPassword(props.rowData.id)"><i class="fa fa-lock"></i> Change Password </button> -->
                            </div>
                        </div>
                    </vuetable>
                    <!-- Vuetable -->
                </div>
                <!-- Pagination Info -->
                <div class="col-md-6">
                    <vuetable-pagination-info ref="paginationInfo"
                    ></vuetable-pagination-info>
                </div><!-- End of Pagination Info -->
                <!-- Pagination Buttons -->
                <div class="col-md-6 text-right">
                    <vuetable-pagination ref="pagination"
                        @vuetable-pagination:change-page="onChangePage"
                        :css="css.pagination"
                    ></vuetable-pagination>
                </div><!-- End of Pagination Buttons -->
            </div>
            <!-- END row -->
        </div>
    </div>
</template>
<script lang="ts">
import ScholarFormComponent from './ScholarFormComponent.vue';
import { TableMixins } from './TableMixins';
import { TableStyle } from './TableStyle.js';
import FieldsDef from "./ScholarsListFieldsDef.js";
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
                type: "",
                term : ""
            },
            openDialog: false,
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
    components:{
        'scholar-form-component' : ScholarFormComponent
    },
    methods:{
        addScholar(){
            this.openDialog = true;
            this.actionType = 'new';
            this.selected_scholar = {}
        },
        editScholar(data){
            this.selected_scholar = data;
            this.openDialog = true;
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
        },
        changeScholarPassword(data){

        }
    },
    mounted(){
        this.$events.on('update_scholars_table', (data) => {
            this.updateTable();
        });
        this.$root.$on('isClose', (data) => {
            this.openDialog = false;
        });
    }
}
</script>
