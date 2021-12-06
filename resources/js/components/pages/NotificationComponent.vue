<template>
	<div>
		<!-- BEGIN #notification -->
		<div id="notification" class="section-container main-content-view bg-white">
			<!--  -->
            <div class="container">
			    <div class="row no-margin mt-2">
					<div class="col-lg-3 col-md-3 col-sm-12">
                        <label>Date 
                            <v-datepicker 
                                v-model="filtersParam.date" 
                                valueType="format" 
                                type="date"
                                format="YYYY-MM-DD" range 
                                @change="updateTable()"></v-datepicker>
                        </label>
					</div>
				</div>
			
                <div class="row no-margin mt-1">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <loading :active.sync="isLoading" 
                            :can-cancel="true" 
                            :on-cancel="onCancel"
                            :is-full-page="fullPage"></loading>
                        <vuetable ref="vuetable"
                            :api-url="'/getNotification'"
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
                        
                            <div slot="actions" slot-scope="props">
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
                        <!-- end list-email -->
                </div>
            </div>
		</div>
		<!-- END #notification -->
	</div>
</template>
<script>
import { TableMixins } from './TableMixins';
import { TableStyle } from './TableStyle.js';
import FieldsDef from "./NotificationFieldsDef.js";
export default {
	mixins : [ TableMixins ],
	data(){
		return {
			fields     : FieldsDef,
			perPage    : 15,
			css        : TableStyle,
			notificationData : {},
			date : null,
			filtersParam : {
                date : ""
            },
            isLoading : false,
            fullPage  : true, 
            sortOrder  : [
                {
                    field    : "account_name",   // Choose the Defualt Sorted Data by name
                    direction: "desc"    // Sorting Direction
                }
            ],
		}
	},
	methods: {
        getNotification(){
            this.axios.get('/getNotification',
			{
				params : {
					date : (this.filtersParam.date != null) ? moment(this.filtersParam.date).format('L') : null
				}
			})
            .then((response) => {
                this.notificationData = response.data;
            })
            .catch((error) => {
                // this.clearAll();
                console.log(error.response.data)
            })
        }
    },
    created(){
        this.getNotification();
		
    }
}
</script>