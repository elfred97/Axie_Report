<template>
	<div>
		<div class="section-container">
            <div class="row no-margin">
                <div class="col-md-10 offset-md-1">
                    <div class="container">
                        <h3>Announcement</h3>
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Search 
                                        <input 
                                            type="text" 
                                            aria-controls="data-table-default" 
                                            placeholder="Search Announcement" 
                                            class="custom-input custom-input-sm form-control form-control-sm" 
                                            v-model="search" 
                                            v-on:keyup.enter="getAnnouncement()">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="vertical-box-row">
                            <!-- begin vertical-box-cell -->
                            <div class="vertical-box-cell" v-if="announcementsData.length > 0">
                                <!-- begin vertical-box-inner-cell -->
                                <div class="vertical-box-inner-cell bg-white">
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
                                                <li class="list-group-item unread" v-for="announcement in announcementsData">
                                                    <a class="email-user bg-blue">
                                                        <span class="text-white"><i class="fas fa-bullhorn"></i></span>
                                                    </a>
                                                    <div class="email-info">
                                                        <div class="row no-margin">
                                                            <div class="col-md-3">
                                                                {{ announcement.title }}
                                                            </div>
                                                            <div class="col-md-5">
                                                                {{ announcement.description }}
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{ announcement.notif_status }}
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{ announcement.created_at | formatDate }}
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
                            </div>
                            <!-- end vertical-box-cell -->
                            <div v-else class="no_result_found">
                                <img src="/img/no_result_found.png" alt="">
                                <p>No result found.</p>
                            </div>
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
            announcementsData : {},
            search : '',
        }
    },
    methods: {
        getAnnouncement(){
            let account_type = this.$store.state.global_guard_type;
            this.axios.get('notifications/'+account_type, {
                params : {
                    search: this.search,
                }
            })
            .then(response => {
                // console.log(response.data);
                this.announcementsData = response.data;
            })
            .catch( error => {
                console.log(error.response.data);
            })
        }
    },
    mounted(){
        this.getAnnouncement();
    }
}
</script>