<template>
    <div>
        <div class="dataTables_length" id="data-table-default_length">
            <label>Type 
                <select 
                    name="data-table-default_length" 
                    aria-controls="data-table-default" 
                    class="custom-select custom-select-sm form-control form-control-sm"
                    @change="updateType"
                    v-model="selected"
                    >
                        <option value="">All</option>
                        <option :value="type_data.id" v-for="type_data in typeData">{{ type_data.name }}</option>
                </select> 
            </label>
        </div>
    </div>
</template>
<script>
export default {
    props: ['type', 'type_id'],
    data() {
        return {
            typeData : {},
            selected : '',
            typeValue : '',
        }
    },
    watch : {
        'type' : function(newVal){
            if(newVal)
                this.selected = newVal;
        },
        'type_id' : function(newVal){
            if(newVal)
                this.selected = newVal;
        },
    },
    methods : {
        getType(){
            this.axios.get('getType', {
                params : {
                    status : 'Active'
                }
            })
            .then((response) => {
                this.typeData = response.data;
            })
            .catch((error) => {
                console.log(error.response.data);
            })
        },
        updateType(event) {
            this.$emit('updateType', event.target.value);
        },
    },
    mounted(){
        this.getType();
    }
}
</script>
