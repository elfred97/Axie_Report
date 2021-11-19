<template>
    <div>
        <div class="section-container">
            <div class="container">
                <div class="row row-space-10 m-b-20">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="account-container">
                            <!-- BEGIN account-sidebar -->
                            <div class="account-sidebar">
                                <div class="account-sidebar-cover">
                                    <img src="assets/img/cover/cover-1.jpg" alt="" />
                                </div>
                                <div class="account-sidebar-content text-center">
                                    <h4>{{ userData.account_name }}</h4>

                                    <p class="mb-2 mt-2">Scan QR Code</p>
                                    <img :src='"/uploads/"+userData.qr_code' alt="" class="img-fluid">
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
                                            <div class="col-md-6">
                                                <label for="">Account Name</label>
                                                <p> {{ userData.account_name }} </p>
                                            </div>
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
                                                        <p v-else>{{ userData.ronin_wallet }}</p>
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
            </div>
        </div>
        
    </div>
</template>
<script>
export default {
    data(){
        return {
            userData: {},
            onEdit  : false,
        }
    },
    methods : {
        getScholarInformation(){
            this.axios.get("getScholarInformation")
            .then((response) => {
                console.log(response.data);
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
    },
    created(){
        this.getScholarInformation();
    }
}
</script>