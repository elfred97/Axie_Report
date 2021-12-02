export default [ 
    
    {
        name: "description",
        title: 'Description',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned uppercase",
    },
    {
        name: "type_id",
        title: 'Type',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned uppercase",
    },
    {
        name: "date",
        title: 'Date',
        titleClass: "text-center aligned",
        dataClass: "text-center aligned",        
        formatter: value => {            
            return '<span>'+ moment(value).format('MMM D, YYYY') +'</span>';
        }
    },
  ];
  