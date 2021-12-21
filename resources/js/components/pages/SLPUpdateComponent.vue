<template>
    <div>
         <!-- BEGIN #overview -->
        <div id="slp-update" class="section-container">
            <!-- BEGIN container -->
            <div class="container">

                <!-- begin row -->
                <div class="row row-space-10 m-b-20" v-if="SLPData">
                    <div class="col-md-6">
                        <select name="" id="" v-model="currency">
                            <option value="usd">USD</option>
                            <option value="php">PHP</option>
                            <option value="jpy">JPY</option>
                        </select>
                        <button class="btn btn-inverse btn-xs">Rank #{{SLPData.market_cap_rank}}</button>

                        <h2><span data-animation="number" :data-value="getSLPPrice">{{ getSLPPrice }}</span>
                            <span :class="getSLPChange('1h') > 0 ? 'text-success' : 'text-danger'">{{getSLPChange('1h')}} %</span>
                        </h2>
                        <p class="no-margin">{{this.SLPData.market_data.current_price.btc}} BTC 
                            <span v-if="(SLPData.market_data.price_change_percentage_24h_in_currency.btc > 0)" class="text-success">
                                {{ SLPData.market_data.price_change_percentage_24h_in_currency.btc.toFixed(1) }} %
                                <i class="fas fa-caret-up"></i>
                            </span>
                            <span v-else class="text-danger">
                                {{SLPData.market_data.price_change_percentage_24h_in_currency.btc.toFixed(1) }} %
                                <i class="fas fa-caret-down"></i>
                            </span>
                            </p>
                        <p class="no-margin">{{this.SLPData.market_data.current_price.eth}} ETH 
                            <span v-if="(SLPData.market_data.price_change_percentage_24h_in_currency.eth > 0)" class="text-success">
                                {{SLPData.market_data.price_change_percentage_24h_in_currency.eth.toFixed(1) }} %
                                <i class="fas fa-caret-up"></i>
                            </span>
                            <span v-else class="text-danger">
                                {{SLPData.market_data.price_change_percentage_24h_in_currency.eth.toFixed(1) }} %
                                <i class="fas fa-caret-down"></i>
                            </span>
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            SLPData : null,
            currency:  'php',

        }
    },
    computed : {
        getSLPPrice(){
            if(this.SLPData){
                return this.currency.toUpperCase() + ' ' + this.SLPData.market_data.current_price[this.currency];
            }
        }
    },
    methods: {
        getSLPUpdate(){
            this.axios.get('https://api.coingecko.com/api/v3/coins/smooth-love-potion?tickers=true&market_data=true&community_data=true&developer_data=true&sparkline=true')
            .then((response) => {
                this.SLPData = response.data;
            })
            .catch((error) => {
                console.log('Error: '+ error);
            })
        }, 
        getSLPChange(duration){
            if(this.SLPData){
                let market_data = this.SLPData.market_data;
                if(duration == '7d')
                    return market_data.price_change_percentage_7d_in_currency[this.currency].toFixed(2);
                else if(duration == '14d')
                    return market_data.price_change_percentage_14d_in_currency[this.currency].toFixed(2);
                else if(duration == '30d')
                    return market_data.price_change_percentage_30d_in_currency[this.currency].toFixed(2);
                else if(duration == '24h')
                    return market_data.price_change_percentage_24h_in_currency[this.currency].toFixed(2);
                else if(duration == '1h')
                    return market_data.price_change_percentage_1h_in_currency[this.currency].toFixed(2);
            }
        }
    },
    mounted(){
        this.getSLPUpdate();
    }
}
</script>