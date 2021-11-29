<template>
    <div>
        <label for="">Upload QR Code Image</label>
        <form class="form-horizontal" @submit.prevent="uploadQRCode">
            <div class="input-group">
                <input name="qr_code" type="file" ref="qr_code_file" @change="updateQR" class="form-control no-margin no-padding" style="padding: 1px 3px !important">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary" type="submit">
                        Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    props: ['scholarData'],
    data() {
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
            qr_code_file: '',
        }
    },
    watch : {
        'scholarData': function(newVal){
            if(newVal){
                this.form = new Form(newVal);
            }
        }
    },
    methods : {
        updateQR(){
            this.qr_code_file = this.$refs.qr_code_file.files[0];
        },
        uploadQRCode(){
            let formData = new FormData();
            formData.append('file', this.qr_code_file);
            formData.append('id', this.form.ronin_address)
            formData.append('account_name', this.form.account_name)

            this.axios.post('/uploadQRCode',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                this.qr_code_file = '';
                this.$refs.qr_code_file.value = '';
                
                this.$noty.success("QR Code Uploaded");
                this.$events.fire('update_players_table');
                this.$root.$emit('QRCodeisClose', true);
                this.form.reset();
                
            })
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