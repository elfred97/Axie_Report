
export const TableMixins = {
    methods: {
        updateTable(){
            Vue.nextTick( () => this.$refs.vuetable.refresh())
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData);
            this.$refs.paginationInfo.setPaginationData(paginationData);
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page);
        },        
        onFilterReset(){
            this.filtersParam = {};
            Vue.nextTick( () => this.$refs.vuetable.refresh())
        },
        onLoading(){
            this.isLoading = true;
            // console.log('loading... show your spinner here')
        },
        onLoaded(){
            this.isLoading = false;
        },
        onCancel(){
            console.log("Loader cancelled")
        },
        onCellClicked (data, field, event) {
            this.$refs.vuetable.toggleDetailRow(data.data.id)
        },
        openDetailRow($event, data){
            this.$refs.vuetable.toggleDetailRow(data.id)
        },
    }
}