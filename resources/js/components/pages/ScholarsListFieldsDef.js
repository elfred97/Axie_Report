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
    },
    {
      name : "scholar_name",
      title: 'Scholar Name',
    },
    {
      name : "account_name",
      title: 'Axie Account',
      titleClass: 'center aligned',
      dataClass : 'center aligned',
    },
    {
      name      : "username",
      title     : 'Username',
      titleClass: 'center aligned',
      dataClass : 'center aligned',
    },
    {
      name      : "status",
      title     : 'Status',
      titleClass: 'center aligned',
      dataClass : 'center aligned uppercase',
      formatter : value => {
        if(value == 'Playing')
            return '<span class="text-primary text-bold">'+value+'</span>';
        else if(value == 'Resigned')
            return '<span class="text-info text-bold">'+value+'</span>';
        else if(value == 'No Axie')
            return '<span class="text-warning text-bold">'+value+'</span>';
        else if(value == 'Terminated')
            return '<span class="text-danger text-bold">'+value+'</span>';        
        else
            return '<span class="text-default text-bold">'+value+'</span>';
      }
    },
    {
      name      : "date_started",
      title     : 'Date Started',
      titleClass: 'center aligned',
      dataClass : 'center aligned',
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
  