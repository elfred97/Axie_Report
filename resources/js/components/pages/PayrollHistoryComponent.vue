<template>
    <div>
        <dialog-component v-bind:isOpen="openDialog" v-on:isClose="openDialog = false" modalWidth="30%" :dialogTitle="'Update Payroll History Information'">
            <payroll-history-form-component v-bind:payrollData="selected_payroll" v-on:closeModal="openDialog = false"></payroll-history-form-component>
        </dialog-component>
        <div class="section-container main-content-view bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <input name="file" type="file" ref="file" @change="importPayroll()" class="hide">
                            <button class="btn btn-primary btn-sm"  @click="$refs.file.click()"><i class="fa fa-plus"></i> Import Payroll</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- begin tabs -->
                        <ul class="nav nav-tabs nav-tabs-default" data-sortable-id="index-2">
                            <li class="nav-item"><a href="#pending" data-toggle="tab" class="nav-link active"><i class="fa fa-file-invoice fa-lg m-r-5"></i> <span class="d-none d-md-inline">Pending Payroll</span></a></li>
                            <li class="nav-item"><a href="#paid" data-toggle="tab" class="nav-link"><i class="fas fa-file-invoice-dollar fa-lg m-r-5"></i> <span class="d-none d-md-inline">Paid Payroll</span></a></li>
                        </ul>
                        <div class="tab-content" data-sortable-id="index-3">
                            <div class="tab-pane fade active show" id="pending">
                                <div class="row no-margin">
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Year 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePendingPayroll()"
                                                    v-model="filtersParam.year"
                                                    >
                                                        <option :value="year" v-for="year in year">{{ year}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Month 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePendingPayroll()"
                                                    v-model="filtersParam.month"
                                                    >
                                                        <option :value="index + 1" v-for="(month, index) in month">{{ month}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <type-component :type="filtersParam.type" @updateType="filtersParam.type = $event"></type-component>
                                    </div>
                                    <div class="col-md-3 offset-md-3">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Search 
                                                <input type="text" class="form-control form-control-sm custom-input custom-input-sm" placeholder="Search scholar name" @change="updatePendingPayroll()" v-model="filtersParam.search">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <loading :active.sync="isLoading" 
                                            :can-cancel="true" 
                                            :on-cancel="onCancel"
                                            :is-full-page="fullPage"></loading>
                                        <vuetable ref="pending_payroll"
                                            :api-url="'/getPayrollHistory/pending'"
                                            :fields="fields"
                                            :css="css"
                                            :per-page="perPage"
                                            :append-params="filtersParam"
                                            data-path="data"
                                            pagination-path=""
                                            :sort-order="sortOrder"
                                            @vuetable:pagination-data="onPaginationDataPending"
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
                                            <div slot="actions" slot-scope="props">
                                                <button class="btn btn-xs btn-default" @click="editPayroll(props.rowData)">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                            </div>
                                        </vuetable>
                                        <!-- End of Vuetable -->
                                    </div>
                                    <!-- Pagination Info -->
                                    <div class="col-md-6">
                                        <vuetable-pagination-info ref="pendingpaginationInfo"
                                        ></vuetable-pagination-info>
                                    </div><!-- End of Pagination Info -->
                                    <!-- Pagination Buttons -->
                                    <div class="col-md-6 text-right">
                                        <vuetable-pagination ref="pendingpagination"
                                            @vuetable-pagination:change-page="onChangePagePending"
                                            :css="css.pagination"
                                        ></vuetable-pagination>
                                    </div><!-- End of Pagination Buttons -->
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="paid">
                                <div class="row no-margin">
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Year 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePaidPayroll()"
                                                    v-model="filtersParam_paid.year"
                                                    >
                                                        <option :value="year" v-for="year in year">{{ year}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Month 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePaidPayroll()"
                                                    v-model="filtersParam_paid.month"
                                                    >
                                                        <option :value="index + 1" v-for="(month, index) in month">{{ month}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <type-component :type="filtersParam_paid.type" @updateType="filtersParam_paid.type = $event"></type-component>
                                    </div>
                                    <div class="col-md-3 offset-md-3">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Search 
                                                <input type="text" class="form-control form-control-sm custom-input custom-input-sm" placeholder="Search scholar name" @change="updatePaidPayroll()" v-model="filtersParam_paid.search">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <loading :active.sync="isLoading" 
                                            :can-cancel="true" 
                                            :on-cancel="onCancel"
                                            :is-full-page="fullPage"></loading>
                                        <vuetable ref="paid_payroll"
                                            :api-url="'/getPayrollHistory/paid'"
                                            :fields="fields"
                                            :css="css"
                                            :per-page="perPage"
                                            :append-params="filtersParam_paid"
                                            data-path="data"
                                            pagination-path=""
                                            :sort-order="sortOrder"
                                            @vuetable:pagination-data="onPaginationDataPaid"
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
                                            <div slot="actions" slot-scope="props">
                                                <button class="btn btn-xs btn-default" @click="editPayroll(props.rowData)">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                            </div>
                                        </vuetable>
                                        <!-- End of Vuetable -->
                                    </div>
                                    <!-- Pagination Info -->
                                    <div class="col-md-6">
                                        <vuetable-pagination-info ref="paidpaginationInfo"
                                        ></vuetable-pagination-info>
                                    </div><!-- End of Pagination Info -->
                                    <!-- Pagination Buttons -->
                                    <div class="col-md-6 text-right">
                                        <vuetable-pagination ref="paidpagination"
                                            @vuetable-pagination:change-page="onChangePagePaid"
                                            :css="css.pagination"
                                        ></vuetable-pagination>
                                    </div><!-- End of Pagination Buttons -->
                                </div>
                            </div>
                        </div>
                        <!-- end tabs -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {TableMixins} from './TableMixins';
import { TableStyle } from './TableStyle.js';
// import FieldsDef from "./ImportedFieldsDef.js";
import FieldsDef from "./PayrollHistoryFieldsDef.js";
import PayrollHistoryFormComponent from './PayrollHistoryFormComponent.vue';
export default {
    mixins : [TableMixins],
    data(){
        return {
            fields   : FieldsDef,
            perPage  : 15,
            data     : [],
            css      : TableStyle,
            fullPage : true,
            isLoading: false,
            sortOrder: [
                {
                    field    : 'ronin_address',   // Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
                // {
                //     field    : 'total_slp',   // Choose the Defualt Sorted Data by name
                //     direction: 'desc',
                // },
                // {
                //     field    : 'account_name',   // Choose the Defualt Sorted Data by name
                //     direction: 'desc',
                // },
            ],
            filtersParam : {
                month : '',
                year  : '',
                type  : '',
                search: '',
            },
            filtersParam_paid : {
                month : '',
                year  : '',
                type  : '',
                search: '',
            },
            year       : [ 2020 , 2021 ],
            month      : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            payrollData: {},
            openDialog : false,
            isLoading  : false,
            fullPage   : true,
            selected_payroll : {},
            import_file : "",
        }
    },
    watch : {
        'filtersParam.type': function(newVal){
            this.updatePendingPayroll();
        },
        'filtersParam_paid.type': function(newVal){
            this.updatePaidPayroll();
        }
    },
    components: {
        'payroll-history-form-component' : PayrollHistoryFormComponent
    },
    methods: {
        // updatePayroll(status,  data){
        //     this.axios.post('updatePayrollHistory', {
        //         id : data.id,
        //         status : status
        //     })
        //     .then( response => {
        //         this.$noty.success(response.data.message);
        //         this.updatePendingPayroll();
        //         this.updatePaidPayroll();
        //     })
        // },
        updatePendingPayroll(){
            Vue.nextTick( () => this.$refs.pending_payroll.refresh())
        },
        onPaginationDataPending(paginationData) {
            this.$refs.pendingpagination.setPaginationData(paginationData);
            this.$refs.pendingpaginationInfo.setPaginationData(paginationData);
        },
        onPaginationDataPaid(paginationData) {
            this.$refs.paidpagination.setPaginationData(paginationData);
            this.$refs.paidpaginationInfo.setPaginationData(paginationData);
        },
        onChangePagePending(page) {
            this.$refs.pending_payroll.changePage(page);
        },
        updatePaidPayroll(){
            Vue.nextTick( () => this.$refs.paid_payroll.refresh())
        },
        onChangePagePaid(page) {
            this.$refs.paid_payroll.changePage(page);
        },
        editPayroll(data){
            this.selected_payroll = data;
            this.openDialog =  true;
        },
        importPayroll() {
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

            this.axios.post('/importPayroll',
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
                this.updatePendingPayroll();
                this.updatePaidPayroll();
            })

        }
    },
    mounted(){
        this.$events.on('update_payroll_history_table', (data) => {
            this.updatePendingPayroll();
            this.updatePaidPayroll();
        });
        this.$root.$on('isClose', (data) => {
            this.openDialog = false;
        });
    }
}
</script>