<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
<style type="text/css">
    .input-group-btn {
    position: relative;
    font-size: 18px;
    white-space: nowrap;
}
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
        <style>
            .rowselected{background-color: #f0ad4e;}
        </style>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon label-default">Invoice Number</span>
                                <input type="text" name="invoiceNo" id="invoiceNo" class="form-control input-lg" placeholder="Invoice Number" value="<?php echo $invno;?>">
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'];?>">
                            </div></div>

                            <div class="col-md-6">
                            <div class="input-group">
                                Credit Limit :<span id="lblcreditLimit"></span><br>
                                Outstanding :<span id="lblcredit"></span><br>
                                Available Limit :<span id="lblavaLimit"></span><br>
                            </div></div>
                    </div></div></div></div>
        <div class="row">
            <div class="col-lg-8">
                <div class="box">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" id="payTab">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Customer Payment</a></li>
              <li class=""><a href="#tab_2" disabled data-toggle="tab" aria-expanded="false">Ower's Account(Third party payment)</a></li>
              <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li>
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!-- <form role="form" id="addDep" data-parsley-validate method="post" action="#"> -->
                <div class="modal-content">

                    <div class="modal-header">
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button> -->
                        <h4 class="modal-title" id="myModalLabel2">Customer Payment Details <span id="errPayment"></span></h4>
                        <span class="pull-right"><input type="checkbox" value="1" name="allowThirdPay" id="allowThirdPay"> &nbsp;Allow Third Party Payments</span>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- <form class="form-horizontal"> -->
                                <div class="col-md-6">
                                    <!--<div class="form-group">-->
                                        <!--<h4 class="text-center">Payment Type : <span class="discount_type">: <span class="label label-primary">percentage</span></span></h4>-->
                                     <!--    <div class="input-group" id="companyInput">
                                        <span class="input-group-addon label-info">Company Amount</span>
                                        <input type="number" name="company_amount" id="company_amount" min='0' value="0"  step="50"  class="form-control input-lg" placeholder="Company claim amount">
                                    </div><br> -->

                                    <div class="input-group">
                                        <span class="input-group-addon label-success">Cash Amount</span>
                                        <input type="number" name="cash_amount" id="cash_amount" min='0' value="0"  step="50"  class="form-control input-lg" placeholder="cash amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card Amount</span>
                                        <input type="number" disabled name="card_amount" id="card_amount" min='0' value="0"  class="form-control input-lg" placeholder="card amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Cheque Amount</span>
                                        <input type="number" name="cheque_amount" id="cheque_amount" min='0' value="0"  class="form-control input-lg" placeholder="Cheque amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Bank Amount</span>
                                        <input type="number" name="bank_amount" id="bank_amount" min='0' value="0"  class="form-control input-lg" placeholder="Bank Transfer amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Advance Amount</span>
                                        <input type="number" name="advance_amount" id="advance_amount" min='0' value="0"  class="form-control input-lg" placeholder="Advance amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Credit Amount</span>
                                        <input type="number" name="credit_amount" id="credit_amount" min='0'  value="0"  step="50"  class="form-control input-lg" placeholder="credit amount" onfocus="this.select();" onmouseup="return false;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-warning btn-lg" id="addCredit"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="chequeReference" class="control-label">Remark<span class="required"></span></label>
                                        <textarea  class="form-control" name="pay_remark" id="pay_remark"></textarea>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card Receipt Amount</span>
                                        <input type="number" name="card_receipt_amount" id="card_receipt_amount" min='0'  value="0"  step="50"  class="form-control" placeholder="Card Receipt Amount" onfocus="this.select();" onmouseup="return false;">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Cheque Receipt Amount</span>
                                        <input type="number" name="cheque_receipt_amount" id="cheque_receipt_amount" min='0'  value="0"  step="50"  class="form-control" placeholder="Cheque Receipt Amount" onfocus="this.select();" onmouseup="return false;">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Part Invoice No</span>
                                        <input type="text" name="part_invoice_no" id="part_invoice_no" class="form-control" placeholder="Part Invoice No" onfocus="this.select();" onmouseup="return false;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="label">Advance Payment</span>
                                        <input type="text" name="advance_payment_no" id="advance_payment_no"   class="form-control input-lg" placeholder="Advace Payment No">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card type</span>
                                        <select name="card_type" id="card_type" class="form-control input-md">
                                            <option value="0">Select a type</option>
                                            <option value="1">Visa</option>
                                            <option value="2">Master</option>
                                            <option value="3">Amex</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Reference</span>
                                        <input type="text" name="card_ref" id="card_ref"   class="form-control input-md" placeholder="Reference">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Amount</span>
                                        <input type="number" name="ccard_amount" id="ccard_amount" min='0'  step="50"  value="0"  class="form-control input-lg" placeholder="card amount" onfocus="this.select();" onmouseup="return false;">
                                        <span class="input-group-btn"><button class="btn btn-primary btn-lg" id='addCard' type="button">Add</button></span>
                                    </div>
                                    <h4>Card details</h4>
                                    <label id="errCard"></label>
                                    <table class="table table-hover" id='tblCard'>
                                        <thead>
                                            <tr><th>Type</th><th>Ref</th><th>Amount</th><th></th></tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="row"><div class="col-md-12">
                                <div class="form-group">
                                    <label for="bank">Commission Amount<span class="required"></span></label>
                                    <input type="number" class="form-control" name="commission"  id="commission">
                                </div>
                                <div class="form-group">
                                    <label for="bank" class="control-label">Commission Paid to<span class="required"></span></label>
                                    <input class="form-control" required="required"  name="com_paidto" id="com_paidto">
                                </div>
                            </div></div>
                                    <div id='bankData'><hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bank" class="control-label">Bank Account<span class="required">*</span></label>
                                    <select class="form-control" required="required"  name="bank_acc" id="bank_acc">
                                    <option value="">Select a Bank Account</option>
                                    <?php foreach($bank_acc as $banks){?>
                                        <option value="<?php echo $banks->acc_id; ?>"><?php echo $banks->acc_name." / ".$banks->acc_no." - ".$banks->BankName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div></div>
                                </div>
                                <!-- <div class="col-md-4"> -->
                                    <!-- <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Total</td><td>:</td><td  id='mtotal'  class='text-right'>0.00</td></tr>
                                            <tr><td>Discount</td><td>:</td><td  id='mdiscount'  class='text-right'>0.00</td></tr>
                                            <tr><td>Advance</td><td>:</td><td  id='madvance'  class='text-right'>0.00</td></tr>
                                            <tr><td>Net Payable</td><td>:</td><td  id='mnetpay'  class='text-right'>0.00</td></tr>
                                            <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table> -->
                                <!-- </div> -->

                                
                            <!-- </form> -->
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                
                            <div id='chequeData'><hr><h4>Cheque Details</h4>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank" class="control-label">Bank <span class="required">*</span></label>
                                    <select class="form-control" required="required"  name="bank" id="bank">
                                    <option value="">Select a Bank</option>
                                    <?php foreach($bank as $banks){?>
                                        <option value="<?php echo $banks->BankCode; ?>"><?php echo $banks->BankName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeNo" class="control-label">Cheque No <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeNo" id="chequeNo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeReciveDate" class="control-label">Cheque Received date <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeReciveDate" id="chequeReciveDate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeDate" class="control-label">Date of Cheque<span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeDate" id="chequeDate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeReference" class="control-label">Cheque Reference<span class="required"></span></label>
                                    <textarea  class="form-control" name="chequeReference" id="chequeReference">

                                    </textarea>
                                </div>
                            </div>
                        </div></div>
                        </div>
                    </div>

                </div>
            <!-- </form> -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!-- <form role="form" id="addDep" data-parsley-validate method="post" action="#"> -->
                <div class="modal-content">

                    <div class="modal-header">
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button> -->
                        <h4 class="modal-title" id="myModalLabel2">Third Party Payment Details <span id="errPayment2"></span></h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- <form class="form-horizontal"> -->
                            <div class="col-md-12"> <div class="input-group">
                                        <span class="input-group-addon label-info">Third Party Customer</span>
                                        <input type="text" name="third_party_customer" id="third_party_customer" class="form-control input-lg" placeholder="Third Party Customer">
                                    </div><br></div>
                                <div class="col-md-6">
                                 
                                    <!--<div class="form-group">-->
                                        <!--<h4 class="text-center">Payment Type : <span class="discount_type">: <span class="label label-primary">percentage</span></span></h4>-->
                                        <!-- <div class="input-group" id="companyInput">
                                        <span class="input-group-addon label-info">Company Amount</span>
                                        <input type="number" name="company_amount2" id="company_amount2" min='0' value="0"  step="50"  class="form-control input-lg" placeholder="Company claim amount">
                                    </div><br> -->
                                    <div class="input-group">
                                        <span class="input-group-addon label-success">Cash Amount</span>
                                        <input type="number" name="cash_amount2" id="cash_amount2" min='0' value="0"  step="50"  class="form-control input-lg" placeholder="cash amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card Amount</span>
                                        <input type="number" disabled name="card_amount2" id="card_amount2" min='0' value="0"  class="form-control input-lg" placeholder="card amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Cheque Amount</span>
                                        <input type="number" name="cheque_amount2" id="cheque_amount2" min='0' value="0"  class="form-control input-lg" placeholder="Cheque amount" onfocus="this.select();" onmouseup="return false;">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Credit Amount</span>
                                        <input type="number" name="credit_amount2" id="credit_amount2" min='0'  value="0"  step=".01"  class="form-control input-lg" placeholder="credit amount" onfocus="this.select();" onmouseup="return false;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-warning btn-lg" id="addCredit2"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Cash</td><td>:</td><td  id='mcash'  class='text-right'>0.00</td></tr>
                                            <tr><td>Card</td><td>:</td><td  id='mcard'  class='text-right'>0.00</td></tr>
                                            <tr><td>Cheque</td><td>:</td><td  id='mcheque'  class='text-right'>0.00</td></tr>
                                            <tr><td>Credit</td><td>:</td><td  id='mcredit'  class='text-right'>0.00</td></tr>
                                            <tr><td>Company</td><td>:</td><td  id='mcompany'  class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table> -->
                                    <!--</div>-->
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">Card type</span>
                                        <select name="card_type2" id="card_type2" class="form-control input-lg">
                                            <option value="0">Select a type</option>
                                            <option value="1">Visa</option>
                                            <option value="2">Master</option>
                                            <option value="3">Amex</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Reference</span>
                                        <input type="text" name="card_ref2" id="card_ref2"   class="form-control input-lg" placeholder="Reference">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Amount</span>
                                        <input type="number" name="ccard_amount2" id="ccard_amount2" min='0'  step="50"  value="0"  class="form-control input-lg" placeholder="card amount" onfocus="this.select();" onmouseup="return false;">
                                        <span class="input-group-btn"><button class="btn btn-primary btn-lg" id='addCard2' type="button">Add</button></span>
                                    </div>
                                    <h4>Card details</h4>
                                    <label id="errCard"></label>
                                    <table class="table table-hover" id='tblCard2'>
                                        <thead>
                                            <tr><th>Type</th><th>Ref</th><th>Amount</th><th></th></tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <!-- <div class="col-md-4"> -->
                                    <!-- <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Total</td><td>:</td><td  id='mtotal'  class='text-right'>0.00</td></tr>
                                            <tr><td>Discount</td><td>:</td><td  id='mdiscount'  class='text-right'>0.00</td></tr>
                                            <tr><td>Advance</td><td>:</td><td  id='madvance'  class='text-right'>0.00</td></tr>
                                            <tr><td>Net Payable</td><td>:</td><td  id='mnetpay'  class='text-right'>0.00</td></tr>
                                            <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table> -->
                                <!-- </div> -->

                                
                            <!-- </form> -->
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div id='chequeData2'><hr><h4>Cheque Details</h4>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank" class="control-label">Bank <span class="required">*</span></label>
                                    <select class="form-control" required="required"  name="bank2" id="bank2">
                                    <option value="">Select a Bank</option>
                                    <?php foreach($bank as $banks){?>
                                        <option value="<?php echo $banks->BankCode; ?>"><?php echo $banks->BankName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeNo" class="control-label">Cheque No <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeNo2" id="chequeNo2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeReciveDate" class="control-label">Cheque Received date <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeReciveDate2" id="chequeReciveDate2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeDate" class="control-label">Date of Cheque<span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeDate2" id="chequeDate2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeReference" class="control-label">Cheque Reference<span class="required"></span></label>
                                    <textarea  class="form-control" name="chequeReference2" id="chequeReference2">

                                    </textarea>
                                </div>
                            </div>
                        </div></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>

                </div>
            <!-- </form> -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                like Aldus PageMaker including versions of Lorem Ipsum.
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
                </div>
            </div>
            <div class="col-md-4">
             <div  class="box">
                <table class="table table-hover">
                    <tbody>
                        <tr><td>Total</td><td>:</td><td  id='mtotal'  class='text-right'>0.00</td></tr>
                        <tr><td>Discount</td><td>:</td><td  id='mdiscount'  class='text-right'>0.00</td></tr>
                        <!-- <tr><td>Advance</td><td>:</td><td  id='madvance'  class='text-right'>0.00</td></tr> -->
                        <tr><td>VAT</td><td>:</td><td  id='mvat'  class='text-right'>0.00</td></tr>
                        <tr><td>NBT</td><td>:</td><td  id='mnbt'  class='text-right'>0.00</td></tr>
                        <tr><td>Net Payable</td><td>:</td><td  id='mnetpay'  class='text-right' style="font-size: 25px;">0.00</td></tr>
                        <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr>
                    </tbody>
                </table>

                <table class="table table-hover">
                    <tbody>
                    <tr><td></td><td></td><td class='text-right'>Customer</td><td class='text-right'>Third Party</td></tr>
                        <tr><td>Cash</td><td>:</td><td  id='mcash'  class='text-right'>0.00</td><td  id='mcash2'  class='text-right'>0.00</td></tr>
                        <tr><td>Card</td><td>:</td><td  id='mcard'  class='text-right'>0.00</td><td  id='mcard2'  class='text-right'>0.00</td></tr>
                        <tr><td>Cheque</td><td>:</td><td  id='mcheque'  class='text-right'>0.00</td><td  id='mcheque2'  class='text-right'>0.00</td></tr>
                        <tr><td>Bank</td><td>:</td><td  id='mbank'  class='text-right'>0.00</td><td  id='mbank2'  class='text-right'>0.00</td></tr>
                        <tr><td>Credit</td><td>:</td><td  id='mcredit'  class='text-right'>0.00</td><td  id='mcredit2'  class='text-right'>0.00</td></tr>
                        <tr><td>Advance</td><td>:</td><td  id='madvance'  class='text-right'>0.00</td></tr>

                        <tr><td>Total</td><td>:</td><td  id='mcompany'  class='text-right'>0.00</td><td  id='mcompany2'  class='text-right'>0.00</td></tr>
                    </tbody>
                </table></div>
            </div>
        </div>
         <div class="row">
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-footer">
                        <div class="modal-footer">
                        <button id="cardPrint" disabled class="btn btn-primary  pull-left">Card Receipt Print</button>
      &nbsp;&nbsp;&nbsp;
      
      <button id="chequePrint" disabled  class="btn btn-primary pull-left">Cheque Receipt Print</button>
      <a href="../../../admin/Salesinvoice/view_invoice/<?php echo base64_encode($invno);?>"  class="btn btn-primary pull-left">Invoice</a>
                        <!-- <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button> -->
                        <button type="button" id="saveInvoice" class="btn btn-success btn-lg">Confirm Payment</button>
                    </div>
                    </div></div></div></div>
        <div class="col-lg-4">
                   </div>
    </section>
     <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice2" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">
                    <div class="modal-body" >
                         <?php //receipt print 
                            $this->load->view('admin/payment/customer-card-receipt-print.php',true); ?>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="printInvoice" class="btn btn-primary btn-lg">Print</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

     <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice3" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">
                    <div class="modal-body" >
                         <?php //receipt print 
                            $this->load->view('admin/payment/customer-cheque-receipt-print.php',true); ?>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="printInvoice" class="btn btn-primary btn-lg">Print</button>
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
                                <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4" style="font-size:40px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?></b></td>
                                </tr> <?php //}  ?>
                                <tr style="text-align:center;font-size:25px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><b><?php echo $company['CompanyName2'] ?></b></td>
                                </tr>
                                <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"> <?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?></td>
                                </tr><tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><?php echo $company['AddressLine03'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:25px;">
                                    <td colspan="4">
                                        <!--<img valign="bottom" src="/upload/phone.png" style="height:28px;">--> 
                                        &nbsp;<?php echo $company['LanLineNo'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                                    <td colspan="4">Customer Payment</td>
                                </tr>
                                <tr style="text-align:center;">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Payment Number</td>
                                    <td>:</td>
                                    <td id="invNumber"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Payment Date</td>
                                    <td>:</td>
                                    <td id="invoiceDate"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Customer Name</td>
                                    <td>:</td>
                                    <td id="cusname"></td>
                                </tr>
                                <tr style="text-align:left;font-size:13px;">
                                    <td colspan="2">Outstanding Balance</td>
                                    <td>:</td>
                                    <td id="outstand"></td>
                                </tr>
                            </table>
                            <style>#tblData td{padding: 2px;}</style>
                            <table id="tblData"  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <thead>
                                    <tr style="text-align:center;border:#000 solid 1px;">
                                        <td style="text-align:center;border:#000 solid 1px;">Cheque Date</td>
                                        <td style="text-align:center;border:#000 solid 1px;"> Cheque No</td>
                                        <td style="text-align:center;border:#000 solid 1px;">Bank Name</td>
                                        <td style="text-align:center;border:#000 solid 1px;">T. Amount</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot style='border:#000 solid 1px;'>
                                    <tr >
                                        <td colspan="3" style="text-align: right;">Total Payment Amount</td>
                                    <!--<td></td>-->
                                        <td style="text-align:right"  id="invTotal">0.00</td>
                                    </tr>

                                </tfoot>
                            </table>
                            <table  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px 5px 30px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">


                                <tr style="text-align:center;font-size:25px;">
                                    <td colspan="4"><b>Thank You Come Again</b></td>
                                </tr>
                                <tr style="text-align:center">
                                    <td colspan="4">&nbsp;</td>
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
$('#chequeReciveDate,#chequeDate,#chequeReciveDate2,#chequeDate2').datepicker({ format: 'yyyy-mm-dd'});
$('#appoDate').datepicker().datepicker("setDate", new Date());

var creditAmount = 0;
var advanceAmount = 0;
var cashAmount = 0;
var bankAmount = 0;
var chequeAmount = 0;
var cardAmount =0;
var companyAmount =0;
var toPay=0;
var dueAmount=0;
 var inv=0;
var cusCode=0;
var total=0;
var totalDiscount=0;
var cusPayment=0;
var cusType=0;

var creditAmount2 = 0;
var cashAmount2 = 0;
var chequeAmount2 = 0;
var cardAmount2 =0;
var companyAmount2 =0;
var toPay=0;
var dueAmount=0;
var thirdcusCode=0;
var cusPayment2=0;
var thirdCusType=0;
var isThridPay=0;
var cusTotal=0;
var tcusTotal=0;
$("#saveInvoice").attr('disabled', true);
$("#advance_amount").prop("disabled",true);
$("#chequeData").hide();
$("#chequeData2").hide();
$("#bankData").hide();
$("#cash_amount2").prop("disabled",true);
$("#cheque_amount2").prop("disabled",true);
$("#ccard_amount2").prop("disabled",true);
$("#credit_amount2").prop("disabled",true);

 inv=$("#invoiceNo").val();


 $("input[name='allowThirdPay']").change(function(){
    if(this.checked) {
        isThridPay=1;
        if(thirdcusCode!='' || thirdcusCode!=0){
            addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        }
        
    }else{
        isThridPay=0;
    }
 });

var advance_payment_no=0;
var advance_amount=0;

var creditLimit=0;
var outstanding=0;
var availibleOutstand=0;

location2 =$("#location").val();

    $("#advance_payment_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../salesinvoice/loadadvancepaymentjson',
                dataType: "json",
                data: {
                    q: request.term,
                    cusCode:cusCode,
                    loc:location2
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,
                            value: item.id,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            advance_payment_no = ui.item.value;            
            $("#advance_amount").val(0);
            $("#madvance").html(0);
            loadAdvanceData(advance_payment_no);
        }
    });
    
    function loadAdvanceData(pay_no){
        $.ajax({
            type: "POST",
            url: "../../Salesinvoice/getadvancepaymentbyid",
            data: { payid: pay_no },
            success: function(data) {
                var resultData = JSON.parse(data);
                advanceAmount =0;
                if (resultData.advance){
                    advanceAmount = parseFloat(resultData.advance.TotalPayment);
                    advance_payment_no = resultData.advance.CusPayNo;
                    $("#advance_amount").val(advanceAmount);
                    $("#madvance").html(advanceAmount);
                     addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
                
                }
            }
        });
    }

 if(inv!=''){
    $("#mcash").html('0.00');
        $("#mcard").html('0.00');
        $("#mcredit").html('0.00');
        $("#mchange").html('0.00');
        $("#card_amount").val((0));
        $("#cash_amount").val(0);
        $("#advance_amount").val((0));
        $("#credit_amount").val(0);
        $("#cart-value").html('0.00');
        $("#madvance").html('0.00');
        $("#cart-topay").html('0.00');
        $("#cart-discount").html('0.00');
        $("#mtotal").html('0.00');
        $("#mnetpay").html('0.00');
        $("#mdiscount").html('0.00');
        $("#changeLable").html('Change/Refund');
        availibleOutstand=0;
        creditLimit =0;
        outstanding =0;
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicedetail/'+inv,
      dataType: 'json',
      success: function(data) {
        
        blockPayment(data.IsPayment);
        creditLimit =parseFloat(data.cus.CreditLimit);
        outstanding =parseFloat(data.cus.CusOustandingAmount);
        availibleOutstand =creditLimit-outstanding;
        cusCode=data.customerCode;
        cusType=data.cus.payMethod;
        total=data.JobTotalAmount;
        totalDiscount=data.JobTotalDiscount;
        $('#mtotal').html(accounting.formatMoney(data.JobTotalAmount));
        $('#mdiscount').html(accounting.formatMoney(data.JobTotalDiscount));
        $('#mnetpay').html(accounting.formatMoney(data.JobNetAmount-data.JobAdvance));
        $('#madvance').html(accounting.formatMoney(data.JobAdvance));
        $('#mvat').html(accounting.formatMoney(data.JobVatAmount));
        $('#mnbt').html(accounting.formatMoney(data.JobNbtAmount));
        $('#lblcreditLimit').html(accounting.formatMoney(creditLimit));
        $('#lblcredit').html(accounting.formatMoney(outstanding));
        $('#lblavaLimit').html(accounting.formatMoney(availibleOutstand));
          
          toPay=parseFloat(data.JobNetAmount-data.JobAdvance);
          if(cusType==2){
            $("#credit_amount").prop("disabled",false);
          }else{
            $("#credit_amount").prop("disabled",true);
          }
      }
    });
 }


$('#invoiceNo').autocomplete({
  autoFocus: true,
  minLength: 0,
  source: function (request,response) {
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicejson',
      dataType: 'json',
      data: {q:request.term},
      success: function(data) {
        response($.map(data,function(item) {
          return {label: item.text,value: item.text,data: item}
        }));
      }
    });
  },select: function(event,ui) {
 inv=(ui.item.label);
    $("#mcash").html('0.00');
        $("#mcard").html('0.00');
        $("#mcredit").html('0.00');
        $("#mchange").html('0.00');
        $("#advance_amount").val((0));
        $("#card_amount").val((0));
        $("#cash_amount").val(0);
        $("#credit_amount").val(0);
        $("#cart-value").html('0.00');
        $("#madvance").html('0.00');
        $("#cart-topay").html('0.00');
        $("#cart-discount").html('0.00');
        $("#mtotal").html('0.00');
        $("#mnetpay").html('0.00');
        $("#mdiscount").html('0.00');
        $("#changeLable").html('Change/Refund');
        availibleOutstand=0;
        creditLimit =0;
        outstanding =0;
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicedetail/'+inv,
      dataType: 'json',
      success: function(data) {
        if(data.JJobType==1){
            $("#companyInput").show();
        }else{
            $("#companyInput").hide();
        }
        blockPayment(data.IsPayment);
        creditLimit =parseFloat(data.cus.CreditLimit);
        outstanding =parseFloat(data.cus.CusOustandingAmount);
        availibleOutstand =creditLimit-outstanding;

        cusCode=data.customerCode;
        cusType=data.cus.payMethod;
        total=data.JobTotalAmount;
        totalDiscount=data.JobTotalDiscount;
        $('#mtotal').html(accounting.formatMoney(data.JobTotalAmount));
          $('#mdiscount').html(accounting.formatMoney(data.JobTotalDiscount));
          $('#mnetpay').html(accounting.formatMoney(data.JobNetAmount-data.JobAdvance));
          $('#madvance').html(accounting.formatMoney(data.JobAdvance));
          $('#mvat').html(accounting.formatMoney(data.JobVatAmount));
          $('#mnbt').html(accounting.formatMoney(data.JobNbtAmount));
          $('#lblcreditLimit').html(accounting.formatMoney(creditLimit));
          $('#lblcredit').html(accounting.formatMoney(outstanding));
          $('#lblavaLimit').html(accounting.formatMoney(availibleOutstand));
          toPay=parseFloat(data.JobNetAmount-data.JobAdvance);

          if(cusType==2){
            $("#credit_amount").prop("disabled",false);
          }else{
            $("#credit_amount").prop("disabled",true);
          }
      }
    });
  }
});

    var ccard = [];
    $("#addCard").click(function() {
        var cref = $("#card_ref").val();
        var ctype = $("#card_type option:selected").val();
        var cname = $("#card_type option:selected").html();
        var camount = parseFloat($("#ccard_amount").val());
        var ccTypeArrIndex = $.inArray(ctype, ccard);
        if (ctype == '' || ctype == 0) {
            $("#errCard").show();
            $("#errCard").html('Please select a card type').addClass('alert alert-danger alert-sm');
            $("#errCard").fadeOut(1500);
            return false;
        } else if (camount == '' || camount == 0) {
            $("#errCard").show();
            $("#errCard").html('Please enter card amount').addClass('alert alert-danger alert-xs');
            $("#errCard").fadeOut(1500);
            return false;
        } else {
            if (ccTypeArrIndex < 0) {
                $("#tblCard tbody").append("<tr ctype='" + ctype + "'  cref='" + cref + "'  camount='" + camount + "' cname='" + cname + "' ><td>" + cname + "</td><td>" + cref + "</td><td class='text-right'>" + accounting.formatMoney(camount) + "</td><td><a href='#' class='btn btn-danger removeCard' ><i class='fa fa-close'></i></a></td></tr>");
                ccard.push(ctype);
                cardAmount += camount;
               addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
                $("#card_amount").val((cardAmount));
                $("#card_ref").val('');
                $("#card_type").val(0);
                $("#ccard_amount").val(0);
                $("#card_receipt_amount").val(cardAmount);
            } else {
                $("#errCard").show();
                $("#errCard").html('Card type already exist').addClass('alert alert-danger alert-sm');
                $("#errCard").fadeOut(1500);
            }
        }

    });


