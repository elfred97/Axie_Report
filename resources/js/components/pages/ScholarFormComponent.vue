<template>
    <div>
        <div ref="loader" id="ajax-loading"></div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_name" v-model="form.username">
                <div v-if="form.errors.has('username')" v-html="form.errors.get('username')" class="text-danger"/>
            </div>
            <div class="col-md-4">
                <label for="" v-if="scholarData.id != null">Update Password</label>
                <label for="" v-else>New Password</label>
                <input type="password" name="password" id="password" class="form-control" v-model="form.email_password" placeholder="Input new password to reset">
                <div v-if="form.errors.has('email_password')" v-html="form.errors.get('email_password')" class="text-danger"/>
                <small>Input new password to change password</small>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="first_name" v-model="form.first_name">
                <div v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" class="text-danger"/>
            </div>

            <div class="col-md-4">
                <label for="">Middle Name</label>
                <input type="text" class="form-control" name="middle_name"  v-model="form.middle_name">
            </div>

            <div class="col-md-4">
                <label for="">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="last_name" v-model="form.last_name">
                <div v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" class="text-danger"/>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="scholar_email" v-model="form.email">
                <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" class="text-danger"/>
            </div>            

            <div class="col-md-4">
                <label for="">Date Started <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="date_started" v-model="form.date_started">
                <div v-if="form.errors.has('date_started')" v-html="form.errors.get('date_started')" class="text-danger"/>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <type-component :type_id="form.type_id" @updateType="form.type_id = $event"></type-component>
                <div v-if="form.errors.has('type_id')" v-html="form.errors.get('type_id')" class="text-danger"/>
            </div>

            <div class="col-md-4">                
                <status-component :action="action" :status="form.status" @updateStatus="form.status = $event"></status-component>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-6">
                <label for="">Axie Account</label>
                <multi-select 
                    v-model="selected"
                    :multiple="true"
                    @search-change="searchPlayer"
                    @select="selectAxieAccount"
                    track-by="account_name"
                    :show-label="false"
                    :options="options"
                    :custom-label="customLabel"
                    :close-on-select="false" 
                    :clear-on-select="false" 
                    :taggable="true"
                    >
                </multi-select>
                <!-- 
                <multi-select 
                    v-model="selected"
                    :multiple="true"
                    @search-change="searchPlayer"
                    @select="selectAxieAccount"
                    track-by="id"
                    :show-label="false"
                    :options="options"
                    :custom-label="customLabel"
                    >
                </multi-select>
                 -->
                <div v-if="form.errors.has('account_name')" v-html="form.errors.get('account_name')" class="text-danger"/>
            </div>
            <div class="col-md-6" v-if="form.ronin_wallet">
                <label for="">Ronin Wallet</label>
                <p class="no-margin text-content">{{ form.ronin_wallet }}</p>
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
                type_id           : '',
                status            : 'Playing',
                date_started      : '',
                email_password    : '',
                accounts          : []
            }),
            options           : [],
            selected          : null,
            action            : "new",
        }
    },
    watch : {
        'scholarData': function(newVal){
            if(newVal){
                this.form = new Form(newVal);
                this.selected = newVal.accounts;
                this.searchPlayer();
                this.action = "update";
            }
        },
    },
    methods:{
        submitForm(){
            this.$refs.loader.style.display = 'block';

            let account_name = [];
            if(this.selected != null)
                this.selected.forEach(element => {
                    account_name.push(element.account_name);
                });
            
            this.form.account_name =  account_name.toString();

            this.form.post('/saveScholar').then((response) => {
                this.$noty.success(response.data.message);
                this.$events.fire('update_scholars_table');
                this.$root.$emit('isClose', true);
                this.form.reset();
                this.$refs.loader.style.display = 'none';
            })
            .catch((error) => {
                if(error.response.data.status == 422){
                    error.response.data.forEach(element => {
                        this.$noty.error('Recheck Form inputs');
                        
                    });
                }
                else{
                    this.$noty.error("Something went wrong please try again later.")
                }
                this.$refs.loader.style.display = 'none';
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
                accounts      : [],
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
            // this.form.account_name = eventData.account_name;
            console.log(eventData);
        }
    },
    mounted(){
        this.searchPlayer();
        if(this.scholarData){
            this.form = new Form(this.scholarData);
            this.action = "new";
        }
        else{
            this.resetForm();
            this.action = "update";
        }
    }
}
</script>