<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <type-component :type="form.type" @updateType="form.type = $event"></type-component>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Subject</label>
                <input type="text" class="form-control" placeholder="Subject" v-model="form.subject">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Message</label>
                <textarea name="" id="" cols="20" rows="4" class="form-control" v-model="form.message" placeholder="Message Here"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-xs pull-right" @click="saveReminder()">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['reminder'],
    data(){
        return {
            form : new Form({
                type   : null,
                subject: null,
                message: null
            })
        }
    },
    methods : {
        saveReminder(){
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
        if(this.reminder){
            this.form = new Form(this.reminder);
        }
    }
}
</script>