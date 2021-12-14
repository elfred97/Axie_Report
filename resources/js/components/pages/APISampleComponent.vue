<template>
    <div>
        
    </div>
</template>
<script>
export default {
    data(){
        return {
            axies : {},

        }
    },
    methods : {
        getAxieList(){
            let ronin_address = '0xc992bc7b3a60c2c2c12b3242af73e97c5610d17c';
            this.axios.get('https://graphql-gateway.axieinfinity.com/graphql', {
                params: {
                    "operationName": "GetAxieBriefList",
                    "variables": {
                        "from": 0,
                        "size": 100,
                        "sort": "IdDesc",
                        "auctionType": "All",
                        "owner": ronin_address,
                        "criteria": {
                            "region": null,
                            "parts": null,
                            "bodyShapes": null,
                            "classes": null,
                            "stages": null,
                            "numMystic": null,
                            "pureness": null,
                            "title": null,
                            "breedable": null,
                            "breedCount": null,
                            "hp": [],
                            "skill": [],
                            "speed": [],
                            "morale": []
                        }
                    },
                    "query": "query GetAxieBriefList($auctionType: AuctionType, $criteria: AxieSearchCriteria, $from: Int, $sort: SortBy, $size: Int, $owner: String) {\n  axies(auctionType: $auctionType, criteria: $criteria, from: $from, sort: $sort, size: $size, owner: $owner) {\n    total\n    results {\n      ...AxieBrief\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment AxieBrief on Axie {\n  id\n  name\n  stage\n  class\n birthDate\n breedCount\n  image\n  genes\n  title\n  battleInfo {\n    banned\n    __typename\n  }\n  auction {\n    currentPrice\n    currentPriceUSD\n    __typename\n  }\n  parts {\n    id\n    name\n    class\n    type\n    specialGenes\n    __typename\n  }\n  __typename\n}\n"
                }
            })
            .then(response => {
                // console.log(response.data);
                this.axies = response.data.data.axies.results;
                this.getSampleAxieDetails(this.axies[0].id);
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        getSampleAxieDetails(axieID){
            this.axios.get('https://graphql-gateway.axieinfinity.com/graphql', {
                params: {
                    "operationName": "GetAxieDetail",
                    "variables": {
                        "axieId": axieID
                    },
                    "query": "query GetAxieDetail($axieId: ID!) {\n  axie(axieId: $axieId) {\n    ...AxieDetail\n    __typename\n  }\n}\n\nfragment AxieDetail on Axie {\n  id\n  image\n  class\n  chain\n  name\n  genes\n  owner\n  birthDate\n  bodyShape\n  class\n  sireId\n  sireClass\n  matronId\n  matronClass\n  stage\n  title\n  breedCount\n  level\n  figure {\n    atlas\n    model\n    image\n    __typename\n  }\n  parts {\n    ...AxiePart\n    __typename\n  }\n  stats {\n    ...AxieStats\n    __typename\n  }\n  auction {\n    ...AxieAuction\n    __typename\n  }\n  ownerProfile {\n    name\n    __typename\n  }\n  battleInfo {\n    ...AxieBattleInfo\n    __typename\n  }\n  children {\n    id\n    name\n    class\n    image\n    title\n    stage\n    __typename\n  }\n  __typename\n}\n\nfragment AxieBattleInfo on AxieBattleInfo {\n  banned\n  banUntil\n  level\n  __typename\n}\n\nfragment AxiePart on AxiePart {\n  id\n  name\n  class\n  type\n  specialGenes\n  stage\n  abilities {\n    ...AxieCardAbility\n    __typename\n  }\n  __typename\n}\n\nfragment AxieCardAbility on AxieCardAbility {\n  id\n  name\n  attack\n  defense\n  energy\n  description\n  backgroundUrl\n  effectIconUrl\n  __typename\n}\n\nfragment AxieStats on AxieStats {\n  hp\n  speed\n  skill\n  morale\n  __typename\n}\n\nfragment AxieAuction on Auction {\n  startingPrice\n  endingPrice\n  startingTimestamp\n  endingTimestamp\n  duration\n  timeLeft\n  currentPrice\n  currentPriceUSD\n  suggestedPrice\n  seller\n  listingIndex\n  state\n  __typename\n}\n"
                }
            })
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error.response.data);
            })
        },
        getActivityLog(){
            this.axios.get('https://graphql-gateway.axieinfinity.com/graphql', {
                params: {
                    "operationName": "GetActivityLog",
                    "variables": {
                        "from": 0,
                        "size": 6
                    },
                    "query": "query GetActivityLog($from: Int, $size: Int) {\n  profile {\n    activities(from: $from, size: $size) {\n      ...Activity\n      __typename\n    }\n    __typename\n  }\n}\n\nfragment Activity on Activity {\n  activityId\n  accountId\n  action\n  timestamp\n  seen\n  data {\n    ... on ListAxie {\n      ...ListAxie\n      __typename\n    }\n    ... on UnlistAxie {\n      ...UnlistAxie\n      __typename\n    }\n    ... on BuyAxie {\n      ...BuyAxie\n      __typename\n    }\n    ... on GiftAxie {\n      ...GiftAxie\n      __typename\n    }\n    ... on MakeAxieOffer {\n      ...MakeAxieOffer\n      __typename\n    }\n    ... on CancelAxieOffer {\n      ...CancelAxieOffer\n      __typename\n    }\n    ... on SyncExp {\n      ...SyncExp\n      __typename\n    }\n    ... on MorphToPetite {\n      ...MorphToPetite\n      __typename\n    }\n    ... on MorphToAdult {\n      ...MorphToAdult\n      __typename\n    }\n    ... on BreedAxies {\n      ...BreedAxies\n      __typename\n    }\n    ... on BuyLand {\n      ...BuyLand\n      __typename\n    }\n    ... on ListLand {\n      ...ListLand\n      __typename\n    }\n    ... on UnlistLand {\n      ...UnlistLand\n      __typename\n    }\n    ... on GiftLand {\n      ...GiftLand\n      __typename\n    }\n    ... on MakeLandOffer {\n      ...MakeLandOffer\n      __typename\n    }\n    ... on CancelLandOffer {\n      ...CancelLandOffer\n      __typename\n    }\n    ... on BuyItem {\n      ...BuyItem\n      __typename\n    }\n    ... on ListItem {\n      ...ListItem\n      __typename\n    }\n    ... on UnlistItem {\n      ...UnlistItem\n      __typename\n    }\n    ... on GiftItem {\n      ...GiftItem\n      __typename\n    }\n    ... on MakeItemOffer {\n      ...MakeItemOffer\n      __typename\n    }\n    ... on CancelItemOffer {\n      ...CancelItemOffer\n      __typename\n    }\n    ... on ListBundle {\n      ...ListBundle\n      __typename\n    }\n    ... on UnlistBundle {\n      ...UnlistBundle\n      __typename\n    }\n    ... on BuyBundle {\n      ...BuyBundle\n      __typename\n    }\n    ... on MakeBundleOffer {\n      ...MakeBundleOffer\n      __typename\n    }\n    ... on CancelBundleOffer {\n      ...CancelBundleOffer\n      __typename\n    }\n    ... on AddLoomBalance {\n      ...AddLoomBalance\n      __typename\n    }\n    ... on WithdrawFromLoom {\n      ...WithdrawFromLoom\n      __typename\n    }\n    ... on AddFundBalance {\n      ...AddFundBalance\n      __typename\n    }\n    ... on WithdrawFromFund {\n      ...WithdrawFromFund\n      __typename\n    }\n    ... on TopupRoninWeth {\n      ...TopupRoninWeth\n      __typename\n    }\n    ... on WithdrawRoninWeth {\n      ...WithdrawRoninWeth\n      __typename\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment ListAxie on ListAxie {\n  axieId\n  priceFrom\n  priceTo\n  duration\n  txHash\n  __typename\n}\n\nfragment UnlistAxie on UnlistAxie {\n  axieId\n  txHash\n  __typename\n}\n\nfragment BuyAxie on BuyAxie {\n  axieId\n  price\n  owner\n  txHash\n  __typename\n}\n\nfragment GiftAxie on GiftAxie {\n  axieId\n  destination\n  txHash\n  __typename\n}\n\nfragment MakeAxieOffer on MakeAxieOffer {\n  axieId\n  price\n  txHash\n  __typename\n}\n\nfragment CancelAxieOffer on CancelAxieOffer {\n  axieId\n  txHash\n  __typename\n}\n\nfragment SyncExp on SyncExp {\n  axieId\n  exp\n  txHash\n  __typename\n}\n\nfragment MorphToPetite on MorphToPetite {\n  axieId\n  txHash\n  __typename\n}\n\nfragment MorphToAdult on MorphToAdult {\n  axieId\n  txHash\n  __typename\n}\n\nfragment BreedAxies on BreedAxies {\n  sireId\n  matronId\n  lovePotionAmount\n  txHash\n  __typename\n}\n\nfragment BuyLand on BuyLand {\n  row\n  col\n  price\n  owner\n  txHash\n  __typename\n}\n\nfragment ListLand on ListLand {\n  row\n  col\n  priceFrom\n  priceTo\n  duration\n  txHash\n  __typename\n}\n\nfragment UnlistLand on UnlistLand {\n  row\n  col\n  txHash\n  __typename\n}\n\nfragment GiftLand on GiftLand {\n  row\n  col\n  destination\n  txHash\n  __typename\n}\n\nfragment MakeLandOffer on MakeLandOffer {\n  row\n  col\n  price\n  txHash\n  __typename\n}\n\nfragment CancelLandOffer on CancelLandOffer {\n  row\n  col\n  txHash\n  __typename\n}\n\nfragment BuyItem on BuyItem {\n  tokenId\n  itemAlias\n  price\n  owner\n  txHash\n  __typename\n}\n\nfragment ListItem on ListItem {\n  tokenId\n  itemAlias\n  priceFrom\n  priceTo\n  duration\n  txHash\n  __typename\n}\n\nfragment UnlistItem on UnlistItem {\n  tokenId\n  itemAlias\n  txHash\n  __typename\n}\n\nfragment GiftItem on GiftItem {\n  tokenId\n  itemAlias\n  destination\n  txHash\n  __typename\n}\n\nfragment MakeItemOffer on MakeItemOffer {\n  tokenId\n  itemAlias\n  price\n  txHash\n  __typename\n}\n\nfragment CancelItemOffer on CancelItemOffer {\n  tokenId\n  itemAlias\n  txHash\n  __typename\n}\n\nfragment BuyBundle on BuyBundle {\n  listingIndex\n  price\n  owner\n  txHash\n  __typename\n}\n\nfragment ListBundle on ListBundle {\n  numberOfItems\n  priceFrom\n  priceTo\n  duration\n  txHash\n  __typename\n}\n\nfragment UnlistBundle on UnlistBundle {\n  listingIndex\n  txHash\n  __typename\n}\n\nfragment MakeBundleOffer on MakeBundleOffer {\n  listingIndex\n  price\n  txHash\n  __typename\n}\n\nfragment CancelBundleOffer on CancelBundleOffer {\n  listingIndex\n  txHash\n  __typename\n}\n\nfragment AddLoomBalance on AddLoomBalance {\n  amount\n  senderAddress\n  receiverAddress\n  txHash\n  __typename\n}\n\nfragment WithdrawFromLoom on WithdrawFromLoom {\n  amount\n  senderAddress\n  receiverAddress\n  txHash\n  __typename\n}\n\nfragment AddFundBalance on AddFundBalance {\n  amount\n  senderAddress\n  txHash\n  __typename\n}\n\nfragment WithdrawFromFund on WithdrawFromFund {\n  amount\n  receiverAddress\n  txHash\n  __typename\n}\n\nfragment WithdrawRoninWeth on WithdrawRoninWeth {\n  amount\n  receiverAddress\n  txHash\n  receiverAddress\n  __typename\n}\n\nfragment TopupRoninWeth on TopupRoninWeth {\n  amount\n  receiverAddress\n  txHash\n  receiverAddress\n  __typename\n}\n"
                }
            })
            .then(response => {
                console.log(response.data)
            })
            .catch(error => {

            })
        }
    },
    mounted(){
        this.getAxieList();
        // this.getSampleAxieDetails();
        // this.getActivityLog();
    }
}
</script>