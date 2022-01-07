var moment = require('moment');
export default [ 
    // {
    //     name: 'detailRowIndicator',
    //     title: '',
    //     width: "1%",
    // },
    {
      name      : "type",
      title     : 'Type',
      titleClass: 'center aligned',
      dataClass : 'center aligned uppercase',
      sortField: "type",
    },
    {
      name : "scholar_name_field",
      title: 'Scholar Name',
      sortField: "scholar_name",
    },
    {
      name : "account_name",
      title: 'Axie Account',
      titleClass: 'center aligned',
      dataClass : 'center aligned',
      sortField: "account_name",
    },
    {
      name      : "username",
      title     : 'Username',
      titleClass: 'center aligned',
      dataClass : 'center aligned',
    },
    {
      name      : "ronin_wallet",
      title     : 'Ronin Wallet',      
    },
    {
      name      : "status",
      title     : 'Status',
      titleClass: 'center aligned',
      dataClass : 'center aligned',
      sortField: "status",
      formatter : value => {
        if(value.trim().toUpperCase() == 'PLAYING')
            return '<span class="text-primary text-bold">'+value.trim().toUpperCase()+'</span>';
        else if(value.trim().toUpperCase() == 'RESIGNED')
            return '<span class="text-info text-bold">'+value.trim().toUpperCase()+'</span>';
        else if(value.trim().toUpperCase() == 'NO AXIE')
            return '<span class="text-warning text-bold">'+value.trim().toUpperCase()+'</span>';
        else if(value.trim().toUpperCase() == 'TERMINATED')
            return '<span class="text-danger text-bold">'+value.trim().toUpperCase()+'</span>';
          else if(value.trim().toUpperCase() == 'DELIVERED')
            return '<span class="text-success text-bold">'+value.trim().toUpperCase()+'</span>';
        else
            return '<span class="text-default text-bold">'+value.trim().toUpperCase()+'</span>';
      }
    },
    {
      name      : "date_started",
      title     : 'Date Started',
      titleClass: 'center aligned',
      dataClass : 'center aligned',
      sortField: "date_started",
      formatter : value => {
        return '<span>'+ moment(value).format('MMM D, YYYY') +'</span>';
        }
    },
    {
      name      : "action",
      title     : "Action",
      titleClass: "text-center aligned",
      dataClass : "text-center aligned",
      width     : '15%',
    },
  ];
  