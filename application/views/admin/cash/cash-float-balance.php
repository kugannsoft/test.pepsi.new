<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <style>
        .selected{background-color: #eea236;}
    </style>
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
                            <div class="col-sm-5">

                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Billing Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" required="required"  name="invDate" id="invDate" value="<?php echo date('Y-m-d') ?>" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Float Amount <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" required="required"  name="floatAmount" id="floatAmount"  placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">&nbsp; <span class="required"></span></label>
                                    <div class="col-sm-6">
                                        <button class="btn btn-info" id='addFloat'>Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        Cash Out &nbsp;&nbsp; <input class="prd_icheck" type="radio" value="1" checked required="required"  name="cash_type" id="cash_type1">
                                    </div>
                                    <div class="col-sm-9">
                                        Cash In &nbsp;&nbsp;<input  class="prd_icheck"  type="radio" value="0"  required="required"  name="cash_type" id="cash_type2">
                                    </div><br>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-3 control-label">Transaction Type <span class="required">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="trans_type"  id="trans_type">
                                            <option value="">-Select a Transaction Type-</option>
                                            <?php foreach ($transType as $trns) { ?>
                                            <option value="<?php echo $trns->TransactionCode; ?>" ><?php echo $trns->TransactionName; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="input-group-btn">
                                <button class="btn btn-warning"  id="addCat"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-danger" id="delCat"><i class="fa fa-close"></i></button>
                            </div>
                                    </div>
                                    <div class="input-group" id="panel_dep3">
                                <input type="text" class="form-control pull-right" name="dep3" id="dep3">
                                <span class="input-group-btn"><button class="btn btn-primary" id="saveDep3">Add</button></span>
                            </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-3 control-label">Employee <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" required="required"  name="emp" id="emp" >
                                            <option value="0">All</option>
                                             <?php foreach ($salesperson as $trns) { ?>
                                            <option value="<?php echo $trns->RepID; ?>"><?php echo $trns->RepName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label for="invDate" class="col-sm-3 control-label">Remark <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-3 control-label">Amount <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" required="required"  name="cashAmount" id="cashAmount"  placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-3 control-label">Is Active <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" checked class="prd_icheck" required="required"  name="isAct" id="isAct">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">&nbsp; <span class="required"></span></label>
                                    <div class="col-sm-6">
                                        <input type="hidden" class="form-control" required="required"  name="oid" id="oid"  placeholder="">
                                        <button class="btn btn-info" id='addCash'>Add</button>&nbsp;
                                        <button class="btn btn-danger" id='clearCash'>Clear</button>
                                    </div>
                                </div>
                                <table class="table table-hover" id="cash_float">
                                    <thead>
                                        <tr><th>#</th><th>Mode</th><th>Remark</th><th class="text-right">Cash Amount</th><th></th></tr>
                                     </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span id="lbl_batch_no"></span></b>
                                <!--<br><button class="btn btn-info pull-right" id='pay'>Save</button>-->
                                <button class="btn btn-success" id='print'>Print Invoice</button>
                            </div>
                            <div class="col-lg-8">

                            </div>
                        </div>



                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="tbl_payment" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Start Time</th>
                                        <th>Start Float</th>
                                        <th>End Time</th>
                                        <th>End Float</th>
                                        <th>Cash Sales</th>
                                        <th>Credit Sales</th>
                                        <th>Card Sales</th>
                                        <th>Discount</th>
                                        <th >Net Sales</th>
                                        <th >Advance</th>
                                        <th>Cash In</th>
                                        <th>Cash Out</th>
                                        <th  class="text-right">Balance Amount</th><th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
<!--                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th ></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th  class="text-right" id="totErn"> Earnings</th>
                                        <th  class="text-right" id="totExp">Expenses</th>
                                    </tr>
                                </tfoot>-->
                            </table>
                        </div>
<!--                        <span id="lastTranaction">Last Cancel Invoice : </span>-->
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

    <!--total discount-->
    <div class="modal fade bs-bill-modal-lg" id="modelTotalDis" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Total Items Discount</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="text-center">Apply Total Items Discount By <span class="discount_type">: <span class="label label-warning">Cash</span></span></h4>
                                        <div class="input-group">
                                            <span class="input-group-btn"><button class="btn btn-primary btn-lg percentage_discount " disType="2" val="1" type="button">Percentage</button></span>
                                            <input type="number" name="discount_value" id="totalAmountDiscount" class="form-control input-lg" min="0" value="0"  step="5"  placeholder="Define the amount or percentage here...">
                                            <span class="input-group-btn"><button class="btn btn-warning flat_discount btn-lg active" disType="2"  val="2" type="button">Cash</button></span>
                                        </div></div>
                                    <label id="errTotalDis"></label>
                                </div><div class="col-md-3"></div>
                            </form>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-lg pull-left" id="clearTotalDiscount" type="button">Remove Total Items Discount</button>
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="addDiscount" class="btn btn-success btn-lg">Add Discount</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content"><div class="modal-body" >
                        <div class="row"  id="printArea" align="center" style='margin:5px;'>

                            <table style="border-collapse:collapse;width:500px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <?php //foreach ($company as $com) {  ?>
                                <tr style="text-align:center;font-size:20px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4" style="font-size:20px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?></b></td>
                                </tr> <?php //}  ?>
                                <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><?php echo $company['AddressLine01'] ?> <?php echo $company['AddressLine02'] ?> <?php echo $company['AddressLine03'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                                    <td colspan="4">Cashier Balance Sheet</td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Balance Date</td>
                                    <td>:</td>
                                    <td id="invoiceDate"><?php echo date("Y-m-d H:i:s");?></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Cashier</td>
                                    <td>:</td>
                                    <td id="invCashier"><?php echo $_SESSION['fname'];?></td>
                                </tr>
                            </table>
                            <style>#tblData td{padding: 2px;}</style>
                            <table id="tblData"  style="border-collapse:collapse;width:500px;font-size:14px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                
                                <tbody>

                                </tbody>
                                <tfoot style='border:#000 solid 1px;'>
                                    <tr >
                                        <td style="text-align: right;" colspan="3">......................</td>
                                        <td></td>
                                        <td style="text-align:right"></td>
                                    </tr>
                                    <tr id="discountRow">
                                        <td style="text-align: right;"  colspan="3">Cashier Signature</td>
                                        <td></td>
                                        <td style="text-align:right"></td>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                            <table  style="border-collapse:collapse;width:500px;font-size:14px;margin:5px 5px 30px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <tr style="text-align:center;font-size:12px;">
                                    <td colspan="4"><i>Software By NSOFT &nbsp;&nbsp;&nbsp;&nbsp;www.nsoft.lk</i></td>
                                </tr>
                            </table>

                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="printInvoice" class="btn btn-primary btn-lg">Print</button>
                    </div>

                </div>
            </form>
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
    $("#panel_dep3").hide();
$('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    
    $("#trans_type").select2({
        placeholder: "Select a transation type",
        allowClear: true
    });
    
    $('#addCat').click(function(e) {
        $("#panel_dep3").show();
        $("#dep3").focus();
        e.preventDefault();
    });
    
    
    
</script>