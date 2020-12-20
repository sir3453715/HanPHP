function format ( d ) {
    return '<td colspan="1" class="vat" style="border-right:1px solid #ddd;"></td>'+
            '<td colspan="9">'+
                '<table class="table table-bordered">'+
                    '<tbody class="c-gray">'+
                        '<tr class="danger">'+
                            '<th class="text-center">名稱</th>'+
                            '<th class="text-center">宅配單號</th>'+
                        '</tr>'+
                        '<tr>'+
                            '<td class="text-center">贈送</td>'+
                            '<td class="text-center">'+d.for_name+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td class="text-center">贈送</td>'+
                            '<td class="text-center">'+d.for_name+'</td>'+
                        '</tr>'+
                    '</tbody>'+
                '</table>'+
            '</td>';
}
$(document).ready(function() {

    var opt = {
        fixedHeader: true,
        processing: true,
        searching: true,
        // serverSide: true,
        deferRender: true,
        ajax: {
            url: 'orders.php?func=list',
            data: function (d) {
                var info = $('#myTable').DataTable().page.info();
                // d.pageNo = info.page;
                // var xh = $('#xsjb_xh').val();
                // d.extraSerach=xh;
            }
        },
        createdRow: function (row, data, index) {
            $(row).addClass("text-center");//置中
        },
        // dom: '<l<t>ip>',
        columns: [{
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {
                // data: 'addtime'
                "data": 'addtime',
                "orderable": false,
                "render": function(data,type,row,meta){
                    return data = '<div class="details-control"></div>'+ data;
                }
            },
            {
                data: 'seccode'
            },
            {
                data: 'for_name'
            },
            {
                data: 'payment'
            },
            {
                data: 'pay_state',
                render: function (data, type, row) {
                    if(data==0){
                        return '<span class="label label-default">未付款</span>';
                    }else if(data==1){
                        return '<span class="label label-success">付款成功</span>';
                    }else if(data==2){
                        return '<span class="label label-default">付款失敗</span>';
                    }else if(data==3){
                        return '<span class="label label-default">取消付款</span>';
                    }
                },
            },
            {
                data: 'state',
                render: function (data, type, row) {
                    if (data == 0){
                        return '<span class="label label-danger">處理中</span>';
                    }else if (data == 1){
                        return '<span class="label label-warning">備貨中</span>';
                    }else if (data == 2){
                        return '<span class="label label-primary">已出貨</span>';
                    }else if (data == 3){
                        return '<span class="label label-success">訂單完成</span>';
                    }else if (data == 4){
                        return '<span class="label label-default">訂單取消</span>';
                    }
                },
            },
            {
                data: 'total'
            },
            {
                render: function (data, type, row) {
                    var output = '';
                    if(row.payment=='匯款' && row.pay_state==0){
                            output += '<div class="btn-group btn-group-xs">'+
                                '<a href="print_reconciliation.php?sn=' + row.sn + '" target="_blank" title="對帳單">'+
                                        '<button type="button" class="btn btn-default">'+
                                            '<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>'+
                                        '</button>'+
                                '</a>'+
                            '</div>';
                    }
                    if(row.isshipment==1){
                            if(row.total>0){
                                output += '<div class="btn-group btn-group-xs">'+
                                    '<a href="print_shipping.php?sn=' + row.sn + '" target="_blank" title="出貨單">'+
                                        '<button type="button" class="btn btn-default">'+
                                            '<i class="fa fa-cube fa-lg" aria-hidden="true"></i>'+
                                        '</button>'+
                                    '</a>'+
                                '</div>';
                            }
                            output += '<div class="btn-group btn-group-xs">'+
                                '<a href="print_delivery.php?sn=' + row.sn + '" target="_blank" title="宅配單">'+
                                    '<button type="button" class="btn btn-default">'+
                                        '<i class="fa fa-truck fa-lg" aria-hidden="true"></i>'+
                                    '</button>'+
                                '</a>'+
                            '</div>';
                    }
                    return output;
                },
                bSortable: false
            },
            {
                data: 'sn',
                render: function (data, type, row) {
                    return '<td class="text-center">'+
                                '<div class="btn-group btn-group-xs">'+
                                    '<a href="javascript:void(0);" onclick="upd1('+ data +');" title="檢視"><button type="button" class="btn btn-primary">'+
                                        '<span class="fa fa-eye"></span>'+
                                    '</button></a>'+
                                '</div>'+
                            '</td>'
                },
                bSortable: false
            }
        ],
        language: {
            "url": "js/lib/datatables/zh-TW.json"
        }
    };
    var table = $('#myTable').DataTable(opt);
    $('#myTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
    //点击提交按钮重新绘制表格，并将输入框中的值赋予检索框
    // $('#search').click(function () {
    //     var xh = $('#xsjb_xh').val();
    //     var table = $('#myTable').DataTable();
    //     table.search(xh).draw();
    // });
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });
});
$('#example23').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});