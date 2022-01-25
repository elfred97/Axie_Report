<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Settings</h4>
                <div class="panel-heading-btn">                                    
                    <button class="btn btn-xs btn-success" @click="saveSettings()" v-if="getGuardRole == 2">
                        <i class="fas fa-check"></i> Update Settings
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row" v-if="getGuardRole == 2">
                    <div class="col-md-3">
                        <label for="">MMR</label>
                        <input type="number" class="form-control" v-model="options.mmr">
                    </div>
                    <div class="col-md-3">
                        <label for="">Minimum SLP</label>
                        <input type="number" class="form-control" v-model="options.minimum_slp">
                    </div>
                    <div class="col-md-3">
                        <label for="">Target SLP Value</label>
                        <input type="number" class="form-control" v-model="options.target_slp_price">
                    </div>
                    <div class="col-md-3">
                        <label for="">Target SLP Unit</label>
                        <select id="target_slp_unit" class="form-control" v-model="options.target_slp_unit">
                            <option value=""></option>
                            <option value="PHP">PHP</option>
                            <option value="USD">USD</option>
                            <option value="JPY">JPY</option>
                        </select>
                    </div>
                </div>
                <div class="row" v-else-if="getGuardRole == 1">
                    <div class="col-md-12">
                        <ul class="list-group h-15">
                            <li class="list-group-item">
                                <div class="row no-margin">
                                    <div class="col-md-3 text-center">Type</div>
                                    <div class="col-md-3 text-center">SLP</div>
                                    <div class="col-md-3 text-center">MMR</div>
                                    <div class="col-md-3 text-center">Target SLP</div>
                                </div>
                            </li>
                            <li class="list-group-item" v-for="notification in NotificationList">
                                <div class="row no-margin text-center">
                                    <div class="col-md-3 text-bold">
                                        <span v-if="notification.type != null">{{notification.type.name}}</span>
                                    </div>
                                    <div class="col-md-3">{{notification.options.minimum_slp}}</div>
                                    <div class="col-md-3">{{notification.options.mmr}}</div>
                                    <div class="col-md-3">{{notification.options.target_slp_price}} <span class="pull-right">{{notification.options.target_slp_unit}}</span></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            settings : {},
            options : {
                mmr                : '',
                minimum_slp        : '',
                target_slp_price   : '',
                target_slp_unit    : '',
                
            },
            NotificationList : {}
        }
    },
    computed : {
        getGuardRole(){
            return this.$store.state.global_guard_role;
        },
    },
    methods : {
        getSettings(){
            let url = (this.$store.state.global_guard_role == 1) ? 'allNotificationSettings' : 'getNotificationSettings';
            this.axios.get(url)
            .then((response) =>{
                // console.log(response.data.notification_settings.options);
                console.log(response.data);
                if(this.$store.state.global_guard_role == 2){
                    if(response.data.notification_settings)
                        this.options = response.data.notification_settings.options;
                }
                else{
                    this.NotificationList = response.data;
                }
                
            })
            .catch((error) => {
                console.log(error);
            })
        },
        saveSettings(){
            this.axios.post('saveNotificationSettings', {
                status : 1,
                options : this.options
            })
            .then((response) =>{
                if(response.data.is_error == false)
                    this.$noty.success("Notification Settings Saved");
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getSettings();
    },
}
</script>