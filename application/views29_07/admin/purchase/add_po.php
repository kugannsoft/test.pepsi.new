<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
    <style type="text/css">
        .icheckbox_square-blue, .iradio_square-blue{
            background-color: #fff;
        }
    </style>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success container-fluid">
                    <div class="row" style="background: #D0D0D0;"><br>
                        <style>
                            .form-group {margin-bottom: 5px;}
                        </style>
                        <div class="col-md-4">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="customer" class="col-sm-4 control-label">PO No <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" value="<?php echo $po_no; ?>"  name="grn_no" id="grn_no" placeholder="Auto Generate">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnDate" class="col-sm-4 control-label">Delivery Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" required="required"  name="grnDate" id="grnDate" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="invlocation" value="<?php echo $_SESSION['location'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="maxSerial" id="maxSerial" >
                                        <input type="hidden" name="vatRate" id="vatRate" value="<?php echo $company['VAT']; ?>">
                                <input type="hidden" name="nbtRate" id="nbtRate" value="<?php echo $company['NBT']; ?>">
                                <input type="hidden" name="nbtRatioRate" id="nbtRatioRate" value="<?php echo $company['NBT_Ratio']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-sm-4 control-label">Location</label>  
                                        <div class="col-sm-6">
                                            <select tabindex="3" disabled class="form-control" id="location">
                                                <?php foreach ($location as $loc) { ?>
                                            <option value="<?php echo $loc->location_id; ?>" <?php if ($loc->location_id == $_SESSION['location']) {echo 'selected';}?>><?php echo $loc->location; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <div  class="col-md-5">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="supplier" class="col-sm-4 control-label">Supplier<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" tabindex="4" required="required"  name="supplier" id="supplier" placeholder="Supplier name">
                                        <option value="">-Select a supplier-</option>
                                        <?php foreach ($sup as $pl) { ?>
                                            <option value="<?php echo $pl->id; ?>"><?php echo $pl->text; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="grnremark"class="col-sm-4 control-label">PO Remark<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <textarea name="grnremark"  tabindex="2" id="grnremark" class="form-control"></textarea>
                                        <!-- <input type="hidden" tabindex="5" name="invoicenumber" id="invoicenumber" class="form-control" /> -->
                                       <!--  <input type="hidden" tabindex="6"  min="0" step="200" name="additional" value="0" id="additional" class="form-control" /> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnremark"class="col-sm-4 control-label">Bill No<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <!-- <textarea name="grnremark"  tabindex="2" id="grnremark" class="form-control"></textarea> -->
                                        <input type="text" tabindex="5" name="invoicenumber" id="invoicenumber" class="form-control" />
                                        <!-- <input type="hidden" tabindex="6"  min="0" step="200" name="additional" value="0" id="additional" class="form-control" /> -->
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label  class="col-sm-4 control-label">JOB No<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <!-- <textarea name="grnremark"  tabindex="2" id="grnremark" class="form-control"></textarea> -->
                                        <!-- <input type="hidden" tabindex="5" name="invoicenumber" id="invoicenumber" class="form-control" /> -->
                                        <input type="text" tabindex="6"  name="additional" value="<?php echo $jobno; ?>" id="additional" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invoicenumber" class="col-sm-4 control-label">Total PO VAT/NBT</label>
                                    <div class="col-sm-7">
                                         <input class="prd_icheck" type="checkbox" name="isTotalVat"  id="isTotalVat" value='1'> VAT  
                                         <input class="prd_icheck" type="checkbox" name="isTotalNbt" id="isTotalNbt" value='1'> NBT
                                <input class="" type="hidden" name="totalNbtRatio" id="totalNbtRatio" value='1'>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="additional" class="col-sm-4 control-label">Additional Charges</label>
                                    <div class="col-sm-7">
                                        <input type="hidden" tabindex="6"  min="0" step="200" name="additional" value="0" id="additional" class="form-control" />
                                    </div>
                                </div> -->
                               <!--  <div class="form-group">
                                        <label class="col-sm-4 control-label">Price Level</label>  
                                        <div class="col-sm-6">
                                            <select tabindex="7" class="form-control" id="priceLevel"> 
                                             <?php foreach ($plv as $pl) { ?>
                                            <option value="<?php echo $pl->PL_No; ?>" <?php if ($pl->PL_No == 1) {echo 'selected';}?>><?php echo $pl->PriceLevel; ?></option>
                                            <?php } ?></select>
                                        </div>
                                    </div> -->
                            </form>
                        </div>
                        <div  class="col-md-3">
                            <h4><b>Purchase Order Details</b></h4>
                            <table style="font-size: 18px;">
                                <tr>
                                    <td>Total PO Amount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="totalgrn">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>PO Discount Amount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="grndiscount">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>VAT Amount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="totalVat">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>NBT Amount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="totalNbt">0.00</span></td>
                                </tr>
                                <tr style="color: green;">
                                    <td><b>Net PO Amount</b></td>
                                    <td>:</td>
                                    <td class="text-right"><span  id="netgrnamount">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="text-right">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Product Discount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="totalprodiscount">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>PO Discount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="totalgrndiscount">0.00</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <div class="col-md-4">
                            <div class="box-body">
                                <form class="form-horizontal" id="formProduct">
                                    <span id="lbl_batch_no"></span>
                                    <label id="errProduct"></label>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Supplier Item</label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" tabindex="8" class="prd_icheck" name="suppliercheck" value="1"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="itemCode" class="col-sm-4 control-label"><span class="required"></span></label>
                                            <div class="col-sm-8"><span id="productName" style="font-size: 10px;"></span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="lbl_refCode">
                                            <label for="itemCode" class="col-sm-4 control-label">Product <span class="required"></span></label>
                                            <div class="col-sm-8 input-group">
                                                <!-- <span id="productName"></span> -->
                                                <input type="text" tabindex="9" name="itemCode" id="itemCode" class="form-control" onfocus="this.select();" onmouseup="return false;">
<!--                                                <select class="form-control"  name="itemCode" id="itemCode">
                                                </select>-->
                                                <span class="input-group-btn">
                                                    <button class="btn btn-warning" id="addpro"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div id="lotPriceLable" >
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Loan Type</label>  
                                            <div class="col-sm-6">
                                                <select class="form-control" disabled id="loanType">
                                                    <!--<option value="">-Select-</option>-->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Loan Amount</label>  
                                            <div class="col-sm-6">
                                                <input type="number" step="10000" id="lotPrice" value="0" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="productLable" >
                                         <div class="form-group">
                                        <label class="col-sm-4 control-label">Unit Or Case</label>
                                        <div class="col-sm-4">
                                            <select required="required" tabindex="9" class="form-control" name="mUnit" id="mUnit">
                                                <option value="UNIT">Unit</option>
                                                <option value="CASE">Case</option>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label for="product" class="col-sm-4 control-label">Qty <span class="required">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="number" tabindex="10"  min="0" step="1" class="form-control" required="required"  name="qty" id="qty" placeholder="Enter Qty"  value="0">
                                                
                                            </div>
                                            <div class="col-sm-2"><span id="upm"></span></div>
                                            <input class="prd_icheck" type="checkbox" name="isProVat"  id="isProVat" value="1"> VAT

                                        </div>
                                        <div class="form-group" id="dv_FreeQty">
                                            <label for="product" class="col-sm-4 control-label">Free Qty <span class="required"></span></label>
                                            <div class="col-sm-4">
                                                <input type="number" tabindex="11"  min="0" step="1" class="form-control" required="required"  name="freeqty" id="freeqty" placeholder="Enter Qty"  value="0">

                                            </div>
                                            <div class="col-sm-2"></div>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="product" class="col-sm-4 control-label">
                                            <!-- Unit Cost  -->
                                            <span class="required"></span></label>
                                            <div class="col-sm-4">
                                                <input type="hidden" tabindex="12"  min="0" step="1" class="form-control" required="required"  name="unitcost" id="unitcost" placeholder="Enter Qty"  value="0">
                                            </div>
                                            <div class="col-sm-2"></div>
                                             <input class="prd_icheck" type="checkbox" name="isProNbt" id="isProNbt" value='1'> NBT
                                             <input class="" type="hidden" name="proNbtRatio" id="proNbtRatio" value='1'>
                                        </div>
                                        <div class="form-group">
                                            <label for="sellingPrice"class="col-sm-4 control-label">Selling Price <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number"  tabindex="13"  min="0" step="1" class="form-control" required="required"  name="sellingPrice" id="sellingPrice" placeholder="Enter Selling Price">
                                                <input type="hidden" disabled class="form-control" required="required"  name="prdName" id="prdName" placeholder="Enter product Code">
                                                <input type="hidden" class="form-control" required="required"  name="batchCode" id="batchCode">
                                                <input type="hidden" class="form-control" required="required"  name="upc" id="upc">
                                                <input type="hidden" class="form-control" required="required"  name="isSerial" id="isSerial">
                                            </div>
                                        </div>
                                        <div class="form-group" id="dv_SN">
                                            <label for="product" class="col-sm-4 control-label">Serial No <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" tabindex="14" class="form-control" required="required"  name="serialNo" id="serialNo" placeholder="Enter Serial No"  value="">
                                                <input type="hidden" tabindex="14" class="form-control" required="required"  name="serialQty" id="serialQty"  value="0">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product" class="col-sm-7 control-label">Product Wise Discount<span class="required">*</span></label>
                                            <div class="col-sm-3"><input tabindex="15" type="radio" checked required="required" class="prd_icheck"  name="discount_type" id="productWise" value="1"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product" class="col-sm-7 control-label">Total Item Wise Discount<span class="required">*</span></label>
                                            <div class="col-sm-3"><input tabindex="15"  type="radio" required="required" class="prd_icheck"  name="discount_type" id="totalItemWise" value="2"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="buyAmount" class="col-sm-4 control-label">Discount %<span class="required"></span></label>
                                            <div class="col-sm-5 input-group">
                                                <span class="input-group-addon"><input tabindex="16"  type="radio" class="prd_icheck" name="discount" checked value="1"></span>
                                                <input type="number" min="0"  tabindex="16"  step="5" pattern="[0-9]*" class="form-control" required="required"  name="disPercent" id="disPercent" placeholder="Enter Discount Percentage" value="0">
                                            </div>
                                            <div class="col-sm-7">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="totalNet" class="col-sm-4 control-label">Dis. Amount <span class="required"></span></label>
                                            <div class="col-sm-5 input-group">
                                                <span class="input-group-addon"><input tabindex="17"  type="radio" class="prd_icheck" name="discount" value="2"></span>
                                                <input type="number" tabindex="17"  min="0" step="50" pattern="[0-9]*" class="form-control" required="required"  name="disAmount" id="disAmount" placeholder="Enter discount amount" value="0">
                                                <input type="hidden" min="0" step="50" pattern="[0-9]*" class="form-control" required="required"  name="totalWithOutDiscount" id="totalWithOutDiscount" placeholder="Enter sold amount" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="rank" class="col-sm-4 control-label">&nbsp;</label>
                                        <button tabindex="18"  type="button" id="addItem" class="btn btn-primary ">Add Item</button>
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-center"><b>Purchase Order Item List</b></h5>
                            <div class="table-responsives">
                                <table id="tbl_item" class="table table-bordered table-striped table-responsives">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Unit Cost</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Discount (%)</th>
                                            <th>Total Net Amount</th>
                                            <th>Serial</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <span id="errData"></span>
                                &nbsp;<input  tabindex="20"  type="hidden" name="dwnFile" id="dwnFile" value="<?php echo base_url().'admin/grn/barcode.txt'?>">&nbsp;
                                <a class="btn btn-warning"  tabindex="20"  id="dwnLink" href="<?php echo base_url("admin/grn/downloadBarCode")?>">Download Barcode</a>&nbsp;
                                <button id="loadBarCode" class="btn btn-info">Barcode Generate</button>&nbsp; <button  tabindex="19" id="saveItems" class="btn btn-success">Save</button>&nbsp;<button id="btnPrint" class="btn btn-primary">Print</button>&nbsp;<button  tabindex="21" id="resetItems" class="btn btn-danger">Reset</button>&nbsp;
                                <input type="hidden" name="action" id="action" value="1">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"><div class="modal-body" >
             <?php //invoice print 
                    $this->load->view('admin/purchase/po_print.php',true); ?>  
            </div></div>
        </div>
    </div>
</div>
<script>
    $('#grnDate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    $("#supplier").select2({
        minimumInputLength: 1
    });
</script>