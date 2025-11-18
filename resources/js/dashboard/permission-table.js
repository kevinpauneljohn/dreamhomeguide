import Datatables from "datatables.net-bs5";

let table  = new Datatables('#example',{
    ajax: {
        url: '/permissions',
        type: 'GET'
    },
    columns: [
        // {data: 'id',name: 'id'},
        {data: 'name',name: 'name'},
        {data: 'created_at',name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
    ],
    processing: true,
    serverSide: true,
});
// table.on('click', 'tbody tr', function () {
//     let data = table.row(this).data();
//
//     alert('You clicked on ' + data[0] + "'s row");
// });
