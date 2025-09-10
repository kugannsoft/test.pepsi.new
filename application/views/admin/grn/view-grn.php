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
            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="pull-right">
                            <button type="button" id="btnPrint" class="btn btn-primary btn-lg btn-block">Print</button>
                        </div>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row" id="printArea" align="center" style='margin:5px;'>
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><?php if ($grn_hed->GRN_No == 0) {
                                                    echo '<label class="label label-success">Active</label>';
                                                } else {
                                                    if ($grn_hed->GRN_No == 1) {
                                                        echo '<label class="label label-danger">Canceled</label>';
                                                    }
                                                } ?></td>
                                        </tr>
                                        <tr>
                                            <td>GRN No</td>
                                            <td>:</td>
                                            <td class="text-right" id="totalAmount"><?php echo $grn_hed->GRN_No; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td class="text-right" id="totalDis"><?php echo $grn_hed->GRN_Date; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Supplier</td>
                                            <td>:</td>
                                            <td class="text-right" id="totalNet"><?php echo $grn_hed->SupName; ?></td>
                                        </tr>

                                    </table>

                                </div>
                                <div class="col-md-4">
                                    <table class="table">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"></td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount</td>
                                            <td>:</td>
                                            <td class="text-right"
                                                id="totalAmount"><?php echo number_format($grn_hed->GRN_Amount,
                                                    2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Discount</td>
                                            <td>:</td>
                                            <td class="text-right"
                                                id="totalDis"><?php echo number_format($grn_hed->GRN_DisAmount,
                                                    2); ?></td>
                                        </tr>

                                        <tr>
                                            <td>Additional Charges</td>
                                            <td>:</td>
                                            <td class="text-right"
                                                id="totalDis"><?php echo number_format($grn_hed->GRN_AdditionalCharges,
                                                    2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Net Amount</td>
                                            <td>:</td>
                                            <td class="text-right"
                                                id="totalNet"><?php echo number_format($grn_hed->GRN_NetAmount + $grn_hed->GRN_AdditionalCharges,
                                                    2); ?></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="tbl_payment" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>

                                        <th>Total Quantity</th>
                                        <th>Free Qty</th>
                                        <th>Cost Price</th>
                                        <th>Selling Price</th>
                                        <th>Discount</th>
                                        <th class="text-right">Total Net Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach ($grn AS $grndata) { ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $grndata->GRN_Product ?></td>
                                            <td><?php echo $grndata->Prd_Description ?></td>

                                            <td class="text-right"><?php echo number_format($grndata->GRN_Qty,
                                                    2) ?></td>
                                            <td class="text-right"><?php echo number_format($grndata->GRN_FreeQty,
                                                    2) ?></td>
                                            <td class="text-right"><?php echo number_format($grndata->GRN_UnitCost,
                                                    2) ?></td>
                                            <td class="text-right"><?php echo number_format($grndata->GRN_Selling,
                                                    2) ?></td>
                                            <td class="text-right"><?php echo number_format($grndata->GRN_DisAmount,
                                                    2) ?></td>
                                            <td class="text-right"><?php echo number_format($grndata->GRN_NetAmount,
                                                    2) ?></td>
                                        </tr>
                                        <?php $i++;
                                    } ?>
                                    </tbody>
                                    <thead>
                                    <tr>

                                        <th colspan="8" class="text-right">Total</th>
                                        <th class="text-right"><?php echo number_format($grn_hed->GRN_NetAmount,
                                                2); ?></th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
    <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="cusModal">
                <!-- load data -->
            </div>
        </div>
    </div>

    

</div>
<style>
    .shop-items:hover{
        background-color: #00ca6d;
        color: #fff;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnPrint").click(function () {
            console.log('asas');
            $('#printArea').focus().print();
        });
    });
</script>