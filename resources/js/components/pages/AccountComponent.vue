<template>
    <div>
        <!-- Draggable Dialog Component key is for rerendering only-->
        <dialog-component :key="componentKey" v-bind:isOpen="isOpenDialog" v-on:isClose="isOpenDialog = false" :dialogTitle="isOpenDialogTitle" :modalWidth="isOpenDialogSize">
            <component v-bind:is="isOpenDialogComponent" v-bind="object_values"></component>
        </dialog-component>
        <!-- End of Draggable Dialog-->

        <div class="section-container main-content-view bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <!-- Begin Account Settings -->
                        <account-information></account-information>
                        <!-- End Account Settings -->
                        
                        <!-- Begin Notification Settings -->
                        <notification-settings></notification-settings>
                        <!-- End Notification Settings -->

                        <!-- Begin Notification Settings -->
                        <!-- <reminder-component></reminder-component> -->
                        <!-- End Notification Settings -->
                    </div>
                    <div class="col-md-5">
                        <!-- Begin Users List -->
                        <users-component></users-component>
                        <!-- End Users List -->
                        
                        <!-- Begin Type -->
                        <type-component></type-component>
                        <!-- End Type -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import NotificationSettingsComponent from './NotificationSettingsComponent.vue'
import AccountInformationComponent from './AccountInformationComponent.vue';
import ReminderComponent from './ReminderComponent.vue';
import UsersComponent from './UsersComponent.vue';
import TypeComponent from './TypeListComponent.vue';

// Dialog Components
import changePasswordComponent from './changePasswordComponent.vue';
import addReminderFormComponent from './addReminderFormComponent.vue';
import newUserFormComponent from './newUserFormComponent.vue';
import updateTypeInfoComponent from './updateTypeInfoComponent.vue';
export default {
    data(){
        return {
            isOpenDialog         : false,
            isOpenDialogComponent: '',
            isOpenDialogTitle    : '',
            isOpenDialogSize     : '100%',
            componentKey         : 0,
            componentsProps      : {
                    userInfo     : null,
                    usersListInfo: null,
                    typeInfo     : null,
                    settingsInfo : null,
                    reminder     : null,
            }
        }
    },
    components : {
        'account-information'  : AccountInformationComponent,
        'reminder-component'   : ReminderComponent,
        'users-component'      : UsersComponent,
        'type-component'       : TypeComponent,
        'notification-settings': NotificationSettingsComponent,
        // Dialog Components
        'changePassword-form': changePasswordComponent,
        'newUser-form'       : newUserFormComponent,
        'updateTypeInfo-form': updateTypeInfoComponent,
        'add-reminder-form'  : addReminderFormComponent,
    },
    methods: {
        
    },
    computed: {
        object_values: function(){ //created to manipulate passed props in each components rendered
            if(this.isOpenDialogComponent === 'changePassword-form')
                return  { userInfo : this.componentsProps.userInfo }
            else if(this.isOpenDialogComponent === 'newUser-form')
                return  { usersListInfo : this.componentsProps.usersListInfo }
            else if(this.isOpenDialogComponent === 'updateTypeInfo-form')
                return  { typeInfo : this.componentsProps.typeInfo }
            else if(this.isOpenDialogComponent === 'add-reminder-form')
                return  { reminder : this.componentsProps.reminder }
        }
    },
    mounted(){
        this.$root.$on('showDialog', (openDialog, openDialogComponent, openDialogTitle, openDialogSize, propsObject) => {
                this.isOpenDialog          = openDialog;
                this.isOpenDialogComponent = openDialogComponent;
                this.isOpenDialogSize      = openDialogSize;
                this.isOpenDialogTitle     = openDialogTitle;

                if(openDialogComponent === 'newUser-form') this.componentsProps.usersListInfo = propsObject;
                else if(openDialogComponent === 'updateTypeInfo-form') this.componentsProps.typeInfo      = propsObject;
                else if(openDialogComponent === 'add-reminder-form') this.componentsProps.reminder      = propsObject;

                this.componentKey = this.componentKey + 1;
            });
        this.$root.$on('isClose', (data) => {
            
            this.isOpenDialog = false;
        });
    }
}
</script>