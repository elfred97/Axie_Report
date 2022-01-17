<template>
    <div>
        <div id="header" class="header">
            <!-- BEGIN container -->
            <!-- <div class="container"> -->
                <!-- BEGIN header-container -->
                <div class="header-container">
                    <!-- BEGIN navbar-toggle -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- END navbar-toggle -->
                    <!-- BEGIN header-logo -->
                    <div class="header-logo">
                        <span class="brand-logo"><img src="/img/pet-logo.png" alt=""></span>
                        <span class="brand-text">
                            <span class="text-primary">Axie Tracking Report</span>
                        </span>
                    </div>
                    <!-- END header-logo -->
                    <!-- BEGIN header-nav -->
                    <div class="header-nav">
                        <div class=" collapse navbar-collapse" id="navbar-collapse">
                            <ul class="nav">
                                <li>
                                    <router-link to="/home" v-if="getGuardType == 'admins'">Home</router-link>
                                    <router-link to="/scholars" v-else>Home</router-link>
                                </li>                                
                                <li v-if="getGuardType == 'admins'">
                                    <router-link to="/game_logs">Game Logs</router-link>
                                </li>                                
                                <li>
                                    <router-link to="/players" v-if="getGuardType == 'admins'">Axie Accounts</router-link>
                                    <router-link to="/scholar_account" v-else>Account</router-link>
                                </li>                                
                                <li>
                                    <router-link to="/payroll_history" v-if="getGuardType == 'admins'">Payroll History</router-link>
                                    <router-link to="/scholar_payroll" v-else>Payroll History</router-link>
                                </li>
                                <li>
                                    <router-link to="/scholarList" v-if="getGuardType == 'admins'">Scholars</router-link>
                                    <router-link to="/scholar_announcement" v-else>Announcement</router-link>
                                </li>
                                <li>
                                    <router-link to="/notification" v-if="getGuardType == 'admins'">Notification</router-link>
                                    <router-link to="/scholar_notification" v-else>Notification</router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END header-nav -->
                    <!-- BEGIN header-nav -->
                    <div class="header-nav">
                        <ul class="nav pull-right" >
                            <li class="dropdown dropdown-hover">
                                <a href="#" class="header-cart" data-toggle="dropdown" v-if="getTotal > 0">
                                    <i class="fa fa-bell"></i>
                                    <span class="total">{{ getTotal }}</span>
                                    <span class="arrow top"></span>
                                </a>
                                <div class="dropdown-menu media-list dropdown-menu-cart">
                                    <div v-if="notification_count > 0">
                                        <div class="dropdown-header">Penalty</div>
                                        <a href="javascript:;" class="dropdown-item media" v-for="notification in notificationData" @click="gotoNotification(notification)" v-if="checkStatus(notification, 'notification')">
                                            <div class="media-left">
                                                <i class="fa fa-exclamation-triangle media-object text-warning"></i>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-muted f-s-10 pull-right">{{ notification.created_at | formatDate }}</div>
                                                <h6 class="media-heading"> {{ notification.scholar_name }} ({{ notification.account_name }})</h6>
                                                <p v-if="notification.category == 1"> {{ notification.gained_slp_today }} SLP </p>
                                                <p v-if="notification.category == 2"> {{ notification.mmr }} MMR </p>
                                            </div>
                                        </a>
                                    </div>
                                    <div v-if="announcement_count > 0">
                                        <div class="dropdown-header">Announcement</div>
                                        <a href="javascript:;" class="dropdown-item media" v-for="announcement in announcementsData" @click="gotoAnnouncement" v-if="checkStatus(announcement, 'announcement')">
                                            <div class="media-left">
                                                <i class="fa fa-bullhorn media-object bg-silver-darker"></i>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-muted f-s-10 pull-right"> {{ announcement.reminder_time | formatDateTime }}</div>
                                                <h6 class="media-heading">{{ announcement.title }}</h6>
                                                <p>{{ announcement.description }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown dropdown-hover">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- <img src="assets/img/user/user-13.jpg" alt="" />  -->
                                    <span class="d-none d-md-inline">{{ accountData.first_name }} {{ accountData.last_name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div v-if="getGuardType == 'admins'">
                                        <router-link to="/settings" class="dropdown-item"><i class="fas fa-sliders-h"></i> Settings</router-link>
                                        <div class="dropdown-divider" ></div>
                                    </div>
                                    <!-- <a href="/api_sample" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> API Sample</a> -->
                                    <a href="/logout" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- END header-nav -->
                </div>
                <!-- END header-container -->
            <!-- </div> -->
            <!-- END container -->
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            notificationData : {},
            accountData      : {},
            announcementsData: {},
            total_count : 0,
            notification_count : 0,
            announcement_count : 0,
        }
    },
    watch: {
        'notificationData': function(newVal){
            if(newVal){
                // this.getTotal();
            }
        },
        'announcementsData': function(newVal){
            if(newVal){
                // this.getTotal();
            }
        }
    },
    computed : {
        getGuardType(){
            return this.$store.state.global_guard_type;
        },
        
        getTotal(){
            return this.announcement_count + this.notification_count;
        },
        
    },
    methods: {
        getTotalAnnouncementCount(){
            let ann_count = 0;

            if(this.announcementsData.length > 0)
                this.announcementsData.forEach((element, index) => {                                        
                    if(element.notif_status == 1)
                        ann_count = ann_count + 1;
                });
        
            this.announcement_count = ann_count;
            // return ann_count;
        },
        getTotalNotificationCount(){
            let notif_count = 0;
            if(this.notificationData.length > 0){
                this.notificationData.forEach((element, index) => {                                        
                    if(element.status == 1){
                        notif_count = notif_count + 1;
                    }
                });
            }
            this.notification_count = notif_count;
        },
        getNotification(){
            if(this.$store.state.global_guard_type == 'admins'){
                this.axios.get('/getNotification',{
                    params : {
                        date : 'today'
                    }
                })
                .then((response) => {
                    this.notificationData = response.data;
                    this.getTotalNotificationCount();
                })
                .catch((error) => {
                    // this.clearAll();
                    console.log(error.response.data)
                })
            }
            else{
                this.axios.get('getScholarNotification')
                .then(response => {
                    // console.log(response.data);
                    this.notificationData = response.data;
                    this.getTotalNotificationCount();
                })
                .catch( error => {
                    console.log(error.response.data);
                })
            }
        },
        getAnnouncement(){
            let account_type = this.$store.state.global_guard_type;
            this.axios.get('notifications/'+account_type)
            .then(response => {
                // console.log(response.data);
                this.announcementsData = response.data;
                this.getTotalAnnouncementCount();
            })
            .catch( error => {
                console.log(error.response.data);
            })
        },
        getAccountInfo(){
            // if(this.$store.state.global_guard_type == 'admins'){
                this.axios.get('/getAccountInfo/'+this.$store.state.global_guard_type)
                .then((response) => {
                    this.accountData = response.data;
                })
                .catch((error) => {
                    // this.clearAll();
                    console.log(error.response.data)
                })
            // }
        },
        gotoNotification(data){
            let url      = '';
            let redirect = '';
            if(this.$store.state.global_guard_type == 'admins'){
                redirect = 'changeStatusNotification';
                url = '/notification';
            }
            else{
                redirect = 'changeStatusNotificationScholar';
                url = '/scholar_notification';

            }
            this.axios.post(redirect)
            .then(response => {
                this.getNotification();
            })
            .catch(error => {
                console.log(error.response.data);
            });

            window.open(url, '_self'); 
            
        },
        gotoAnnouncement(){
            this.axios.post('changeStatusReminders')
            .then(response => {
                this.getAnnouncement();
            })
            .catch(error => {
                console.log(error.response.data);
            });

            window.open('/scholar_announcement', '_self'); 
        },
        
        checkStatus(data, type){
            
            if(this.$store.state.global_guard_type == 'admins'){
                if(data.status == 1)
                    return true;
                else
                    return false;
            }
            else{
                if(type == 'notification'){
                    if(data.status == 1)
                        return true;                    
                }
                else if(type == 'announcement'){
                    console.log(type);
                    console.log(data);
                    if(data.notif_status == 1)
                        return true
                }

                return false;
            }
        }
    },
    created(){
        this.getNotification();
        this.getAccountInfo();
        this.getAnnouncement();
        this.$events.on('update_notification', (data) => {
            this.getNotification();
        });        
    }
}
</script>