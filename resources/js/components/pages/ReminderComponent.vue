<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Reminder</h4>
                <div class="panel-heading-btn">
                    <button class="btn btn-xs btn-success" @click="$root.$emit('showDialog', true, 'add-reminder-form', 'New Reminder', '30%')">
                        <i class="fas fa-plus"></i> New Reminder
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <loading :active.sync="isLoading" 
                            :can-cancel="true" 
                            :on-cancel="onCancel"
                            :is-full-page="fullPage"></loading>
                        <vuetable ref="vuetable"
                            :api-mode="false"
                            :fields="fields"
                            :per-page="perPage"
                            :data-manager="dataManager"
                            pagination-path="pagination"
                            @vuetable:pagination-data="onPaginationData"
                            >
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
        </div>
    </div>
</template>
<script>
import {TableMixins} from './TableMixins';
import { TableStyle } from './TableStyle.js';
import FieldsDef from "./reminderFieldsDef.js";
export default {
    mixins : [TableMixins],
    data () {
        return {
            fields    : FieldsDef,
            perPage   : 15,
            data      : [],
            isLoading: false,
            fullPage  : true,
            css       : TableStyle,
        }
    },
    watch: {
        data(newVal, oldVal) {
        this.$refs.vuetable.refresh();
        }
    },
    methods: {
        
        getReminder(){
            this.axios.get("getReminder")
            .then(response => {
                this.data = response.data.reminders.data;
            })
            .catch(error => {
                console.log(error)
            });
        },
        
        dataManager(sortOrder, pagination) {
            if (this.data.length < 1) return;

            let local = this.data;

            // sortOrder can be empty, so we have to check for that as well
            if (sortOrder.length > 0) {
                console.log("orderBy:", sortOrder[0].sortField, sortOrder[0].direction);
                local = _.orderBy(
                local,
                sortOrder[0].sortField,
                sortOrder[0].direction
                );
            }

            pagination = this.$refs.vuetable.makePagination(
                local.length,
                this.perPage
            );
            console.log('pagination:', pagination)
            let from = pagination.from - 1;
            let to = from + this.perPage;

            return {
                pagination: pagination,
                data: _.slice(local, from, to)
            };
        },
    },
    mounted(){
        this.getReminder();
    }
}
</script>
