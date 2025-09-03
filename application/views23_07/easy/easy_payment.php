<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <style>
        .form-group {
            margin-bottom: 3px;
        }
        /*.thumbnail{margin-bottom: 5px;*/
            /*padding:4px 4px 4px 10px;*/
            /*border-radius: 1px;}*/

        /*.form-control {*/
            /*display: block;*/
            /*width: 100%;*/
            /*height: 28px;*/
            /*padding: 2px 10px;*/
        /*}*/

        /*.box{*/
            /*margin-bottom: 10px;*/
        /*}*/

        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-right: 5px;
            padding-left: 10px;
        }

        .input-group-addon {
            padding: 2px 3px;
        }
        #tbl_payment_schedule td {text-align: right;}
        #tbl_payment_schedule tfoot th {
            text-align: right;
            border-top: 1px solid #000;
            border-bottom: 1px double #000;
        }
        #tbl_payment_schedule .yr_row td{
            font-weight: bold;
            border-top: #000 1px solid;
        }
        .row {
            margin-right:0px;
            margin-left: 0px;
        }

        .required{
            color: red;
        }
    </style>

<div class="content-wrapper">
        <section class="content-header">
            <?php echo $pagetitle; ?>
            <?php echo $breadcrumb; ?>

        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-success">
                        <div class="row"><br>
                            <div class="col-md-4">
                                <form class="form-horizontal" >
                                    <div class="form-group">
                                        <label for="customer" style="text-align: left" class="col-sm-4 control-label">Account<span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="hidden" name="outAccNo"  id="outAccNo" value="<?php echo $ac_no; ?>">
<!--                                            <input type="hidden" name="success"  id="successRedirect" value="--><?php //echo $sr; ?><!--">-->
<!--                                            <input type="hidden" name="dwnInterest"  id="dwnInterest" value="--><?php //echo $dwn_int; ?><!--">-->
                                            <input type="text" class="form-control" required="required"  name="account_no" id="account_no" placeholder="Account No or Nic" value="<?php echo $ac_no; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="invDate" style="text-align: left" class="col-sm-4 control-label">Invoice Date <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" required="required"  name="invDate" id="invDate" placeholder="">
                                            <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                            <input type="hidden" class="form-control" required="required"  name="location" id="location" value="<?php echo $_SESSION['location'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="invDate" style="text-align: left" class="col-sm-4 control-label">Customer <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly="readonly" class="form-control" required="required"  name="cusName" id="cusName" placeholder="customer name">
                                            <input type="hidden" class="form-control" required="required"  name="customerCode" id="customerCode" value="">
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div  class="col-md-4">
                                <form class="form-horizontal" >

                                    <div class="form-group ">
<!--                                        <label for="isLot" style="text-align: left" class="col-sm-3 control-label">Type <span class="required">*</span></label>-->
                                        <div class="col-sm-10 thumbnail">
                                            Product &nbsp;<input type="radio" required="required" class="prd_icheck"  checked="checked" name="isLot" id="notLot" value="0">
                                            &nbsp; Loan  &nbsp;<input type="radio" required="required"  class="prd_icheck"  name="isLot" id="isLot" value="1">
                                            &nbsp; |Easy  &nbsp;<input type="radio" required="required"  class="prd_icheck"  name="payType" id="easyPay" value="2">
                                        </div>
                                    </div>
<!--                                    <div class="form-group ">-->
<!--                                        <label for="isLot" class="col-sm-3 control-label">Payment<span class="required">*</span></label>-->
<!--                                        <div class="col-sm-6 thumbnail">-->
                                            <!--                                                        Normal &nbsp;<input type="radio" required="required" class="prd_icheck"  checked="checked" name="payType" id="normalPay" value="1">-->
