export const routes = [
    { path: '*', redirect: '/home'},
    { 
        path: '/home', 
        component: require('./components/pages/HomeComponent.vue').default,
        meta : {
            admins : true,
        }
    },
    { 
        path: '/game_logs', 
        component: require('./components/pages/ImportComponent.vue').default,
        meta : {
            admins : true,
        }
    },
    { 
        path: '/players', 
        component: require('./components/pages/PlayerComponent.vue').default,
        meta : {
            admins : true,
        }
    },
    { 
        path: '/scholarList', 
        component: require('./components/pages/ScholarListComponent.vue').default,
        meta : {
            admins : true,
        }
    },
    { 
        path: '/payroll_history', 
        component: require('./components/pages/PayrollHistoryComponent.vue').default,
        meta : {
            admins : true,
        }
    },
    { 
        path: '/settings', 
        component: require('./components/pages/AccountComponent.vue').default,
        meta : {
            admins : true,
        }
    },
    { 
        path: '/audit', 
        component: require('./components/pages/AuditComponent.vue').default,
        meta : {
            admins : true,
        }
    },
    {
        path: '/notification', 
        component: require('./components/pages/NotificationComponent.vue').default,
        meta : {
            admins : true,
        }
    },

    { 
        path: '/scholars', 
        component: require('./components/scholar_pages/Home/ScholarHomeComponent.vue').default,
        meta : {
            admins : false,
        }
    },
    { 
        path: '/scholar_account', 
        component: require('./components/scholar_pages/Account/ScholarAccountComponent.vue').default,
        meta : {
            admins : false,
        }
    },
    { 
        path: '/scholar_payroll', 
        component: require('./components/scholar_pages/Payroll/ScholarPayrollComponent.vue').default,
        meta : {
            admins : false,
        }
    },
    { 
        path: '/scholar_notification', 
        component: require('./components/scholar_pages/Notification/ScholarNotificationComponent.vue').default,
        meta : {
            admins : false,
        }
    },
    { 
        path: '/scholar_announcement', 
        component: require('./components/scholar_pages/Announcement/AnnouncementComponent.vue').default,
        meta : {
            admins : false,
        }
    },
    { 
        path: '/api_sample', 
        component: require('./components/pages/APISampleComponent.vue').default,
        meta : {
            admins : true,
        }
    },
]