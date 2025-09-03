<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <form id="filterform">
                                <div class="col-md-2">
                                    <select class="form-control" name="newsalesperson" id="newsalesperson" >
                                        <option value="">--Select Salesperson--</option>
                                        <?php foreach ($salespersons AS $salesperson) { ?>
                                            <option value="<?php echo $salesperson->RepID ?>"><?php echo $salesperson->RepName ?></option>
                                        <?php } ?>
                                    </select>
                                    <!-- <input type="hidden" name="route_ar" id="route_ar"> -->
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="route" id="route" >
                                        <option value="">--Select Route--</option>
                                      
                                    </select>
                                    
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="customer" id="customer" >
                                        <option value="">--Select Customer--</option>
                                      
                                    </select>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" name="startdate" value="<?php echo date("Y-m-d") ?>"/>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control" name="enddate"  id="enddate" value="<?php echo date("Y-m-d") ?>"/>
                                    </div>
                                </div>
                                
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-flat btn-success">Show</button>
                                </div>
                            </form>
                            <div class="col-md-1">
                                <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" id="printReport">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body table-responsive">
                        <table id="saletable" class="table table-bordered">
                            <thead>
                            <tr style="background-color: #1fbfb8">
                                <td>Code</td>
                                <td>Discription</td>
                                <td>Unit Cost</td>
                                <td>Unit Price</td>
                                <td>Free Qty</td>
                                <td>Qty</td>
                                <td>Dis Value</td>
                                <td>Total Net Amount</td>
                                <td>Total Coast</td>
                                <td>Profit</td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--print view modal-->
        <div id="salesbydateprint" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- load data -->
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('.input-daterange').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('#newsalesperson').on('change', function() {
        var salespersonID = $(this).val();
        if (salespersonID != "0") {
           
            $.ajax({
                url: "<?php echo base_url(); ?>" + "admin/customer/findemploeeroute",
                method: 'POST',
                data: { salespersonID: salespersonID },
                dataType: 'json',
                success: function(response) {
                    
                    $('#route').empty();
                    $('#route').append('<option value="0">-Select-</option>');
                    
                    $.each(response, function(index, routeID) {
                    console.log(routeID);
                    $('#route').append('<option value="'+ routeID.route_id +'">'+ routeID.route_name +'</option>');
                });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching routes:', error);
                }
            });
        } else {
            $('#route').empty();
            $('#route').append('<option value="0">-Select-</option>');
        }
    });

    $('#route').on('change', function() {
        var routeID = $(this).val();
        if (routeID != "0") {
           
            $.ajax({
                url: "<?php echo base_url(); ?>" + "admin/sales/findroutecustomer",
                method: 'POST',
                data: { routeID: routeID },
                dataType: 'json',
                success: function(response) {
                    
                    $('#customer').empty();
                    $('#customer').append('<option value="0">-Select-</option>');
                    
                    $.each(response, function(index, customers) {
                    console.log(customers);
                    $('#customer').append('<option value="'+ customers.CusCode +'">'+ customers.CusName +'</option>');
                });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching customer:', error);
                }
            });
        } else {
            $('#customer').empty();
            $('#customer').append('<option value="0">-Select-</option>');
        }
    });
   

    $('#filterform').submit(function (e) {
        e.preventDefault();
     
        $.ajax({
            type: 'POST',
            url: "loadinvoicesaleswiseitemreport",
            data: $(this).serialize(),
            success: function(response) {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                    console.log(response);
                   
                    let data = response.data;
                    if (Array.isArray(data)) {
                        $('#saletable tbody').empty();
                        if (data.length > 0) {
                            let currentInvoice = '';
                            let currentDate = '';
                            let customerName = '';
                            let customerCode = "";
                         
                            $.each(data, function(index, item) {
                                if (item.SalesInvNo !== currentInvoice) {
                                    if (currentInvoice !== '') {
                                    $('#saletable tbody').append(`
                                        <tr style="background-color: #d9edf7">
                                            <td colspan="4">Total for Invoice ${currentInvoice}</td>
                                            <td><strong>${totalSalesFreeQty}</strong></td>
                                            <td><strong>${totalSalesQty}</strong></td>
                                            <td><strong>${totalSalesDisValue}</strong></td>
                                              <td><strong>${invtotalNetAmount}</strong></td>
                                              <td><strong>${invtotalCost}</strong></td>
                                              <td><strong>${invprofitAmount}</strong></td>
                                            <td colspan="4"></td>
                                        </tr>
                                    `);
                                }
                              
                                totalSalesQty = 0;
                                totalSalesFreeQty = 0;
                                totalSalesDisValue =0;
                                invtotalNetAmount =0;
                                invtotalCost =0;
                                invprofitAmount =0;
                                    $('#saletable tbody').append(`
                                    <tr style="background-color: #f2f2f2">
                                        <td colspan="10">
                                            <strong>Invoice No: ${item.SalesInvNo}</strong> - 
                                            <strong>Inv Date: ${item.SalesDate}</strong>-
                                             <strong>Invoice No: ${item.CusCode}</strong> - 
                                            <strong>Inv Date: ${item.DisplayName}</strong>
                                        </td>
                                    </tr>
                                `);
                                
                                currentInvoice = item.SalesInvNo; 
                                currentDate = item.SalesDate;
                                customerName = item.SalesInvNo; 
                                customerCode = item.DisplayName;
                         
                                }
                                let totalNetAmount = (item.SalesQty * item.SalesUnitPrice) - item.SalesDisValue;
                                let totalCost = (item.SalesQty*item.SalesCostPrice);
                                let profitAmount =(totalNetAmount - totalCost);
                                $('#saletable tbody').append(`
                                
                                    <tr>
                                        <td>${item.CusCode}</td>
                                        <td>${item.SalesProductName}</td>
                                        <td>${item.SalesCostPrice}</td>
                                        <td>${item.SalesUnitPrice}</td>
                                        <td>${item.SalesFreeQty}</td>
                                        <td>${item.SalesQty}</td>
                                        <td>${item.SalesDisValue}</td>
                                        <td>${totalNetAmount}</td>
                                        <td>${totalCost.toFixed(2)}</td>
                                        <td>${profitAmount.toFixed(2)}</td>
                                    </tr>
                                `);
                                totalSalesQty += parseFloat(item.SalesQty);
                                totalSalesFreeQty += parseFloat(item.SalesFreeQty);
                                totalSalesDisValue += parseFloat(item.SalesDisValue);
                                invtotalNetAmount += parseFloat(totalNetAmount);
                                invtotalCost += parseFloat(totalCost);
                                invprofitAmount += parseFloat(profitAmount);
                            });

                        }else{
                            $('#saletable tbody').append(`
                                <tr>
                                    <td colspan="3" class="text-center">No data found for the selected date range.</td>
                                </tr>
                            `);
                        }
                    }
                }
              
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
            }
        })
    });

 


    function loadprint() {
        $('.modal-content').load('<?php echo base_url() ?>admin/report/', function (result) {
            $('#salesbydateprint').modal({show: true});
        });
    }
    function printdiv() {
        var datebalance = $("#enddate").val();
        $("#printReport").print({
            prepend:"<h3 style='text-align:center'>Daily Loading Report "+datebalance+"</h3><hr/>",
            title:'Daily Loading Report '+datebalance
        });
    }
    
</script>