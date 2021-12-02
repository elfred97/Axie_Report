<template>
    <div>
        <div id="header" class="header">
            <!-- BEGIN container -->
            <div class="container">
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
                                <!-- <li>
                                    <router-link to="/payroll_history" v-if="getGuardType == 'admins'">Payroll History</router-link>
                                    <router-link to="/scholar_payroll" v-else>Payroll History</router-link>
                                </li> -->
                                <li v-if="getGuardType == 'admins'">
                                    <router-link to="/scholarList">Scholars</router-link>
                                </li>
                                <li>
                                    <router-link to="/notification" v-if="getGuardType == 'admins'">Notification</router-link>                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END header-nav -->
                    <!-- BEGIN header-nav -->
                    <div class="header-nav">
                        <ul class="nav pull-right" >
                            <li class="dropdown dropdown-hover" v-if="getGuardType == 'admins'">
                                <a href="#" class="header-cart" data-toggle="dropdown">
                                    <i class="fa fa-bell"></i>
                                    <span class="total" v-if="notificationData.length > 0">{{ notificationData.length }}</span>
                                    <span class="total" v-else>0</span>
                                    <span class="arrow top"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-cart p-0">
                                    <div class="cart-header">
                                        <h4 class="cart-title text-center">Not meeting 75 SLP </h4>
                                    </div>
                                    <div class="cart-body scroll-h h-15">
                                        <ul class="cart-item" v-if="notificationData.length > 0">
                                            <li v-for="notification in notificationData" >
                                                <div class="cart-item-info" @click="gotoNotification">
                                                    <small class="pull-right">{{notification.created_at | formatDate}}</small>
                                                    <h4><b>{{ notification.player_name }}</b> <span class="pull-right">{{ notification.account_name }}</span></h4>
                                                    <p class="price">{{ notification.gained_slp_today }} SLP</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <p class="text-center no-margin" v-else> No Notification
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <center>
                                                    <router-link to="/notification" class="btn btn-sm btn-default" v-if="getGuardType == 'admins'">View All</router-link>
                                                    <router-link to="/scholar_notification" class="btn btn-sm btn-default" v-else>View All</router-link>
                                                    <!-- <button class="btn btn-sm btn-default">View All</button> -->
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown dropdown-hover" v-else>
                                <a href="#" class="header-cart" data-toggle="dropdown">
                                    <i class="fa fa-bell"></i>
                                    <span class="total" v-if="notificationData.length > 0">{{ notificationData.length }}</span>
                                    <span class="total" v-else>0</span>
                                    <span class="arrow top"></span>
                                </a>
                                <div class="dropdown-menu media-list  dropdown-menu-cart p-0">
                                    <a href="javascript:;" class="dropdown-item media">
                                        <div class="media-left">
                                            <i class="fa fa-bug media-object bg-silver-darker"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
                                            <div class="text-muted f-s-10">3 minutes ago</div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="dropdown dropdown-hover">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- <img src="assets/img/user/user-13.jpg" alt="" />  -->
                                    <span class="d-none d-md-inline">{{ accountData.first_name }} {{ accountData.last_name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- <span href="javascript:;" class="dropdown-item">Settings</span> -->
                                    <router-link to="/settings" v-if="getGuardType == 'admins'" class="dropdown-item">Settings</router-link>
                                    <div class="dropdown-divider" ></div>
                                    <a href="/logout" class="dropdown-item">Log Out</a>
                                </div>
                            </li>
                        </ul>
                        <!-- <ul class="nav pull-right">
                            <li>
                                <a href="/logout">Log Out</a>
                            </li>
                        </ul> -->
                    </div>
                    <!-- END header-nav -->
                </div>
                <!-- END header-container -->
            </div>
            <!-- END container -->
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            notificationData: {},
            accountData     : {},
        }
    },
    computed : {
        getGuardType(){
            return this.$store.state.global_guard_type;
        }
    },
    methods: {
        getNotification(){
            if(this.$store.state.global_guard_type == 'admins'){
                this.axios.get('/getNotification',{
                    params : {
                        date : 'today'
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
            else{

            }
        },
        getAccountInfo(){
            if(this.$store.state.global_guard_type == 'admins'){
                this.axios.get('/getAccountInfo')
                .then((response) => {
                    this.accountData = response.data;
                })
                .catch((error) => {
                    // this.clearAll();
                    console.log(error.response.data)
                })
            }
        },
        gotoNotification(){
            let routeData = this.$router.resolve({name: 'notification'}); 
            window.open(routeData.href, '_blank');
        },
        getAnnouncement(){
            let account_type = this.$store.state.global_guard_type;

            console.log(account_type);

            this.axios.get('notifications/'+account_type)
            .then(response => {
                console.log(response.data);
            })
            .catch( error => {
                console.log(error.response.data);
            })
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