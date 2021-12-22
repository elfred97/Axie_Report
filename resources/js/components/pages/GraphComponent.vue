<template>
    <div>
        <!-- BEGIN #graph -->
        <div id="graph" class="section-container">
            <!-- BEGIN container -->
            <div class="container">
                <!-- BEGIN section-title -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Year 
                                        <select 
                                            name="data-table-default_length" 
                                            aria-controls="data-table-default" 
                                            class="custom-select custom-select-sm form-control form-control-sm"
                                            @change="getGraph"
                                            v-model="filter.selected_year"
                                            >
                                                <option :value="year" v-for="year in year">{{ year}}</option>
                                        </select> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Month 
                                        <select 
                                            name="data-table-default_length" 
                                            aria-controls="data-table-default" 
                                            class="custom-select custom-select-sm form-control form-control-sm"
                                            @change="getGraph"
                                            v-model="filter.selected_month"
                                            >
                                                <option :value="index + 1" v-for="(month, index) in month">{{ month }}</option>
                                        </select> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <type-component :type="filter.selected_type" @updateType="filter.selected_type = $event"></type-component>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="dataTables_length" id="data-table-default_length">
                            <label>Search 
                                <multi-select 
                                    v-model="selected_player"
                                    :multiple="false"
                                    @search-change="searchPlayer"
                                    @select="selectAxieAccount"
                                    track-by="id"
                                    :show-label="false"
                                    :options="options"
                                    :custom-label="customLabel"
                                    >
                                </multi-select>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- END section-title -->
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
            year     : [ 2020 , 2021 ],
            month    : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            graphData: [],
            filter   : {
                selected_year : '',
                selected_month: '',
                selected_type : '',
                selected_account_name : ''

            },
            selected_type : '',
            options : [],
            selected_player : '',
        }
    },
    watch : {
        'filter.selected_type': function(newVal){
            this.getGraph();
        }
    },
    methods: {
        getGraph(){
            let term = {
                year : this.filter.selected_year,
                month: this.filter.selected_month,
                type : this.filter.selected_type,
                account_name : this.filter.selected_account_name,
            }            
            this.axios.get('/getGraph', {
                params : {
                    year : this.filter.selected_year,
                    month: this.filter.selected_month,
                    type : this.filter.selected_type,
                    account_name : this.filter.selected_account_name,
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
                this.$events.fire('graph-filter-set', this.filter);
                this.$events.fire('graph-data', response.data);
            })
            .catch((error) => {
                // this.clearAll();
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
            this.filter.selected_account_name = eventData.account_name;
            this.getGraph();
        }
    },
    components: {
      JSCharting,
    },
    mounted(){
        this.searchPlayer();
        this.filter.selected_year = moment().format('YYYY');
        this.filter.selected_month = moment().format('M');
        // console.log(this.month[moment().format('M')])
        this.getGraph();
    }
}
</script>
