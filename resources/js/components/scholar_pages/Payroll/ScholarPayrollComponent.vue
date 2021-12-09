<template>
    <div>
        <div class="section-container">
            <div class="row no-margin">
                <div class="col-md-10 offset-md-1">
                    <div class="container">
                        <h3>Payroll History</h3>
                        <div class="vertical-box-row">
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
                                                                <b>TX ID:</b> {{ payroll.txn_id }}
                                                            </span>
                                                            <span class="email-desc">
                                                                <div class="row">
                                                                    <div class="col-md-6"><b>Total SLP: </b>{{ payroll.total_slp }}</div>                                                                    
                                                                    <div class="col-md-6"><b>Status: </b>{{ payroll.total_slp }}</div>
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
            payrolls : {}
        }
    },
    methods : {
        getPayrollHistory(){
            this.axios.get('getScholarPayrollHistory')
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