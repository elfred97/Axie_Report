<template>
    <div>
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
                        <a @click="$root.$emit('showDialog', true, 'changePassword-form', 'Change Password', '30%')">Click Here</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
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
        }
    },
    watch: {
        'accountData' : function(newVal){
            if(newVal)
                this.form = newVal;
        }
    },
    methods: {
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
    },
    mounted() {
        this.getAccountInfo();
    },
}
</script>