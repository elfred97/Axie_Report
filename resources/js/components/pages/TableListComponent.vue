<template>
    <div>
        <!-- BEGIN #tablet-list -->
        <div id="table-list" class="section-container bg-white mb-2">
            <!-- BEGIN container -->
            <!-- <div class="container"> -->
                <div class="row no-margin">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <type-component :type="filtersParam.type" @updateType="filtersParam.type = $event"></type-component>
                    </div>
                    <div class="col-lg-4 offset-lg-5 col-md-4 offset-md-5 col-sm-12">
                        <div class="row">
                            <div class="col-lg-4">
                                1st Penalty: <span class="btn btn-xs btn-info">{{ penalties.first }}</span> 
                            </div>
                            <div class="col-lg-4">
                                2nd Penalty: <span class="btn btn-xs btn-warning">{{ penalties.second }}</span> 
                            </div>
                            <div class="col-lg-4">
                                3rd Penalty: <span class="btn btn-xs btn-danger">{{ penalties.third }}</span> 
                            </div>
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
                            :api-url="'/getReport'"
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
            <!-- </div> -->
            <!-- END container -->
        </div>
        <!-- END Table List -->
    </div>
</template>
<script>
import {TableMixins} from './TableMixins';
import { TableStyle } from './TableStyle.js';
// import FieldsDef from "./ImportedFieldsDef.js";
import FieldsDef from "./FieldsDef.js";
import ImportedDetailRow from "./ImportedDetailRow.vue";
export default {
    mixins : [TableMixins],
    data () {
        return {
            fields    : FieldsDef,
            perPage   : 15,
            data      : [],
            reportData: {},
            type      : '',
            css       : TableStyle,
            detailRow : ImportedDetailRow,
            lowest_mmr : 800,
            sortOrder : {
                type : 'type_name',
                order: "desc",
            },
            penalties : {
                first : 0,
                second: 0,
                third : 0,
            },
            filtersParam : {
                type : ""
            },
            fullPage  : true,
            isLoading: false,
            sortOrder: [
                {
                    field    : 'ronin_address',   // Choose the Defualt Sorted Data by name
                    direction: 'desc',
                },
                // {
                //     field    : 'average_per_day',   // Choose the Defualt Sorted Data by name
                //     direction: 'desc',
                // },
                // {
                //     field    : 'created_at',   // Choose the Defualt Sorted Data by name
                //     direction: 'desc',
                // },
            ],
        }
    },
    watch:{
        'reportData': function(newVal){
            this.reportData = newVal;
        },
        'sortOrder.type' : function(newVal){
            this.getReport();
        },
        'sortOrder.order' : function(newVal){
            this.getReport();
        },
        'filtersParam.type' : function(newVal){
            if(newVal == '')
            {
                this.penalties = {
                    first : 0,
                    second : 0,
                    third : 0,
                }
            }
            this.updateTable();
            this.getPenalties(newVal);
        }
    },
    methods: {
        // getReport(){
        //     this.axios.get('/getReport', {
        //         params:{
        //             type     : this.type,
        //             sortType : this.sortOrder.type,
        //             sortOrder: this.sortOrder.order,
        //         }
        //     })
        //     .then((response) => {
        //         this.reportData = response.data;
        //     })
        //     .catch((error) => {
        //         // this.clearAll();
        //         console.log(error.response.data)
        //     })
        // },
        getDayEarn(data){
            if(data.length >= 2)
                return data[data.length - 1].total_slp - data[data.length - 2].total_slp;
            else
                return data[data.length - 1].total_slp;
        },
        sortTable(type){
            if(this.sortOrder.type == type){
                this.sortOrder.order = (this.sortOrder.order == 'asc') ? 'desc' : 'asc';
            }
            this.sortOrder.type = type;
        },
        resetPenalties(){
            this.penalties = {
                first : 0,
                second : 0,
                third : 0,
            }
        },
        getPenalties(type){
            if(type != ''){
                this.axios.get('/penalty-count/'+type)
                .then((response) => {
                    this.resetPenalties();
                    response.data.penalties.forEach( element => {
                        if(element.penalty == 1)
                            this.penalties.first = element.total;
                        else if(element.penalty == 2)
                            this.penalties.second = element.total;
                        else if(element.penalty == 3)
                            this.penalties.third = element.total;
                    });
                    
                })
                .catch((error) => {
                    // this.clearAll();
                    console.log("error")
                })
            }
        }
    },
}
</script>