$("#addCredit").click(function() {

    if(creditAmount>availibleOutstand){
        $.notify("Sorry, Credit Limit is Exceed. Please use another payment method.", "danger");
        return false;
    }else{
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
         if(isThridPay==1){

         }else{
            if (dueAmount > 0 && cusType==2) {
                creditAmount+=dueAmount;
                $("#credit_amount").val((creditAmount));
            }else if(dueAmount>toPay){
                creditAmount-=dueAmount;
                $("#credit_amount2").val((creditAmount));
            }
         }
         addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
    }
     
       

    });

$("#addCredit2").click(function() {

     if(isThridPay==1){
        if (dueAmount > 0 && thirdCusType==2) {
            creditAmount2+=dueAmount;
            $("#credit_amount2").val((creditAmount2));
            $("#changeLable").html('Due');
            $("#changeLable").css({"color": "red", "font-size": "100%"});
            $("#mchange").css({"color": "red", "font-size": "150%"});
        }else{
            creditAmount2-=dueAmount;
            $("#credit_amount2").val((creditAmount2));
          
        }
     }else{
        
     }
     addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
       

    });

    $("#tblCard tbody").on('click', '.removeCard', function() {
        $(this).parent().parent().remove();
        var removeItem = $(this).parent().parent().attr('ctype');
        ccard = jQuery.grep(ccard, function(value) {
            return value != removeItem;
        });
        cardAmount -= parseFloat($(this).parent().parent().attr('camount'));
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        $("#card_amount").val((cardAmount));
        $("#card_receipt_amount").val(cardAmount);
    });

