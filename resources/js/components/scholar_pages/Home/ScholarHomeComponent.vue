<template>
    <div>
        <div class="section-container">
            <div class="container">
                <div class="row row-space-10 m-b-20">
                    <div class="col-md-5">
                        <!-- SLP Update -->
                        <slp-update-component></slp-update-component>
                    </div>
                    <div class="col-md-7">
                        <!-- Stats -->
                        <stats-component></stats-component>
                    </div>
                </div>
            </div>
        </div>
        <!-- Penalty -->
        <div class="section-container bg-white">
            <div class="container">
                <div class="row row-space-10 m-b-20">
                    <div class="col-md-12">
                        <scholar-penalty-component></scholar-penalty-component>
                    </div>
                </div>
            </div>
        </div>

        <!-- List of All Imports -->
        <div class="section-container bg-white">
            <div class="container">
                <div class="row row-space-10 m-b-20">
                    <div class="col-md-12">
                        <scholar-import-list-component></scholar-import-list-component>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import SLPUpdateComponent from './SLPUpdateComponent.vue';
import StatsComponent from './StatsComponent.vue';
import ScholarPenaltyComponent from './ScholarPenaltyComponent.vue';
import ScholarImportListComponent from './ScholarImportListComponent.vue';
export default {
    components : {
        'stats-component'              : StatsComponent,
        'slp-update-component'         : SLPUpdateComponent,
        'scholar-penalty-component'    : ScholarPenaltyComponent,
        'scholar-import-list-component': ScholarImportListComponent,
    }
}
</script>