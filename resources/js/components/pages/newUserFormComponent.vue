<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Status</label>
                <select class="form-control" v-model="form.status">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-2" placeholder="First Name" v-model="form.first_name">
                <div v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" class="text-danger"/>
            </div>
            <div class="col-md-4">
                <label for="">Middle Name</label>
                <input type="text" class="form-control mb-2" placeholder="Middle Name" v-model="form.middle_name">
                
            </div>
            <div class="col-md-4">
                <label for="">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-2" placeholder="Last Name" v-model="form.last_name">
                <div v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" class="text-danger"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <p>Select Type <span class="text-danger">*</span></p>
                <type-component @updateType="form.type_id = $event"></type-component>
                <div v-if="form.errors.has('type_id')" v-html="form.errors.get('type_id')" class="text-danger"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4"> 
                <label for="">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-2" placeholder="Username" v-model="form.username">
                <div v-if="form.errors.has('username')" v-html="form.errors.get('username')" class="text-danger"/>
            </div>
        </div>
        <hr>
        <div class="row" v-if="!usersListInfo">
            <div class="col-md-4"> 
                <label for="">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control mb-2" placeholder="Password" v-model="form.new_password">
                <div v-if="form.errors.has('new_password')" v-html="form.errors.get('new_password')" class="text-danger"/>
            </div>
            <div class="col-md-4"> 
                <label for="">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control mb-2" placeholder="Confirm Password" v-model="form.confirm_password">
            </div>
        </div>
        <div class="pull-right">
            <button class="btn btn-xs btn-primary" @click="updateUser()"><i class="fas fa-check"></i> Save</button>
        </div>
    </div>
</template>
<script>
export default {
    props: ['usersListInfo'],
    data(){
        return {
            form : new Form({
                username        : null,
                first_name      : null,
                middle_name     : null,
                last_name       : null,
                new_password    : null,
                confirm_password: null,
                status          : 1,
                type_id : null,
            }),
        }
    },
    methods:{
        updateUser(){
            if(this.usersListInfo)
                if(this.form.password != null)
                    if(this.form.newPassword != this.form.confirm_password){
                        this.form.errors.errors['new_password'] = 'Password did not match';
                        return false;
                    }

            this.form.post('/updateUser')
            .then((response) => {
                if(this.usersListInfo)
                    this.$noty.success('Update User Info');
                else
                    this.$noty.success('New User Added');

                this.$events.fire('update_users');
                this.$root.$emit('isClose', true);
            })
            .catch((error) => {
                // this.form.errors = error.response.data.errors;
                console.log(error);
            })
        }
    },
    mounted(){
        if(this.usersListInfo){
            this.form = new Form(this.usersListInfo);
        }
    }
}
</script>