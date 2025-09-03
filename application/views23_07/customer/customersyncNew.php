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
                                <td>###</td>
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
            "url": "allSynCustomers",
            "type": "POST"
        },
        "columns": [

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
            {"data": "CusCode", "visible": false, "searchable": true},

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
            {"data": "CusName", "visible": false, "searchable": true},

            {"data": "CusBookNo"},
            {"data": "MobileNo"},
            {"data": "CreditLimit", searchable: false},
            {
                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    if (row.IsActive == 1) {
                        return '<span class="label label-xs label-success" >Active</span>';
                    } else if (row.IsActive == 0) {
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
            },
            {
                <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<button value="' + row.CusCode + '" id="' + row.CusCode + '"  Class="delete btn btn-xs btn-danger">Delete</button> &nbsp;';
                }
                <?PHP  } else {?>
                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<button value="' + row.CusCode + '" id="' + row.CusCode + '"  Class="delete btn btn-xs btn-danger">Delete</button> &nbsp;';
                }
                <?php }?>
            }
        ]
    });

    $(document).on('click', '.delete', function () {
        var id = $(this).attr("id");
        if (confirm("Are you want to Delete Synchronized Customer ?")){
            $.ajax({
                type: "post",
                url: "../Customer/cancel_syn_customer",
                data: {id: id},
                success: function (json) {
                    location.reload();
                }
            });
        }else {

        }
    });

</script>