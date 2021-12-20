<template>
    <div>
        <div class="section-container">
            <div class="row no-margin">
                <div class="col-md-10 offset-md-1">
                    <div class="container">
                        <h3>Payroll History</h3>
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-8 col-xs-12">
                                <div class="dataTables_length" id="data-table-default_length">
                                    <label>Search 
                                        <input type="text" aria-controls="data-table-default" placeholder="Search Payroll" class="custom-input custom-input-sm form-control form-control-sm" v-model="search" @change="getPayrollHistory()">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="vertical-box-row" v-if="payrolls.length > 0">
                            <!-- begin vertical-box-cell -->
                            <div class="vertical-box-cell">
                                <!-- begin vertical-box-inner-cell -->
                                <div class="vertical-box-inner-cell bg-white">
                                    <!-- begin scrollbar -->
                                    <div class="slimScrollDiv inbox" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                                        <div data-scrollbar="true" data-height="100%" data-init="true" style="overflow: hidden; width: auto; height: 100%;">
                                            <!-- begin list-email -->
                                            <ul class="list-group list-group-lg no-radius list-email">
                                                <li class="list-group-item unread" v-for="payroll in payrolls">
                                                    <div class="email-info">
                                                        <a href="email_detail.html">
                                                            <span class="email-sender">{{ payroll.account_name }}</span>
                                                            <span class="email-title">
                                                                <p class="no-margin text-content">
                                                                    <b>TX ID:</b> {{ payroll.txn_id }}
                                                                </p>
                                                            </span>
                                                            <span class="email-desc">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p class="no-margin text-content">
                                                                            <b>Total SLP: </b>{{ payroll.total_slp }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="no-margin text-content">
                                                                            <b>Status: </b>{{ payroll.total_slp }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                            <span class="email-time">
                                                                {{ payroll.created_at | formatDate }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- end list-email -->
                                        </div>
                                    </div>
                                    <!-- end scrollbar -->
                                </div>
                                <!-- end vertical-box-inner-cell -->
                            </div>
                            <!-- end vertical-box-cell -->
                        </div>
                        <div v-else class="no_result_found">
                            <img src="/img/no_result_found.png" alt="">
                            <p>No result found.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
export default {    
    data() {
        return {
            payrolls : {},
            search : '',
        }
    },
    methods : {
        getPayrollHistory(){
            this.axios.get('getScholarPayrollHistory', {
                params: {
                    search : this.search
                }
            })
            .then(response => {
                this.payrolls = response.data;
            })
        }
    },
    mounted(){
        this.getPayrollHistory();
    }
}
</script>