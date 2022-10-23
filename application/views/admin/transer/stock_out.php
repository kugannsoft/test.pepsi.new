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
                                    <label for="customer" class="col-sm-4 control-label">Transfer Out No <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" readonly  name="grn_no" id="grn_no" placeholder="auto gen">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnDate" class="col-sm-4 control-label">Transfer Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" required="required"  name="grnDate" id="grnDate" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="invlocation" value="<?php echo $_SESSION['location'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnremark"class="col-sm-4 control-label">Transfer Remark<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <textarea name="grnremark"  tabindex="2" id="grnremark" class="form-control"></textarea>
                                    </div>
                                    <span id="top"></span>
                                </div>
                                
                            </form>
                        </div>
                        <div  class="col-md-5">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                        <label class="col-sm-4 control-label">From Location</label>  
                                        <div class="col-sm-6">
                                            <select tabindex="3" class="form-control" id="location_from" disabled>
                                                <?php foreach ($location as $loc) { ?>
                                            <option value="<?php echo $loc->location_id; ?>" <?php if ($loc->location_id == $_SESSION['location']) {echo 'selected';}?>><?php echo $loc->location; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <div class="form-group">
                                        <label class="col-sm-4 control-label">To Location</label>  
                                        <div class="col-sm-6">
                                            <select tabindex="3" class="form-control" id="location_to">
                                                <option value="">Select destination location</option>
                                                <?php foreach ($location as $loc) { ?>
                                            <option value="<?php echo $loc->location_id; ?>"><?php echo $loc->location; ?></option>
                                            <?php } ?>
                                            </select>
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
                                        <div id="lbl_refCode">
                                            <label for="itemCode" class="col-sm-4 control-label">Product Code <span class="required"></span></label>
                                            <div class="col-sm-6">
                                                <input type="text" tabindex="9" name="itemCode" id="itemCode" class="form-control">
<!--                                                <select class="form-control"  name="itemCode" id="itemCode">
                                                    
                                                </select>-->
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
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="product" class="col-sm-4 control-label">Unit Cost <span class="required">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="number" tabindex="12"  min="0" step="1" class="form-control" required="required"  name="unitcost" id="unitcost" placeholder="Enter Qty"  value="0">
                                            </div>
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
                                        <label class="col-sm-4 control-label">Is Return</label>
                                        <div class="col-sm-4">
                                            <select required="required" tabindex="9" class="form-control" name="mReturn" id="mReturn">
                                                <option value="0">-Select-</option>
                                                <option value="1">Return</option>
                                                <option value="2">Other</option>
                                            </select>
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
                            <h5 class="text-center"><b>Stock Transfer out Item List</b></h5>
                            <div class="table-responsives">
                                <table id="tbl_item" class="table table-bordered table-striped table-responsives">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th>Unit Price</th>
                                            <th>Selling Price</th>
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
<!--                                &nbsp;<input  tabindex="20"  type="hidden" name="dwnFile" id="dwnFile" value="<?php echo base_url().'admin/grn/barcode.txt'?>">&nbsp;
                                <a class="btn btn-warning"  tabindex="20"  id="dwnLink" href="<?php echo base_url("admin/grn/downloadBarCode")?>">Download Barcode</a>&nbsp;-->
                                <button id="loadBarCode" class="btn btn-info">Barcode Generate</button>&nbsp; <button  tabindex="19" id="saveItems" class="btn btn-success">Save</button>&nbsp;<button  tabindex="21" id="resetItems" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('#grnDate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        startDate: "tomorrow"
    });
    
    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    $("#supplier").select2({
        ajax: {
            url: "loadsupplierjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });
    
</script>