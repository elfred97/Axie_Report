<template>
    <div>
         <!-- BEGIN #overview -->
        <div id="overview" class="section-container main-content-view bg-white">
            <!-- BEGIN container -->
            <!-- <div class="container"> -->                
                <!-- BEGIN row -->
                <div class="row no-margin mt-2">
                    <!-- <div class="col-md-1">
                        <select name="per_page" id="" class="form-control" v-model="perPage" @change="updateTable()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div> -->
                    <div class="col-md-2">
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
                    <div class="col-md-6">
                        <div class="pull-right">
                            <input name="file" type="file" ref="file" @change="importFile()" class="hide">
                            <button class="btn btn-primary btn-sm"  @click="$refs.file.click()"><i class="fa fa-plus"></i> Import Excel File</button>
                        </div>
                    </div>
                </div>
                <div class="row no-margin mt-1">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <loading :active.sync="isLoading" 
                            :can-cancel="true" 
                            :on-cancel="onCancel"
                            :is-full-page="fullPage"></loading>
                        <vuetable ref="vuetable"
                            :api-url="'/getImportedReport'"
                            :fields="fields"
                            :css="css"
                            :per-page="perPage"
                            :append-params="filtersParam"
                            data-path="data"
                            pagination-path=""
                            :sort-order="sortOrder"
                            :detail-row-component="detailRow"
                            @vuetable:pagination-data="onPaginationData"
                            @vuetable:row-clicked="onCellClicked"
                            @vuetable:loading="onLoading"
                            @vuetable:loaded="onLoaded">
                            >
                            <template slot="mmr_field" slot-scope="props">
                                <div>
                                    <span class="text-danger" v-if="props.rowData.mmr < lowest_mmr">
                                        {{ props.rowData.mmr }}
                                    </span>
                                    <span class="text-default" v-else>
                                        {{ props.rowData.mmr}}
                                    </span>
                                </div>
                            </template>
                            <template slot="detailRowIndicator" slot-scope="props">
                                <div>
                                    <i v-if="$refs.vuetable.isVisibleDetailRow(props.rowData.id)"
                                        class="fas fa-minus-circle"></i>
                                    <i v-else class="fas fa-plus-circle"></i>
                                </div>
                            </template>
                            <div slot="actions" slot-scope="props">
                                <button 
                                    class="ui small button" 
                                    @click="onActionClicked('view-item', props.rowData)"
                                >
                                    <i class="zoom icon"></i>
                                </button>
                                <button 
                                    class="ui small button" 
                                    @click="onActionClicked('edit-item', props.rowData)"
                                >
                                    <i class="edit icon"></i>
                                </button>
                                <button 
                                    class="ui small button" 
                                    @click="onActionClicked('delete-item', props.rowData)"
                                >
                                    <i class="delete icon"></i>
                                </button>
                            </div>
                        </vuetable>
                        <!-- End of Vuetable -->
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
                <!-- </div> -->
            <!-- END container -->
        </div>
        <!-- END # -->
    </div>
</template>
<script>
import {TableMixins} from './TableMixins';
import { TableStyle } from './TableStyle.js';
import FieldsDef from "./ImportedFieldsDef.js";
import ImportedDetailRow from "./ImportedDetailRow.vue";
export default {
    mixins : [TableMixins],
    data () {
        return {
            fields     : FieldsDef,
            perPage    : 15,
            data       : [],
            import_file: '',
            css        : TableStyle,
            detailRow  : ImportedDetailRow,
            filtersParam : {
                type : ""
            },
            isLoading : false,
            fullPage  : true,
            lowest_mmr : 800,
            sortOrder  : [
                {
                    field    : 'average_per_day',// Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
                {
                    field    : 'ronin_address',// Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
                {
                    field    : 'created_at',// Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
            ],
        }
    },
    watch : {
        'filtersParam.type' : function(newVal){
            this.updateTable();
        }
    },
    methods:{
        // importFile(){
        //     alert("File Imported")
        // },
        importFile() {
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

            this.axios.post('/importFile',
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
                this.$noty.success("File Imported");
                this.updateTable();
                this.$events.fire('update_notification');
                this.$events.fire('update_scholars_table');
            })

        }
    },    
}
</script>