<template>
    <div>
        <div class="row">
            <div class="col-md-2">
                <label>Date 
                    <v-datepicker v-model="selected_date" range @change="getGraph()" class=""></v-datepicker>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <JSCharting :options="chartOptions" class="columnChart"></JSCharting>
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
        }
    },
    methods : {
        getGraph(){
            this.axios.get('/getScholarGraph', {
                params: {
                    date : this.selected_date
                }
            })
            .then((response) => {

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
        this.getGraph();
    }
}
</script>