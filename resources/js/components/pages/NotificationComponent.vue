<template>
	<div>
		<!-- BEGIN #notification -->
		<div id="notification" class="section-container main-content-view bg-white">
			<!--  -->
			<div class="row no-margin mt-2">
				<div class="container">
					<div class="col-lg-3 col-md-3 col-sm-12">
						<v-datepicker 
							v-model="date" 
							valueType="format" 
							placeholder="Select date" 
							format="MM/DD/YYYY"
							@change="getNotification"
							/>
					</div>
				</div>
			</div>
			<div class="row no-margin mt-1">
				<div class="container inbox">
					<!-- begin scrollbar -->
					<div data-scrollbar="true" data-height="100%" v-if="notificationData.length > 0">
						<!-- begin list-email -->
						<ul class="list-group list-group-lg no-radius list-email">
							<li class="list-group-item" v-for="(notification, index) in notificationData">
								<!-- <div class="email-checkbox">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox1">
										<label class="custom-control-label" for="emailCheckbox1"></label>
									</div>
								</div> -->
								<a class="email-user bg-blue">
									<span class="text-white">{{ notification.player_name.charAt(0) }}</span>
								</a>
								<div class="email-info">
									<a >
										<span class="email-sender">{{ notification.player_name }}</span>
										<span class="email-title">{{ notification.account_name }}</span>
										<span class="email-desc">Gained SLP for the day <span class="text-danger">{{ notification.gained_slp_today }}</span> on {{ notification.created_at | formatDate }}</span>
										<span class="email-time">{{ notification.created_at | formatDate }}</span>
									</a>
								</div>
							</li>
						</ul>
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
export default {
	mixins : [ TableMixins ],
	data(){
		return {
			perPage: '',
			notificationData : {},
			date : null
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