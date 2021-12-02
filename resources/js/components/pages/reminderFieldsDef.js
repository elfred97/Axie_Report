export default [     
    {
        name: "title",
        title: 'Title',
    },
    {
        name: "description",
        title: 'Description',
    },
    {
        name: "reminder_time",
        title: 'Date & Time',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned uppercase",
        formatter: value => {            
            return '<span>'+ moment(value).format('MMM D, YYYY hh:mm:ss A') +'</span>';
        }
    },
    {
        name: "recurrence",
        title: 'Repeat',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        formatter: value => {
            if(value == 0)
                return 'Never';
            else if(value == 1)
                return 'Monthly';
            else if(value == 2)
                return 'Weekly';
            else if(value == 3)
                return 'Daily';
        }
    },
    {
        name: "type_name",
        title: 'Type',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned uppercase",
    },
    {
        name: "status",
        title: 'Status',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
        formatter: value => {
            if(value == 0)
                return 'Active';
            else if(value == 1)
                return 'Inactive';
            
        }
    },
    {
        name: "actions",
        title: "Action",
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",
    }
  ];
  