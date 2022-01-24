<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Users List</h4>
                <div class="panel-heading-btn">                                    
                    <button class="btn btn-xs btn-success" @click="$root.$emit('showDialog', true, 'newUser-form', 'New User', '50%')">
                        <i class="fas fa-plus"></i> New User
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget-list widget-list-rounded h-15" data-id="widget">
                            <!-- begin widget-list-item -->
                            <div class="widget-list-item" v-for="(user, index) in usersData">
                                <div class="widget-list-media">
                                    <span class="user-bg" :class="bg_class[index]">
                                    {{ user.first_name.charAt(0) }}
                                    </span>
                                </div>
                                <div class="widget-list-content">
                                    <h4 class="widget-list-title">{{ user.first_name }} {{ user.last_name }}</h4>
                                    <p class="widget-list-desc">{{ user.username }}</p>
                                </div>
                                <div class="widget-list-type">
                                    <span>{{user.type_name}}</span>
                                </div>
                                <div class="widget-list-status">
                                    <span v-if="user.status == 1">
                                        <i class="fa fa-circle text-lime f-s-8 mr-2" ></i>
                                        Active
                                    </span>
                                    <span v-else-if="user.status == 2">
                                        <i class="fa fa-circle text-aqua f-s-8 mr-2"></i>
                                        Inactive
                                    </span>
                                </div>
                                <div class="widget-list-action">
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-default" @click="$root.$emit('showDialog', true, 'newUser-form', 'Update Users Info', '50%', user)">
                                            <i class="fas fa-pencil-alt"></i>
                                            Edit</button>
                                        <button class="btn btn-xs btn-default text-danger" @click="deleteUser(user.id)">
                                            <i class="fas fa-trash"></i>
                                            Delete</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end widget-list-item -->                                            
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
            usersData  : {},
            bg_class   : [
                'bg-blue', 
                'bg-info', 
                'bg-pink', 
                'bg-lime', 
                'bg-dark', 
                'bg-aqua', 
                'bg-light',
                'bg-danger', 
                'bg-purple', 
                'bg-indigo', 
                'bg-success', 
                'bg-primary', 
                'bg-warning', 
                'bg-default', 
            ]
        }
    },
    methods: {
        getUsers(){
            this.axios.get('/getUsers')
            .then((response) => {
                this.usersData = response.data;
            })
            .catch((error) => {
                // this.clearAll();
                console.log(error.response.data)
            })
        },
        deleteUser(id){
            this.$alertify.confirmWithTitle("Delete", "Are you sure to delete this user?", 
            ()=> {
                this.axios.post('/deleteUser', {
                    id : id
                })
                .then((response) => {
                    this.getUsers();
                    this.$noty.success(response.data.message);
                })
                .catch((error) => {
                    this.$noty.error("Something went wrong please try again later.")               
                });
            },() =>this.$noty.error("Cancel: Item not removed")
            )
        }
    },
    mounted() {
        this.getUsers();  
        this.$events.on('update_users', (data) => {
            this.getUsers(); 
        });
    },
}
</script>