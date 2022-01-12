<template>
    <div>
        <div class="card border-0 bg-dark text-white mb-3 overflow-hidden">
            <!-- begin card-body -->
            <div class="card-body">
                <!-- begin row -->
                <div class="row">
                    <account-list-component @updateAccountList="account_selected = $event"></account-list-component>
                </div>
                <div class="row">
                    <!-- begin col-7 -->
                    <div class="col-xl-8 col-lg-9">
                        <!-- begin title -->
                        <div class="mb-3 text-grey">
                            <b>Today SLP</b>
                            <span class="ml-2">
                                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Total sales" data-placement="top" data-content="Net sales (gross sales minus discounts and returns) plus taxes and shipping. Includes orders from all sales channels."></i>
                            </span>
                        </div>
                        <!-- end title -->
                        <div class="row text-truncate no-margin">
                            <div class="col-6">
                                <!-- begin total-sales -->
                                <div class="d-flex mb-1">
                                    <h2 class="mb-0"><span data-animation="number" :data-value="today_slp">{{ today_slp }}</span></h2>
                                    <div class="ml-auto mt-n1 mb-n1"><div id="total-sales-sparkline"></div></div>
                                </div>
                                <!-- end total-sales -->
                                <!-- begin percentage -->
                                <!-- <div class="text-grey">
                                    <i class="fa fa-caret-up"></i> <span data-animation="number" data-value="33.21">33.21</span>% compare to last week
                                </div> -->
                                <!-- end percentage -->
                            </div>
                            <div class="col-3">
                                <div class="f-s-12 text-grey">Unclaimed</div>
                                <div class="f-s-18 f-w-600 p-b-1" data-animation="number" :data-value="unclaimed"> {{ unclaimed }}</div>
                            </div>
                            <div class="col-3">
                                <div class="f-s-12 text-grey">Claimed</div>
                                <div class="f-s-18 f-w-600 p-b-1" data-animation="number" :data-value="claimed"> {{ claimed }}</div>
                            </div>
                        </div>
                        <hr class="bg-white-transparent-2" />
                        <!-- begin row -->
                        <div class="row text-truncate">
                            <!-- begin col-6 -->
                            <div class="col-3">
                                <div class="f-s-12 text-grey">Yesterday SLP</div>
                                <div class="f-s-18 f-w-600 p-b-1" data-animation="number" :data-value="yesterday_slp"> {{ yesterday_slp }}</div>
                            </div>
                            <!-- end col-6 -->
                            <!-- begin col-6 -->
                            <div class="col-3">
                                <div class="f-s-12 text-grey">Avg SLP Per Day</div>
                                <div class="f-s-18 f-w-600 p-b-1"><span data-animation="number" :data-value="average_per_day"> {{ average_per_day }} </span></div>
                            </div>
                            <!-- end col-6 -->
                            <!-- begin col-6 -->
                            <div class="col-3">
                                <div class="f-s-12 text-grey">MMR</div>
                                <div class="f-s-18 f-w-600 p-b-1" data-animation="number" :data-value="mmr">  {{ mmr }} </div>
                            </div>
                            <!-- end col-6 -->
                            <!-- begin col-6 -->
                            <div class="col-3">
                                <div class="f-s-12 text-grey">Penalty</div>
                                <div class="f-s-18 f-w-600 p-b-1"><span data-animation="number" :data-value="penalty">{{ penalty }}</span></div>
                            </div>
                            <!-- end col-6 -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end col-7 -->
                    <!-- begin col-5 -->
                    <div class="col-xl-4 col-lg-3 align-items-center d-flex justify-content-center">
                        <img src="assets/img/svg/img-1.svg" height="150px" class="d-none d-lg-block" />
                    </div>
                    <!-- end col-5 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end card-body -->
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            average_per_day: 0,
            yesterday_slp  : 0,
            today_slp      : 0,
            unclaimed      : 0,
            claimed        : 0,
            penalty        : 0,
            mmr            : 0,
            account_selected : {}
        }
    },
    watch : {
        'account_selected' : function(newVal){
            this.getScholarReport();
        }
    },
    methods: {
        getScholarReport(){
            this.axios.get('getScholarReport', {
                params : {
                    account_name : this.account_selected.account_name
                }
            })
            .then((response) => {
                let report = response.data;
                
                if(report.length > 0){
                    this.unclaimed       = report[report.length - 1].unclaimed;
                    this.claimed         = report[report.length - 1].claimed;
                    this.penalty         = report[report.length - 1].penalty;
                    this.average_per_day = report[report.length - 1].average_per_day;
                    this.today_slp       = report[report.length - 1].gained_slp_today;
                    this.mmr             = report[report.length - 1].mmr;

                    if(report.length > 1){
                        this.yesterday_slp = report[report.length - 2].gained_slp_today;
                    }                    
                }

            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
    created(){
        // this.getScholarReport();
    }
}
</script>