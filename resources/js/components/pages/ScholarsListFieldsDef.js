var moment = require('moment');
export default [ 
    // {
    //     name: 'detailRowIndicator',
    //     title: '',
    //     width: "1%",
    // },
    {
      name : "type_id",
      title: 'Type',
      titleClass: 'center aligned',
      dataClass: 'center aligned uppercase',
    },
    {
      name      : "scholar_name",
      title     : 'Scholar Name',
    },
    {
      name : "username",
      title: 'Username',
      titleClass: 'center aligned',
      dataClass: 'center aligned',
    },
    {
      name : "status",
      title: 'Status',
      titleClass: 'center aligned',
      dataClass: 'center aligned',
      formatter: value => {
            if(value == 'Active')
                return '<span class="text-primary text-bold">'+value+'</span>';
            else if(value == 'Inctive')
                return '<span class="text-info text-bold">'+value+'</span>';
            else if(value == 'Deleted')
                return '<span class="text-danger text-bold">'+value+'</span>';        
      }
    },
    {
      name : "date_started",
      title: 'Date Started',
      titleClass: 'center aligned',
      dataClass: 'center aligned',
      formatter: value => {
        return '<span>'+ moment(value).format('MMM D, YYYY') +'</span>';
        }
    },
    {
      name      : "action",
      title     : "Action",
      titleClass: "text-center aligned",
      dataClass : "text-center aligned",
    },
  ];
  