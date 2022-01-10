<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <label for="">Name</label>
                <p class="no-margin text-content">{{ scholarData.scholar_name }}</p>
            </div>
            <div class="col-md-4">
                <label for="">Email</label>
                <p class="no-margin text-content">{{ scholarData.email }}</p>
            </div>
            <div class="col-md-4">
                <label for="">Date Started</label>
                <p class="no-margin text-content">{{ scholarData.date_started | formatDate }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="">Type</label>
                <p class="no-margin text-content">{{ scholarData.type }}</p>
            </div>
            
            <div class="col-md-4">
                <label for="">Status</label>
                <p class="no-margin text-content">{{ scholarData.status }}</p>
            </div>
            
            <div class="col-md-4">
                <label for="">Username</label>
                <p class="no-margin text-content">{{ scholarData.username }}</p>
            </div>
        </div>
        <div class="row" v-if="scholarData.ronin_wallet">
            <div class="col-md-6">
                <label for="">Ronin Wallet</label>
                <p class="no-margin text-content">{{ scholarData.ronin_wallet }}</p>
            </div>
        </div>
        <hr>
        <h5>Scholar History</h5>
        <div class="row h-15">
            <div class="col-md-12">
                <ul class="list-group">
                    <li class="list-group-item" v-for="(history, index) in scholarHistory">
                        <div class="row no-margin">
                            <div class="col-md-6">{{ history.account_name }}</div>
                            <div class="col-md-3">
                                <span v-if="history.status == 1">{{ history.h_created | formatDate }}</span>
                                <span v-else-if="history.status == 0">{{ history.h_updated | formatDate }}</span>
                                
                            </div>
                            <div class="col-md-3">
                                <span v-if="history.status == 1">Active</span>
                                <span v-else-if="history.status == 0">Inactive</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['scholarData'],
    data(){
        return {
            scholarHistory : {}
        }
    },
    // watch: {
    //     'scholarData' : function(newVal){
    //         if(newVal){
                
    //         }
    //     }
    // },
    methods: {
        getPlayerScholarHistory(){
            this.axios.get('getScholarHistories', {
                params : {
                    id : this.scholarData.id
                }
            })
            .then(response => {
                this.scholarHistory = response.data;
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
    },
    mounted() {
        this.getPlayerScholarHistory();
    },
}
</script>