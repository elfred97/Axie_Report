<template>
    <div>
        <!-- BEGIN #tablet-list -->
        <div id="table-list" class="section-container bg-white">
            <!-- BEGIN container -->
            <!-- <div class="container"> -->
                <div class="row no-margin">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="dataTables_length" id="data-table-default_length">
                            <label>Type 
                                <select 
                                    name="data-table-default_length" 
                                    aria-controls="data-table-default" 
                                    class="custom-select custom-select-sm form-control form-control-sm"
                                    v-model="type"
                                    @change="getReport()"
                                    >
                                        <option value="">All</option>
                                        <option value="Decent">Decent</option>
                                        <option value="Trust">Trust</option>
                                </select> 
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin mt-1">
                    <div class="col-lg-12">
                        <table class="footable table">
                            <thead>
                                <tr>
                                    <th @click="sortTable('p.status')" class="onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'p.status'}]">
                                                Status
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.name')" class="onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.name'}]">
                                                Account Name
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('p.first_name')" class="onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'p.first_name'}]">
                                                Scholar Name
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <!-- <th>Ronin Address</th> -->
                                    <th @click="sortTable('p.penalty')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'p.penalty'}]">
                                                Penalty
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.mmr')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.mmr'}]">
                                                MMR
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.gained_slp_today')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.gained_slp_today'}]">
                                                1 Day Earn
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.created_at')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.created_at'}]">
                                                Date
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.average_per_day')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.average_per_day'}]">
                                                Ave Per Day
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.unclaimed')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.unclaimed'}]">
                                                Unclaimed
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.claimed')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.claimed'}]">
                                                Claimed
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.total_slp')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.total_slp'}]">
                                                Total SLP
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template>
                                    </th>
                                    <th @click="sortTable('r.last_claim_date')" class="text-center onHover">
                                        <template>
                                            <div v-bind:class="[{ active : sortOrder.type === 'r.last_claim_date'}]">
                                                Last Claim
                                                <i class="fas fa-caret-down" v-if="sortOrder.order == 'desc'"></i>
                                                <i class="fas fa-caret-up" v-else></i>
                                            </div>
                                        </template></th>                                
                                    <!-- <th>Manager Share</th>
                                    <th>Scholar Share</th>
                                    <th>MMR</th>
                                    <th>Rank</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in reportData">
                                    <td>{{ data[data.length - 1].status}}</td>
                                    <td>{{ data[data.length - 1].account_name}}</td>
                                    <td>{{ data[data.length - 1].player_name }}</td>
                                    <!-- <td>{{ data[data.length - 1].ronin_address }}</td> -->
                                    <td class="text-center">
                                        <span class="text-bold text-default" v-if="data[data.length - 1].penalty == 0">
                                            {{ data[data.length - 1].penalty }}
                                        </span>
                                        <span class="text-bold text-info" v-else-if="data[data.length - 1].penalty == 1">
                                            {{ data[data.length - 1].penalty }}
                                        </span>
                                        <span class="text-bold text-warning" v-else-if="data[data.length - 1].penalty == 2">
                                            {{ data[data.length - 1].penalty }}
                                        </span>
                                        <span class="text-bold text-danger" v-else>
                                            {{ data[data.length - 1].penalty }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ data[data.length - 1].mmr }}
                                    </td>
                                    <td class="text-center">
                                        <span class="btn btn-danger btn-xs" v-if="getDayEarn(data) < 75">
                                            {{ getDayEarn(data) }}
                                        </span>
                                        <span v-else>
                                            {{ getDayEarn(data) }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ data[data.length - 1].created_at | formatDate }}</td>
                                    <td class="text-center">{{ data[data.length - 1].average_per_day }}</td>
                                    <td class="text-center">{{ data[data.length - 1].unclaimed }}</td>
                                    <td class="text-center">{{ data[data.length - 1].claimed }}</td>
                                    <td class="text-center">{{ data[data.length - 1].total_slp }}</td>
                                    <td class="text-center">{{ data[data.length - 1].last_claim_days }} by {{ data[data.length - 1].last_claim_date | formatDate }}</td>
                                    <!-- <td>{{ data[data.length - 1].manager_share }}</td>
                                    <td>{{ data[data.length - 1].scholar_share }}</td> -->
                                    <!-- <td>{{ data[data.length - 1].mmr }}</td>
                                    <td>{{ data[data.length - 1].rank }}</td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- </div> -->
            <!-- END container -->
        </div>
        <!-- END Table List -->
    </div>
</template>
<script>
import FieldsDef from "./FieldsDef.js";

export default {
    data () {
        return {
            fields: FieldsDef,
            perPage: 10,
            data: [],
            reportData: {},
            type: '',
            sortOrder : {
                type : '',
                order : "desc",
            },

        }
    },
    watch:{
        'reportData': function(newVal){
            this.reportData = newVal;
        },
        'sortOrder.type' : function(newVal){
            this.getReport();
        },
        'sortOrder.order' : function(newVal){
            this.getReport();
        },
    },
    methods: {
        getReport(){
            this.axios.get('/getReport', {
                params:{
                    type     : this.type,
                    sortType : this.sortOrder.type,
                    sortOrder: this.sortOrder.order,
                }
            })
            .then((response) => {
                this.reportData = response.data;
            })
            .catch((error) => {
                // this.clearAll();
                console.log(error.response.data)
            })
        },
        getDayEarn(data){
            if(data.length >= 2)
                return data[data.length - 1].total_slp - data[data.length - 2].total_slp;
            else
                return data[data.length - 1].total_slp;
        },
        sortTable(type){
            if(this.sortOrder.type == type){
                this.sortOrder.order = (this.sortOrder.order == 'asc') ? 'desc' : 'asc';
            }

            this.sortOrder.type = type;
        }
    },
    created(){
        this.getReport();
    },
}
</script>