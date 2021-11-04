<template>
    <div>
        <div class="section-container main-content-view bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <!-- Begin Account Settings -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Account</h4>
                                <div class="panel-heading-btn">
                                    <button class="btn btn-xs btn-success" @click="updateAccountInfo()">
                                        <i class="fas fa-check"></i> Save
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control mb-2" v-model="form.first_name" name="first_name">

                                        <label for="">Middle Name</label>
                                        <input type="text" class="form-control mb-2" v-model="form.middle_name" name="middle_name">

                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control mb-2" v-model="form.last_name" name="last_name">

                                        <label for="">Username</label>
                                        <input type="text" class="form-control mb-2" v-model="form.username" name="username">
                                    </div>
                                    <div class="offset-md-2 col-md-4">
                                        <p class="mb-0">Change Password?</p>
                                        <a href="">Click Here</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Account Settings -->
                        <!-- Begin Users List -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Users List</h4>
                                <div class="panel-heading-btn">                                    
                                    <button class="btn btn-xs btn-success">
                                        <i class="fas fa-plus"></i> New User
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="widget-list widget-list-rounded" data-id="widget">
                                            <!-- begin widget-list-item -->
                                            <div class="widget-list-item">
                                                <div class="widget-list-media">
                                                    ET
                                                </div>
                                                <div class="widget-list-content">
                                                    <h4 class="widget-list-title">Christopher Struth</h4>
                                                    <p class="widget-list-desc">Bank Transfer</p>
                                                </div>
                                                <div class="widget-list-action">
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-default">Edit</button>
                                                        <button class="btn btn-xs btn-default">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end widget-list-item -->
                                            <!-- begin widget-list-item -->
                                            <div class="widget-list-item">
                                                <div class="widget-list-media">
                                                    E
                                                </div>
                                                <div class="widget-list-content">
                                                    <h4 class="widget-list-title">Janie Flowers</h4>
                                                    <p class="widget-list-desc">Bank Transfer</p>
                                                </div>
                                                <div class="widget-list-action">
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-default">Edit</button>
                                                        <button class="btn btn-xs btn-default">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end widget-list-item -->
                                            <!-- begin widget-list-item -->
                                            <div class="widget-list-item">
                                                <div class="widget-list-media">
                                                    T
                                                </div>
                                                <div class="widget-list-content">
                                                    <h4 class="widget-list-title">Janie Flowers</h4>
                                                    <p class="widget-list-desc">Bank Transfer</p>
                                                </div>
                                                <div class="widget-list-action">
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-default">Edit</button>
                                                        <button class="btn btn-xs btn-default">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end widget-list-item -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Users List -->
                    </div>
                    <div class="col-md-5">
                        <!-- Begin Type -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Type</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item" v-for="type in typeData">
                                                <div class="row mb-0">
                                                    <div class="col-md-6">
                                                        <span>{{ type.name }}</span>                                                             
                                                    </div>
                                                    <div class="col-md-3">
                                                        <i class="fa fa-circle text-lime f-s-8 mr-2" v-if="type.status == 'Active'"></i>
                                                        <i class="fa fa-circle text-aqua f-s-8 mr-2" v-else></i>
                                                        {{ type.status }} 
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="btn-group pull-right">
                                                            <button class="btn btn-xs btn-default" @click="updateType">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                            <button class="btn btn-xs btn-default">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>         
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Add new type here" v-model="newType">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-sm" @click="saveNewType()"><i class="fas fa-plus"></i> New Type</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Type -->

                        <!-- Begin Notification -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Settings</h4>
                                <div class="panel-heading-btn">                                    
                                    <button class="btn btn-xs btn-success">
                                        <i class="fas fa-check"></i> Save
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Notification</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">MMR</label>
                                        <input type="number" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Minimum SLP</label>
                                        <input type="number" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Target SLP Value</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Type -->
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
            onEdit     : false,
            accountData: {},
            form       : new Form(),
            newType    : '',
            typeData   : {},
        }
    },
    watch : {
        'accountData' : function(newVal){
            if(newVal){
                this.form = new Form(newVal);
            }
        }
    },
    methods: {
        getUsers(){

        },
        getAccountInfo(){
            this.axios.get('/getAccountInfo')
            .then((response) => {
                this.accountData = response.data;
            })
            .catch((error) => {
                // this.clearAll();
                console.log(error.response.data)
            })
        },
        getTypes(){
            this.axios.get('/getType')
            .then((response) => {
                this.typeData = response.data;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        getSettings(){

        },

        updateAccountInfo(){
            this.form.post('/updateAccountInfo')
            .then((response) => {
                this.$noty.success(response.data.message);
            })
            .catch((error) => {
                // this.clearAll();
                console.log(error.response.data)
            })
        },
        saveNewType(){
            this.axios.post('/saveNewType', this.newType)
            .then((response) => {
                this.$noty.success(response.data.message);
                this.newType = '';
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
    mounted(){
        this.getUsers();
        this.getAccountInfo();
        this.getTypes();
    }
}
</script>