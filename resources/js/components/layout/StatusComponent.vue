<template>
    <div>
        <div class="dataTables_length" id="data-table-default_length">
            <label>Status 
                <select 
                    name="data-table-default_length" 
                    aria-controls="data-table-default" 
                    class="custom-select custom-select-sm form-control form-control-sm"
                    @change="updateStatus"
                    v-model="selected"
                    >
                        <option value="">All</option>
                        <option :value="status_data.status.trim().toUpperCase()" v-for="(status_data, index) in statusData" v-if="checkAction(status_data.status.trim().toUpperCase())">
                            {{ status_data.status.trim().toUpperCase() }}
                        </option>
                </select> 
            </label>
        </div>
    </div>
</template>
<script>
export default {
    props : ['status', 'action'],
    data(){
        return {
            selected : '',
            statusData : {}
        }
    },
    watch : {
        'status' : function(newVal){
            if(newVal)
                this.selected = newVal;
        }
    },
    methods : {
        getStatuses(){
            this.axios.get('/getStatuses')
            .then(response => {
                // console.log(response.data);
                this.statusData = response.data;
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        updateStatus(event){
            this.$emit('updateStatus', event.target.value);
        },
        checkAction(status_data){
            let status = status_data;
            if(this.action == "new")
            {
                if(status != 'TERMINATED' && status != 'RESIGNED')
                    return true;
                else
                    return false;
            }
            else
                return true;
        },
    },
    created(){
        this.getStatuses();
    }
}
</script>