<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Current Password</label>
                <input type="password" class="form-control" placeholder="Current Password" v-model="form.password">
                <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" class="text-danger text-bold"/>
                <hr>

                <label for="">New Password</label>
                <input type="password" class="form-control mb-2" placeholder="New Password" v-model="form.new_password">
                <div v-if="form.errors.has('new_password')" v-html="form.errors.get('new_password')" class="text-danger text-bold"/>
                
                <label for="">Confirm Password</label>
                <input type="password" class="form-control mb-2" placeholder="Confirm Password" v-model="form.confirm_password">
                
                <div class="pull-right mt-2">
                    <button class="btn btn-primary btn-xs" @click="changePassword"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            form : new Form(),
        }
    },
    methods : {
        changePassword(){
            this.form.post('changePassword')
            .then((response) => {
                this.$noty.success("Password Changed");
                this.$root.$emit('isClose', true);
                this.form.reset();
            })
            .catch((error) => {
                if(error.response.status == 422){
                    this.$noty.error('Recheck Form inputs');
                }
                else{
                    this.$noty.error("Something went wrong please try again later.")
                }
            })
        }
    }
}
</script>