export default [ 
    {
      name: "ronin_address",
      title: 'Ronin Address',
    },
    {
      name: "batch",
      title: 'Batch',
      titleClass: "text-center aligned",
      dataClass: "text-center aligned",
    },
    {
        name: "average_per_day",
        title: 'Average SLP / Day',
    },
    {
        name: "penalty",
        title: 'Penalty',
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
        name: "last_claim_days",
        title: 'Last Claim Days',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },    {
        name: "last_claim_date",
        title: 'Last Claim Date',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        formatter: value => {            
            return '<span>'+ moment(value).format('MMM D, YYYY') +'</span>';
        }
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
        name: "mmr_field",
        title: 'MMR',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
    {
        name: "rank",
        title: 'Rank',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    },
  ];
  