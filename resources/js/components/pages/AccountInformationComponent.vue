<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Account</h4>
                <div class="panel-heading-btn">
                    <button class="btn btn-xs btn-success" @click="updateAccountInfo()">
                        <i class="fas fa-check"></i> Update Information
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

                    </div>
                    <div class="col-md-6">
                        <label for="">Username</label>
                        <input type="text" class="form-control mb-2" v-model="form.username" name="username">

                        <div v-if="getGuardRole == 2">
                            <label for="">Type</label>
                            <select name="" id="" v-model="form.type" class="form-control">
                                <option :value="type_data.id" v-for="type_data in typeData">{{ type_data.name }}</option>
                            </select>
                        </div>
                        <hr>
                        <p class="mb-0">Change Password?</p>
                        <span class="text-blue onHover" @click="$root.$emit('showDialog', true, 'changePassword-form', 'Change Password', '30%')">Click Here</span>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    // props: ['accountData'],
    data(){
        return{
            form       : new Form(),
            accountData: {},
            typeData : {},
        }
    },
    watch: {
        'accountData' : function(newVal){
            if(newVal)
                this.form = new Form(newVal);
        }
    },
    computed : {
        getGuardRole(){
            return this.$store.state.global_guard_role;
        },
    },
    methods: {
        getAccountInfo(){
            this.axios.get('/getAccountInfo/admins')
            .then((response) => {
                this.accountData = response.data;
            })
            .catch((error) => {
                // this.clearAll();
                console.log(error.response.data)
            })
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
        getType(){
            this.axios.get('getType', {
                params : {
                    status : 'Active'
                }
            })
            .then((response) => {
                this.typeData = response.data;
            })
            .catch((error) => {
                console.log(error.response.data);
            })
        },
        updateType(event) {
            this.$emit('updateType', event.target.value);
        },
    },
    mounted() {
        this.getAccountInfo();
        this.getType();
    },
}
</script>