function addPayment(pcash, pcredit,pbank, pcard,pcheque,padvance,tcash, tcredit, tcard,tcheque,pcusType,tcusType) {
    dueAmount = toPay - parseFloat(pcash +pbank+ pcard+pcheque+pcredit+padvance+tcash + tcard+tcheque+tcredit);
        if(isThridPay==1){
            if (dueAmount > 0 && tcusType==2) {
                $("#credit_amount2").val((tcredit));
                $("#changeLable").html('Due');
                $("#changeLable").css({"color": "red", "font-size": "100%"});
                $("#mchange").css({"color": "red", "font-size": "150%"});
            }else if (dueAmount > 0 && tcusType!=2) {
                 $("#credit_amount2").val((0));
                $("#changeLable").html('Due');
                $("#changeLable").css({"color": "red", "font-size": "100%"});
                $("#mchange").css({"color": "red", "font-size": "150%"});
            } else {
                dueAmount = Math.abs(dueAmount);
                $("#changeLable").html('Change/Refund');
                $("#changeLable").css({"color": "green", "font-size": "100%"});
                $("#mchange").css({"color": "green", "font-size": "150%"});
            }         
        }else{
           if (dueAmount > 0 && pcusType==2) {
                $("#credit_amount").val((pcredit));
                $("#changeLable").html('Due');
                $("#changeLable").css({"color": "red", "font-size": "100%"});
                $("#mchange").css({"color": "red", "font-size": "150%"});
                $("input[name='allowThirdPay']").prop('disabled',false);
            }else if (dueAmount > 0 && pcusType!=2) {
                 $("#credit_amount").val((0));
                $("#changeLable").html('Due');
                $("#changeLable").css({"color": "red", "font-size": "100%"});
                $("#mchange").css({"color": "red", "font-size": "150%"});
                $("input[name='allowThirdPay']").prop('disabled',false);
            } else {
                dueAmount = Math.abs(dueAmount);
                $("#changeLable").html('Change/Refund');
                $("#changeLable").css({"color": "green", "font-size": "100%"});
                $("#mchange").css({"color": "green", "font-size": "150%"});
                $("input[name='allowThirdPay']").prop('disabled',true);
            }
        }

        cusTotal=parseFloat(pcash +pbank+ pcard+pcheque+pcredit+padvance);
        tcusTotal=parseFloat(tcash + tcard+tcheque+tcredit);

        $("#mcash").html(accounting.formatMoney(pcash));
        $("#mbank").html(accounting.formatMoney(pbank));
        $("#mcard").html(accounting.formatMoney(pcard));
        $("#mcredit").html(accounting.formatMoney(pcredit));
        $("#mcheque").html(accounting.formatMoney(pcheque));
        $("#madvance").html(accounting.formatMoney(padvance));
        $("#mcompany").html(accounting.formatMoney(cusTotal));

        $("#mcash2").html(accounting.formatMoney(tcash));
        $("#mcard2").html(accounting.formatMoney(tcard));
        $("#mcredit2").html(accounting.formatMoney(tcredit));
        $("#mcheque2").html(accounting.formatMoney(tcheque));
        $("#mcompany2").html(accounting.formatMoney(tcusTotal));

        $("#mchange").html(accounting.formatMoney(dueAmount));
        if((cusTotal+tcusTotal)>=toPay){
            $("#saveInvoice").attr('disabled', false);
        }else{
            $("#saveInvoice").attr('disabled', true);
        }
}


    $("#cheque_amount").keyup(function() {
        chequeAmount = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
        $("#cheque_receipt_amount").val(chequeAmount);
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        if(chequeAmount>0){
            $("#chequeData").show();
        }else{
            $("#chequeData").hide();
        }
    });

    $("#cash_amount").keyup(function() {
        cashAmount = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
       creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
    });

    $("#bank_amount").keyup(function() {
        bankAmount = parseFloat($(this).val());
        cashAmount = parseFloat($("#cash_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
       creditAmount=0;
       if(bankAmount>0){
            $("#bankData").show();
        }else{
            $("#bankData").hide();
        }

       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
    });

    $("#credit_amount").keyup(function() {
        creditAmount = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
        if(creditAmount>availibleOutstand){
            $.notify("Sorry, Credit Limit is Exceed. Please use another payment method.", "danger");
            return false;
        }else{
            addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        }
    });


    $("#advance_amount").keyup(function() {
        advanceAmount = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());

         addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
    });

    $("#cash_amount").blur(function() {
        cashAmount = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
        creditAmount=0;
       $("#credit_amount").val(0);
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
    });

    $("#credit_amount").blur(function() {
        creditAmount = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
        if(creditAmount>availibleOutstand ){
            $.notify("Sorry, Credit Limit is Exceed. Please use another payment method.", "danger");
            return false;
        }else{
            addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        }
    });


     $("#cheque_amount2").keyup(function() {
        chequeAmount2 = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        if(chequeAmount>0){
            $("#chequeData2").show();
        }else{
            $("#chequeData2").hide();
        }
    });

    $("#cash_amount2").keyup(function() {
        cashAmount2 = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount = parseFloat($("#cash_amount").val());
        creditAmount2 = parseFloat($("#credit_amount2").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
        creditAmount2=0;
       $("#credit_amount2").val(0);
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        });

    $("#credit_amount2").keyup(function() {
        creditAmount2 = parseFloat($(this).val());
        bankAmount = parseFloat($("#bank_amount").val());
        advanceAmount = parseFloat($("#advance_amount").val());
        cashAmount = parseFloat($("#cash_amount").val());
        cardAmount = parseFloat($("#card_amount").val());
        companyAmount = parseFloat($("#company_amount").val());
        chequeAmount = parseFloat($("#cheque_amount").val());
        chequeAmount2 = parseFloat($("#cheque_amount2").val());
        cashAmount2 = parseFloat($("#cash_amount2").val());
        creditAmount = parseFloat($("#credit_amount").val());
        cardAmount2 = parseFloat($("#card_amount2").val());
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
    });

    function saveInvoice() {

        var ccRef = new Array();
        var ccAmount = new Array();
        var ccType = new Array();
        var ccName = new Array();
        var ccRef2 = new Array();
        var ccAmount2 = new Array();
        var ccType2 = new Array();
        var ccName2 = new Array();

        var location = $("#location").val();
        var invUser = $("#invUser").val();
        var invfname = $("#invfname").val();
        var invDate=$('#invDate').val();
        var payRemark=$('#pay_remark').val();

        var chequeDate = $("#chequeDate").val();
        var chequeReference = $("#chequeReference").val();
        var chequeReciveDate = $('#chequeReciveDate').val();
        var chequeNo = $('#chequeNo').val();
        var bank = $("#bank option:selected").val();
        var bank_acc = $("#bank_acc option:selected").val();

        var chequeDate2 = $("#chequeDate2").val();
        var chequeReference2 = $("#chequeReference2").val();
        var chequeReciveDate2 = $('#chequeReciveDate2').val();
        var chequeNo2 = $('#chequeNo2').val();
        var bank2 = $("#bank2 option:selected").val();

        var commission = $('#commission').val();
        var com_paidto = $('#com_paidto').val();

        var cardReceiptAmount =parseFloat($('#card_receipt_amount').val());
        var chequeReceiptAmount =parseFloat($('#cheque_receipt_amount').val());
        var part_invoice_no =parseFloat($('#part_invoice_no').val());

        cusPayment = cashAmount + cardAmount+ bankAmount+chequeAmount+advanceAmount+cashAmount2 + cardAmount2+chequeAmount2;

        $('#tblCard tbody tr').each(function(rowIndex, element) {
            ccAmount.push($(this).attr('camount'));
            ccRef.push($(this).attr('cref'));
            ccType.push($(this).attr('ctype'));
            ccName.push($(this).attr('cname'));
        });

        var ccAmountArr = JSON.stringify(ccAmount);
        var ccRefArr = JSON.stringify(ccRef);
        var ccTypeArr = JSON.stringify(ccType);
        var ccNameArr = JSON.stringify(ccName);

        $('#tblCard2 tbody tr').each(function(rowIndex, element) {
            ccAmount2.push($(this).attr('camount'));
            ccRef2.push($(this).attr('cref'));
            ccType2.push($(this).attr('ctype'));
            ccName2.push($(this).attr('cname'));
        });

        var ccAmountArr2 = JSON.stringify(ccAmount2);
        var ccRefArr2 = JSON.stringify(ccRef2);
        var ccTypeArr2 = JSON.stringify(ccType2);
        var ccNameArr2 = JSON.stringify(ccName2);
        
       if ((toPay == '' || (toPay == 0)) ) {
            $.notify("Error. Please select an invoice.", "danger");
            return false;
        }else if ((cusTotal+tcusTotal) < toPay) {
            $.notify("Error. Please check the total payment.", "danger");
            return false;
        } else if (creditAmount > 0 && (cusCode == 0)) {
            $.notify("Error. Please select a customer.", "danger");
            return false;
        } else if (creditAmount == 0 && (cashAmount == 0) && (cardAmount == 0) && (chequeAmount == 0)) {
            $.notify("Error. Please cash amount.", "danger");
            return false;
        }else {
            $("#saveInvoice").attr('disabled', true);
            $.ajax({
                type: "post",
                url: "<?php echo base_url('admin') ?>/Payment/saveJobPayment",
                data: {invNo:inv,commission:commission, com_paidto:com_paidto, cusCode: cusCode,thirdcusCode: thirdcusCode, invDate: invDate, invUser: invUser, cash_amount: cashAmount,bank_acc:bank_acc,bank_amount: bankAmount, company_amount: companyAmount,card_amount: cardAmount,advance_amount: advanceAmount, advance_payment_no: advance_payment_no, credit_amount: creditAmount,cheque_amount: chequeAmount,cash_amount2: cashAmount2, company_amount2: companyAmount2,card_amount2: cardAmount2, credit_amount2: creditAmount2,cheque_amount2: chequeAmount2, total_amount: total, cusPayment: cusPayment, return_amount: 0, refund_amount: 0,
                    total_discount: totalDiscount, final_amount: toPay,cardReceiptAmount:cardReceiptAmount,chequeReceiptAmount:chequeReceiptAmount,part_invoice_no :part_invoice_no,location: location, ccAmount: ccAmountArr, ccRef: ccRefArr, ccType: ccTypeArr, ccName: ccNameArr,chequeNo:chequeNo,bank: bank, chequeReference: chequeReference, chequeRecivedDate: chequeReciveDate, chequeDate: chequeDate,ccAmount2: ccAmountArr2, ccRef2: ccRefArr2, ccType2: ccTypeArr2, ccName2: ccNameArr2,chequeNo2:chequeNo2,bank2: bank2, chequeReference2: chequeReference2, chequeRecivedDate2: chequeReciveDate2, chequeDate2: chequeDate2,payRemark:payRemark},
                        success: function(data) {
                            var resultData = JSON.parse(data);
                            var feedback = resultData['fb'];
                            var invNumber = resultData['InvNo'];
                            var invoicedate = resultData['InvDate'];
                            if (feedback != 1) {
                                $.notify("Error. Payment not saved successfully.", "danger");
                                $("#saveInvoice").attr('disabled', false);
                                return false;
                            } else {
                                if(chequeAmount>0){
                                    printchequeReceipt(invNumber,'Cheque');
                                }
                                
                                if(cardAmount>0){
                                    printcardReceipt(invNumber,'Card');
                                }
                                $.notify("Payment saved successfully.", "success");
                                $("#saveInvoice").attr('disabled', true);
                            }
                        }
            });
        }
    }

     $("#saveInvoice").click(function() {
        saveInvoice();
    });

     function blockPayment(ispay){
        if(ispay==1){
            $("#saveInvoice").attr('disabled', true);
            $.notify("Sorry. Payment already done.", "danger");
        }else{
            $("#saveInvoice").attr('disabled', false);
        }
     }
     $("#payTab").tabs();
    $("#payTab").tabs("option","disabled", [1]);
    $("#allowThirdPay").change(function() {
        if(this.checked) {
            $( "#payTab" ).tabs( "enable", 1 );
        }else{
            $("#payTab").tabs("option","disabled", [1]);
        }
    });


    var ccard2 = [];
    $("#addCard2").click(function() {
        var cref2 = $("#card_ref2").val();
        var ctype2 = $("#card_type2 option:selected").val();
        var cname2 = $("#card_type2 option:selected").html();
        var camount2 = parseFloat($("#ccard_amount2").val());
        var ccTypeArrIndex2 = $.inArray(ctype2, ccard2);
        if (ctype2 == '' || ctype2 == 0) {
            $("#errCard2").show();
            $("#errCard2").html('Please select a card type').addClass('alert alert-danger alert-sm');
            $("#errCard2").fadeOut(1500);
            return false;
        } else if (camount2 == '' || camount2 == 0) {
            $("#errCard2").show();
            $("#errCard2").html('Please enter card amount').addClass('alert alert-danger alert-xs');
            $("#errCard2").fadeOut(1500);
            return false;
        } else {
            if (ccTypeArrIndex2 < 0) {
                $("#tblCard2 tbody").append("<tr ctype='" + ctype2 + "'  cref='" + cref2 + "'  camount='" + camount2 + "' cname='" + cname2 + "' ><td>" + cname2 + "</td><td>" + cref2 + "</td><td class='text-right'>" + accounting.formatMoney(camount2) + "</td><td><a href='#' class='btn btn-danger removeCard' ><i class='fa fa-close'></i></a></td></tr>");
                ccard2.push(ctype2);
                cardAmount2 += camount2;
               addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
                $("#card_amount2").val((cardAmount2));
                $("#card_ref2").val('');
                $("#card_type2").val(0);
                $("#ccard_amount2").val(0);
            } else {
                $("#errCard2").show();
                $("#errCard2").html('Card type already exist').addClass('alert alert-danger alert-sm');
                $("#errCard2").fadeOut(1500);
            }
        }

    });

    $("#tblCard2 tbody").on('click', '.removeCard', function() {
        $(this).parent().parent().remove();
        var removeItem = $(this).parent().parent().attr('ctype');
        ccard2 = jQuery.grep(ccard2, function(value) {
            return value != removeItem;
        });
        cardAmount2 -= parseFloat($(this).parent().parent().attr('camount'));
        addPayment(cashAmount, creditAmount,bankAmount, cardAmount,chequeAmount,advanceAmount,cashAmount2, creditAmount2, cardAmount2,chequeAmount2,cusType,thirdCusType);
        $("#card_amount2").val((cardAmount2));
    });


    $("#third_party_customer").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../payment/loadcustomersjson',
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            thirdcusCode = ui.item.value;
            $("#tbl_payment tbody").html("");
            total_due_amount = 0;
            total_over_payment = 0;

            $.ajax({
                type: "POST",
                url: "../../Payment/getCustomersDataById",
                data: { cusCode: thirdcusCode},
                success: function(data)
                {
                    var resultData = JSON.parse(data);
                    if(cusCode==resultData.cus_data.CusCode){
                        $.notify("Third party customer Already exists. Sorry you can't select same customer. ", "warning");
                        thirdcusCode=0;
                    }else{
                        thirdcusCode = resultData.cus_data.CusCode;
                    thirdCusType=resultData.cus_data.payMethod;

                    if(thirdCusType==2){
                        $("#credit_amount2").prop("disabled",false);
                      }else{
                        $("#credit_amount2").prop("disabled",true);
                      }
                      $("#cash_amount2").prop("disabled",false);
                        $("#cheque_amount2").prop("disabled",false);
                        $("#ccard_amount2").prop("disabled",false);
                    }

                    

                   
                }
            });


        }


    });


