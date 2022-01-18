<template>
    <div>
        <div class="section-container">
            <div class="row no-margin">
                <div class="col-md-10 offset-md-1">
                    <div class="container">
                        <h3>Notification</h3>
                        <div class="row">
                            <!-- <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Search 
                                        <input 
                                            type="text" 
                                            aria-controls="data-table-default" 
                                            placeholder="Search Notification" 
                                            class="custom-input custom-input-sm form-control form-control-sm" 
                                            v-model="search" 
                                            v-on:keyup.enter="getAnnouncement()">
                                    </label>
                                </div>
                            </div> -->
                            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                                <category-list-component @updateCategoryList="category = $event"></category-list-component>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                                <account-list-component :account='true' @updateAccountList="account_selected = $event"></account-list-component>
                            </div>
                        </div>
                        <div class="vertical-box-row">
                            <!-- begin vertical-box-cell -->
                            <div class="vertical-box-cell">
                                <!-- begin vertical-box-inner-cell -->
                                <div class="vertical-box-inner-cell bg-white" v-if="notificationsData.length > 0">
                                    <!-- begin scrollbar -->
                                    <div class="slimScrollDiv inbox" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                                        <div data-scrollbar="true" data-height="100%" data-init="true" style="overflow: hidden; width: auto; height: 100%;">
                                            <!-- begin list-email -->                                            
                                            <ul class="list-group list-group-lg no-radius list-email">
                                                <li class="list-group-item list-group-item-title">
                                                    <div class="email-user"></div>
                                                    <div class="email-info">
                                                        <div class="row no-margin">
                                                            <div class="col-md-3 text-bold">Account Name</div>
                                                            <div class="col-md-5 text-bold">Description</div>
                                                            <div class="col-md-2 text-bold">Status</div>
                                                            <div class="col-md-2 text-bold">Date</div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item" v-for="notification in notificationsData" :class="notification.status == 1 ? 'unread' : 'read'">
                                                    <a href="" class="email-user bg-blue">
                                                        <span class="text-white"><i class="fas fa-bullhorn"></i></span>
                                                    </a>
                                                    <div class="email-info">
                                                        <div class="row no-margin">
                                                            <div class="col-md-3">
                                                                {{ notification.account_name }}
                                                            </div>
                                                            <div class="col-md-5">
                                                                <span v-if="notification.category != 3">
                                                                    Penalty: 
                                                                    {{ notification.penalty }} - 
                                                                    
                                                                    <span v-if="notification.category == 1">Minimum SLP not met</span>
                                                                    <span v-else-if="notification.category == 2">Minimum MMR not met</span>
                                                                </span>
                                                                <span v-else>
                                                                    Terminated
                                                                </span>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span v-if="notification.status == 1">Unread</span>
                                                                <span v-else>Read</span>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{ notification.created_at | formatTimeDate }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- end list-email -->
                                        </div>
                                    </div>
                                    <!-- end scrollbar -->
                                </div>
                                <!-- end vertical-box-inner-cell -->
                                <div v-else class="no_result_found">
                                    <img src="/img/no_result_found.png" alt="">
                                    <p>No result found.</p>
                                </div>
                            </div>
                            <!-- end vertical-box-cell -->
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            notificationsData: {},
            // search           : '',
            account_selected : '',
            category         : '',
        }
    },
    watch : {
        'account_selected' : function(newVal){
            // if(newVal)
                this.getNotification();
        },
        'category' : function(newVal){
            // if(newVal){
                this.getNotification();
            // }
        }
    },
    methods: {
        getNotification(){
            let account_type = this.$store.state.global_guard_type;
            this.axios.get('getScholarNotification', {
                params : {
                    // search : this.search,
                    account_name : this.account_selected.account_name,
                    category : this.category,
                }
            })
            .then(response => {
                // console.log(response.data);
                this.notificationsData = response.data;
            })
            .catch( error => {
                console.log(error.response.data);
            })
        }
    },
    mounted(){
        this.getNotification();
    }
}
</script>