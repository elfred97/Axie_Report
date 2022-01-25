<template>
    <div>
        <!-- BEGIN #overview -->
        <div id="overview" class="section-container bg-white">
            <!-- BEGIN container -->
            <div class="container">

                <!-- begin row -->
                <div class="row row-space-10 m-b-20">
                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.total_slp == true">
                        <div class="widget widget-stats bg-gradient-secondary m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-equals fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL SLP</div>
                                <div class="stats-number" v-if="total_slp">{{ total_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <div class="stats-number" v-else>0</div>
                                <!-- <div class="stats-desc">Better than last week (54.9%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.total_unclaimed == true">
                        <div class="widget widget-stats bg-gradient-muted m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fab fa-bitcoin fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL UNCLAIMED SLP</div>
                                <div class="stats-number" v-if="total_unclaimed">{{ total_unclaimed.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <div class="stats-number" v-else>0</div>
                                <!-- <div class="stats-desc">More than last week (23.5%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.total_claimed == true">
                        <div class="widget widget-stats bg-pink m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-money-bill fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL CLAIMED</div>
                                <div class="stats-number" v-if="total_claimed">{{ total_claimed.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <div class="stats-number" v-else>0</div>
                                <!-- <div class="stats-desc">More than last week (10.5%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->

                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.total_slp_today == true">
                        <div class="widget widget-stats bg-gradient-teal m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-calendar fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL SLP TODAY</div>
                                <div class="stats-number" v-if="today_slp">{{ today_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <div class="stats-number" v-else>0</div>
                                <!-- <div class="stats-desc">Better than last week (70.1%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.total_slp_yesterday == true">
                        <div class="widget widget-stats bg-gradient-blue m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-calendar-check fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL SLP YESTERDAY</div>
                                <div class="stats-number" v-if="yesterday_slp">{{ yesterday_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <div class="stats-number" v-else>0</div>
                                <!-- <div class="stats-desc">Better than last week (40.5%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.total_average == true">
                        <div class="widget widget-stats bg-gradient-purple m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-divide fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TOTAL AVERAGE</div>
                                <div class="stats-number" v-if="total_average_slp">{{ total_average_slp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <div class="stats-number" v-else>0</div>
                                <!-- <div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->

                     <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.lowest_mmr == true">
                        <div class="widget widget-stats bg-gradient-lime m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-divide fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">LOWEST MMR</div>
                                <div class="stats-number" v-if="mmr_count">{{ mmr_count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                                <div class="stats-number" v-else>0</div>
                                <!-- <div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->

                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.penalty == true">
                        <div class="widget widget-stats bg-gradient-cyan m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-exclamation-triangle fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">1st PENALTY</div>
                                <div class="stats-number">
                                    {{ penalties.first }}
                                </div>
                                <!-- <div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->

                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.penalty == true">
                        <div class="widget widget-stats bg-gradient-orange m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-exclamation-triangle fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">2nd PENALTY</div>
                                <div class="stats-number">
                                    {{ penalties.second }}
                                </div>
                                <!-- <div class="stats-desc">Better than last week (76.3%)</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->

                    <!-- begin col-3 -->
                    <div class="col-md-20" v-if="options.penalty == true">
                        <div class="widget widget-stats bg-gradient-danger m-b-10">
                            <div class="stats-icon stats-icon-lg"><i class="fas fa-exclamation-triangle fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">3rd PENALTY</div>
                                <div class="stats-number">
                                    {{ penalties.third }}
                                </div>
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
import { CustomizationMixins } from './CustomizationMixins';
export default {
    mixins : [ CustomizationMixins ],
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
            },
            penalties : {
                first : 0,
                second : 0,
                third : 0,
            },
            mmr_count : 0,
            options : {
                mmr                : '',
                minimum_slp        : '',
                target_slp_price   : '',
                target_slp_unit    : '',
                total_slp          : true,
                total_unclaimed    : true,
                total_claimed      : true,
                total_slp_today    : true,
                total_slp_yesterday: true,
                total_average      : true,
                penalty            : true,
                lowest_mmr         : true,
            },
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
            this.axios.get('/getTotalSLPs', {
                params:{
                    year     : this.filters.selected_year,
                    month     : this.filters.selected_month,
                    type     : this.filters.selected_type,
                    // account_name     : data.selected_type,
                }
            })
            .then((response) => {
                this.total_data = response.data.data;

                let total_slp = 0;
                let total_claimed = 0;
                let total_unclaimed = 0;

                for (const [key, value] of Object.entries(response.data.data)) {
                    total_slp += parseInt(value.total_slp);
                    total_claimed += parseInt(value.claimed);
                    total_unclaimed += parseInt(value.unclaimed);
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
            data.forEach(element => {
                total += parseInt(element.slp);
            });
            this.total_average_slp = Math.round(total / data.length);
        },
        getPenalties(filter){
            this.penalties.first = 0;
            this.penalties.second = 0;
            this.penalties.third = 0;
            this.axios.get('/penalty-count/'+filter.selected_type)
            .then((response) => {
                response.data.penalties.forEach( element => {
                    if(element.penalty == 1)
                        this.penalties.first = element.total;
                    else if(element.penalty == 2)
                        this.penalties.second = element.total;
                    else if(element.penalty == 3)
                        this.penalties.third = element.total;
                });
            })
            .catch((error) => {
                // this.clearAll();
                console.log("error")
            })
        },
        getLowestMMR(filter){
            this.axios.get('/getLowestMMR', {
                params : {
                    month : filter.selected_month,
                    year : filter.selected_year,
                    type_id : filter.selected_type,
                }
            })
            .then((response) => {                
                this.mmr_count = response.data.lowest_mmr_counts;
            })
            .catch((error) =>{
                console.log(error);
            })
        },        
    },
    mounted(){
        this.getTotal();
        this.getSettings();
        this.$events.$on('graph-filter-set', (eventData) => {
            this.filters = eventData;
            console.log(eventData);
            this.getTotal();
            this.onFilterSet(eventData);
            this.getPenalties(eventData);
            this.getLowestMMR(eventData);
        });
        // this.getSampleAxieDetails();
        // this.getAxieList();
        // this.$events.$on('graph-data', (eventData) => this.getAverage(eventData));
    }
}
</script>