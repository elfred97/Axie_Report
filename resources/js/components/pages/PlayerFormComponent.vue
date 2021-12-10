<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Ronin Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="ronin_address" placeholder="Ex: (ronin:a548f40bffd52781274bf4e951f6a6420a038600)" v-model="form.ronin_address">
                <div v-if="form.errors.has('ronin_address')" v-html="form.errors.get('ronin_address')" class="text-danger"/>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Account Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_name" v-model="form.account_name">
                <div v-if="form.errors.has('account_name')" v-html="form.errors.get('account_name')" class="text-danger"/>
            </div>
        </div>
        <div class="row mt-2">
           
            <div class="col-md-4">
                <label for="">Marketplace Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="market_place_email" v-model="form.market_place_email">
                <div v-if="form.errors.has('market_place_email')" v-html="form.errors.get('market_place_email')" class="text-danger"/>
            </div>

            <div class="col-md-4">
                <label for="" v-if="scholarData.id">Update Email Password</label>
                <label for="" v-else>New Password</label>
                <input type="password" class="form-control" name="email_password" v-model="form.email_password">
                <div v-if="form.errors.has('email_password')" v-html="form.errors.get('email_password')" class="text-danger"/>
            </div>
        
        </div>

        <div class="row mt-2">            
            <div class="col-md-3">
                <img :src="'uploads/'+form.qr_code" alt="" class="img-fluid">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <p><i>Note: The default share of scholar is 30% for the first 30 days. After 30 days the scholar's share will be updated to 40%.</i></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <button class="btn btn-sm btn-primary" @click="submitForm">
                        <i class="fa fa-check"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['scholarData'],
    data(){
        return {
            form : new Form({
                ronin_address     : '',
                first_name        : '',
                middle_name       : '',
                last_name         : '',
                account_name      : '',
                scholar_email     : '',
                market_place_email: '',
                email_password    : '',
                qr_code           : 'default.jpg',
            }),
            
        }
    },
    watch : {
        'scholarData': function(newVal){
            if(newVal){
                this.form = new Form(newVal);
            }
        }
    },
    methods:{
        submitForm(){
            this.form.post('/savePlayer')
            .then((response) => {
                // this.$refs.calysta_loader.style.display = 'none';
                this.$noty.success(response.data.message);
                this.$events.fire('update_players_table');
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
            });
        },
        resetForm(){
            this.form = new Form({
                id                : NULL,
                ronin_address     : '',
                account_name      : '',
                scholar_email     : '',
                market_place_email: '',
                email_password    : '',
                type              : 'Decent',
                status            : 'Playing',
                date_started      : '',
            })
        },
        
        
    },
    mounted(){
        if(this.scholarData){
            this.form = new Form(this.scholarData);
        }
        else{
            this.resetForm();
        }
    }
}
</script>