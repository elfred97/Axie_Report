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
                    <div :class="getGuardRole == 1 ? 'col-lg-7 col-md-6 col-sm-12 col-xs-12' : 'col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-12 col-xs-12'">
                        <!-- Begin Account Settings -->
                        <account-information></account-information>
                        <!-- End Account Settings -->
                        
                        <!-- Begin Notification Settings -->
                        <notification-settings></notification-settings>                        
                        <!-- End Notification Settings -->

                        <!-- Begin Custom Settings -->
                        <custom-settings></custom-settings>
                        <!-- End Custom Settings -->

                        <!-- Begin Notification Settings -->
                        <reminder-component></reminder-component>
                        <!-- End Notification Settings -->
                    </div>
                    <div v-if="getGuardRole == 1" class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
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
import CustomSettingsComponent from './CustomSettingsComponent.vue'
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
        'custom-settings': CustomSettingsComponent,
        // Dialog Components
        'changePassword-form': changePasswordComponent,
        'newUser-form'       : newUserFormComponent,
        'updateTypeInfo-form': updateTypeInfoComponent,
        'add-reminder-form'  : addReminderFormComponent,
    },
    methods: {
        
    },
    computed: {
        getGuardRole(){
            return this.$store.state.global_guard_role;
        },
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