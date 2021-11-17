<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Ronin Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="ronin_address" placeholder="Ex: (ronin:a548f40bffd52781274bf4e951f6a6420a038600)" v-model="form.ronin_address">
                <div v-if="form.errors.has('ronin_address')" v-html="form.errors.get('ronin_address')" class="text-danger text-bold"/>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Account Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_name" v-model="form.account_name">
                <div v-if="form.errors.has('account_name')" v-html="form.errors.get('account_name')" class="text-danger text-bold"/>
            </div>
        </div>
        <div class="row mt-2">
           
            <div class="col-md-4">
                <label for="">Marketplace Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="market_place_email" v-model="form.market_place_email">
                <div v-if="form.errors.has('market_place_email')" v-html="form.errors.get('market_place_email')" class="text-danger text-bold"/>
            </div>

            <div class="col-md-4">
                <label for="">Email Password <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="password" v-model="form.password">
                <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" class="text-danger text-bold"/>
            </div>
        
            <div class="col-md-4">
                <label for="">Date Started <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="date_started" v-model="form.date_started">
                <div v-if="form.errors.has('date_started')" v-html="form.errors.get('date_started')" class="text-danger text-bold"/>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <label for="">Upload QR Code Image</label>
                <form class="form-horizontal" @submit.prevent="uploadQRCode">
                    <div class="input-group">
                        <input name="file" type="file" ref="file" @change="updateQR" class="form-control no-margin no-padding" style="padding: 1px 3px !important">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-primary" type="submit">
                                Upload
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <img :src="form.qr_code" alt="" class="img-fluid">
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
                type              : 'Decent',
                status            : 'Playing',
                date_started      : '',
            })
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
            this.form.post('/saveScholar').then((response) => {
                // this.$refs.calysta_loader.style.display = 'none';
                this.$noty.success(response.data.message);
                this.$events.fire('update_scholars_table');
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
                first_name        : '',
                middle_name       : '',
                last_name         : '',
                account_name      : '',
                scholar_email     : '',
                market_place_email: '',
                email_password    : '',
                type              : 'Decent',
                status            : 'Playing',
                date_started      : '',
            })
        },
        uploadQRCode(){

        },
        updateQR(){

        }
    },
    mounted(){
        if(this.scholarData)
            this.form = new Form(this.scholarData);
        else{
            this.resetForm();
        }
    }
}
</script>