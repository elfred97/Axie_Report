<template>
    <div>
        <overview-component></overview-component>
        <graph-component></graph-component>
        <tablelist-component></tablelist-component>
    </div>
</template>
<script>
import OverviewComponent from './OverviewComponent.vue';
import GraphComponent from './GraphComponent.vue';
import TableListComponent from './TableListComponent.vue';
export default {
    components:{
        'overview-component' : OverviewComponent,
        'graph-component' : GraphComponent,
        'tablelist-component' : TableListComponent,
    }
}
</script>
