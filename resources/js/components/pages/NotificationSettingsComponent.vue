<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Settings</h4>
                <div class="panel-heading-btn">                                    
                    <button class="btn btn-xs btn-success" @click="saveSettings()">
                        <i class="fas fa-check"></i> Update Settings
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
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
                <p class="mt-2 mb-2">Show / Hide</p>
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="total_slp" v-model="options.total_slp">
                            <label class="custom-control-label" for="total_slp">Total SLP</label>
                        </div>
                        <!-- end custom-switches -->
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="total_unclaimed" v-model="options.total_unclaimed">
                            <label class="custom-control-label" for="total_unclaimed">Total Unclaimed</label>
                        </div>
                        <!-- end custom-switches -->
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="total_claimed" v-model="options.total_claimed">
                            <label class="custom-control-label" for="total_claimed">Total Claimed</label>
                        </div>
                        <!-- end custom-switches -->
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="total_slp_today" v-model="options.total_slp_today">
                            <label class="custom-control-label" for="total_slp_today">Total SLP Today</label>
                        </div>
                        <!-- end custom-switches -->
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="total_slp_yesterday" v-model="options.total_slp_yesterday">
                            <label class="custom-control-label" for="total_slp_yesterday">Total SLP Yesterday</label>
                        </div>
                        <!-- end custom-switches -->
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="total_average" v-model="options.total_average">
                            <label class="custom-control-label" for="total_average">Total Average</label>
                        </div>
                        <!-- end custom-switches -->
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="penalty" v-model="options.penalty">
                            <label class="custom-control-label" for="penalty">Penalty</label>
                        </div>
                        <!-- end custom-switches -->
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <!-- begin custom-switches -->
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="lowest_mmr" v-model="options.lowest_mmr">
                            <label class="custom-control-label" for="lowest_mmr">Lowest MMR</label>
                        </div>
                        <!-- end custom-switches -->
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
                total_slp          : true,
                total_unclaimed    : true,
                total_claimed      : true,
                total_slp_today    : true,
                total_slp_yesterday: false,
                total_average      : false,
                penalty            : true,
                lowest_mmr         : false,
            }
        }
    },
    methods: {
        getSettings(){
            this.axios.get('getNotificationSettings')
            .then((response) =>{
                this.options = JSON.parse(response.data.notification_settings.options);
            })
            .catch((error) => {
                console.log(error);
            })
        },
        saveSettings(){
            this.axios.post('saveNotificationSettings', {
                status : 1,
                options : JSON.stringify(this.options)
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