<!--                                            &nbsp; Easy  &nbsp;<input type="radio" required="required"  class="prd_icheck"  name="payType" id="easyPay" value="2">-->
<!--                                        </div>-->
<!--                                    </div>-->

                                </form>
                            </div>
                            <div  class="col-md-4">
                                <table>
                                    <tr>
                                        <td>Customer Name </td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><span id="city"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Customer Nic </td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><span id="cusCode"></span></td>
                                    </tr>
                                     <tr>
                                        <td>Referral No </td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><span id="referralNo"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Credit Limit </td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td class="text-right"><span  id="creditLimit"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Credit Period</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td  class="text-right"><span  id="cusOutstand"></span></td>
                                    </tr>
                                    <!--                                                <tr>
                                                                                        <td>Available Limit</td>
                                                                                        <td>:</td>
                                                                                        <td class="text-right"><span id="availableCreditLimit"></span> </td>
                                                                                    </tr>-->
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-md-4">
                                <div class="box-body">
                                    <form class="form-horizontal" id="formProduct">
                                        <span id="lbl_batch_no"></span>
                                        <div class="form-group">
                                            <label class="col-sm-4  control-label" style="text-align: left">Price Level</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" id="priceLevel">
                                                    <?php foreach ($pricelevel as $pricelevels) { ?>
                                                        <option value="<?php echo $pricelevels->PL_No; ?>"   <?php
                                                        if ($pricelevels->PL_No == 1) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo $pricelevels->PriceLevel; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="lbl_refCode">
                                                <label for="itemCode" style="text-align: left" class="col-sm-4 control-label">Product Code <span class="required"></span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" required="required"  name="itemCode" id="itemCode" placeholder="Enter Product Code" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="lbl_refCode">
                                                <!--<label for="itemCode" class="col-sm-4 control-label">&nbsp; <span class="required"></span></label>-->
                                                <div class="col-sm-10">
                                                    <span id="productName" class="pull-right" ></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="lotPriceLable" >
<!--                                            <div class="form-group">-->
<!--                                                <label class="col-sm-4  control-label" style="text-align: left">Loan Type</label>-->
<!--                                                <div class="col-sm-6">-->
<!--                                                    <select class="form-control" disabled id="loanType">-->
                                                        <!--<option value="">-Select-</option>-->
<!--                                                        --><?php //while ($row = mysqli_fetch_array($getLoanTypes)) { ?>
<!--                                                            <option value="--><?php //echo $row['SubDepNo']; ?><!--"   --><?php
                                                            //                                                                if ($row['CusTypeId'] == 2) {
                                                            //                                                                    echo 'selected';
                                                            //                                                                }
//                                                            ?><!--><?php //echo $row['Description']; ?><!--</option>-->
<!--                                                        --><?php //} ?>
<!--                                                    </select>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="text-align: left">Loan Amount</label>
                                                <div class="col-sm-6">
                                                    <input type="number" step="10000" id="lotPrice" value="<?php echo $balance; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="productLable" >
                                            <div class="form-group">
                                                <label for="sellingPrice" class="col-sm-4 control-label" style="text-align: left">Unit Price <span class="required">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" required="required"  name="sellingPrice" id="sellingPrice" placeholder="Enter Selling Price">
                                                    <input type="hidden" disabled class="form-control" required="required"  name="prdName" id="prdName" placeholder="Enter product Code">
                                                    <input type="hidden" class="form-control" required="required"  name="batchCode" id="batchCode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="product" class="col-sm-4 control-label" style="text-align: left">Qty <span class="required">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="number"  min="0" step="1" class="form-control" required="required"  name="qty" id="qty" placeholder="Enter Qty"  value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="product" class="col-sm-4 control-label" style="text-align: left">Serial No <span class="required">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" required="required"  name="serialNo" id="serialNo" placeholder="Enter Serial No"  value="">
                                                </div>
                                            </div>
                                            <!--                                                    <div class="form-group">
                                                                                                    <label for="product" class="col-sm-7 control-label">Product Wise Discount<span class="required">*</span></label>
                                                                                                    <div class="col-sm-3"><input type="radio" checked required="required" class="prd_icheck"  name="discount_type" id="productWise" value="1"></div>
                                                                                                </div>
                                                                                                 <div class="form-group">
                                                                                                    <label for="product" class="col-sm-7 control-label">Total Item Wise Discount<span class="required">*</span></label>
                                                                                                    <div class="col-sm-3"><input type="radio" required="required" class="prd_icheck"  name="discount_type" id="totalItemWise" value="2"></div>
                                                                                                </div>-->
                                            <div class="form-group"  >
                                                <div class="col-sm-10">
                                                    <label for="isCut" class="col-sm-6 control-label" style="border:1px solid #D2D6DE;font-size:11px;">Product Wise <span class="required"></span> <input type="radio" checked required="required" class="prd_icheck"  name="discount_type" id="productWise" value="1"></label>
                                                    <label for="isPolish" class="col-sm-6 control-label"  style="border:1px solid #D2D6DE;font-size:11px;">Total Item Wise <span class="required"></span> <input type="radio" required="required" class="prd_icheck"  name="discount_type" id="totalItemWise" value="2"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="buyAmount" class="col-sm-4 control-label" style="text-align: left">Discount %<span class="required"></span></label>
                                                <div class="col-sm-6 input-group">
                                                    <span class="input-group-addon"><input type="radio" class="prd_icheck" name="discount" checked value="1"></span>
                                                    <input type="number" min="0"  step="5" pattern="[0-9]*" class="form-control" required="required"  name="disPercent" id="disPercent" placeholder="Enter Discount Percentage" value="0">
                                                </div><div class="col-sm-7">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="totalNet" class="col-sm-4 control-label" style="text-align: left">Dis. Amount <span class="required"></span></label>
                                                <div class="col-sm-6 input-group">
                                                    <span class="input-group-addon"><input type="radio" class="prd_icheck" name="discount" value="2"></span>
                                                    <input type="number" min="0" step="50" pattern="[0-9]*" class="form-control" required="required"  name="disAmount" id="disAmount" placeholder="Enter discount amount" value="0">
                                                    <input type="hidden" min="0" step="50" pattern="[0-9]*" class="form-control" required="required"  name="totalWithOutDiscount" id="totalWithOutDiscount" placeholder="Enter sold amount" value="0">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="rank" class="col-sm-4 control-label">&nbsp;</label>
                                            <button type="button" id="addItem" class="btn btn-primary ">Add Item</button>
                                        </div>
                                    </form>


                                </div><!-- /.box-body -->
                            </div>
                            <div class="col-md-8"><br>
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li id="t1" class="active"><a href="#tab_1" data-toggle="tab">Products</a></li>
                                        <li id="t2" ><a href="#tab_2" data-toggle="tab">Extra Amount</a></li>
                                        <!--<li id="t3" ><a href="#tab_3" data-toggle="tab">Payment</a></li>-->
                                        <li id="t4" ><a href="#tab_4" data-toggle="tab">Payment Schedule</a></li>
                                        <!--                                    <li id="t5" ><a href="#tab_5" data-toggle="tab">Extra Charges</a></li>-->
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <div class="box box-success" id="itemTable">
                                                <div class="box-header">
                                                    <h4></h4>
                                                </div>
                                                <div class="box-body">
                                                    <table id="tbl_item" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product Name</th>
                                                            <th>Serial No</th>
                                                            <th>Qty</th>
                                                            <th>Unit Price</th>
                                                            <th>Discount</th>
                                                            <th>Total Net Amount</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label for="product" class="col-sm-3 control-label">Down Payment <span class="required"></span></label>
                                                        <div class="col-sm-3">
                                                            <input type="number"  min="0" step="1000" class="form-control" required="required"  name="downPayment" id="downPayment" placeholder="Down payment amount"  value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-footer">
                                                    <a href="#tab_2" id="setTable" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                                </div>
                                                <br>
                                            </div><!-- /.box-body -->

                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_2">
                                            <div class="box box-primary">
                                                <div class="box-body">
                                                    <div class="col-md-4"><b>Add Extra Amounts</b>
                                                        <form class="form-horizontal">
                                                            <div class="form-group">
                                                                <label for="expenses" class="control-label">Date <span class="required">*</span></label>

                                                                <input type="text" step="5000" class="form-control" required="required"  name="expenses_date" id="expenses_date" >

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expenses_amount" class="control-label">Description <span class="required">*</span></label>
                                                                <textarea class="form-control" required="required"  name="expenses" id="expenses"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expenses_amount" class="control-label">Extra Amount <span class="required">*</span></label>
                                                                <input type="number" step="1000" class="form-control" required="required"  name="expenses_amount" id="expenses_amount" placeholder="Enter Expenses amount" value="0">
                                                            </div>
                                                            <div class="form-group" >
                                                                <label for="expenses_amount" class="control-label"> </label>
                                                                <input type="button" class="btn btn-primary pull-right" name="addExpenses" id="addExpenses" value="Add">
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <table id="table_expenses"   class="table table-bordered table-striped table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>Extra Amount</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Total</th>
                                                            <th id="totalExpenses" class="pull-right text-red text-bold"></th>
                                                            <th></th>
                                                            </tfoot>
                                                        </table>
                                                        <div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="box-footer">
                                                <a href="#tab_1" id="backItems" data-toggle="tab" class="btn btn-success pull-left">Back</a><a href="#tab_3" id="next3" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                            </div>
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_3">

                                            <div class="box box-danger" id="payView">
                                                <div class="box-header">
                                                    <h4>Add Payment Details</h4>
                                                </div>
                                                <div class="box-body" >
                                                    <table id="dwPaymentTbl" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <td>#</td>
                                                        <td>Is</td>
                                                        <td>Payment Date</td>
                                                        <td>Down Payment</td>
                                                        <td>Interest Rate</td>
                                                        <td>Interest </td>
                                                        <td></td>
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="button"  class="btn btn-xs btn-info" required="required"  name="downPayment" id="add_dp0"   value="Add down Payments"></td>
                                                        <td><input type="button"  class="btn btn-xs btn-danger" required="required"  name="downPayment" id="add_dp_int" placeholder="Enter down payment amount"  value="Add Payment's Interest"></td>
                                                        <td>Total</td>
                                                        <td id="totalDp" class="pull-right text-bold "></td>
                                                        <td></td>
                                                        </tfoot>
                                                    </table>
                                                    <div id="costTable">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="cashAmount" class="control-label">Cash Payment <span class="required">*</span></label>
                                                                <input type="number" step="5000" class="form-control" required="required"  name="cashAmount" id="cashAmount" placeholder="Enter Expenses amount" value="0">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="chequeAmount" class="control-label">Cheque Payment <span class="required"></span></label>
                                                                <input type="number" step="5000" class="form-control" required="required"  name="chequeAmount" id="chequeAmount" placeholder="Enter Expenses amount" value="0">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="creditAmount" class="control-label">Credit Payment <span class="required"></span></label>
                                                                <input type="number" step="5000" class="form-control" required="required"  name="creditAmount" id="creditAmount" placeholder="Enter Expenses amount" value="0">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="returnPayment" class="control-label">Return Payment <span class="required"></span></label>
                                                                <input type="number" step="5000" class="form-control" required="required"  name="returnPayment" id="returnPayment" placeholder="Enter Expenses amount" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div id="chequeData">
                                                                <div class="form-group">
                                                                    <br><br><br>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="chequeNo" class="control-label">Cheque Number <span class="required">*</span></label>
                                                                    <input type="text" class="form-control" required="required"  name="chequeNo" id="chequeNo">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="chequeReciveDate" class="control-label">Cheque Received date <span class="required">*</span></label>
                                                                    <input type="text" class="form-control" required="required"  name="chequeReciveDate" id="chequeReciveDate">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="chequeDate" class="control-label">Date of Cheque<span class="required">*</span></label>
                                                                    <input type="text" class="form-control" required="required"  name="chequeDate" id="chequeDate">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="chequeReference" class="control-label">Cheque Reference<span class="required"></span></label>
                                                                    <textarea  class="form-control" name="chequeReference" id="chequeReference"></textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="chequeNo" class="control-label">Return Invoice <span class="required"></span></label>
                                                                <input type="text" class="form-control" required="required" placeholder="Select  a return invoice"  name="returnInvoice" id="returnInvoice">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="chequeReciveDate" class="control-label">Return Amount <span class="required"></span></label>
                                                                <input type="text" class="form-control" disabled required="required"  name="returnAmount" id="returnAmount" value="0">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="chequeDate" class="control-label">Refund Amount<span class="required"></span></label>
                                                                <input type="text" class="form-control" required="required"  name="refundAmount" id="refundAmount" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="paymentTable">
                                                        <div class="form-horizontal col-lg-6" >
                                                            <div id="panel_down_payments">

                                                                <div class="form-group">
                                                                    <label for="product" class="col-sm-6 control-label">
                                                                        <!--<input type="button"  class="btn btn-xs btn-info" required="required"  name="downPayment" id="add_dp0"   value="Add down Payments">-->
                                                                    </label>
                                                                    <div class="col-sm-5">
                                                                        <!--                                                                    <input type="button"  class="btn btn-xs btn-danger" required="required"  name="downPayment" id="add_dp_int" placeholder="Enter down payment amount"  value="Add Payment's Interest">-->
                                                                    </div>
                                                                </div><div id="down_pays"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 pull-right">
                                                        <div class='thumbnail form-horizontal' id='panel_quarter' style="display:none;">
                                                            <div class='form-group'>
                                                                <label for='product' class='col-sm-5 control-labe'>Quarter Payment Date <span class='required'></span></label>
                                                                <div class='col-sm-6'>
                                                                    <input type='text'  min='0'  class='form-control' required='required'  name='quartPayDate' id='quartPayDate' placeholder='Enter down payment amount'  >
                                                                </div>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='product' class='col-sm-5 control-label'>Quarter Payment <span class='required'></span></label>
                                                                <div class='col-sm-6'>
                                                                    <input type='number'  min='0' step='1000' class='form-control' required='required'  name='quartPayment' id='quartPayment' placeholder='Quarter payment amount'  value='0'>
                                                                </div>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='totalNet' class='col-sm-3 control-label'>Interest  <span class='required'></span></label>
                                                                <div class='col-sm-8 input-group'><span class='input-group-addon'>
                                                                    <input type='checkbox' class='prd_icheck'   name='isQuartInterest' id='isQuartInterest' value='1'></span>
                                                                    <input type='number'  min='0' step='1' class='form-control' required='required'  name='quart_interest_rate' id='quart_interest_rate' placeholder='Interest rate'  value='0'>
                                                                    <span class='input-group-addon' id='quartInterest'>0.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="box-footer">
                                                <a href="#tab_2" id="back2" data-toggle="tab" class="btn btn-success pull-left">Back</a><a href="#tab_4" id="next4" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                            </div>
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_4">
                                            <div class="box box-info">
                                                <div class="box-body" id="payment_schedule">
                                                    <b>Payment Schedule Details</b><br><br>
                                                    <div class="form-horizontal col-lg-8" >

                                                        <div class="form-group">
                                                            <label for="product" class="col-sm-6 control-label">No of Interest Term <span class="required"></span></label>
                                                            <div class="col-sm-6">
                                                                <select  class="form-control" name="noOfIntTerm" id="noOfIntTerm">
                                                                    <option value="0">-Select a term-</option>
                                                                </select>
                                                            </div>
                                                            <!--                                                            <label class="col-sm-4 control-label">No of Instalment Term </label>-->
                                                            <!--                                                            <div class="col-sm-1">-->
                                                            <input type="hidden" name="instalment" id="instalment" readonly="readonly">
                                                            <!--                                                            </div>-->
                                                        </div>
                                                        <div class='form-group'>
                                                            <input type='hidden'  min='0' step='1' class='form-control' required='required'  name='term_interest_rate2' id='term_interest_rate2' placeholder='Interest rate'  value='0'>
                                                            <label for='isQuartInterest' class='col-sm-6 control-label'>Interest<span class='required'></span></label>
                                                            <div class='col-sm-6 input-group'>
                                                                <!--                                                                <span class='input-group-addon'>-->
                                                                <!--                                                                    <input type='checkbox' class='prd_icheck'   name='isTermInterest' id='isTermInterest' value='1'>-->
                                                                <!--                                                                </span>                                                                    -->
                                                                <input type='number'  min='0' step='1' class='form-control' required='required'  name='term_interest_rate' id='term_interest_rate' placeholder='Interest rate'  value='0'>
                                                                <span id="termInterst" class='input-group-addon'>0.00</span>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <p class="font-weight-bold col-sm-3">Installment Type</p>
                                                            <input type="hidden" name="instalmentTypes" id="instalmentTypes">
                                                            <div class="btn-group col-sm-9" data-toggle="buttons">
                                                                <label class="btn btn-primary form-check-label">
                                                                    <input class="prd_icheck" type="radio" name="installmentType" id="monthly" required="required" value="1">
                                                                    Monthly
                                                                </label>
                                                                <label class="btn btn-primary form-check-label">
                                                                    <input class="prd_icheck" type="radio" name="installmentType" id="weekly" value="2" required="required"> Weekly
                                                                </label>
                                                                <label class="btn btn-primary form-check-label">
                                                                    <input class="prd_icheck" type="radio" name="installmentType" id="daily" value="3" required="required"> Daily
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='isQuartInterest' class='col-sm-6 control-label'>Monthly Payment date </label>
                                                            <div class='col-sm-6'>
                                                                <input type='text'  class='form-control' required='required'  name='mothly_payment_date' id='mothly_payment_date' placeholder='Monthly Payment Date'  value='0'>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <input type="hidden" id="monthAr" >
                                                    <input type="hidden" id="monPayAr" >
                                                    <input type="hidden" id="pricAr" >
                                                    <input type="hidden" id="intAr" >
                                                    <input type="hidden" id="balAr" >
                                                    <table id="tbl_payment_schedule" class="table table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th colspan="6" class="text-center">Easy payment schedule</th></tr>
                                                        <tr><th>Month</th><th>Payment</th><th>Principal</th><th>Interest</th><th>Extra</th><th>Balance</th></tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                        <th>Total</th><th id="tps_tot_pay">Payment</th><th id="tps_tot_prin">Principal</th><th id="tps_tot_int">Interest</th><th id="tps_tot_extra">Extra</th><th id="tps_tot_bal">Balance</th>

                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <div class="box-footer">
                                                    <a href="#tab_3" id="back3" data-toggle="tab" class="btn btn-success pull-left">Back</a>
                                                    <a href="#tab_5" id="next5" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                                </div>
                                            </div>

                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_5">
                                            <div class="box box-success">

                                                <div  class="box-body">
                                                    <table id="exChargesTbl" class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <td colspan="3">Extra Charges</td></thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                        <td></td>
                                                        <td></td>
                                                        <td id="total_extra"  class="pull-right text-red text-bold"></td>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <a href="#tab_4" id="back4" data-toggle="tab" class="btn btn-success pull-left">Back</a>
                                            </div>
                                        </div>
                                    </div><!-- /.tab-content -->
                                </div><!-- nav-tabs-custom -->

                                <div class="box-footer">
                                    <input type="button" id="resetItems" value="Reset" class="btn btn-danger pull-left">&nbsp;&nbsp;
                                    <input type="button" id="saveItems" value="Save" class="btn btn-success pull-right">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3"><div class="box box-success"><style> .tbl_summary {font-size: 15px;}</style>
                        <table style="font-size: 18px;" class="table table-hover">
                            <tr>
                                <td class="tbl_summary">Total Amount</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<b><span id="totalAmount">0.00</span></b></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary">Discount Amount</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<span id="discountAmount">0.00</span></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary">Down Payment</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<b><span id="dwnPayments">0.00</span></b></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary">Extra Charges</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<span id="extCharges">0.00</span></td>
                            </tr>

                            <tr>
                                <td class="tbl_summary">Pending Down Payment</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<span id="totalDwnPayments">0.00</span></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary">Down Payment Interest</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<span id="dwnPaymentInt">0.00</span></td>
                            </tr>
                            <tr style="display:none;">
                                <td class="tbl_summary">Quarter Payment Interest</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<span id="quarterPaymentInt">0.00</span></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary">Extra Amount</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<span id="extraAmount">0.00</span></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary">Gross Amount</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<b><span id="netAmount">0.00</span></b></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary">Interest Amount</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<span id="interestAmount">0.00</span></td>
                            </tr>

                            <tr>
                                <td class="tbl_summary">Net Amount</td>
                                <td>:</td>
                                <td style="text-align: right;">&nbsp;<b><span id="netAmountWithInt">0.00</span></b></td>
                            </tr>
                            <tr>
                                <td class="tbl_summary"><span id="dueAmountLable2">Change Amount</span></td>
                                <td>:</td>
                                <td style="text-align: right;"><span id="dueAmount2">0.00</span></td>
                            </tr>
                            <tr  id="returnAmountLable">
                                <td class="tbl_summary"><span>Return Amount</span></td>
                                <td>:</td>
                                <td style="text-align: right;"><span id="return_amount"></span></td>
                            </tr>
                            <tr id="refundAmountLable">
                                <td class="tbl_summary"><span >Refund Amount</span></td>
                                <td>:</td>
                                <td style="text-align: right;"><span id="refund_amount"></span></td>
                            </tr>
                        </table>

                    </div></div>
            </div>
        </section><!-- /.content -->
</div><!-- ./wrapper -->

<script type="text/javascript">
    $('body').addClass('sidebar-collapse');
    $(function() {

        $('.prd_icheck').iCheck({
            checkboxClass: 'icheckbox_square-yellow',
            radioClass: 'iradio_square-blue',
            increaseArea: '50%'
        });

        $("#example1").dataTable({
            aaSorting: [[0, 'asc']],
            "fnInitComplete": function(oSettings) {
                $("*[rel=facebox]", this.fnGetNodes()).facebox({
                    loadingImage: '../plugins/facebox/loading.gif',
                    closeImage: '../plugins/facebox/closelabel.png'
                });
            }
        });

        $("#addCustomer").click(function() {

            var cusName = $("#cusName").val();
            var formData = $("#form2").serialize();

            if (cusName == '') {
                alert("Please Enter customer name");
                return false;
            } else {
                $.ajax({
                    type: "post",
                    url: "../Admin/Controller/Customer.php",
                    data: formData,
                    success: function(data) {

                        if (data == 1) {
                            alert("Customer saved successfully");
                        } else {
                            alert("Customer did not save successfully");
                        }
                    }
                });
            }
        });

        $('#preview3').on('change', '#img-1', function() {

            $("#cusAction").val('uploadCustomerImages');
            $("#img-loadin-1").show();
            $("#img-btn-1").hide();
            var $theForm = $('#form2'),
                formData = new FormData($theForm[0]);

            $.ajax({
                url: "../Admin/Controller/Customer.php",
                type: "POST",
                data: formData,
                success: function(data) {

                    $("#cusAction").val('addCustomer');
                    $("#img-loadin-1").hide();
                    $('#imageuploadpart').before(data);
                    $("#img-btn-1").show();
                    $('#success').show();
                    var cusImage = $('#img-close-1').attr('imgdata');

                    $("#cusImageId").val(cusImage);
                    $("#img-btn-1").hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        });


    });
</script>
<!--<script src="../dist/js/invoice.js"></script>-->
<!--<script src="../dist/js/pay_cal.js"></script>-->
<!--<script src="../dist/js/mycalc.js"></script>-->
<script type="text/javascript">
    function deleteRecord(fid) {
        var check = confirm("Are you sure want to delete this...");
        if (check == true) {
            window.location.href = "../Admin/Controller/Product.php?action=deleteProduct&product_id=" + fid;
        }
        else {
            return  false;
        }
    }
</script>
<script>

    $('body').on('hidden.bs.modal', '.modal', function() {
        $(this).removeData('bs.modal');
    });

    $('.starrr').on('starrr:change', function(e, value) {
        if (value) {
            $('.your-choice-was').show();
            $('.choice').text(value);
            $('.rank').val(value);
            $('.rank2').val(value);
        } else {
            $('.your-choice-was').hide();
        }
    });
</script>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'added') { ?>
    <div class="alert alert-success">Data successfully added.</div>
<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'notadded') { ?>
    <div class="alert alert-danger">Data successfully not added.</div>
<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'emailsent') { ?>
    <div class="alert alert-success">Confirmation successfully and email has been sent.</div>
<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'updated') { ?>
    <div class="alert alert-success">Data successfully updated.</div>
<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'notupdated') { ?>
    <div class="alert alert-danger">Data successfully not updated.</div>
<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted') { ?>
    <div class="alert alert-success">Data successfully deleted.</div>
<?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'notdeleted') { ?>
    <div class="alert alert-danger">Data successfully not deleted.</div>
<?php } ?>
