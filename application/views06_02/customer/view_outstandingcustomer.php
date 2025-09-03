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
                                    <td>No</td>
                                    <td>Phone</td>
                                    <td>Credit Limit</td>
                                    <td>Outstanding</td>
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
    var customertbl = $('#customertbl').dataTable({
       "processing": true,
            "serverSide": true,
            "order": [[1, "desc"]],
            "language": {
                "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
            },
            "ajax": {
                "url": "allCustomersjoin",
                "type": "POST"
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
                        {"data": "MobileNo", searchable: false},
                        {"data": "CreditLimit", searchable: false},
                        {"data": "Outstanding", searchable: false},
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
</script>