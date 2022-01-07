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
        <div class="row h-15">
            <div class="col-md-6"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['scholarData'],
    methods: {
        getPlayerScholarHistory(){},
    },
    mounted() {
        this.getPlayerScholarHistory();
    },
}
</script>