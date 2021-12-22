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
        sortField: "type_name",
    },
    {
      name: "account_name",
      title: 'Account Name',
      sortField: "account_name",
    },
    {
        name: "player_name",
        title: 'Scholar Name',
        sortField: "player_name",
    },
    {
        name: "penalty",
        title: 'Penalty',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        sortField: "penalty",
    },
    {
        name: "mmr_field",
        title: 'MMR',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        sortField: "mmr_field",
    },
    {
        name: "gained_slp_today",
        title: '1 Day SLP',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        sortField: "gained_slp_today",
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
        name: "average_per_day",
        title: 'Ave Per Day',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        sortField: "average_per_day",
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
        sortField: "total_slp",
    },
    {
      name: "last_claim_date",
      title: "Last Claim Date",
      titleClass: "text-center aligned",
      dataClass: "text-center aligned",
    },
  ];
  