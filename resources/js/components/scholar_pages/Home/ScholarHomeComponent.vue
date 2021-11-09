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

        <!-- List of All Imports -->
    </div>
</template>
<script>
import SLPUpdateComponent from './SLPUpdateComponent.vue';
import StatsComponent from './StatsComponent.vue';
export default {
    components : {
        'slp-update-component': SLPUpdateComponent,
        'stats-component'     : StatsComponent,
    }
}
</script>