<template>
	<div>
		<!-- BEGIN #notification -->
		<div id="notification" class="section-container main-content-view bg-white">
			<!--  -->
			<div class="row no-margin mt-2">
				<div class="container">
					<div class="col-lg-3 col-md-3 col-sm-12">
						<v-datepicker 
							v-model="filtersParam.date" 
							valueType="format" 
							placeholder="Select date" 
							format="MM/DD/YYYY"
							@change="updateTable()"
							/>
					</div>
				</div>
			</div>
			<div class="row no-margin mt-1">
				<div class="container inbox">
					<!-- begin scrollbar -->
					<div data-scrollbar="true" data-height="100%" v-if="notificationData.length > 0">
						<!-- begin list-email -->
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
                            :detail-row-component="detailRow"
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
					<div class="text-center" v-else-if="notificationData.length == 0 && date != null">
						<i class="fas fa-search fa-2x"></i>
						<p class="no-margin">No data found. Try a different date</p>
					</div>
					<div class="text-center" v-else>
						<i class="fas fa-search fa-2x"></i>
						<p class="no-margin">No data found.</p>
					</div>
					<!-- end scrollbar -->
				</div>
			</div>
		</div>
		<!-- END #notification -->
	</div>
</template>
<script>
import { TableMixins } from './TableMixins';
import { TableStyle } from './TableStyle.js';
import FieldsDef from "./ImportedFieldsDef.js";
export default {
	mixins : [ TableMixins ],
	data(){
		return {
			fields     : FieldsDef,
			perPage    : 15,
			perPage: '',
			css        : TableStyle,
			notificationData : {},
			date : null,
			filtersParam : {
                date : ""
            },
            isLoading : false,
            fullPage  : true, 
		}
	},
	methods: {
        getNotification(){
            this.axios.get('/getNotification',
			{
				params : {
					date : (this.date != null) ? moment(this.date).format('YYYY-MM-DD') : null
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