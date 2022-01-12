<template>
    <div>
        <!-- <h2>Axie Details</h2> -->
        <!-- <div class="row row-space-10">
            <div class="col-md-3">
                <label for="">Search</label>
                <input type="text" class="form-control" placeholder="Search Axie by ID">
            </div>
            <div class="col-md-1">
                <label for="">Filter by Class</label>
                <select name="" id="" class="form-control">
                    <option value="All">All</option>
                    <option value="Egg">Egg</option>
                    <option value="Beast">Beast</option>
                    <option value="Plant">Plant</option>
                    <option value="Bug">Bug</option>
                    <option value="Mech">Mech</option>
                    <option value="Dusk">Dusk</option>
                    <option value="Aquatic">Aquatic</option>
                    <option value="Bird">Bird</option>
                    <option value="Reptile">Reptile</option>
                    <option value="Dawn">Dawn</option>
                </select>
            </div>
            <div class="col-md-1">
                <label for="">Breeds</label>
                <select name="" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="">Parts</label>
                <input type="text" class="form-control" placeholder="search body parts">
            </div>
            <div class="col-md-2">
                <label for="">Genetic R1</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="">Genetic R2</label>
                <input type="text" class="form-control">
            </div>
        </div> -->
        <div class="row row-space-10">
            <div class="col-md-3">
                <p class="no-margin">
                    Total {{ axies.length}}
                </p>
            </div>
            <div class="col-md-2">
                <account-list-component @updateAccountList="account_selected = $event"></account-list-component>
            </div>
            <div class="col-md-7">
                <div class="pull-right">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" v-for="(axie, index) in axies">
                <div class="axie-card">
                    <div class="title">
                        <div class="row no-margin">
                            <div class="col-md-8">
                                <h4 class="text-bold">{{axie.name}} <a :href="'https://marketplace.axieinfinity.com/axie/'+axie.id" target="_blank"><i class="fas fa-share"></i></a></h4>
                                <div class="row no-margin">
                                    <div class="col-md-4">
                                        <p class="no-margin"><small>Class</small></p>
                                        {{axie.class}}
                                    </div>
                                    <div class="col-md-4">
                                        <p class="no-margin"><small>Breeds</small></p>
                                        {{axie.breedCount}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img :src="axie.image" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row no-margin">
                            <div class="col-md-4 text-center" v-for="parts in axie.parts">
                                <label for="" class="text-center">{{parts.type}}</label>
                                <!-- <eye-component v-if="parts.type == 'Eyes'" :data="parts" :name="parts.id"></eye-component>
                                <ear-component v-else-if="parts.type == 'Ears'"  :data="parts" :name="parts.id"></ear-component>
                                <back-component v-else-if="parts.type == 'Back'"  :data="parts" :name="parts.id"></back-component>
                                <mouth-component v-else-if="parts.type == 'Mouth'"  :data="parts" :name="parts.id"></mouth-component>
                                <horn-component v-else-if="parts.type == 'Horn'"  :data="parts" :name="parts.id"></horn-component>
                                <tail-component v-else-if="parts.type == 'Tail'"  :data="parts" :name="parts.id"></tail-component> -->
                                <p class="no-margin">{{parts.name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// import EyeComponent from './BodyParts/EyeComponent.vue';
// import EarComponent from './BodyParts/EarComponent.vue';
// import BackComponent from './BodyParts/BackComponent.vue';
// import MouthComponent from './BodyParts/MouthComponent.vue';
// import HornComponent from './BodyParts/HornComponent.vue';
// import TailComponent from './BodyParts/TailComponent.vue';
export default {
    data(){
        return {
            display : {
                first : false,
                second: false,
                third : false,
            },
            userData: {},
            axies   : {},
            account_selected : ''
        }
    },
    // components : {
    //     'eye-component' : EyeComponent,
    //     'ear-component' : EarComponent,
    //     'back-component' : BackComponent,
    //     'mouth-component' : MouthComponent,
    //     'horn-component' : HornComponent,
    //     'tail-component' : TailComponent,
    // },
    watch: {
        'display': function(newVal){
            console.log(newVal);
        },
        'account_selected' : function(newVal){
            this.getAxieList();
        }
    },
    methods: {
        previewAxie(id){
            window.open('https://marketplace.axieinfinity.com/axie/'+id, '_blank');
        },
        getAxieParts(data){
            console.log(data);
        },
        changeStatus(id){
            if(id == 1)
                this.display.first = ! this.display.first;
            else if(id == 2)
                this.display.second = ! this.display.second;
            else if(id == 3)
                this.display.third = ! this.display.third;
        },
         getAxieList(){
            // let ronin_address = "0x" + this.userData.ronin_address.split(":")[1];
            let ronin_address = "0x" + this.account_selected.ronin_address.split(':')[1];
            // let ronin_address = "0xc417a4b041f18d8cf2bb90b754969afb2146cc8c";
            // console.log(ronin_address)
            this.axios.get('https://graphql-gateway.axieinfinity.com/graphql', {
                params: {
                    operationName: "GetAxieBriefList",
                    variables: {
                        from: 0,
                        size: 100,
                        sort: "IdDesc",
                        auctionType: "All",
                        owner: ronin_address,
                        criteria: {
                            region: null,
                            parts: null,
                            bodyShapes: null,
                            classes: null,
                            stages: null,
                            numMystic: null,
                            pureness: null,
                            title: null,
                            breedable: null,
                            breedCount: null,
                            hp: [],
                            skill: [],
                            speed: [],
                            morale: []
                        }
                    },
                    query: "query GetAxieBriefList($auctionType: AuctionType, $criteria: AxieSearchCriteria, $from: Int, $sort: SortBy, $size: Int, $owner: String) {\n  axies(auctionType: $auctionType, criteria: $criteria, from: $from, sort: $sort, size: $size, owner: $owner) {\n    total\n    results {\n      ...AxieBrief\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment AxieBrief on Axie {\n  id\n  name\n  stage\n  class\n birthDate\n breedCount\n  image\n  genes\n  title\n  battleInfo {\n    banned\n    __typename\n  }\n  auction {\n    currentPrice\n    currentPriceUSD\n    __typename\n  }\n  parts {\n    id\n    name\n    class\n    type\n    specialGenes\n    __typename\n  }\n  __typename\n}\n"
                }
            })
            .then(response => {
                // console.log(response.data);
                this.axies = response.data.data.axies.results;
                // this.getSampleAxieDetails(this.axies[0].id);
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        getAccountInformation(){
            this.axios.get("getAccountInfo/scholars")
            .then((response) => {
                // console.log(response.data);
                this.userData = response.data;
                // this.getAxieList();
            })
            .catch((error) => {
                console.log(error.data);
            })
        },
    },
    mounted(){
        this.getAccountInformation();
    }
}
</script>