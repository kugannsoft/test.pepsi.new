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
                <div class="box box-success container-fluid">
                    <div class="row" style="background: #D0D0D0;"><br>
                        <style>
                            .form-group {margin-bottom: 5px;}
                        </style>
                        <div class="col-md-4">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="customer" class="col-sm-4 control-label">Return No <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" readonly  name="grn_no" id="grn_no" placeholder="auto gen">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnDate" class="col-sm-4 control-label">Return Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" required="required"  name="invDate" id="invDate" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="invlocation" value="<?php echo $_SESSION['location'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnremark"class="col-sm-4 control-label">Return Remark<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <textarea name="grnremark"  tabindex="2" id="grnremark" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="additional" class="col-sm-4 control-label">Sales Person</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" required="required"  name="newsalesperson" id="newsalesperson" placeholder="sales person">
                                        <option value="">-Select a sales person-</option>
                                        <?php foreach ($salesperson as $trns) { ?>
                                            <option value="<?php echo $trns->RepID; ?>" 
                                            >
                                                <?php echo $trns->RepName; ?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Routes </label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="route" id="route">
                                            <option value="0">-Select-</option>
                                        </select>                                    
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div  class="col-md-5">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="supplier" class="col-sm-4 control-label">Customer<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <!-- <input type="text" class="form-control" tabindex="4" required="required"  name="customer" id="customer" placeholder="Customer name/Code/ Phone"> -->
                                        <select class="form-control" required="required" name="customer" id="customer" placeholder="customer name">
                                                    <option value="0">-Select a customer-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invoicenumber" class="col-sm-4 control-label">Invoice Type</label>
                                    <div class="col-sm-7">
                                        <select tabindex="5" name="invType" id="invType" class="form-control">
                                            <option value="1">Sales</option>
                                            <option value="2">Service</option>
                                            <option value="3">POS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invoicenumber" class="col-sm-4 control-label">Invoice Number</label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="5" name="invoice" id="invoice" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="additional" class="col-sm-4 control-label">
                                    <!-- Non Return Invoice -->
                                    </label>
                                    <div class="col-sm-7" >
                                        <input type="checkbox" tabindex="6" name="nonInv" value="1" id="nonInv" class="prd_icheck" />
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-sm-4 control-label">Price Level</label>  
                                        <div class="col-sm-6">
                                            <select tabindex="7" class="form-control" id="priceLevel"> 
                                             <?php foreach ($plv as $pl) { ?>
                                            <option value="<?php echo $pl->PL_No; ?>" <?php if ($pl->PL_No == 1) {echo 'selected';}?>><?php echo $pl->PriceLevel; ?></option>
                                            <?php } ?></select>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <div  class="col-md-3">
                            <h4><b>Invoice Value Details</b></h4>
                            <table style="font-size: 18px;">
                                <tr>
                                    <td>Total Inv Amount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="totalgrn">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Inv Discount Amount</td>
                                    <td>:</td>
                                    <td class="text-right"><span id="grndiscount">0.00</span></td>
                                </tr>
                                <tr style="color: green;">
                                    <td><b>Net Inv Amount</b></td>
                                    <td>:</td>
                                    <td class="text-right"><span  id="netgrnamount">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="text-right">&nbsp;</td>
                                </tr>
                                
                            </table>

                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <div class="col-md-5">
                            <div class="box-body">
                                <form class="form-horizontal" id="formProduct">
                                    <span id="location"></span>
                                    <span id="lbl_batch_no"></span>
                                    <label id="errProduct"></label>
                                    <div class="form-group">
                                        <div>
                                            <label for="itemCode" class="col-sm-4 control-label"><span class="required"></span></label>
                                            <div class="col-sm-8"><span id="productName" style="font-size: 10px;"></span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="lbl_refCode">
                                            <label for="itemCode" class="col-sm-4 control-label">Product Code <span class="required"></span></label>
                                            <div class="col-sm-6 input-group">
                                                <input type="text" tabindex="9" name="itemCode" id="itemCode" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-warning" id="addpro"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div id="productLable" >
                                        <div class="form-group">
                                            <label for="product" class="col-sm-4 control-label">Qty <span class="required">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="number" tabindex="10"  min="0" step="1" class="form-control" required="required"  name="qty" id="qty" placeholder="Enter Qty"  value="0">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="sellingPrice"class="col-sm-4 control-label">Selling Price <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number"  tabindex="13"  min="0" step="1" class="form-control" required="required"  name="sellingPrice" id="sellingPrice" placeholder="Enter Selling Price">
                                                <input type="hidden"  tabindex="13"  min="0" step="1" class="form-control" required="required"  name="invsellingPrice" id="invsellingPrice" placeholder="Enter Selling Price">
                                                <input type="hidden" tabindex="12"  min="0" step="1" class="form-control" required="required"  name="unitcost" id="unitcost" placeholder="Enter Qty"  value="0">
                                                <input type="hidden" disabled class="form-control" required="required"  name="prdName" id="prdName" placeholder="Enter product Code">
                                                <input type="hidden" class="form-control" required="required"  name="batchCode" id="batchCode">
                                                <input type="hidden" class="form-control" required="required"  name="upc" id="upc">
                                                <input type="hidden" class="form-control" required="required"  name="isSerial" id="isSerial">
                                            </div>
                                        </div>
                                        <div class="form-group" id="dv_SN">
                                            <label for="product" class="col-sm-4 control-label">Serial No <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <input readonly="readonly" type="text" tabindex="14" class="form-control" required="required"  name="serialNo" id="serialNo" placeholder="Enter Serial No"  value="">
                                                <input type="hidden" tabindex="14" class="form-control" required="required"  name="serialQty" id="serialQty"  value="0">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="rank" class="col-sm-4 control-label">&nbsp;</label>
                                        <button tabindex="18"  type="button" id="addItem" class="btn btn-primary ">Add Item</button>
                                    </div>
                                </form>
                                <table id="tbl_payment" class="table table-bordered table-hover" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th class="text-right">Credit Amount</th>
                                        <th class="text-right">Return Amount</th>
                                        <th class="text-right">Available Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot id="over_payment_rows">
                                </tfoot>
                            </table>

                            </div><!-- /.box-body -->
                        </div>
                        <div class="col-md-7">
                            <h5 class="text-center"><b>Return Item List</b></h5>
                            <div class="table-responsives">
                                <table id="tbl_item" class="table table-bordered table-striped table-responsives">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
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
                                <button  tabindex="19" id="saveItems" class="btn btn-success">Save</button>&nbsp;<button  tabindex="21" id="resetItems" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('#invDate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        startDate: "tomorrow"
    });
    
    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    $('#customer').select2({
    placeholder: "Select a customer",
    allowClear: true,
    minimumInputLength:1,
    width: '100%'
});
</script>