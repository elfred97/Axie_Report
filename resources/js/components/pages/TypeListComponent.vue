<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Type</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group h-15">
                            <li class="list-group-item" v-for="type in typeData">
                                <div class="row no-margin">
                                    <div class="col-md-6">
                                        <span class="text-bold">{{ type.name }}</span>                                                             
                                    </div>
                                    <div class="col-md-3">
                                        <i class="fa fa-circle text-lime f-s-8 mr-2" v-if="type.status == 'Active'"></i>
                                        <i class="fa fa-circle text-aqua f-s-8 mr-2" v-else></i>
                                        {{ type.status }} 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group pull-right">
                                            <button class="btn btn-xs btn-default" @click="$root.$emit('showDialog', true, 'updateTypeInfo-form', 'Update Type', '30%', type)">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </button>
                                            <button class="btn btn-xs btn-default text-danger" @click="deleteType(type.id)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>         
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Add new type here" v-model="newType">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" @click="saveNewType()"><i class="fas fa-plus"></i> New Type</button>
                            </div>
                        </div>
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
            newType    : '',
            typeData   : {},
        }
    },
    methods: {
        getTypes(){
            this.axios.get('/getType')
            .then((response) => {
                this.typeData = response.data;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        saveNewType(){
            this.axios.post('/saveNewType', {
                name : this.newType
            })
            .then((response) => {
                this.$noty.success(response.data.message);
                this.newType = '';
                this.getTypes();
            })
            .catch((error) => {
                // console.log(error);
                this.$noty.error(error.response.data.message);
            })
        },
        deleteType(id){
            this.$alertify.confirmWithTitle("Delete", "Are you sure to delete this type?", 
            ()=> {
                this.axios.post('/deleteType', {
                    id : id
                })
                .then((response) => {
                    this.getTypes();
                    this.$noty.success(response.data.message);
                })
                .catch((error) => {
                    this.$noty.error("Something went wrong please try again later.")               
                });
            },() =>this.$noty.error("Cancel: Item not removed")
            )
        }
    },
    mounted() {
        this.getTypes();
        this.$events.on('update_type', (data) => {
            this.getTypes(); 
        });
    },
}
</script>