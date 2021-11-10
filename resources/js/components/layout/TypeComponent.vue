<template>
    <div>
        <div class="dataTables_length" id="data-table-default_length">
            <label>Type 
                <select 
                    name="data-table-default_length" 
                    aria-controls="data-table-default" 
                    class="custom-select custom-select-sm form-control form-control-sm"
                    @change="updateType"
                    >
                        <option value="">All</option>
                        <option :value="type.name" v-for="type in typeData">{{ type.name }}</option>
                </select> 
            </label>
        </div>
    </div>
</template>
<script>
export default {
    props: ['type'],
    data() {
        return {
            typeData : {},
            selected : null,
        }
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
            // console.log(event.target.value)
            this.$emit('updateType', event.target.value);
            
        },
    },
    mounted(){
        this.getType();
        if(this.type)
            this.selected = this.type;
    }
}
</script>