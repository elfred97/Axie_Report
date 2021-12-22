var moment = require('moment');
export default [ 
    {
        name: 'detailRowIndicator',
        title: '',
        width: "1%",
        
    },
    {
      name : "type_name",
      title: 'Type',
      titleClass: 'center aligned',
      dataClass: 'center aligned uppercase bold',
      sortField: 'type_name'
      
    },
    {
      name : "qr_code_field",
      title: 'QR Code',
      titleClass: 'center aligned',
      dataClass: 'center aligned',      
      width     : "8%",
      sortField: 'qr_code_field'
    },
    {
      name      : "ronin_address",
      title     : 'Ronin Address',
      dataClass: 'text-content',
      width     : "10%",
      sortField: 'ronin_address'
    },
    {
      name : "account_name",
      title: 'Account Name',
      sortField: 'account_name'
    },
    {
      name : "player_name",
      title: 'Scholar Name',
      sortField: 'player_name'
    },
    {
      name : "penalty",
      title: 'Penalty',
      titleClass: 'center aligned',
      dataClass: 'center aligned',
      sortField: 'penalty',
      formatter: value => {
        let color = 'text-default';
        if(value == 0){
          color = 'text-default';
        }
        else if(value == 1){
          color = 'text-info';
        }
        else if(value == 2){
          color = 'text-warning';
        }
        else{
          color = 'text-danger';
        }
        return '<span class="text-bold ' + color + '">'+value+'</span>';
    }
    },
    {
      name : "scholar_share",
      title: 'Scholar Share',
      titleClass: 'center aligned',
      dataClass: 'center aligned',
    },
    {
      name : "manager_share",
      title: 'Manager Share',
      titleClass: 'center aligned',
      dataClass: 'center aligned',
    },
    // {
    //   name : "market_place_email",
    //   title: 'Market Place',
    //   titleClass: 'center aligned',
    //   dataClass: 'center aligned',
    // },
    // {
    //   name : "password",
    //   title: 'Market Place Password',
    //   titleClass: 'center aligned',
    //   dataClass: 'center aligned',
    // },
    {
      name : "status",
      title: 'Status',
      titleClass: 'center aligned',
      dataClass: 'center aligned uppercase',      
    },    
    {
      name      : "action",
      title     : "Action",
      titleClass: "text-center aligned",
      dataClass : "text-center aligned",
    },
  ];
  