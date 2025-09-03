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
                    <div class="box-body">
                        <?php if (in_array("M6", $blockAdd) || $blockAdd == null) { ?>
                            <b><span class="alert alert-success pull-left" id="lastProduct"></span></b>
                            <button onclick="addp()" class="btn btn-flat btn-primary pull-right">Add Product</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box" id="catDiv">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="producttbl">
                            <thead>
                                <tr>
                                    <td>Pro. Code</td>
                                    <td>Name</td>
                                    <td>Appear Name</td>
                                    <?php if (in_array("SM135", $blockView) || $blockView == null) { ?>
                                    <td>Cost Price</td>
                                    <?php } ?>
                                    <td>Set Prices</td>
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
    <!--add department modal-->
    <div id="productmodal" class="modal fade bs-add-category-modal-lg"  role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" style="width: 95%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var producttbl = $('#producttbl').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [[0, "desc"]],
            "language": {
                "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
            },
            "ajax": {
                "url": "allProducts",
                "type": "POST"
            },
            "columns":
                    [
                        {"data": "ProductCode"},
                        {"data": "Prd_Description"},
                        {"data": "Prd_AppearName"},
                        <?php if (in_array("SM135", $blockView) || $blockView == null) { ?>
                        {"data": "Prd_CostPrice", searchable: false},
                        <?php } ?>
                        {"data": "Prd_SetAPrice", searchable: false},
                        {
                            <?php if (in_array("M6", $blockEdit) || $blockEdit == null) { ?>
                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<button onclick="editp(\'' + row.ProductCode + '\')" class="btn btn-xs btn-default" >Edit</button>';
                            }
                            <?PHP  } else {?>
                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<button onclick="editp(\'' + row.ProductCode + '\')" class="btn btn-xs btn-default" disabled>Edit</button>';
                            }
                            <?php }?>
                        },
                        {
                            "data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                if (row.Prd_IsActive == 1) {
                                    return '<span class="label label-xs label-success" >Active</span>';
                                } else if (row.Prd_IsActive == 0) {
                                    return '<span class="label label-xs label-danger" >Inactive</span>';
                                }

                            }
                        }
                    ]
        });
    });
    function addp() {
        $('.modal-content').load('<?php echo base_url() ?>admin/product/loadmodal_addproduct/', function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
    function editp(id) {
        console.log(id);
        $('.modal-content').load('<?php echo base_url() ?>admin/product/loadmodal_editproduct/', {id: id}, function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
</script>


