<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <label for="">TXN ID</label>
                <input type="text" class="form-control" v-model="form.txn_id" placeholder="Input Transaction Hash here">
            </div>
            <div class="col-md-4 mt-2">
                <label for="">Status</label>
                <select name="" id="" class="form-control" v-model="form.status">
                    <option value="0">Pending</option>
                    <option value="1">Paid</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="pull-right">
                    <button class="btn btn-xs btn-primary" @click="saveForm()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['payrollData'],
    data(){
        return {

            form : new Form(),
        }
    },
    watch : {
        'payrollData': function(newVal){
            if(newVal){
                this.form = new Form(newVal);
            }
        },
    },
    methods: {
        saveForm(){
            this.form.post('updatePayrollHistory')
            .then(response => {
                this.$noty.success(response.data.message);
                this.$events.fire('update_payroll_history_table');
                this.$root.$emit('isClose', true);
                this.form.reset();
            })
            .catch(error => {
                console.log(error.response.data);
            })
        }
    },
    mounted(){
        if(this.payrollData)
            this.form = new Form(this.payrollData)
    }
}
</script>