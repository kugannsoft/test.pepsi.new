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
            <div class="col-sm-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" id="controls">
                                    <label for="customer" class="col-sm-5 control-label">Enter Serial No <span class="required">*</span></label>
                                    <div class="col-sm-7 input-group">
                                        <input type="text" autofocus class="form-control input-lg" required="required"  name="search_product" id="search_product" style="font-size:25px" placeholder="Enter Serial/IMEI">
                                        <span class="input-group-btn"><button class="btn btn-primary btn-lg" id="srClear"><i class="fa fa-recycle"></i></button></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!--<label for="invDate" class="col-sm-5 control-label">Cancel Date <span class="required">*</span></label>-->
                                    <div class="col-sm-6">
                                        <!--<input type="text" class="form-control" required="required"  name="invDate" id="invDate" value="<?php echo date('Y-m-d')?>" placeholder="">-->
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                    </div>
                                </div>
                                <table class="table">
                                    <tr><td colspan="3" id="result"><span></span></td></tr>
                                    <tr><td>Stock</td><td>:</td><td class="text-left" id="stock"></td></tr>
                                    <tr><td>Model</td><td>:</td><td class="text-left" id="model"></td></tr>
                                    <tr><td>Product Code</td><td>:</td><td class="text-left" id="productCode"></td></tr>
                                    <tr><td>Serial</td><td>:</td><td class="text-left"  id="serial"></td></tr>
                                    <?php if (in_array("SM135", $blockView) || $blockView == null) { ?>
                                <tr><td>Cost Price</td><td>:</td><td class="text-left"  id="costPrice"></td></tr> 
                                <?php } ?>
                                <tr><td>Selling Price</td><td>:</td><td class="text-left"  id="sellingPrice"></td></tr> 
                                 <tr><td>Location</td><td>:</td><td class="text-left"  id="shop"></td></tr>
                                 <tr><td>supplier</td><td>:</td><td class="text-left"  id="sup"></td></tr>
                                </table>
                                 <table class="table" id="tblTrans">
                                     <tr><td colspan="3"><span><b>Transfer Details</b></span></td></tr>
                                    <tr><td>Transfer No</td><td>:</td><td class="text-left" id="trnsNo"></td></tr>
                                    <tr><td>Transfer Out Date</td><td>:</td><td class="text-left" id="trnsDate"></td></tr>
                                    <tr><td>From Location</td><td>:</td><td class="text-left"  id="fromShop"></td></tr>
                                    <tr><td>To Location</td><td>:</td><td class="text-left"  id="toShop"></td></tr>
                                <tr><td>Transfer In Date</td><td>:</td><td class="text-left"  id="trnsInDate"></td></tr> 
                                <tr><td>Status</td><td>:</td><td class="text-left"  id="trnsStat"></td></tr> <!--
                                 <tr><td>Inv Amount</td><td>:</td><td class="text-left"  id="invAmount"></td></tr>
                                 <tr><td>Discount</td><td>:</td><td class="text-left"  id="discount"></td></tr>
                                 <tr><td>Net Amount</td><td>:</td><td class="text-left" id="invNet"></td></tr>
                                 <tr><td>Customer Payment</td><td>:</td><td class="text-left"  id="cusPay"></td></tr>-->
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <table class="table"  id="tblGrn">
                                    <tr><td colspan="3"><span><b>GRN Details</b></span></td></tr>
                                    <tr><td>GRN No</td><td>:</td><td class="text-left" id="grnNo"></td></tr>
                                    <tr><td>GRN Date</td><td>:</td><td class="text-left" id="grnDate"></td></tr>
<!--                                    <tr><td>Product Code</td><td>:</td><td class="text-left" id="productCode"></td></tr>
                                    <tr><td>Serial</td><td>:</td><td class="text-left"  id="serial"></td></tr>
                                <tr><td>Cost Price</td><td>:</td><td class="text-left"  id="costPrice"></td></tr> 
                                <tr><td>Selling Price</td><td>:</td><td class="text-left"  id="sellingPrice"></td></tr> 
                                 <tr><td>Location</td><td>:</td><td class="text-left"  id="shop"></td></tr>
                                 <tr><td>supplier</td><td>:</td><td class="text-left"  id="sup"></td></tr>-->
                                </table>
                                <table class="table" id="tblSale">
                                    <tr><td colspan="3"><span>Sale Details</span></td></tr>
                                    <tr><td>Invoice No</td><td>:</td><td class="text-left" id="invNo"></td></tr>
                                    <tr><td>Invoice Date</td><td>:</td><td class="text-left" id="invDate"></td></tr>
                                    <tr><td>Location</td><td>:</td><td class="text-left"  id="invShop"></td></tr>
                                    <?php if (in_array("SM135", $blockView) || $blockView == null) { ?>
                                <tr><td>Cost Price</td><td>:</td><td class="text-left"  id="invCostPrice"></td></tr> 
                                <?php } ?>
                                <tr><td>Selling Price</td><td>:</td><td class="text-left"  id="invSellingPrice"></td></tr> 
                                 <tr><td>Inv Amount</td><td>:</td><td class="text-left"  id="invAmount"></td></tr>
                                 <tr><td>Discount</td><td>:</td><td class="text-left"  id="discount"></td></tr>
                                 <tr><td>Net Amount</td><td>:</td><td class="text-left" id="invNet"></td></tr>
                                 <tr><td>Customer Payment</td><td>:</td><td class="text-left"  id="cusPay"></td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                               <span ></span>
                            </div>
                            <div class="col-lg-8">
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
<!--                            <table id="tbl_payment" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Serial No</th>
                                        <th>Total Quantity</th>
                                        <th >Free Qty</th>
                                        <th>Selling Price</th>
                                        <th>Discount</th>
                                        <th  class="text-right">Total Net Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>-->
                        </div>
                        <!--<span id="lastTranaction">Last Cancel Invoice : </span>-->
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
