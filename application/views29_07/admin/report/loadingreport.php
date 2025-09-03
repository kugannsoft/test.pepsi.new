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
                                <div class="col-md-4">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" name="startdate" value="<?php echo date("Y-m-d") ?>"/>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control" name="enddate"  id="enddate" value="<?php echo date("Y-m-d") ?>"/>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-flat btn-success">Show</button>
                                </div>
                            </form>
                            <div class="col-md-2">
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
                                <td>Product Code</td>
                                <td>Product Name</td>
                                <td>Qty</td>
                                <td>free qty</td>
                                <td>Return Qty</td>

                                <td> Total Qty Amount</td>

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
   

    $('#filterform').submit(function (e) {
        e.preventDefault();
     
        $.ajax({
            type: 'POST',
            url: "loadloadingreport",
            data: $(this).serialize(),
            success: function(response) {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                    console.log(response);
                    let data = response.data;
                    if (Array.isArray(data)) {
                        $('#saletable tbody').empty();
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                $('#saletable tbody').append(`
                                    <tr>
                                        <td>${item.SalesProductCode}</td>
                                        <td>${item.SalesProductName}</td>
                                        <td>${item.TotalSalesQty}</td>
                                        <td>${item.TotalSalesFreeQty}</td>
                                         <td>${item.SalesReturnQty}</td>

                                        <td>${(item.Prd_CostPrice * item.TotalSalesQty).toFixed(2)}</td>


                                    </tr>
                                `);
                            })
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