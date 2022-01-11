<template>
    <div>
        <dialog-component v-bind:isOpen="openDialog" v-on:isClose="openDialog = false" :key="componentKey" modalWidth="30%" :dialogTitle="this.selected.account_name+' QR Code'">
            <qrcode-view-component v-bind:scholarData="selected" v-on:closeModal="openDialog = false"></qrcode-view-component>
        </dialog-component>
        <div class="section-container">
            <div class="container">
                <div class="row row-space-10 m-b-20">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="account-container">
                            <!-- BEGIN account-sidebar -->
                            <div class="account-sidebar">
                                <div class="account-sidebar-cover">
                                    <img src='assets/img/cover/cover-1.jpg' alt="" />
                                </div>
                                <div class="account-sidebar-content text-center">
                                    <!-- <h4>{{ userData.account_name }}</h4>
                                    <div v-if="userData.qr_code">
                                        <p class="mb-2 mt-2">Scan QR Code</p>
                                        <img :src="getQRCode"  class="img-fluid"/> 

                                        <p class="text-center mt-2">QR Code is valid for 7 days</p>
                                    </div>
                                    <div v-else class="no_qr_code">
                                        <img src="img/no_qr.jpg" alt="" class="img-fluid">
                                        <p class="text-center">No QR Code uploaded</p>
                                    </div> -->
                                    <h2>Welcome to Axie Tracker</h2>
                                    <img src="img/welcome.png" alt="" class="img-fluid">
                                    <p>Track your account and axie</p>
                                </div>
                            </div>
                            <!-- END account-sidebar -->
                            <!-- BEGIN account-body -->
                            <div class="account-body">
                                <!-- BEGIN row -->
                                <div class="row">
                                    <!-- BEGIN col-6 -->
                                    <div class="col-md-7">
                                        <h4>Account Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Name</label>
                                                <p> {{ userData.first_name }} {{ userData.last_name }}</p>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <label for="">Account Name</label>
                                                <p> {{ userData.account_name }} </p>
                                            </div> -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Ronin Address</label>
                                                <p> {{ userData.ronin_address }} </p>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Email</label>
                                                <p> {{ userData.email }} </p>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Date Started</label>
                                                <p> {{ userData.date_started | formatDate }} </p>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Status</label>
                                                <p> {{ userData.status }} </p>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Type</label>
                                                <p> {{userData.type_name}} </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END col-6 -->
                                    <!-- BEGIN col-6 -->
                                    <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading bg-gradient-lime">
                                                <h4 class="panel-title text-white">Ronin Wallet</h4>
                                                <div class="panel-heading-btn">
                                                    <button class="btn btn-xs btn-default" v-if="onEdit == false" @click="onEdit = ! onEdit"><i class="fas fa-pencil-alt"></i> Edit</button>
                                                    <button class="btn btn-xs btn-white" v-else @click="onEdit = ! onEdit"><i class="fas fa-times"></i> Cancel</button>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">Ronin Wallet</label>
                                                        <div v-if="onEdit == true">
                                                            <input type="text" class="form-control mb-2" v-model="userData.ronin_wallet">
                                                            <div class="pull-right">
                                                                <button class="btn btn-primary btn-xs" @click="updateRoninWallet"><i class="fas fa-check"></i> Save</button>
                                                            </div>
                                                        </div>                                                        
                                                        <p v-else class="text-content">{{ userData.ronin_wallet }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END col-6 -->
                                </div>
                                <!-- END row -->
                            </div>
                            <!-- END account-body -->
                        </div>
                    </div>
                </div>
                <div class="row row-space-10 m-b-20">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4>Axie Account</h4>
                        <div class="row h-15">
                            <div class="col-md-12">
                                <ul class="list-group" v-if="scholarHistory">
                                    <li class="list-group-item">
                                        <div class="row no-margin">
                                            <div class="col-md-4 text-bold">Axie Account</div>
                                            <div class="col-md-3 text-bold text-center">Date</div>
                                            <div class="col-md-2 text-bold text-center">Status</div>
                                            <div class="col-md-3 text-bold text-center">QR Code</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item" v-for="(history, index) in scholarHistory">
                                        <div class="row no-margin">
                                            <div class="col-md-4">{{ history.account_name }}</div>
                                            <div class="col-md-3 text-center">
                                                <span v-if="history.status == 1">{{ history.h_created | formatDate }}</span>
                                                <span v-else-if="history.status == 0">{{ history.h_updated | formatDate }}</span>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <span v-if="history.status == 1">Active</span>
                                                <span v-else-if="history.status == 0">Inactive</span>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <span v-if="history.qr_code">
                                                    <a @click="viewQRCode(history)" class="onHover text-primary">View QR Code</a>
                                                </span>
                                                <span v-else>No QR Code</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>
import QRCodeViewComponent from './QRCodeViewComponent.vue';
export default {
    data(){
        return {
            userData          : {},
            onEdit            : false,
            scholarHistory    : {},
            openDialog        : false,
            openDialog_preview: false,
            componentKey      : 0,
            selected          : {}
        }
    },
    watch : {
        'userData' : function(newVal){
            if(newVal){
                this.getPlayerScholarHistory(newVal.id);
            }
        }
    },
    components:{
        'qrcode-view-component' : QRCodeViewComponent
    },
    
    methods : {
        getAccountInformation(){
            this.axios.get("getAccountInfo/scholars")
            .then((response) => {
                // console.log(response.data);
                this.userData = response.data;
            })
            .catch((error) => {
                console.log(error.data);
            })
        },
        updateRoninWallet(){
            this.axios.post('updateRoninWallet', {
                ronin_wallet : this.userData.ronin_wallet,
            })
            .then((response) => {
                this.$noty.success(response.data.message);
                this.onEdit = false;
            })
            .catch((error) => {
                console.log(error.response.data);
            }) 
        },
        getPlayerScholarHistory(id){
            this.axios.get('getScholarHistories', {
                params : {
                    id : id
                }
            })
            .then(response => {
                this.scholarHistory = response.data;
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        viewQRCode(data){
            this.openDialog = true;
            this.selected = data;
            this.componentKey += 2;
        },
    },
    created(){
        this.getAccountInformation();
    }
}
</script>