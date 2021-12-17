<template>
    <div>
        <slp-update-component></slp-update-component>
        <overview-component></overview-component>
        <graph-component></graph-component>
        <tablelist-component></tablelist-component>
    </div>
</template>
<script>
import SLPUpdateComponent from './SLPUpdateComponent.vue';
import OverviewComponent from './OverviewComponent.vue';
import GraphComponent from './GraphComponent.vue';
import TableListComponent from './TableListComponent.vue';
export default {
    components:{
        'slp-update-component': SLPUpdateComponent,
        'overview-component'  : OverviewComponent,
        'graph-component'     : GraphComponent,
        'tablelist-component' : TableListComponent,
    }
}
</script>
