var moment = require('moment');
export default [ 
  {
    name: 'detailRowIndicator',
    title: '',
    width: "1%",
  },
  {
    name: "type",
    title: 'Type',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
    
  },
  {
    name: "ronin_address",
    title: 'Ronin Address',
    sortField: 'ronin_address',
  },
  {
    name: "account_name",
    title: 'Account Name',
  },
  {
    name: "player_name",
    title: 'Scholar Name',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
  },
  {
    name: "gained_slp_today",
    title: '1 Day SLP',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
  },
  
  {
    name: "created_at",
    title: 'Date',
    sortField: 'created_at',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
    formatter: value => {            
        return '<span>'+ moment(value).format('MMM D, YYYY') +'</span>';
    }
  },
  {
    name: "average_per_day",
    title: 'Average per day',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
    sortField: 'average_per_day',
  },
  {
    name: "unclaimed",
    title: 'Unclaimed',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
  },
  {
    name: "claimed",
    title: 'Claimed',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
  },
  {
    name: "total_slp",
    title: 'Total SLP',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
  },
  {
    name: "mmr_field",
    title: 'MMR',
    titleClass: 'center aligned',
    dataClass: 'center aligned',    
  },
  {
    name: "rank",
    title: 'Rank',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
  },
  // {
  //   name: "last_claim",
  //   title: 'Last Claim Date',
  //   titleClass: 'center aligned',
  //   dataClass: 'center aligned',
  // },
  // {
  //   name: "manager_share",
  //   title: 'Manager Share',
  //   titleClass: 'center aligned',
  //   dataClass: 'center aligned',
  // },
  // {
  //   name: "scholar_share",
  //   title: 'Scholar Share',
  //   titleClass: 'center aligned',
  //   dataClass: 'center aligned',
  // },
  // {
  //   name: "action",
  //   title: "Action",
  //   titleClass: "text-center aligned",
  //   dataClass: "text-center aligned",    
  // },
  ];
  