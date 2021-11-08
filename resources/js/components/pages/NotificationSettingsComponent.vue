<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Settings</h4>
                <div class="panel-heading-btn">                                    
                    <button class="btn btn-xs btn-success">
                        <i class="fas fa-check"></i> Update Settings
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">MMR</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="">Minimum SLP</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="">Target SLP Value</label>
                        <input type="number" class="form-control">
                    </div>
                </div>
                <p class="mt-2">Show / Hide</p>
                <div class="row"></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            settings : {}
        }
    },
    methods: {
        getSettings(){

        }
    },
    mounted() {
        this.getSettings();
    },
}
</script>