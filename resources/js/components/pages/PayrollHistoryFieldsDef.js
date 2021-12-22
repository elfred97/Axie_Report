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
        sortField: "account_name",
    },
    {
        name: "ronin_address",
        title: 'Ronin Address',
        dataClass: 'text-content',
        width     : "25%",
        sortField: "ronin_address",
    },
    {
        name: "total_slp",
        title: 'Total SLP',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        sortField: "total_slp",
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
        sortField: "type_name",
    },
    {
        name: "created_at",
        title: 'Date',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        sortField: "created_at",
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
  