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
                                    <!--<td>Pro. Code</td>-->
                                    <td>Name</td>
                                    <td>Appear Name</td>
                                    <td>Cost Price</td>
                                    <td>Selling Price</td>
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
            "order": [[1, "desc"]],
            "language": {
                "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
            },
            "ajax": {
                "url": "allProducts",
                "type": "POST"
            },
            "columns":
                    [
                        
                        {"data": "Prd_Description"},
                        {"data": "Prd_AppearName"},
                        {"data": "Prd_CostPrice", searchable: false},
                        {"data": "ProductPrice", searchable: false},
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
