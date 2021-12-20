<template>
    <div>
        <div class="section-container">
            <div class="row no-margin">
                <div class="col-md-10 offset-md-1">
                    <div class="container">
                        <h3>Notification</h3>
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-8 col-xs-12">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Search 
                                        <input type="text" aria-controls="data-table-default" placeholder="Search Notification" class="custom-input custom-input-sm form-control form-control-sm" v-model="search" @change="getAnnouncement()">
                                    </label>
                                </div>
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
                                                <li class="list-group-item unread" v-for="notification in notificationsData">
                                                    <a href="email_detail.html" class="email-user bg-blue">
                                                        <span class="text-white"><i class="fas fa-bullhorn"></i></span>
                                                    </a>
                                                    <div class="email-info">
                                                        <a href="email_detail.html">
                                                            <span class="email-title">
                                                                {{ notification.account_name }}
                                                            </span>
                                                            <span class="email-desc">
                                                                Penalty: 
                                                                {{ notification.penalty }} - 
                                                                
                                                                <span v-if="notification.category == 1">Minimum SLP not met</span>
                                                                <span v-else-if="notification.category == 2">Minimum MMR not met</span>
                                                                
                                                            </span>
                                                            <span class="email-time">
                                                                {{ notification.created_at | formatTimeDate }}
                                                            </span>
                                                        </a>
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
            notificationsData : {},
            search: '',
        }
    },
    methods: {
        getNotification(){
            let account_type = this.$store.state.global_guard_type;
            this.axios.get('getScholarNotification/', {
                params : {
                    search : this.search
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