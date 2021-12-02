export const NotificationSettingsMixins = {
    methods : {
        getSettings(){
            this.axios.get('getNotificationSettings')
            .then((response) =>{
                if(response.data.notification_settings)
                    this.options = response.data.notification_settings.options;
                
            })
            .catch((error) => {
                console.log(error);
            })
        },
    }
}