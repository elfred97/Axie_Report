<template>
    <div>
        <div class="section-container main-content-view bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- begin tabs -->
                        <ul class="nav nav-tabs nav-tabs-default" data-sortable-id="index-2">
                            <li class="nav-item"><a href="#pending" data-toggle="tab" class="nav-link active"><i class="fa fa-file-invoice fa-lg m-r-5"></i> <span class="d-none d-md-inline">Pending Payroll</span></a></li>
                            <li class="nav-item"><a href="#paid" data-toggle="tab" class="nav-link"><i class="fas fa-file-invoice-dollar fa-lg m-r-5"></i> <span class="d-none d-md-inline">Paid Payroll</span></a></li>
                        </ul>
                        <div class="tab-content" data-sortable-id="index-3">
                            <div class="tab-pane fade active show" id="pending">
                                <div class="row no-margin">
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Year 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePayroll"
                                                    v-model="filtersParam.year"
                                                    >
                                                        <option :value="year" v-for="year in year">{{ year}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Month 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePayroll"
                                                    v-model="filtersParam.month"
                                                    >
                                                        <option :value="month" v-for="month in month">{{ month}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <type-component :type="filtersParam.type" @updateType="filtersParam.type = $event"></type-component>
                                    </div>
                                    <div class="col-md-3 offset-md-3">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Search 
                                                <input type="text" class="form-control form-control-sm custom-input custom-input-sm" placeholder="Search scholar name" @change="updatePayroll" v-model="filtersParam.search">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="no-margin media-list media-list-with-divider mt-2">
                                    <li >
                                        <div class="row no-margin">
                                            <div class="col-md-4">
                                                <h6 class="no-margin">Scholar Name <span class="pull-right">(Account Name)</span></h6>
                                                <span>Ronin Address: </span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b for="">30%: </b> 8</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b>40%: </b> 4 </span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="text-center"><b>Total: </b> 12</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="no-margin">TX ID: </p>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-xs btn-primary"><i class="fas fa-check"></i> Set as Paid</button>
                                            </div>
                                        </div>
                                    </li>
                                    <li >
                                        <div class="row no-margin">
                                            <div class="col-md-4">
                                                <h6 class="no-margin">Scholar Name <span>(Account Name)</span></h6>
                                                <span class="no-margin">Ronin Address: </span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b for="">30%: </b> 8</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b>40%: </b> 4 </span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="text-center"><b>Total: </b> 12</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="no-margin">TX ID: </p>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-xs btn-primary"><i class="fas fa-check"></i> Set as Paid</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="paid">
                                <div class="row no-margin">
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Year 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePayroll"
                                                    v-model="filtersParam.year"
                                                    >
                                                        <option :value="year" v-for="year in year">{{ year}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Month 
                                                <select 
                                                    name="data-table-default_length" 
                                                    aria-controls="data-table-default" 
                                                    class="custom-select custom-select-sm form-control form-control-sm"
                                                    @change="updatePayroll"
                                                    v-model="filtersParam.month"
                                                    >
                                                        <option :value="month" v-for="month in month">{{ month}}</option>
                                                </select> 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <type-component :type="filtersParam.type" @updateType="filtersParam.type = $event"></type-component>
                                    </div>
                                    <div class="col-md-3 offset-md-3">
                                        <div class="dataTables_length" id="data-table-default_length">
                                            <label>Search 
                                                <input type="text" class="form-control form-control-sm custom-input custom-input-sm" placeholder="Search scholar name" @change="updatePayroll" v-model="filtersParam.search">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="no-margin media-list media-list-with-divider mt-2">
                                    <li >
                                        <div class="row no-margin">
                                            <div class="col-md-4">
                                                <h6 class="no-margin">Scholar Name <span>(Account Name)</span></h6>
                                                <span>Ronin Address: </span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b for="">30%: </b> 8</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b>40%: </b> 4 </span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="text-center"><b>Total: </b> 12</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="no-margin">TX ID: </p>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-xs btn-default"><i class="fas fa-check"></i> Cancel</button>
                                            </div>
                                        </div>
                                    </li>
                                    <li >
                                        <div class="row no-margin">
                                            <div class="col-md-4">
                                                <h6 class="no-margin">Scholar Name <span>(Account Name)</span></h6>
                                                <span class="no-margin">Ronin Address: </span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b for="">30%: </b> 8</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="no-margin text-center"><b>40%: </b> 4 </span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="text-center"><b>Total: </b> 12</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="no-margin">TX ID: </p>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-xs btn-default"><i class="fas fa-check"></i> Cancel</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- end tabs -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            filtersParam : {
                month : '',
                year  : '',
                type  : '',
                search: '',
            },
            year     : [ 2020 , 2021 ],
            month    : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        }
    },
    watch : {
        'filter.type': function(newVal){
            this.getGraph();
        }
    },
    methods: {
        updatePayroll(){
        }
    },

}
</script>