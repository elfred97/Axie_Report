export const NotificationSettingsMixins = {
    methods : {
        getSettings(){
            this.axios.get('getNotificationSettings')
            .then((response) =>{                
                this.options = response.data.notification_settings.options;
            })
            .catch((error) => {
                console.log(error);
            })
        },
    }
}