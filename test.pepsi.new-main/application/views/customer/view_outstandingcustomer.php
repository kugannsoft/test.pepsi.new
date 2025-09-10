<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper"> 
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <!--div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <button onclick="addm()" class="btn btn-flat btn-primary pull-right">Create Customer</button>
                    </div>
                </div>
            </div>
        </div-->

        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-3">
               
                <select id="filter_salesperson" class="form-control">
                    <option value="">-- All Salespersons --</option>
                    <?php foreach ($salespersons as $sp) { ?>
                        <option value="<?= $sp->RepID ?>"><?= $sp->RepName ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                    <select class="form-control" name="route" id="route" multiple>
                        <option value="">--Select Route--</option>
                                      
                    </select>
                <input type="hidden" name="route_ar" id="route_ar">
            </div>
             <div class="col-md-2">
                <select class="form-control" name="customer" id="customer" >
                                        
                </select>
                                    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="customertbl">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Name</td>
                                    <td></td>
                                    <td>Phone</td>
                                    <!-- <td>Credit Limit</td> -->
                                    <td>Outstanding</td>
                                    <td>Route</td>
                                    <td>###</td>
                                    <td>###</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
            <!-- load data -->
        </div>
    </div>
</div>

<script>
    
    var customertbl = $('#customertbl').DataTable({
       "processing": true,
            "serverSide": true,
            "order": [[1, "desc"]],
            "language": {
                "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
            },
            "ajax": {
                "url": "allCustomersjoin",
                "type": "POST",
                 "data": function(d) {
                    d.salesperson = $('#filter_salesperson').val();
                    d.route = $('#route_ar').val();
                    d.customer =$('#customer').val();
                }
            },
            "columns":
                    [
                        {
                            <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '" >' + row.CusCode + '</a>';
                            }
                            <?PHP  } else {?>

                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return row.CusCode;
                            }
                            <?php }?>
                        },
                        {"data": "CusCode","visible": false,"searchable": true},


                        {
                            <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '" >' + row.CusName + '</a>';
                            }
                            <?PHP  } else {?>

                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return row.CusName;
                            }
                            <?php }?>
                        },
                        {"data": "CusName","visible": false,"searchable": true},
                        {"data": "CusBookNo", searchable: false},
                        {"data": "MobileNo", searchable: true},
                     
                        {"data": "Outstanding", searchable: false},
                         {"data": "name", searchable: true},
                        {"data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                if(row.IsActive==1){
                                    return '<span class="label label-xs label-success" >Active</span>';
                                }else if (row.IsActive==0) {
                                    return '<span class="label label-xs label-danger" >Inactive</span>';
                                }
                                
                            }
                        },
                        {
                            <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '"  class="btn btn-xs btn-default" >View</a>';
                            }
                            <?PHP  } else {?>
                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '"  class="btn btn-xs btn-default" disabled>View</a>';
                            }
                            <?php }?>
                        }
                    ]
    });


        $('#filter_salesperson').on('change', function () {
                customertbl.ajax.reload();
            });

      $('#customer').on('change', function () {
                customertbl.ajax.reload();
            });
            
          $('#filter_salesperson').on('change', function() {
        
             var salespersonID = $(this).val();
             if (salespersonID != "0") {
    
                 $.ajax({
                    
                     url:  "findemploeeroute",
                     method: 'POST',
                     data: { salespersonID: salespersonID },
                     dataType: 'json',
                     success: function(response) {
    
                         $('#route').empty();
                         $('#route').append('<option value="0">-Select-</option>');   url: "../Admin/Controller/Product.php",
    
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


    $("#route").select2({
        placeholder: "Select a Route"
    });

    var loc = [];
    $("#route").change(function() {
        loc.length = 0;

        $("#route :selected").each(function() {
            loc.push($(this).val());
        });
        $("#route_ar").val(JSON.stringify(loc));
        customertbl.ajax.reload();
    });


     $('#route').on('change', function() {
   
        var routeID = $(this).val();
        var newsalesperson = $('#filter_salesperson').val();
        
        $.ajax({
            url: baseUrl + '/job/loadcustomersroutewise',
            type: 'POST',
            dataType: "json",
            data: {
                routeID: routeID,
                newsalesperson:newsalesperson
            },
            success: function(data) {
                console.log("Customer Data:", data);
                $("#customer").html('<option value="">Select Customer</option>');

               
                if (data.length > 0) {
                    $.each(data, function(index, customer) {
                        $("#customer").append(
                            `<option value="${customer.CusCode}">${customer.DisplayName}</option>`
                        );
                    });
                }

                $('#customer').select2({
                    placeholder: "Select a customer",
                    allowClear: true,
                    width: '100%'
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error); 
            }
        });
    });


</script>