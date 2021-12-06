<template>
    <div>
        <div class="section-container main-content-view bg-white">
            <div class="container">
                <div class="row">
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
                                                        <option :value="month" v-for="month in month">{{ month}}</option>
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
                                                    class="btn btn-xs btn-primary" 
                                                    @click="updatePayroll('pending', props.rowData)"
                                                >
                                                    Set as Paid
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
                                                        <option :value="month" v-for="month in month">{{ month}}</option>
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
                                                <input type="text" class="form-control form-control-sm custom-input custom-input-sm" placeholder="Search scholar name" @change="updatePendingPayroll" v-model="filtersParam.search">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="no-margin media-list media-list-with-divider mt-2">
                                    <li v-for="payroll in payrollData" v-if="payroll.status == 1">
                                        <div class="row no-margin">
                                            <div class="col-md-4">
                                                <h6 class="no-margin">Scholar Name <span>(Account Name)</span></h6>
                                                <span>Ronin Address: </span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b for="">30%: </b> 8</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b>40%: </b> 4 </span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="text-center"><b>Total: </b> 12</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="no-margin">TX ID: </p>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-xs btn-default"><i class="fas fa-check"></i> Cancel</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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
export default {
    mixins : [TableMixins],
    data(){
        return {
            fields    : FieldsDef,
            perPage   : 15,
            data      : [],
            css       : TableStyle,
            fullPage  : true,
            isLoading: false,
            sortOrder: [
                {
                    field    : 'total_slp',   // Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
                {
                    field    : 'ronin_address',   // Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
                {
                    field    : 'account_name',   // Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
            ],
            filtersParam : {
                month : '',
                year  : '',
                type  : '',
                search: '',
            },
            year       : [ 2020 , 2021 ],
            month      : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            payrollData: {},
        }
    },
    watch : {
        'filter.type': function(newVal){
            this.getGraph();
        }
    },
    methods: {
        updatePendingPayroll(){
            Vue.nextTick( () => this.$refs.pending_payroll.refresh())
        },
        onChangePagePending(page) {
            this.$refs.pending_payroll.changePage(page);
        },
    },

}
</script>