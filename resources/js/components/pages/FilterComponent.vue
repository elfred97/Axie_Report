<style scoped>
.multiselect, .multiselect__content-wrapper{
    width: 300px;
}
</style>
<template>
    <div>
        <div id="graph" class="section-container">
            <!-- BEGIN container -->
            <div class="container">
                <!-- BEGIN section-title -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Year 
                                        <select 
                                            name="data-table-default_length" 
                                            aria-controls="data-table-default" 
                                            class="custom-select custom-select-sm form-control form-control-sm"
                                            @change="updateFilter"
                                            v-model="filter.selected_year"
                                            >
                                                <option :value="year" v-for="year in year">{{ year}}</option>
                                        </select> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Month 
                                        <select 
                                            name="data-table-default_length" 
                                            aria-controls="data-table-default" 
                                            class="custom-select custom-select-sm form-control form-control-sm"
                                            @change="updateFilter"
                                            v-model="filter.selected_month"
                                            >
                                                <option :value="index + 1" v-for="(month, index) in month">{{ month }}</option>
                                        </select> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <type-component :type="filter.selected_type" @updateType="filter.selected_type = $event"></type-component>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="dataTables_length" id="data-table-default_length">
                            <label>Search 
                                <multi-select 
                                    v-model="selected_player"
                                    :multiple="false"
                                    @search-change="getListPlayers"
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
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            year     : [],
            month    : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            filter   : {
                selected_year        : '',
                selected_month       : '',
                selected_type        : '',
                selected_account_name: ''

            },
            selected_type  : '',
            options        : [],
            selected_player: '',
        }
    },
    watch : {
        'selected_player' : function(newVal){
            this.updateFilter();
        },
        'filter.selected_year': function(newVal){
            this.updateFilter();
        },
        'filter.selected_month': function(newVal){
            this.updateFilter();
        },
        'filter.selected_type': function(newVal){
            this.updateFilter();
        },
        'filter.selected_account_name': function(newVal){
            this.updateFilter();
        },
    },
    methods : {
        getYear(){
            let start_year = 2020;
            let current_year = new Date().getFullYear();

            for (var i = start_year; i <= current_year; i++) {
                this.year.push(i);
            }
        },
        getListPlayers(query){
            this.axios.get('getListPlayers', {
                params : {
                    term : query
                }
            })
            .then((response) => {
                // console.log(response.data);
                this.options = response.data
                this.selected_player = response.data[0];
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
            this.updateFilter();
        },
        updateFilter(){
            this.$events.fire('graph-filter-set', this.filter);
        }
    },
    mounted(){
        this.getYear();
        this.getListPlayers();
        this.filter.selected_year = moment().format('YYYY');
        this.filter.selected_month = moment().format('M');
    }
}
</script>