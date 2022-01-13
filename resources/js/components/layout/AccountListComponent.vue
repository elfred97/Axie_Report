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
                        <option :value="accounts" v-for="accounts in accountList">
                            {{ accounts.account_name }}
                        </option>
                </select> 
            </label>
        </div>
    </div>
</template>
<script>
export default {
    props : ['account', 'type'],
    data (){
        return {
            accountList: {},
            selected   : ''
        }
    },
    watch : {
        'accountList' : function(newVal){
            if(newVal){                
                this.selected = newVal[0];
                this.$emit('updateAccountList', this.selected);
            }
        },
    },
    methods : {
        getListOfAccounts(){
            this.axios.get('/getListOfAccounts')
            .then(response => {
                // console.log(response.data[0].accounts);
                if(response.data.status == "TERMINATED" || response.data.status == "RESIGNED" )
                    this.accountList = response.data[0].histories;
                else
                    this.accountList = response.data[0].accounts;
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        updateAccountName(event){
            // console.log(this.selected);
            // if(this.type){
                this.$emit('updateAccountList', this.selected);
            // }    
            // else
            //     this.$emit('updateAccountList', this.selected.account_name);
        }
    },
    mounted() {
        this.getListOfAccounts();
    },
}
</script>