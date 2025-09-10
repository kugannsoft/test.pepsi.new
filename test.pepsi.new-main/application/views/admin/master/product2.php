<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    
    <section class="content">
        <div class="box collapse cart-options" id="collapseExample">
            <div class="box-header">Filter Categories</div>
            <div class="box-body categories_dom_wrapper">
            </div>
            <div class="box-footer">
                <button class="btn btn-primary close-item-options pull-right">Hide options</button>
            </div>
        </div>   
        <div class="row">
            <div class="box col-lg-12" id="catDiv">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="producttbl">
                            <thead>
                                <tr>
                                    <td>Pro. Code</td>
                                    <td>Name</td>
                                    <td>Appear Name</td>
                                    <td>Cost Price</td>
                                    <td>Set Price</td>
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
        </div>

        <!--add department modal-->
        <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- load data -->
                </div>
            </div>
        </div>
    </section>
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
                    {"data": "Prd_CostPrice",searchable: false},
                    {"data": "Prd_SetAPrice",searchable: false},
                    {"data":  null, orderable: false, searchable: false,
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-xs btn-default" >Edit</button>';
                        }
                    }
                ]
    });


    });
</script>
