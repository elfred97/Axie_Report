export const NotificationSettingsMixins = {
    methods : {
        getSettings(){
            this.axios.get('getNotificationSettings')
            .then((response) =>{
                this.options = JSON.parse(response.data.notification_settings.options);
            })
            .catch((error) => {
                console.log(error);
            })
        },
    }
}