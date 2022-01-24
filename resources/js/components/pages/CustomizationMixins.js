export const CustomizationMixins = {
    methods : {
        getSettings(){
            this.axios.get('getCuztomizationSettings')
            .then((response) =>{
                // console.log(response.data);
                if(response.data.notification_settings)
                    this.options = response.data.notification_settings.options;
                
            })
            .catch((error) => {
                console.log(error);
            })
        }
    }
}