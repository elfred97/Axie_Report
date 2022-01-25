
<template>
    <div>
        <!-- BEGIN #graph -->
        <div id="graph" class="section-container">
            <!-- BEGIN container -->
            <div class="container">
               
                <!-- BEGIN category-container -->
                <div class="category-container">
                        <!-- BEGIN category-sidebar -->
                        <div class="category-sidebar">
                            <ul class="category-list">
                                <li class="list-header">Date</li>
                                <li v-for="data in graphData">
                                    <a>
                                        <b>{{data.date | formatDate}}</b> - <span class="pull-right">{{ data.slp }}</span>
                                    </a>
                                </li>                            
                            </ul>
                        </div>
                        <!-- END category-sidebar -->
                        <!-- BEGIN category-detail -->
                        <div class="category-detail">
                            <JSCharting :options="chartOptions" class="columnChart" v-if="graphData.length > 0"></JSCharting>
                            <div class="mt-1 text-center" v-else>
                                <p class="text-center">No Graph Available</p>
                            </div>
                        </div>
                        <!-- END category-detail -->
                    
                </div>
                <!-- END category-container -->
            </div>
            <!-- END container -->
        </div>
        <!-- END #graph -->
    </div>
</template>
<script>
import JSCharting from 'jscharting-vue';
export default {
    data () {
        return {
            chartOptions: {
                type  : 'line',
                height: 800,
                legend: {
                    template: '%icon %name',
                    position: 'inside top left',
                },
                defaultPoint_marker_type: 'none',
                xAxis_crosshair_enabled : true,
                yAxis_formatString      : '',
                series                  : [
                    {
                        name  : 'SLP',
                        points: [
                            // [new Date(2021, 10, 1), 28.15], // [new Date(2021, 10, 2), 28.2],                           
                        ],
                    },
                ]
            },
            // year     : [],
            // month    : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            graphData: [],
            // filter   : {
            //     selected_year : '',
            //     selected_month: '',
            //     selected_type : '',
            //     selected_account_name : ''

            // },
            // selected_type : '',
            options : [],
            // selected_player : '',
        }
    },
    
    methods: {
        getGraph(data){
            let term = {
                year : data.selected_year,
                month: data.selected_month,
                type : data.selected_type,
                account_name : data.selected_account_name,
            }            
            this.axios.get('/getGraph', {
                params : {
                    year : data.selected_year,
                    month: data.selected_month,
                    type : data.selected_type,
                    account_name : data.selected_account_name,
                }
            })
            .then((response) => {
                this.chartOptions.series[0].points = [];
                response.data.forEach(element => {
                    this.chartOptions.series[0].points.push(
                        [
                            moment(element.date).format('YYYY, MM, D'), 
                           element.slp
                        ]
                    )
                });
                this.graphData = response.data;
                // this.$events.fire('graph-filter-set', this.filter);
                this.$events.fire('graph-data', response.data);
            })
            .catch((error) => {
                // this.clearAll();
            })
        },
    },
    components: {
      JSCharting,
    },
    mounted(){
        // this.getYear();
        // this.getListPlayers();
        // this.filter.selected_year = moment().format('YYYY');
        // this.filter.selected_month = moment().format('M');
        // console.log(this.month[moment().format('M')])
        this.$events.$on('graph-filter-set', (eventData) => {
            this.filters = eventData;
            // console.log(eventData);
            this.getGraph(eventData);
        });
    }
}
</script>