function printcardReceipt(payNo,payType){
        $("#cardPrint").prop("disabled",false);
        $.ajax({
            type: "POST",
            url: "../../Payment/getReceiptPaymentByInvoice",
            data: {payNo:payNo,payType:'Card'},
            success: function(data)
            {
                var resultData = JSON.parse(data);
                
                if(resultData.pay){
                    $("#rcpdate,#rcpdate1").html(resultData.pay.JobInvDate);
                    $("#rcpreceiptno,#rcpreceiptno1").html(resultData.pay.ReceiptNo);
                    $("#rcpamountword,#rcpamountword1").html(resultData.pay_amount);
                    $("#rcpreason,#rcpreason1").html(resultData.pay.Remark);
                    $("#rcpcusname,#rcpcusname1").html(resultData.pay.RespectSign+" "+resultData.pay.CusName);
                    $("#rcpcusaddress,#rcpcusaddress1").html(nl2br(resultData.pay.Address01));
                    $("#rcpcuscode,#rcpcuscode1").html(resultData.pay.CusCode);
                    $("#rcpamount,#rcpamount1").html(accounting.formatMoney(resultData.pay.ReceiptAmount));
                    $("#rcpchequeno,#rcpchequeno1").html(resultData.pay.Mode+" "+resultData.pay.Reference);
                     $("#rcppaytype,#rcppaytype1").html(resultData.pay.JobInvPayType+" Payment");
                      $("#rcpinvno,#rcpinvno1").html(resultData.pay.JobInvNo);
                    $("#rcpvno,#rcpvno1").html(resultData.pay.JRegNo);
                }

            }
        });
    }

    function printchequeReceipt(payNo,payType){
        $("#chequePrint").prop("disabled",false);
        $.ajax({
            type: "POST",
            url: "../../Payment/getReceiptPaymentByInvoice",
            data: {payNo:payNo,payType:'Cheque'},
            success: function(data)
            {
                var resultData = JSON.parse(data);
                
                if(resultData.pay){
                    $("#chq_rcpdate,#chq_rcpdate1").html(resultData.pay.JobInvDate);
                    $("#chq_rcpreceiptno,#chq_rcpreceiptno1").html(resultData.pay.ReceiptNo);
                    $("#chq_rcpamountword,#chq_rcpamountword1").html(resultData.pay_amount);
                    $("#chq_rcpreason,#chq_rcpreason1").html(resultData.pay.Remark);
                    $("#chq_rcpcusname,#chq_rcpcusname1").html(resultData.pay.RespectSign+" "+resultData.pay.CusName);
                    $("#chq_rcpcusaddress,#chq_rcpcusaddress1").html(nl2br(resultData.pay.Address01));
                    $("#chq_rcpcuscode,#chq_rcpcuscode1").html(resultData.pay.CusCode);
                    $("#chq_rcpamount,#chq_rcpamount1").html(accounting.formatMoney(resultData.pay.ReceiptAmount));
                    $("#chq_rcpchequeno,#chq_rcpchequeno1").html(resultData.pay.ChequeNo);
                    $("#chq_rcpbank,#chq_rcpbank1").html(resultData.pay.BankName);
                     $("#chq_rcpchequedate,#chq_rcpchequedate1").html(resultData.pay.ChequeDate);
                     $("#chq_rcppaytype,#chq_rcppaytype1").html(resultData.pay.JobInvPayType+" Payment");
                      $("#chq_rcpinvno,#chq_rcpinvno1").html(resultData.pay.JobInvNo);
                    $("#chq_rcpvno,#chq_rcpvno1").html(resultData.pay.JRegNo);
                }

            }
        });
    }

    var com_paidto='';

    $("#com_paidto").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../../payment/loadcustomersjson',
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            com_paidto = ui.item.value;
        }
    });

    $("#chequePrint").click(function(){
        $("#printArea3").print();
    });

    $("#cardPrint").click(function(){
        $("#printArea2").print();
    });

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

</script>