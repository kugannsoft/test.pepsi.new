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
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        Expenses &nbsp;&nbsp; <input class="prd_icheck" type="radio" value="1" checked required="required"  name="cash_type" id="cash_type">
                                    </div>
                                    <div class="col-sm-6">
                                        Earning &nbsp;&nbsp;<input  class="prd_icheck"  type="radio" value="0"  required="required"  name="cash_type" id="cash_type">
                                    </div><br>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Transaction Type <span class="required">*</span></label>
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
                                    <label for="invDate" class="col-sm-5 control-label">Transaction Date <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="invDate" id="invDate" value="<?php echo date('Y-m-d')?>" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Remark <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Float Amount <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="floatAmount" id="floatAmount"  placeholder="">
                                        </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <table class="table">
                                    <tr><td></td><td></td><td class="text-right"></td></tr>
                                    <tr><td>Total Expenses</td><td>:</td><td class="text-right" id="totalAmount"></td></tr>
                                    <tr><td>Total Earning</td><td>:</td><td class="text-right"  id="totalDis"></td></tr>
                                
                                    
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span id="lbl_batch_no"></span></b>
                                <br><button class="btn btn-info pull-right" id='pay'>Save</button>
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
                                        <th>Float No</th>
                                        <th>Counter No</th>
                                        <th>Float Date</th>
                                        <th>Entered Date</th>
                                        <th >Transaction Code</th>
                                        <th>Transaction Name</th>
                                        <th>Is Expenses</th>
                                        <th  class="text-right"> Earnings</th>
                                        <th  class="text-right">Expenses</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
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
                                </tfoot>
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

                            <table style="border-collapse:collapse;width:290px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
<?php //foreach ($company as $com) {  ?>
                                <tr style="text-align:center;font-size:20px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4" style="font-size:20px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?></b></td>
                                </tr> <?php //} ?>
                                <tr style="text-align:center;font-size:18px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><b><?php echo $company['CompanyName2'] ?></b></td>
                                </tr>
                                <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                                    <td colspan="4">Copy of Cash Invoice</td>
                                </tr>
				<tr style="text-align:center;">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Invoice Number</td>
                                    <td>:</td>
                                    <td id="invNumber"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Invoice Date</td>
                                    <td>:</td>
                                    <td id="invoiceDate"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Cashier</td>
                                    <td>:</td>
                                    <td id="invCashier"></td>
                                </tr>
                            </table>
                            <style>#tblData td{padding: 2px;}</style>
                            <table id="tblData"  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <thead>
                                    <tr style="text-align:center;border:#000 solid 1px;">
                                        <td style="text-align:center;border:#000 solid 1px;">Description</td>
<!--                                        <td style="text-align:center;border:#000 solid 1px;"> Qty</td>
                                        <td style="text-align:center;border:#000 solid 1px;">Price</td>-->
                                        <td style="text-align:center;border:#000 solid 1px;">T. Amount</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot style='border:#000 solid 1px;'>
                                    <tr >
                                        <td colspan="3" style="text-align: right;">Total Amount</td>
                                    <!--<td></td>-->
                                        <td style="text-align:right"  id="invTotal">0.00</td>
                                    </tr>
                                    <tr id="discountRow">
                                        <td colspan="3" style="text-align: right;">Total Discount</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invTotalDis">0.00</td>
                                    </tr>
                                    <tr  id="netAmountRow">
                                        <td colspan="3"  style="text-align: right;">Net Amount</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invNet">0.00</td>
                                    </tr>
                                    <tr  id="cusPayRow">
                                        <td colspan="3"  style="text-align: right;">Customer Pay</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invCusPay">0.00</td>
                                    </tr>
                                    <tr  id="balanceRow">
                                        <td colspan="3" id="crdLabel" style="text-align: right;">Balance Amount</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invBalance">0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <table  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px 5px 30px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">

                                <tr>
                                    <td colspan="4" style="text-align:left;font-size:12px;">Number of Item <span id="invNoItem"></span></td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4">Every accessories for 6 month warranty</td>
                                </tr>
								<tr style="text-align:center">
                                    <td colspan="4" >&nbsp;</td>
                                </tr>
								<tr style="text-align:center;font-size:25px;">
                                    <td colspan="4"><b>Thank You Come Again</b></td>
                                </tr>
								<tr style="text-align:center">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4">Any compliant to sms <?php echo $company['MobileNo'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:12px;">
                                    <td colspan="4"><i>Software By NSOFT &nbsp;&nbsp;&nbsp;&nbsp;www.nsoft.lk</i></td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4" style="height:30px;">&nbsp;</td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4">-</td>
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