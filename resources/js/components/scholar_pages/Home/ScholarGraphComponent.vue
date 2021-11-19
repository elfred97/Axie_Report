<template>
    <div>
        <div class="row">
            <div class="col-md-2">
                <input type="text" class="form-control">
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
                    name: 'October',
                    points: [
                        [new Date(2021, 10, 1), 160],
                        [new Date(2021, 10, 2), 400],
                        [new Date(2021, 10, 3), 300],
                        [new Date(2021, 10, 4), 600],
                        [new Date(2021, 10, 5), 800],
                        [new Date(2021, 10, 6), 800],
                        [new Date(2021, 10, 7), 800],
                        [new Date(2021, 10, 8), 780],
                        [new Date(2021, 10, 9), 500],
                        [new Date(2021, 10, 10), 300],                        
                    ]
                },
                ]
            }
        }
    },
    methods : {
        getGraph(){
            this.axios.get('/getScholarGraph')
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