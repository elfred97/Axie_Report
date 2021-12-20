export default [ 
    {
        name: "player_name",
        title: 'Scholar Name',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned uppercase",
    },
    {
        name: "account_name",
        title: 'Account Name',
        width     : "10%",
    },
    {
        name: "ronin_address",
        title: 'Ronin Address',
        dataClass: 'text-content',
        width     : "25%",
    },
    {
        name: "total_slp",
        title: 'Total SLP',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "txn_id",
        title: 'TXN ID',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned text-content",        
        width     : "20%",
    },
    {
        name: "type_name",
        title: 'Type',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "created_at",
        title: 'Date',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",        
        formatter: value => {            
            return '<span>'+ moment(value).format('MMM D, YYYY') +'</span>';
        }
    },
    {
      name: "actions",
      title: "Actions",
      titleClass: "text-center aligned",
      dataClass: "text-center aligned",
    },
  ];
  