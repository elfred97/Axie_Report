<template>
    <div>
        <!-- BEGIN #overview -->
        <div id="overview" class="section-container bg-white">
            <!-- BEGIN container -->
            <div class="container">

                <!-- begin row -->
                <div class="row row-space-10 m-b-20">
                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-gradient-secondary m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-equals fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL SLP</div>
                                <div class="stats-number">{{ total_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <!-- <div class="stats-desc">Better than last week (54.9%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-gradient-orange m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fab fa-bitcoin fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL UNCLAIMED SLP</div>
                                <div class="stats-number">{{ total_unclaimed.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <!-- <div class="stats-desc">More than last week (23.5%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-pink m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-money-bill fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL CLAIMED</div>
                                <div class="stats-number">{{ total_claimed.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <!-- <div class="stats-desc">More than last week (10.5%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->

                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-gradient-teal m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-calendar fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL SLP TODAY</div>
                                <div class="stats-number">{{ today_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <!-- <div class="stats-desc">Better than last week (70.1%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-gradient-blue m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-calendar-check fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL SLP YESTERDAY</div>
                                <div class="stats-number">{{ yesterday_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <!-- <div class="stats-desc">Better than last week (40.5%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-gradient-purple m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-divide fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL AVERAGE</div>
                                <div class="stats-number">{{ total_average_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <!-- <div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->   

                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-gradient-grey m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-divide fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">PENALTY</div>
                                <div class="stats-number">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="badge badge-info">1 : <b>123</b></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="badge badge-warning">2 : <b>123</b></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="badge badge-danger">3 : <b>123</b></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->   
                    
                    <!-- begin col-3 -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget widget-stats bg-gradient-aqua m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-divide fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">LOWEST MMR</div>
                                <div class="stats-number">{{ total_average_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <!-- <div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->                    
                </div>
                <!-- end row -->
            </div>
            <!-- END container -->
        </div>
        <!-- END #overview -->
    </div>
</template>
<script>
export default {
    data(){
        return {
            data             : {},
            total_data       : {},
            today_slp        : 0,
            yesterday_slp     : 0,
            total_unclaimed  : 0,
            total_claimed    : 0,
            total_average_slp: 0,
            total_slp        : 0,
            filters          : {
                selected_year : '',
                selected_month: '',
                selected_type : '',
            }
        }
    },
    methods:{
        onFilterSet(filters){
            this.getTotalbyFilter(filters);
            // this.geTotal();
        },
        getTotalbyFilter(filters){
            this.axios.get('/getTotalReportbyDate', {
                params : {
                    year : filters.selected_year,
                    month: filters.selected_month,
                    type : filters.selected_type
                }
            })
            .then((response) => {
                this.data  = response.data;

                let overall_slp   = 0;
                let yesterday_slp = 0;
                let today_slp     = 0;
                let yesterday = moment(new Date()).subtract(1, 'days').format('YYYY-MM-DD');
                let today     = moment(new Date()).format('YYYY-MM-DD');

                response.data.forEach((element, index) => {                                        
                    let date = moment(element.created_at).format('YYYY-MM-DD');
                    if(date == yesterday){
                        //Get Yesterday SLP
                        yesterday_slp += parseInt(element.total_slp);
                    }
                    else if(date == today){
                        //Get Today SLP
                        today_slp += parseInt(element.total_slp);
                    }
                });
                this.today_slp = today_slp;
                this.yesterday_slp = yesterday_slp;

            })
            .catch((error) => {
                // this.clearAll();
            })
        },
        getTotal(){
            this.axios.get('/getReport', {
                params:{
                    type     : this.type,
                    sortType : null,
                    sortOrder: 'desc',
                }
            })
            .then((response) => {
                this.total_data = response.data;
                let total_slp = 0;
                let total_claimed = 0;
                let total_unclaimed = 0;

                for (const [key, value] of Object.entries(response.data)) {
                    total_slp += parseInt(value[value.length - 1].total_slp);
                    total_claimed += parseInt(value[value.length - 1].claimed);
                    total_unclaimed += parseInt(value[value.length - 1].unclaimed);
                }
                this.total_slp = total_slp;
                this.total_claimed = total_claimed;
                this.total_unclaimed = total_unclaimed;
                
            })
            .catch((error) => {
                // this.clearAll();
                console.log("error")
            })
        },
        getAverage(data){
            let total = 0;
            console.log(data);
            data.forEach(element => {
                total += parseInt(element.slp);
            });
            this.total_average_slp = Math.round(total / data.length);
        }
    },
    mounted(){
        this.getTotal();
        this.$events.$on('graph-filter-set', (eventData) => this.onFilterSet(eventData));
        this.$events.$on('graph-data', (eventData) => this.getAverage(eventData));
    }
}
</script>