<template>
    <div>
        <div class = "field">
            <div class = "row">
                <div class = "col-md-6">
                    <p class="no-margin"><b>Date Started: </b> {{ rowData.date_started | formatDate }}</p>
                </div>
                <div class = "col-md-6">
                    <p class="no-margin"><b>Market Place Email: </b> {{ rowData.market_place_email }}</p>
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