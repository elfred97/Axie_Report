var moment = require('moment');
export default [
  {
    name: "account_name",
    title: 'Account Name',
    sortField: "account_name",
  },
  {
    name: "player_name",
    title: 'Scholar Name',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
    sortField: "player_name",
  },
  {
    name: "category",
    title: 'Category',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
    formatter: value => {
        if(value == 1)
            return '<span>SLP per day penalty</span>';
        else if(value == 2)
            return '<span>MMR penalty</span>';
        else if(value == 3)
            return '<span>Scholar terminated</span>'
    },
    sortField: "category",
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
    name: "status",
    title: 'Status',
    titleClass: 'center aligned',
    dataClass: 'center aligned',
    formatter: value => {
        if(value == 1)
            return '<span>Active</span>';
        else if(value == 2)
            return '<span>Inactive</span>';
    },
    sortField: "status",
  },
  ];
  