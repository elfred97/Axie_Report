<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Name</label>
                <input type="text" class="form-control mb-2" v-model="form.name">

                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" class="text-danger"/>

                <label for="">Status</label>
                <select name="" id="" class="form-control mb-2" v-model="form.status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>

                <div class="pull-right">
                    <button class="btn btn-primary btn-xs" @click="updateType()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['typeInfo'],
    data(){
        return {
            form : new Form({
                name : null,
                status : null,
            }),
        }
    },
    methods : {
        updateType(){
            this.form.post('/updateType')
            .then((response) => {
                    this.$noty.success(response.data.message);

                this.$events.fire('update_type');
                this.$root.$emit('isClose', true);
            })
            .catch((error) => {
                // this.form.errors = error.response.data.errors;
                console.log(error);
            })
        }
    },
    mounted(){
        if(this.typeInfo){
            this.form = new Form(this.typeInfo);
        }
    }
}
</script>