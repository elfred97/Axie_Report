<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-3">
                <div class="dataTables_length" id="data-table-default_length">
                    <label>Date 
                        <v-datepicker v-model="filtersParam.date" range @change="updateTable()" class=""></v-datepicker>
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <account-list-component @updateAccountList="account_selected = $event"></account-list-component>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <loading :active.sync="isLoading" 
                    :can-cancel="true" 
                    :on-cancel="onCancel"
                    :is-full-page="fullPage"></loading>
                <vuetable ref="vuetable"
                    :api-url="'/getScholarImport'"
                    :fields="fields"
                    :css="css"
                    :per-page="perPage"
                    data-path="data"
                    :sort-order="sortOrder"
                    :append-params="filtersParam"
                    pagination-path=""
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
    </div>
</template>
<script>
import {TableMixins} from '../../pages/TableMixins';
import { TableStyle } from '../../pages/TableStyle.js';
import FieldsDef from "./ScholarImportedFieldsDef.js";
export default {
    mixins : [ TableMixins ],
    data() {
        return {
            fields      : FieldsDef,
            perPage     : 15,
            css         : TableStyle,
            filtersParam: {
                date: '',
                account_name : ''
            },
            isLoading: false,
            fullPage : true,
            sortOrder: [
                {
                    field    : "type",   // Choose the Defualt Sorted Data by name
                    direction: "desc"    // Sorting Direction
                }
            ],
            lowest_mmr      : 800,
            account_selected : {
                account_name : '',                
            }
        }
    },
    watch : {
        'account_selected' : function(newVal){
            if(newVal){
                this.filtersParam.account_name = newVal.account_name;
                this.updateTable();
            }
        }
    },
}
</script>