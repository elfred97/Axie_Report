<template>
    <div>
        <div class="dataTables_length" id="data-table-default_length">
            <label>
                Category 
                <select 
                    name="data-table-default_length" 
                    aria-controls="data-table-default" 
                    class="custom-select custom-select-sm form-control form-control-sm"
                    @change="updateCategory"
                    v-model="selected"
                    >
                        <!-- <option value="">All</option> -->
                        <option :value="category[0]" v-for="category in categoryList">
                            {{ category[1] }}
                        </option>
                </select> 
            </label>
        </div>
    </div>
</template>
<script>
export default {
    props : ['category'],
    data (){
        return {
            categoryList: {},
            selected   : ''
        }
    },
    watch : {
        'categoryList' : function(newVal){
            if(newVal){
                // console.log(newVal);
                this.selected = newVal[0][0];
                this.$emit('updateCategoryList', this.selected);
            }
        },
    },
    methods : {
        getListOfCategory(){
            this.axios.get('/listOfCategory')
            .then(response => {
               this.categoryList = response.data;
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        updateCategory(event){
            // console.log(event.target.value);
            this.$emit('updateCategoryList', event.target.value);
        }
    },
    mounted() {
        this.getListOfCategory();
    },
}
</script>