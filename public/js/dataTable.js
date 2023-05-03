function create_datatable(element_id, url ='', cols, rowCallback = null){
    if (rowCallback == null){
        rowCallback = function(){

        }
    }
    return table = $(`#${element_id}`).DataTable({
        dom: 'Bfrtip',
        order: [[0, 'desc']],
        ajax: {
            url: url,
        },
        columns: cols,
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],
        "displayLength": 25,
        language: {
            url: '../resources/lang/fa.json' 
        },
        "rowCallback": rowCallback
    });
    
}

function dblclick_on_inbox_row(element_id,  table, callback){
    $(`#${element_id} tbody`).on('dblclick', 'tr', callback );
}

function click_on_row(){
    table.on('click', 'tr', function(){
        return data = table.row( this ).data();
    })
}

function refresh_table(){
    table.ajax.reload( null, false);
}

function update_datatable(data){
    table.clear();
    table.rows.add(data);
    table.draw();
}