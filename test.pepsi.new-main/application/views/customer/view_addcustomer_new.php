<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!--<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>-->
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    tfoot {
        display: table-header-group;
    }
</style>
<div class="content-wrapper" id="app">
    <section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="row">
            <!--            <div class="col-md-12">-->
            <!--                <div class="box">-->
            <!--                    <div class="box-body">-->
            <!--                        --><?php //if (in_array("SM42", $blockAdd) || $blockAdd == null) { ?>
            <!--                            <b><span class="alert alert-success pull-left" id="lastProduct"></span></b>-->
            <!--                        --><?php //} ?>
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
    </section>
    <section class="content">
        <div class="row">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">-->
<!--                SHOW/HIDE COLUMN-->
<!--            </button>-->


            <div class="col-md-12">
                <table id="woonfunctietotaal" class="table table-bordered table-data3" cellspacing="0" width="100%" style="white-space: nowrap;">
                    <thead>
                    <tr style="background-color: #367fa9; color: white">
                        <th>###</th>
                        <th>Name</th>
                        <th>Salesperson</th>
                        <th>Route</th>
                        <th>Phone</th>
                       
                    </tr>
                    </thead>
                    <tbody id="dataBody">
                    </tbody>
                  
                </table>
            </div>

        </div>
    </section>

</div>

<script type="text/javascript">
    $('body').addClass('sidebar-collapse');

    var tab = null;

      $(document).ready(function() {

        $('#job-woonfunctietotaal').DataTable().destroy();
        $('#dataBody').empty();
        createFilters();
        var table = $('#woonfunctietotaal').DataTable( {
            "processing": true,
            "scrollX":        true,
            "scrollCollapse": true,
            "lengthChange": false,
            "ajax": {
                "url": "easypaymentnsummerybydateforsearch",
                "type": "POST"
            },

            "columns": [
                { "data": "AccNo",  render: function (data, type, row) {
                        if (row.AccNo){
                            return '<a href="../EasyPayment/invoicePrint?ac_no=' + row.AccNo + '" class="btn btn-xs btn-primary">View</a>' +
                                ' &nbsp; <a href="../EasyPayment/easyPaymentSettlement?ac_no=' + row.AccNo + '" class="btn btn-xs btn-warning" >Settlement</a>';
                        }
                        return 0;
                    } , "orderable": false},
                { "data": "AccNo" },
                { "data": "CusName" },
                { "data": "name" , render: function (data, type, row) {
                        return row.name;
                    } },
                { "data": "RepName" , render: function (data, type, row) {
                        return row.RepName;
                    } },
                {"sClass": "text-right", "data": "FinalAmount",  render: function (data, type, row) {
                        return  accounting.formatNumber(data);
                    }},
                {"sClass": "text-right", "data": "GrossAmount",  render: function (data, type, row) {
                        return  accounting.formatNumber(data);
                    } },
                {"sClass": "text-right", "data": "InstallAmount",  render: function (data, type, row) {
                        return  accounting.formatNumber(data);
                    }},
                {"sClass": "text-right", "data": "firstPayment",  render: function (data, type, row) {
                        return  accounting.formatNumber(data);
                    }},
                {"sClass": "text-right", "data": "TotalPaid",  render: function (data, type, row) {
                        return  accounting.formatNumber(data);
                    }},
                {"sClass": "text-right", "data": "InstallAmount",  render: function (data, type, row) {
                        if (row.payDtl){
                            if (row.payDtl.dueterm >= 4){
                                return  '<div class="table-data-feature text-danger"><b>' + accounting.formatNumber(data*row.payDtl.dueterm) + '</b></div>';
                            } else if (row.payDtl.dueterm >= 3){
                                return '<div class="table-data-feature text-primary"><b>' + accounting.formatNumber(data*row.payDtl.dueterm) + '</b></div>';
                            } else if (row.payDtl.dueterm >= 1){
                                return '<div class="table-data-feature text-success"><b>' + accounting.formatNumber(data*row.payDtl.dueterm) + '</b></div>';
                            } else if (row.payDtl.dueterm <= 1 && row.payDtl.dueterm > 0) {
                                return '<div class="table-data-feature text-success"><b>' + accounting.formatNumber(data * row.payDtl.dueterm) + '</b></div>';
                            }
                        }
                        return '<div class="table-data-feature text-success"><b>' +  accounting.formatNumber(0.00) + '</b></div>';
                    } },
                {"sClass": "text-right", "data": "TotalDue",  render: function (data, type, row) {
                        return  accounting.formatNumber(data);
                    }},
                { "data" : "Description"},
                {"sClass": "text-right", "data": "Installments",  render: function (data, type, row) {
                        return  accounting.formatNumber(data);
                    }},
                { "data": "InvDate" },
                { "data": "lastDate" }

            ],
            "select": true,

            footerCallback: function (row,data,start,end,display) {
                var api = this.api();
                var totalAmount = api.column(4,{page:'current'}).data().reduce(function ( a, b ) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $(api.column(4).footer()).html(accounting.formatNumber(totalAmount));

                totalAmount = api.column(5,{page:'current'}).data().reduce(function ( a, b ) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $(api.column(5).footer()).html(accounting.formatNumber(totalAmount));

                totalAmount = api.column(6,{page:'current'}).data().reduce(function ( a, b ) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $(api.column(6).footer()).html(accounting.formatNumber(totalAmount));

                totalAmount = api.column(7,{page:'current'}).data().reduce(function ( a, b ) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $(api.column(7).footer()).html(accounting.formatNumber(totalAmount));

                totalAmount = api.column(8,{page:'current'}).data().reduce(function ( a, b ) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $(api.column(8).footer()).html(accounting.formatNumber(totalAmount));

                var dueAmount = data.map(function (value, index) {
                    if (!display.includes(index)){
                        return 0;
                    }
                    if (!value.payDtl){
                        return 0;
                    }
                    return value.InstallAmount*value.payDtl.dueterm;
                });

                totalAmount = dueAmount.reduce(function ( a, b ) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $(api.column(9).footer()).html(accounting.formatNumber(totalAmount));

                totalAmount = api.column(10,{page:'current'}).data().reduce(function ( a, b ) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
                $(api.column(10).footer()).html(accounting.formatNumber(totalAmount));
            },

            searchDelay: 1500,
            "rowCallback": function( row, data ) {

            },
            "preDrawCallback": function( settings ) {
            },
            "order": [[ 1, 'asc' ]],
            orderCellsTop: true,
            fixedHeader: true,
            lengthMenu: [[-1, 10, 25, 100], ["All", 10, 25, 100]],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend : 'colvis',
                    text : '<i class="fa fa-eye"/> / <i class="fa fa-eye-slash"/>',
                    titleAttr : 'Show/Hide columns'
                },
                {
                    extend: 'print',
                    text : '<i class="fa fa-print" />',
                    exportOptions: {
                        columns: ':visible',
                    }
                }
            ],
            columnDefs: [ {
                targets: -2,
                visible: false
            } ],
            "sScrollX": "100%",
            "scrollY": "400px"
        } );

        tab = table;

        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();

            var column = table.column( $(this).attr('data-column') );

            column.visible( ! column.visible() );
        } );
    });
</script>
