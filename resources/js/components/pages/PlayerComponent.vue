<template>
    <div>
         <!-- BEGIN #overview -->
        <div id="player" class="section-container main-content-view bg-white">
            <dialog-component v-bind:isOpen="openDialog" v-on:isClose="openDialog = false" modalWidth="50%" :dialogTitle="actionType == 'new' ? 'Add New Axie Account' : 'Update Axie Account Information'">
                <player-form-component v-bind:scholarData="selected_player" v-bind:actionType="actionType" v-on:closeModal="openDialog = false"></player-form-component>
            </dialog-component>
            <dialog-component v-bind:isOpen="uploadQRopenDialog" v-on:isClose="uploadQRopenDialog = false" modalWidth="30%" dialogTitle="Upload QR Code">
                <upload-qr-component v-bind:scholarData="selected_player" v-on:closeModal="uploadQRopenDialog = false"></upload-qr-component>
            </dialog-component>
            <!-- BEGIN container -->
            <!-- <div class="container"> -->
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
                        <input name="file" type="file" ref="file" @change="importPlayer()" class="hide">
                        <button class="btn btn-primary btn-sm"  @click="addPlayer"><i class="fa fa-plus"></i> Add New Axie Account </button>
                        <button class="btn btn-warning btn-sm"  @click="$refs.file.click()"><i class="fa fa-plus"></i> Import Axie Account </button>
                        <input name="zip_file" type="file" ref="zip_file" @change="uploadZipQR()" class="hide">
                        <button class="btn btn-info btn-sm"  @click="$refs.zip_file.click()"><i class="fa fa-qrcode"></i> Upload Zip QR Code </button>
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
                        :api-url="'/getPlayers'"
                        :fields="fields"
                        :css="css"
                        :per-page="perPage"
                        data-path="data"
                        pagination-path=""
                        :sort-order="sortOrder"
                        :detail-row-component="detailRow"
                        :append-params="filtersParam"
                        @vuetable:pagination-data="onPaginationData"
                        @vuetable:row-clicked="onCellClicked"
                        @vuetable:loading="onLoading"
                        @vuetable:loaded="onLoaded">
                        <template slot="detailRowIndicator" slot-scope="props">
                            <div>
                                <i v-if="$refs.vuetable.isVisibleDetailRow(props.rowData.id)"
                                    class="fas fa-minus-circle"></i>
                                <i v-else class="fas fa-plus-circle"></i>
                            </div>
                        </template>
                        <template slot="qr_code_field" slot-scope="props">
                            <div>
                                <span v-if="props.rowData.qr_code_date">
                                    <p class="no-margin">Last Updated: </p>
                                    {{ props.rowData.qr_code_date }}
                                </span>
                            </div>
                        </template>
                        <div slot="player_status" slot-scope="props">
                            <div>
                                <span v-if="props.rowData.status == 'PLAYING'" class="text-bold text-success">PLAYING</span>
                                <span v-else-if="props.rowData.status == 'RESIGNED'" class="text-bold text-danger">RESIGNED</span>
                                <span v-else-if="props.rowData.status == 'TERMINATED'" class="text-bold text-danger">TERMINATED</span>
                                <span v-else class="text-bold text-default uppercase">{{ props.rowData.status }}</span>
                            </div>
                        </div>
                        <div slot="action" slot-scope="props">
                            <div class="btn-group">
                                <button class="btn btn-white btn-xs" @click="editPlayer(props.rowData)"><i class="fa fa-pencil-alt"></i> Edit</button>
                                <button class="btn btn-white btn-xs text-danger" @click="deletePlayer(props.rowData.id)"><i class="fa fa-trash"></i> Delete</button>

                                <button class="btn btn-white btn-xs text-primary" @click="uploadQR(props.rowData)"><i class="fa fa-qrcode"></i> Upload QR</button>
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
            <!-- </div> -->
            <!-- END container -->
        </div>
        <!-- END # -->
    </div>
</template>
<script lang="ts">
import PlayerFormComponent from './PlayerFormComponent.vue';
import uploadQRCodeComponent from './uploadQRCodeComponent.vue';
import { TableMixins } from './TableMixins';
import { TableStyle } from './TableStyle.js';
import FieldsDef from "./PlayerFieldsDef.js";
import PlayerDetailRow from './PlayerDetailRow.vue';
export default {
    mixins : [ TableMixins ],
    data () {
        return {
            fields     : FieldsDef,
            perPage    : 15,
            data       : [],
            import_file: '',
            import_zip_file : '',
            detailRow  : PlayerDetailRow,
            sortOrder  : [
                {
                    field    : "type",   // Choose the Defualt Sorted Data by name
                    direction: "desc"    // Sorting Direction
                }
            ],
            css             : TableStyle,
            selected_player : {},
            filtersParam    : {
                type : ""
            },
            openDialog        : false,
            uploadQRopenDialog: false,
            actionType        : 'new',
            isLoading         : false,
            fullPage          : true,
        }
    },
    watch : {
        'filtersParam.type' : function(newVal){
            this.updateTable();
        }
    },
    components:{
        'player-form-component' : PlayerFormComponent,
        'upload-qr-component' : uploadQRCodeComponent,
    },
    methods:{
        addPlayer(){
            this.openDialog = true;
            this.actionType = 'new';
            this.selected_player = {}
        },
        uploadQR(data){
            this.uploadQRopenDialog = true;
            this.selected_player = data;
        },
        editPlayer(data){
            this.selected_player = data;
            this.openDialog = true;
            this.actionType = 'update';
        },
        deletePlayer(id){
            this.$alertify.confirmWithTitle("Delete", "Are you sure to delete this scholar?", 
            ()=> {
                // Axios Request
                this.axios.post('deletePlayer', {
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
        importPlayer(){
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

            this.axios.post('/importPlayer',
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
        uploadZipQR(){
            this.import_zip_file = this.$refs.zip_file.files[0];

            this.$alertify.confirmWithTitle("Import Zip File", "Confirm to upload file"+"</br>"+this.import_zip_file.name, 
            ()=>
                this.uploadZipFile()
            ,() =>
                this.$alertify.error("Cancel")
            )
            // console.log(this.import_file);
        },
        uploadZipFile(){
            let formData = new FormData();
            formData.append('file', this.import_zip_file);

            this.axios.post('/importZipQR',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                // console.log(response.data);
                this.import_zip_file = '';
                this.$refs.zip_file.value = '';
                this.$noty.success("File Imported");;
                this.updateTable();
            })
        },
    },
    mounted(){
        this.$events.on('update_players_table', (data) => {
            this.updateTable();
        });
        this.$root.$on('isClose', (data) => {
            this.openDialog = false;
        });
        this.$root.$on('QRCodeisClose', (data) => {
            this.uploadQRopenDialog = false;
        });
        
    }
}
</script>
