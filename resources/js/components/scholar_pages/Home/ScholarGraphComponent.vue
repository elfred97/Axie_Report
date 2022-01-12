<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-3">
                <div class="dataTables_length" id="data-table-default_length">
                    <label>Date 
                        <v-datepicker v-model="selected_date" range class=""></v-datepicker>
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <account-list-component @updateAccountList="account_selected = $event"></account-list-component>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" v-if="chartOptions.series[0].points.length > 0">
                <JSCharting :options="chartOptions" class="columnChart"></JSCharting>
            </div>
            <div class="col-md-12" v-else>
                <p>No Graph Data Available</p>
            </div>
        </div>
    </div>
</template>
<script>
import JSCharting from 'jscharting-vue';
export default {
    data() {
        return {
            chartOptions: {
                debug : false,
                type: 'line',
                legend: {
                template: '%icon %name',
                position: 'inside top left'
                },
                title_label_color: "red",

                defaultPoint_marker_type: 'none',
                xAxis_crosshair_enabled: true,
                yAxis_formatString: '',
                series: [
                {
                    name: 'SLP',
                    points: [
                                             
                    ]
                },
                ]
            },
            selected_date : '',
            account_selected : {}
        }
    },
    watch : {
        'selected_date' : function(newVal){
            this.getGraph();
        },
        'account_selected' : function(newVal){
            this.getGraph();
        }
    },
    methods : {
        getGraph(){
            this.chartOptions.series[0].points = [];
            this.axios.get('/getScholarGraph', {
                params: {
                    date : this.selected_date,
                    account_name : this.account_selected.account_name,
                }
            })
            .then((response) => {
                response.data.forEach(element => {
                    this.chartOptions.series[0].points.push(
                        [
                            moment(element.created_at).format('YYYY, MM, D'), 
                           element.gained_slp_today
                        ]
                    )
                });
            })
            .catch((error) => {
                console.log(error.response.data)
            })
        }
    },
    components: {
        JSCharting,
    },
    mounted(){
        // this.getGraph();
    }
}
</script>