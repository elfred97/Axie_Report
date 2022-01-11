<template>
    <div>
        <div class="dataTables_length" id="data-table-default_length">
            <label>
                <select 
                    name="data-table-default_length" 
                    aria-controls="data-table-default" 
                    class="custom-select custom-select-sm form-control form-control-sm"
                    @change="updateAccountName"
                    v-model="selected"
                    >
                        <!-- <option value="">All</option> -->
                        <option :value="accounts.account_name" v-for="accounts in accountList">
                            {{ accounts.account_name }}
                        </option>
                </select> 
            </label>
        </div>
    </div>
</template>
<script>
export default {
    props : ['account'],
    data (){
        return {
            accountList : {},
            selected : ''
        }
    },
    watch : {
        'accountList' : function(newVal){
            if(newVal){
                this.selected = newVal[0].account_name;
                this.$emit('updateAccountList', this.selected);
            }
        }
    },
    methods : {
        getListOfAccounts(){
            this.axios.get('/getListOfAccounts')
            .then(response => {
                // console.log(response.data);
                this.accountList = response.data[0].accounts;
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        updateAccountName(event){
            this.$emit('updateAccountList', event.target.value);
        }
    },
    mounted() {
        this.getListOfAccounts();
    },
}
</script>