export default [ 
    {
        name: 'detailRowIndicator',
        title: '',
        width: "1%",
    },
    {
        name: "type_name",
        title: 'type',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned uppercase",
    },
    {
      name: "account_name",
      title: 'Account Name',
    },
    {
        name: "player_name",
        title: 'Scholar Name',
    },
    {
        name: "penalty",
        title: 'Penalty',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "mmr_field",
        title: 'MMR',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "gained_slp_today",
        title: '1 Day SLP',
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
        name: "average_per_day",
        title: 'Ave Per Day',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "unclaimed",
        title: 'Unclaimed',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "claimed",
        title: 'Claimed',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "total_slp",
        title: 'Total SLP',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
      name: "last_claim_date",
      title: "Last Claim Date",
      titleClass: "text-center aligned",
      dataClass: "text-center aligned",
    },
  ];
  