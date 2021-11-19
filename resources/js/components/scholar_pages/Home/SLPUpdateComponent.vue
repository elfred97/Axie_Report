<template>
    <div>
       
        <!-- begin card -->
        <div class="card border-0 bg-dark-darker-transparent-9 text-white text-truncate mb-3">
            <!-- begin card-body -->
            <div class="card-body">
                <!-- begin title -->
                <div class="mb-3 text-grey">
                    <select name="" id="" v-model="currency">
                        <option value="usd">USD</option>
                        <option value="php">PHP</option>
                        <option value="jpy">JPY</option>
                    </select>
                </div>
                <!-- end title -->
                <!-- begin conversion-rate -->
                <div class="d-flex align-items-center mb-1">
                    <h2 class="text-white mb-0"><span data-animation="number" :data-value="getSLPPrice">{{ getSLPPrice }}</span></h2>
                    <div class="ml-auto">
                        <div id="conversion-rate-sparkline"></div>
                    </div>
                </div>
                <!-- end conversion-rate -->
                <!-- begin percentage -->
                <div class="mb-3 text-grey">
                    <i class="fa fa-caret-down" v-if="getSLPChange('24h') < 0"></i> 
                    <i class="fa fa-caret-up" v-else></i> 
                    <span data-animation="number" :data-value="getSLPChange('24h')"> {{ getSLPChange('24h') }} </span>% compare to 24 Hours
                </div>
                <!-- end percentage -->
                <!-- begin info-row -->
                <div class="d-flex mb-2">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-circle text-green f-s-8 mr-2" v-if="getSLPChange('7d') > 0"></i>
                        <i class="fa fa-circle text-red f-s-8 mr-2" v-else></i>
                        7 Days Price Changes
                    </div>
                    <div class="d-flex align-items-center ml-auto">
                        <div class="width-50 text-right pl-2 f-w-600">
                            <i class="fa fa-caret-up" v-if="getSLPChange('7d') > 0"></i> 
                            <i class="fa fa-caret-down" v-else></i>
                            <span data-animation="number" :data-value="getSLPChange('7d')">
                                {{ getSLPChange('7d') }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- end info-row -->
                <!-- begin info-row -->
                <div class="d-flex mb-2">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-circle text-green f-s-8 mr-2" v-if="getSLPChange('14d') > 0"></i>
                        <i class="fa fa-circle text-red f-s-8 mr-2" v-else></i>
                        14 Days Price Changes
                    </div>
                    <div class="d-flex align-items-center ml-auto">
                        <div class="width-50 text-right pl-2 f-w-600">
                            <i class="fa fa-caret-up" v-if="getSLPChange('14d') > 0"></i> 
                            <i class="fa fa-caret-down" v-else></i>
                            <span data-animation="number" :data-value="getSLPChange('14d')">
                                {{ getSLPChange('14d') }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- end info-row -->
                <!-- begin info-row -->
                <div class="d-flex mb-2">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-circle text-green f-s-8 mr-2" v-if="getSLPChange('30d') > 0"></i>
                        <i class="fa fa-circle text-red f-s-8 mr-2" v-else></i>
                        30 Days Price Changes
                    </div>
                    <div class="d-flex align-items-center ml-auto">
                        <div class="width-50 text-right pl-2 f-w-600">
                            <i class="fa fa-caret-up" v-if="getSLPChange('30d') > 0"></i> 
                            <i class="fa fa-caret-down" v-else></i>
                            <span data-animation="number" :data-value="getSLPChange('30d')">
                                {{ getSLPChange('30d') }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- end info-row -->
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
            
    </div>
</template>
<script>
export default {
    data(){
        return {
            SLPData  : null,
            SLP_Price: 0,
            currency : 'php',
            price_changes : {}
        }
    },
    computed : {
        getSLPPrice(){
            if(this.SLPData){
                return this.currency.toUpperCase() + ' ' + this.SLPData.market_data.current_price[this.currency];
            }
        },
    },
    methods : {
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
            }
        }
    },
    mounted(){
        this.getSLPUpdate();
    }
}
</script>