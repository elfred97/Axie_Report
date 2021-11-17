<template>
    <div>
       
        <div class="row row-space-10 m-b-20">
            <div class="col-md-12">
                <select name="" id="" v-model="currency">
                    <option value="usd">USD</option>
                    <option value="php">PHP</option>
                    <option value="jpy">JPY</option>
                </select>
            </div>
            <div class="col-md-12">
                <h5>Smooth Love Potion 
                    <span class="badge badge-inverse">SLP</span>
                </h5>
                <h3>{{ getSLPPrice }}
                    <small class="text-danger ml-2" v-if="getSLPChange_24H < 0">
                            {{ getSLPChange_24H }}  %                              
                    </small>
                    <small class="text-primary ml-2" v-else-if="getSLPChange_24H > 0">
                            {{ getSLPChange_24H }} %
                    </small>
                </h3>
                <div class="btn-group">
                    <button class="btn btn-xs btn-info"><i class="fas fa-bell"></i> Remind SLP Price</button>
                </div>                
            </div>
        </div>
            
    </div>
</template>
<script>
export default {
    data(){
        return {
            SLPData  : null,
            SLP_Price: 0,
            currency : 'php',
        }
    },
    computed : {
        getSLPPrice(){
            if(this.SLPData)
                if(this.currency == 'php')
                    return '₱ ' + this.SLPData.market_data.current_price.php
                else if(this.currency == 'usd')
                    return '$ ' + this.SLPData.market_data.current_price.usd
                else if(this.currency == 'jpy')
                    return '¥ ' + this.SLPData.market_data.current_price.jpy
        },

        getSLPChange_24H(){

            if(this.SLPData){
                let changes = parseFloat(this.SLPData.market_data.price_change_percentage_24h).toFixed(2);
                return changes;
            }
        }
        
    },
    methods : {
        getSLPUpdate(){
            this.axios.get('https://api.coingecko.com/api/v3/coins/smooth-love-potion?tickers=true&market_data=true&community_data=true&developer_data=true&sparkline=true')
            .then((response) => {
                this.SLPData = response.data;                

                // console.log(response.data);
            })
            .catch((error) => {
                console.log('Error: '+ error);
            })
        },        
    },
    mounted(){
        this.getSLPUpdate();
    }
}
</script>