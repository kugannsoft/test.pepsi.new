<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php //echo $pagetitle; ?>
        <?php //echo $breadcrumb; ?>
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
        <div class="row gui-row-tag">
            <div class="meta-row col-lg-12 col-md-12">
                <div class="box box-primary direct-chat direct-chat-primary" id="product-list-wrapper" style="visibility: visible;">
                    <div class="box-header with-border">
                        <form action="" method="post" id="search-item-form">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-large btn-primary btn-lg">Search</button>
                                </span>
                                <input type="text" autofocus id="search_product" name="item_sku_barcode" placeholder="Barcode, Serial Number, Product name or code ..." class="form-control input-lg">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-success btn-lg" id="SHGrid" bound="true"><i class="fa fa-plus-circle"></i> Show/Hide Grid</button>
                                    <!--<a class="btn btn-default"  data-target="#modelInvoice"  data-toggle="modal" alt="Note" ><i class="fa fa-pencil"></i> Note</a>-->
                                </span>
                            </div>
                        </form>
                    </div>
                    <div id="suggestPanel" class="box-body" style="visibility: visible;">
                        <span id="errGrid"></span>
                        <div class="direct-chat-messages item-list-container nscroll" style="padding: 0px; height: 200px;">
                            <div class="row" id="filter-list" style="padding-left:0px;padding-right:0px;margin-left:0px;margin-right:0px;">

                            </div>
                        </div>
                    </div>
                    <div class="overlay" id="product-list-splash" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
            <div class="meta-row col-lg-12 col-md-12">
                <div class="box box-primary direct-chat direct-chat-primary" id="cart-details-wrapper" style="visibility: visible;">
                    <div class="box-header with-border" id="cart-header">

                        <!--<div class="row">-->
                        <div class="col-lg-12 input-group">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"> Price Level</span>
                                <div class="input-group">

                                    <!--<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="Walkin Customer">-->
                                    <select class="form-control" id="prLevel">
                                        <?php foreach ($plv as $pl) { ?>
                                            <option value="<?php echo $pl->PL_No; ?>" <?php if ($pl->PL_No == 1) {
                                            echo 'selected';
                                        }
                                            ?>><?php echo $pl->PriceLevel; ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div> 
                            <!--<div class="input-group">-->
                            <span class="input-group-btn">
                        <!--<button type="button" class="btn btn-primary cart-add-customer" id="addCustomer" ><i class="fa fa-user"></i> Add a customer</button>-->
<!--                                <button type="button" class="btn btn-success" id="SHGrid" bound="true"><i class="fa fa-plus-circle"></i> Show/Hide Grid</button>-->
                            </span>

                            <!--</div>-->
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Please choose a customer</span>
                            <select name="customer_id" id="customer_id"  class="selectpicker form-control" >
                                <option value="0">Customer</option>
                                <?php foreach ($customers as $pl) { ?>
                                    <option value="<?php echo $pl->CusCode; ?>"><?php echo $pl->CusName; ?></option>
<?php } ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary cart-add-customer" id="addCustomer" ><i class="fa fa-user"></i> Add a customer</button>
                            </span>
                        </div>

                    </div>
                    <style>
                        #cart-item-table-header td{font-size:15px;}#cart-table-body td,#cart-details td{font-size:20px;}
                    </style>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table" id="cart-item-table-header" >
                            <thead>
                                <tr class="active">
                                    <td width="50" class="text-left">#</td>
                                    <td width="50" class="text-left"></td>
                                    <td width="210" class="text-left">Items</td>
                                    <td width="130" class="text-right">Unit Price</td>
                                    <td width="145" class="text-right">Quantity</td>
                                    <td width="145" class="text-right">Free quantity</td>
                                    <td width="145" class="text-right">Discount</td>
                                    <td width="115" class="text-right">Total Price</td>
                                    <td width="50" class="text-right"></td>
                                </tr>
                            </thead>
                        </table>
                        <div class="direct-chat-messages nscroll" id="cart-table-body" style="padding: 0px; height: 193px;">
                            <table class="table table-hover table-striped" style="margin-bottom:0;">                
                                <tbody><tr id="cart-table-notice"><td colspan="4">Please add an item</td></tr></tbody>
                            </table>
                        </div>
                        <table class="table" id="cart-details">
                            <tfoot>
                                <tr class="active">
                                    <td width="230" class="text-left" style="font-size:15px;">No Of Items - <span id="itemCount">0</span></td>
                                    
                                    <td width="130" class="text-right"></td>
                                    <td width="130" class="text-right">
                                        Total:                    </td>
                                    <td width="110" class="text-right"><span id="cart-value">LKR 0.00 </span></td>
                                </tr>
                                <tr class="active">
                                    <td colspan="2" width="380" class="text-right cart-discount-notice-area" ><span id="errPrint" class="pull-left"></span></td>
                                    <td width="130" class="text-right">Discount</td>
                                    <td width="110" class="text-right"><span id="cart-discount">LKR 0.00 </span></td>
                                </tr>
                                <tr class="success">
                                    <td width="230" class="text-right">
                                         <div class="input-group pull-left">
                                        <label for="ismultiprice" class="control-label">
                                            <input  class="prd_icheck"  type="checkbox" name="disablePrint" id="disablePrint" value="1">
                                            Disable Print
                                        </label>
                                    </div>
                                    </td>
                                    <td width="130" class="text-right"></td>
                                    <td width="130" class="text-right"><strong>Net Payable</strong></td>
                                    <td width="110" class="text-right"><strong><span id="cart-topay">LKR 0.00 </span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" id="cart-panel">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button"  class="btn btn-warning btn-lg" id="savePrint" style="margin-bottom:0px;">
                                    <i class="fa fa-money"></i>
                                    Print            
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button data-target="#modelPayment" type="button"  data-toggle="modal" class="btn btn-primary btn-lg" id="cart-pay-button" style="margin-bottom:0px;">
                                    <i class="fa fa-money"></i>
                                    Payment            
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button data-target="#modelTotalDis" type="button"  data-toggle="modal" class="btn btn-success btn-lg" id="cart-discount-button" style="margin-bottom:0px;">
                                    <i class="fa fa-gift"></i>
                                    Discount			
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-danger btn-lg" id="cart-return-to-order" style="margin-bottom:0px;"> <!-- btn-app  -->
                                    <i class="fa fa-remove"></i>
                                    Cancel			
                                </button>
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                <input type="hidden" name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                <input type="hidden" name="invfname" id="invfname" value="<?php echo $_SESSION['fname'] ?>">
                            </div>

                        </div>
                    </div>
                    <span id="lastInv" class="pull-left"> Last Invoice - </span>
                    <!-- /.box-footer--> 
                </div>

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

    <!--product modal-->
    <div class="modal fade bs-bill-modal-lg" id="modelBilling" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <!--<form role="form" id="addDep" data-parsley-validate>-->
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Add products</h4>
                        <span id="top"></span>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-6 col-sm-12">
                                    <label id="errProduct"></label>
                                    <div class="form-group">
                                        <label for="mLProCode" class="col-sm-4 control-label">Product Code</label>
                                        <div class="col-sm-6"><span id="mLProCode"></span><input type="hidden" required="required" disabled class="form-control input-lg" name="mProCode" id="mProCode" >
                                            <input type="hidden" required="required" disabled class="form-control" name="mWarrnty" id="mWarrnty" >
                                        </div> <br>
                                    </div>
                                    <div class="form-group">
                                        <label for="mProName" class="col-sm-4 control-label">Product Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" required="required" disabled class="form-control input-lg" name="mProName" id="mProName">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Selling Price</label>
                                        <div class="col-sm-6"><input type="number" required="required" min="1" step="1" class="form-control input-lg"  name="mSellPrice" id="mSellPrice" placeholder="Enter selling price">
                                            <input type="hidden" required="required" class="form-control" name="mCostPrice" id="mCostPrice" ></div> <br>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Unit Or Case</label>
                                        <div class="col-sm-6">
                                            <select required="required" class="form-control input-lg" name="mUnit" id="mUnit">
                                                <option value="Unit">Unit</option>
                                                <option value="Case">Case</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Quantity</label>
                                        <div class='col-sm-6 '><input type='number' name='mQty' id="mQty" min="1" value='1' class='form-control input-lg' aria-describedby='sizing-addon3'></div>
                                        <input type="hidden" required="required" class="form-control" name="mUpc" id="mUpc">
                                    </div>
                                    <div class="form-group" id="dv_FreeQty">
                                        <label class="col-sm-4 control-label">Free Quantity</label>
                                        <div class="col-sm-6"><input type="text" required="required" class="form-control input-lg" name="mFreeQty" id="mFreeQty" value="0" placeholder="Free Qty"></div>
                                    </div>
                                    <div class="form-group"  id="dv_SN">
                                        <label class="col-sm-4 control-label">Serial Number</label>
                                        <div class="col-sm-6"><input type="text" required="required" class="form-control input-lg" name="mSerial" id="mSerial" placeholder="Serial Number">
                                            <input type="hidden" required="required" class="form-control input-lg" name="isSerial" id="isSerial" placeholder="Serial Number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Sale Ref</label>
                                        <div class="col-sm-6"><select name="mRef" id="mRef"  class="form-control input-lg" >
                                                <option value="0">Select a sale ref</option>
                                                <?php foreach ($salePerson as $sp) { ?>
                                                    <option value="<?php echo $sp->RepID; ?>"><?php echo $sp->RepName; ?></option>
<?php } ?>
                                            </select></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h4 class="text-center">Apply Product Wise Discount <span class="discount_type">: <span class="label label-warning">Cash</span></span></h4>
                                        <div class="input-group">
                                            <span class="input-group-btn"><button class="btn btn-primary btn-lg percentage_discount " disType="1" val="1" type="button">Percentage</button></span>
                                            <input type="number" name="discount_value" id="proWiseDiscount" class="form-control input-lg" min="0" step="5" placeholder="Define the amount or percentage here...">
                                            <span class="input-group-btn"><button class="btn btn-warning flat_discount btn-lg active" disType="1"  val="2" type="button">Cash</button></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="addProduct" class="btn btn-primary btn-lg">Add Product</button>
                    </div>

                </div>
            <!--</form>-->
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

    <!--payment model-->
    <div class="modal fade bs-payment-modal-lg" id="modelPayment" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Payment Details <span id="errPayment"></span></h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-4">

                                    <!--<div class="form-group">-->
                                        <!--<h4 class="text-center">Payment Type : <span class="discount_type">: <span class="label label-primary">percentage</span></span></h4>-->
                                    <div class="input-group">
                                        <span class="input-group-addon label-success">Cash Amount</span>
                                        <input type="number" name="cash_amount" id="cash_amount" min='0' value="0"  step="50"  class="form-control input-lg" placeholder="cash amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card Amount</span>
                                        <input type="number" disabled name="card_amount" id="card_amount" min='0' value="0"  class="form-control input-lg" placeholder="card amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Credit Amount</span>
                                        <input type="number" name="credit_amount" id="credit_amount" min='0'  value="0"  step="50"  class="form-control input-lg" placeholder="credit amount">
                                    </div>
                                    <table class="table table-hover">
                                        <tbody>

                                            <tr><td>Cash</td><td>:</td><td  id='mcash'  class='text-right'>0.00</td></tr>
                                            <tr><td>Card</td><td>:</td><td  id='mcard'  class='text-right'>0.00</td></tr>
                                            <tr><td>Credit</td><td>:</td><td  id='mcredit'  class='text-right'>0.00</td></tr>

                                        </tbody>
                                    </table>
                                    <!--</div>-->
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">Card type</span>
                                        <select name="card_type" id="card_type" class="form-control input-lg">
                                            <option value="0">Select a type</option>
                                            <option value="1">Visa</option>
                                            <option value="2">Master</option>
                                            <option value="3">Amex</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Reference</span>
                                        <input type="text" name="card_ref" id="card_ref"   class="form-control input-lg" placeholder="Reference">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Amount</span>
                                        <input type="number" name="ccard_amount" id="ccard_amount" min='0'  step="50"  value="0"  class="form-control input-lg" placeholder="card amount">
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

                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Total</td><td>:</td><td  id='mtotal'  class='text-right'>0.00</td></tr>
                                            <tr><td>Discount</td><td>:</td><td  id='mdiscount'  class='text-right'>0.00</td></tr>
                                            <tr><td>Net Payable</td><td>:</td><td  id='mnetpay'  class='text-right'>0.00</td></tr>
                                            <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table>

                                    
                                </div>
                            </form>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                           
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="saveInvoice" class="btn btn-success btn-lg">Confirm Payment</button>
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
                                </tr> <?php //} ?>
                                <tr style="text-align:center;font-size:25px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><b><?php echo $company['CompanyName2'] ?></b></td>
                                </tr>
                                <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
									<td colspan="4"> <?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?></td>
                                </tr><tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4"><?php echo $company['AddressLine03'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:25px;">
                                    <td colspan="4"><img valign="bottom" src="http://vcom.nsoft.lk/upload/phone.png" style="height:28px;">  &nbsp;<?php echo $company['LanLineNo'] ?></td>
                                </tr>
								<tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                                    <td colspan="4">Cash Invoice</td>
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
                                        <td style="text-align:center;border:#000 solid 1px;"> Qty</td>
                                        <td style="text-align:center;border:#000 solid 1px;">Price</td>
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


</script>