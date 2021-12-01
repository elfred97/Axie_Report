<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_name" v-model="form.username">
                <div v-if="form.errors.has('username')" v-html="form.errors.get('username')" class="text-danger text-bold"/>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="first_name" v-model="form.first_name">
                <div v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" class="text-danger text-bold"/>
            </div>

            <div class="col-md-4">
                <label for="">Middle Name</label>
                <input type="text" class="form-control" name="middle_name"  v-model="form.middle_name">
            </div>

            <div class="col-md-4">
                <label for="">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="last_name" v-model="form.last_name">
                <div v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" class="text-danger text-bold"/>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="scholar_email" v-model="form.email">
                <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" class="text-danger text-bold"/>
            </div>            

            <div class="col-md-4">
                <label for="">Date Started <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="date_started" v-model="form.date_started">
                <div v-if="form.errors.has('date_started')" v-html="form.errors.get('date_started')" class="text-danger text-bold"/>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <type-component :type_id="form.type_id" @updateType="form.type_id = $event"></type-component>
            </div>

            <div class="col-md-4">                
                <div class="dataTables_length" id="data-table-default_length">
                    <label>Status
                        <select 
                            name="data-table-default_length" 
                            aria-controls="data-table-default" 
                            class="custom-select custom-select-sm form-control form-control-sm"
                            v-model="form.status"
                            >
                                <option value="Playing">Playing</option>
                                <option value="Resigned">Resigned</option>
                                <option value="Terminated">Terminated</option>
                                <option value="For QR">For QR</option>
                                <option value="No Axie">No Axie</option>
                        </select> 
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Axie Account</label>
                <multi-select 
                            v-model="selected"
                            :multiple="false"
                            @search-change="searchPlayer"
                            @select="selectAxieAccount"
                            track-by="id"
                            :show-label="false"
                            :options="options"
                            :custom-label="customLabel"
                            >
                        </multi-select>
            </div>
            <div class="col-md-4" v-if="form.ronin_wallet">
                <label for="">Ronin Wallet</label>
                <p class="no-margin text-content">{{ form.ronin_wallet }}</p>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Update Password</label>
                <input type="password" name="password" id="password" class="form-control" v-model="form.email_password" placeholder="Input new password to reset">
                <div v-if="form.errors.has('email_password')" v-html="form.errors.get('email_password')" class="text-danger text-bold"/>
                <small>Input new password to change password</small>
            </div>
        </div>
        <hr>
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
                type_id           : '',
                status            : 'Playing',
                date_started      : '',
                email_password    : '',
            }),
            options           : [],
            selected          : {}
        }
    },
    watch : {
        'scholarData': function(newVal){
            if(newVal){
                this.form = new Form(newVal);
                this.selected = newVal;
            }
        },
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
                id            : NULL,
                first_name    : '',
                middle_name   : '',
                last_name     : '',
                username      : '',
                account_name  : '',
                email         : '',
                password      : '',
                type_id       : '',
                status        : 'Active',
                date_started  : '',
                email_password: '',
            })
        },
        searchPlayer(query){
            this.axios.get('getAllPlayers', {
                params : {
                    term : query
                }
            })
            .then((response) => {
                // console.log(response.data);
                this.options = response.data
            })
            .catch((error) => {
                console.log(error)
            });
        },
        customLabel ({ account_name }) {
            return `${account_name}`
        },
        selectAxieAccount(eventData){
            this.form.account_name = eventData.account_name;
        }
    },
    mounted(){
        this.searchPlayer();
        if(this.scholarData){
            this.form = new Form(this.scholarData);            
        }
        else{
            this.resetForm();
        }
    }
}
</script>