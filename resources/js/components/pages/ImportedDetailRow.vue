<template>
    <div>
        <div class="field">
            <div class="row">
                <div class="col-md-2">
                    <p class="no-margin"><b>Manager Share: </b>{{ rowData.manager_share }}</p>
                </div>
                <div class="col-md-2">
                    <p class="no-margin"><b>Scholar Share: </b>{{ rowData.scholar_share }}</p>
                </div>
            
                <div class="col-md-2" v-if="rowData.last_claim_days">
                    <p class="no-margin"><b>Last Claim Days: </b> {{ rowData.last_claim_days }}
                    <span v-if="rowData.last_claim_days > 1"> days</span>
                    <span v-else> day</span>
                    </p>
                </div>
                <div class="col-md-2" v-if="rowData.last_claim_date">
                    <p class="no-margin"><b>Last Claim Date: </b> {{ rowData.last_claim_date | formatDate }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number    
        }
    }
}
</script>