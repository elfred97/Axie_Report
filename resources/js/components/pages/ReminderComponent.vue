<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Reminder</h4>
                <div class="panel-heading-btn">
                    <button class="btn btn-xs btn-success" @click="$root.$emit('showDialog', true, 'add-reminder-form', 'New Reminder', '30%')">
                        <i class="fas fa-plus"></i> New Reminder
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- begin widget-table -->
                        <div class="table-responsive">
                            <!-- begin widget-table -->
                            <table class="table table-bordered widget-table widget-table-rounded" data-id="widget">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-center">Date</th>                                        
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h6 class="widget-table-title">Payroll reminder</h6>
                                            <p class="widget-table-desc m-b-15 mb-0">To all scholars, your payroll will be delayed today</p>
                                        </td>
                                        <td class="text-nowrap text-center">
                                            <b class="text-inverse" data-id="widget-elm" 
                                                data-light-class="text-inverse" 
                                                data-dark-class="text-white">09/24/2021</b>
                                        </td>                                        
                                        <td class="text-center">
                                            <button class="btn btn-default btn-xs">
                                                <i class="fas fa-pencil-alt"></i>
                                                Edit</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="widget-table-title">Inspire 2</h6>
                                            <p class="widget-table-desc m-b-15 mb-0">Cinematic aerial performance for filmmakers.</p>
                                        </td>
                                        <td class="text-nowrap text-center">
                                            <b class="text-inverse" data-id="widget-elm" 
                                                data-light-class="text-inverse" 
                                                data-dark-class="text-white">09/24/2021</b>
                                        </td>                                       
                                        <td class="text-center">
                                            <button class="btn btn-default btn-xs">
                                                <i class="fas fa-pencil-alt"></i>
                                                Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- end widget-table -->
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>