<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <style>
        .form-group {
            margin-bottom: 3px;
        }

        .box{
            margin-bottom: 10px;
        }

        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-right: 5px;
            padding-left: 10px;
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
        <input type="hidden" name="outAccNo"  id="outAccNo" value="<?php echo $outAccNo; ?>">
        <input type="hidden" name="success"  id="successRedirect" value="<?php echo $sr; ?>">
        <input type="hidden" name="dwnInterest"  id="dwnInterest" value="<?php echo $dwn_int; ?>">
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="row"><br>
                            <div class="col-md-4">
                                <form class="form-horizontal" >
                                    <div class="form-group">
                                        <label for="customer" style="text-align: left" class="col-sm-4 control-label">Account No <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" required="required"  name="account_no" id="account_no" placeholder="Account No or Nic" value="<?php echo $outAccNo; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="invDate" style="text-align: left" class="col-sm-4 control-label">Invoice Date <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" required="required" readonly="readonly"  name="invDate" id="invDate" placeholder="">
                                            <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="invDate" style="text-align: left" class="col-sm-4 control-label">Customer <span class="required">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" required="required" readonly="readonly"  name="cusName" id="cusName" placeholder="customer name">
                                            <input type="hidden" class="form-control" required="required"  name="customerCode" id="customerCode" value="">
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div  class="col-md-4">
                                <form class="form-horizontal" >

                                    <div>
                                        <span style="background-color: red; font-size: 16px" id="reScheduleNotice"></span>
                                    </div>
                                    <!--                                            <div class="form-group ">
                                                                                    <label for="isLot" class="col-sm-3 control-label">Type <span class="required">*</span></label>
                                                                                    <div class="col-sm-6 thumbnail">
                                                                                        Product &nbsp;<input type="radio" required="required" class="prd_icheck"  checked="checked" name="isLot" id="notLot" value="0">
                                                                                        &nbsp; Loan  &nbsp;<input type="radio" required="required"  class="prd_icheck"  name="isLot" id="isLot" value="1">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <label for="isLot" class="col-sm-3 control-label">Payment<span class="required">*</span></label>
                                                                                    <div class="col-sm-6 thumbnail">
                                                                                        Normal &nbsp;<input type="radio" required="required" class="prd_icheck"  checked="checked" name="payType" id="normalPay" value="1">
                                                                                        &nbsp; Easy  &nbsp;<input type="radio" required="required"  class="prd_icheck"  name="payType" id="easyPay" value="2">
                                                                                    </div>
                                                                                </div>-->

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
                                            <td class=""><span  id="referralNo"></span></td>
                                        </tr>
                                    <!--                                                        <td>Outstanding</td>
<tr>
<td>Outstanding</td>
<td>&nbsp;:&nbsp;</td>
<td  class="text-right"><span  id="cusOutstand"></span></td>
</tr>-->
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
                            <div class="col-md-12"><br>
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li id="t1" class="active"><a href="#tab_1" data-toggle="tab">Account History</a></li>
                                        <li id="t2" ><a href="#tab_2" data-toggle="tab">Rental Collection</a></li>
                                        <li id="t3" ><a href="#tab_3" data-toggle="tab">Down Payment Collection</a></li>
                                        <li id="t4" ><a href="#tab_4" data-toggle="tab">Payment Summery</a></li>
                                        <li id="t5" ><a href="#tab_5" data-toggle="tab">Add Extra Amounts</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            <div class="row">
                                                <div class="col-md-6" id="printInvoiceNew">
                                                    <div class="box box-success" >
                                                        <!--<div class="box-header">-->
                                                        <h4>Sales details</h4>
                                                        <!--</div>-->
                                                        <div class="box-body">
                                                            <input type="hidden" id="pay_typeHidden" name="pay_typeHidden" value="">
                                                            <input type="hidden" id="pay_dateHidden" name="pay_dateHidden" value="">
                                                            <table id="tbl_item" class="table table-bordered table-striped table-hover">

                                                                <tbody>
                                                                <tr>
                                                                    <td class="tbl_summary">Account Number</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="accNo"></span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Invoice Number</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="invoiceNo"></span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Payment Type</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="pay_type"></span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Invoice Date</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="invoiceDate"></span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Total Amount</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="totalAmount">0.00</span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Discount Amount</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<span id="discountAmount">0.00</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Down Payment</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="dwnPayments">0.00</span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Extra Charges</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<span id="extCharges">0.00</span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="tbl_summary">Pending Down Payment</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<span id="totalDwnPayments">0.00</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Down Payment Interest</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<span id="dwnPaymentInt">0.00</span></td>
                                                                </tr>
                                                                <tr style="display:none;">
                                                                    <td class="tbl_summary">Quarter Payment Interest</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<span id="quarterPaymentInt">0.00</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Extra Amount</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<span id="extraAmount">0.00</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Gross Amount</td>
                                                                    <!--<td>:</td>/-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="netAmount">0.00</span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary">Interest Amount</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<span id="interestAmount">0.00</span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="tbl_summary">Net Amount</td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;">&nbsp;<b><span id="netAmountWithInt">0.00</span></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="tbl_summary"><span id="dueAmountLable2">Change Amount</span></td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;"><span id="dueAmount2">0.00</span></td>
                                                                </tr>
                                                                <tr  id="returnAmountLable">
                                                                    <td class="tbl_summary"><span>Return Amount</span></td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;"><span id="return_amount"></span></td>
                                                                </tr>
                                                                <tr id="refundAmountLable">
                                                                    <td class="tbl_summary"><span >Refund Amount</span></td>
                                                                    <!--<td>:</td>-->
                                                                    <td style="text-align: right;"><span id="refund_amount"></span></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <br><br>

                                                        </div>
                                                    </div><!-- /.box-body -->
                                                </div>
                                                <div class="form-horizontal">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="product" style="text-align: left" class="col-sm-3 control-label">Penalty  Rate <span class="required"></span></label>
                                                            <div class="col-sm-4">
                                                                <input type="number"  min="0" step="1" class="form-control" required="required"  name="rental_rate" id="rental_rate" placeholder="Penalty Rate"  value="<?php echo $PenaltySetting->rate; ?>" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="product"  style="text-align: left" class="col-sm-3 control-label">No of excuse dates <span class="required"></span></label>
                                                            <div class="col-sm-4">
                                                                <input type="number"  min="0" step="1" class="form-control" required="required"  name="excuse_date" id="excuse_date" placeholder="No of excuse dates"  value="<?php echo $PenaltySetting->date; ?>" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="product" class="col-sm-3 control-label"> <span class="required"></span></label>
                                                            <div class="col-sm-3">
                                                                <input type="button" style="width: 188px;" id="printInvoice" class="btn btn-success" value="Print Invoice" required="required"  name="print2"  >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product" class="col-sm-3 control-label"> <span class="required"></span></label>
                                                            <div class="col-sm-2">
                                                                <input type="button" style="width: 188px;" id="printRdShedule" class="btn btn-info" value="Print Rental Schedule" required="required"  name="print"  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="box-footer">
                                                <a href="#tab_2" id="setTable" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                            </div>


                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_2">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="box box-primary">
                                                        <div class="box-body">
                                                            <b>Payment Schedule Details</b><br><br>

                                                            <input type="hidden" id="monthAr" >
                                                            <input type="hidden" id="monPayAr" >
                                                            <input type="hidden" id="pricAr" >
                                                            <input type="hidden" id="intAr" >
                                                            <input type="hidden" id="balAr" >
                                                            <table id="tbl_payment_schedule" class="table table-hover table-responsive table-condensed">
                                                                <thead>
                                                                <tr><th colspan="6" class="text-center">Easy payment schedule</th></tr>
                                                                <!--                                                                            <tr><th>Month</th><th>Payment Date</th><th class="text-right">Install. Amount</th><th class="text-right">Extra Amount</th><th class="text-right">Due With Extra</th><th class="text-right">Default Rental</th><th class="text-right">With Rental Default</th><th class="text-right">Total Due Amount</th><th class="text-right">Rental Balance</th><th class="text-right">Settle Amount</th><th class="text-right">Due Amount</th></tr>-->
                                                                <tr>
                                                                    <th>Month</th>
                                                                    <th>Payment Date</th>
                                                                    <th class="text-right">Install. Amount</th>
                                                                    <th class="text-right">Extra Amount</th>
                                                                    <th class="text-right">Due With Extra</th>
                                                                     <th class="text-right">Due Days</th>
<!--                                                                    <th class="text-right">Due With Penalty</th>-->
                                                                    <th class="text-right">Total Due Amount</th>
                                                                    <th class="text-right">Rental Balance</th>
                                                                    <th class="text-right">Settle Amount</th>
                                                                    <th class="text-right">Due Amount</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                                <tfoot>
                                                                <!--<th></th>-->
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th>Total</th>
                                                                <th id="tps_tot_prin">0.00</th>
                                                                <th id="tps_tot_pay">0.00</th>
                                                                <th id="tps_tot_int">0.00</th>
                                                                <th id="tps_tot_bal">0.00</th>
                                                                </tfoot>
                                                            </table>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <form id="post_rl" method="post" action="">
                                                            <input type="hidden" name="h_invNo" id="h_invNo">
                                                            <input type="hidden" name="h_accNo" id="h_accNo">
                                                            <input type="hidden" name="h_dueDate" id="h_dueDate">
                                                            <input type="hidden" name="h_dueAmount" id="h_dueAmount">
                                                            <input type="hidden" name="h_term" id="h_term">
                                                            <input type="hidden" name="h_invDate" id="h_invDate">

                                                            <!--                                                <input type="text" name="h_invNo" id="h_invNo">
                                                                                                            <input type="text" name="h_accNo" id="h_accNo">
                                                                                                            <input type="text" name="h_dueDate" id="h_dueDate">
                                                                                                            <input type="text" name="h_dueAmount" id="h_dueAmount">
                                                                                                            <input type="text" name="h_term" id="h_term">
                                                                                                            <input type="text" name="h_invDate" id="h_invDate">-->
                                                            &nbsp;<input type="button" id="reschedule" class="btn btn-danger pull-right" style="margin-left: 3px" value="Reschedule" required="required"  name="reschedule">&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;<input type="button" id="printFinalLetter" class="btn btn-info pull-right" style="margin-left: 3px" value="Print Final Letter" required="required"  name="print">&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="button" id="printRemLetter" class="btn btn-info pull-right" value="Print Reminder Letter" required="required"  name="print">
                                                            First <input type="radio" name="letterType" value="1" class="prd_icheck" checked>
                                                            Second <input type="radio" name="letterType" class="prd_icheck" value="2">
                                                            Final <input type="radio" name="letterType" class="prd_icheck" value="3">
                                                        </form>
                                                    </div>
                                                    <br>
                                                    <div id="rental_cheque"> <form class="">
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label for="chequeNo" class="control-label">Cheque No <span class="required">*</span></label>
                                                                    <input type="text" class="form-control" required="required"  name="chequeNo" id="rd_chequeNo">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label for="chequeReciveDate" class="control-label">Cheque Received date <span class="required">*</span></label>
                                                                    <input type="text" class="form-control" required="required"  name="chequeReciveDate" id="rd_chequeReciveDate">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label for="chequeDate" class="control-label">Date of Cheque<span class="required">*</span></label>
                                                                    <input type="text" class="form-control" required="required"  name="chequeDate" id="rd_chequeDate">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label for="chequeReference" class="control-label">Cheque Reference<span class="required"></span></label>
                                                                    <textarea  class="form-control" name="chequeReference" id="rd_chequeReference">

                                                                            </textarea>
                                                                </div>
                                                            </div></form>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="box box-primary">
                                                        <table id="tbl_item" class="table table-bordered table-striped table-hover">

                                                            <tbody>
                                                            <tr>
                                                                <td class="tbl_summary">Net Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<b><span id="s_netAmount"></span></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Previous Paid Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<b><span id="s_prevPaidAmount"></span></b></td>
                                                            </tr><tr>
                                                                <td class="tbl_summary">Total Net Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<b><span id="s_totalNetAmount"></span></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">No of Installments</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<b><span id="s_installment">0.00</span></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Installment Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<span id="s_installAmount">0.00</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Total Due Amount with Rental Default</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<b><span id="s_totalDueWRD">0.00</span></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Total Installment Due Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<span id="s_installDue">0.00</span></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="tbl_summary">Total Installment Term Due</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<span id="s_installTermDue">0.00</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Total Installment Paid Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<span id="s_installPaidAmount">0.00</span></td>
                                                            </tr>
                                                            <tr >
                                                                <td class="tbl_summary">Total Installment Terms Paid </td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<span id="s_installPaidTerm">0.00</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Total Paid Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<span id="s_totalPaid">0.00</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Total Paid Rental Default</td>
                                                                <!--<td>:</td>/-->
                                                                <td style="text-align: right;">&nbsp;<b><span id="s_totalPaidRD">0.00</span></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="tbl_summary">Total Extra Amount</td>
                                                                <!--<td>:</td>-->
                                                                <td style="text-align: right;">&nbsp;<span id="totalExAmount">0.00</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <form class="form-horizontal">
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Payment Type <span class="required">*</span></label>
                                                            <div class="control-label col-md-7">
                                                                <select class="form-control" required="required"  name="rd_pay_type" id="rd_pay_type" >
                                                                    <option value="">-Select payment type-</option>
                                                                    <?php foreach ($paymentType as $paymentTypes) { ?>
                                                                        <option value="<?php echo $paymentTypes->payTypeId; ?>"><?php echo $paymentTypes->payType; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Payment Date <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text"  class="form-control" required="required"  name="rd_pay_date" id="rd_pay_date" >
                                                                <input type="hidden" class="form-control" required="required"  name="rd_tot_dwnpay" id="rd_tot_dwnpay" value="0">
                                                                <input type="hidden" class="form-control" required="required"  name="rd_tot_extr" id="rd_tot_extr" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">No of Term Due <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text" step="5000" disabled class="form-control" required="required"  name="rd_term_due" id="rd_term_due" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Extra Amount <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text" step="5000" class="form-control" required="required"  name="rd_extr_amount" id="rd_extr_amount" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Insurance Amount</label>
                                                            <div class=" col-md-7">
                                                                <input type="text" step="5000" class="form-control" required="required"  name="rd_insu_amount" id="rd_insu_amount" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left"  class="control-label col-md-5">Total Due <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text" disabled step="5000" class="form-control" required="required"  name="rd_tot_due_amount" id="rd_tot_due_amount" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Paid Amount <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text" step="5000" class="form-control" required="required"  name="rd_pay_amount" id="rd_pay_amount" value="0" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group" >
                                                            <label for="expenses_amount" class="control-label"> </label>
                                                            <input type="button" style="width: 173px" class="btn btn-primary pull-right" name="rdPay" id="rdPay" value="Pay">
                                                        </div>
                                                    </form>
                                                </div>


                                            </div>
                                            <div class="box-footer">
                                                <a href="#tab_1" id="backItems" data-toggle="tab" class="btn btn-success pull-left">Back</a><a href="#tab_3" id="next3" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                            </div>
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_3">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h4>Pending Down Payments</h4>
                                                    <table id="table_dwnPayment"   class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Payment No</th>
                                                            <th>Invoice No</th>
                                                            <th>Payment Date</th>
                                                            <th>Down Payment</th>
                                                            <th>Rental Default</th>
                                                            <th>Total Amount</th>
                                                            <th>Settle Amount</th>
                                                            <th>Total Due</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Total</th>
                                                        <th id="totalDwnPayment" class="pull-right text-red text-bold"></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        </tfoot>
                                                    </table>
                                                    <div class="form-group">
                                                        <input type="button" id="printDwPayment" class="btn btn-info pull-right" value="Print Down Payment Reminder Letter" required="required"  name="print"  >
                                                    </div><br>


                                                </div>
                                                <div class="col-md-3">
                                                    <form class="form-horizontal">

                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Payment Type <span class="required">*</span></label>
                                                            <div class="control-label col-md-7">
                                                                <select class="form-control" required="required"  name="payType2" id="payType2" >
                                                                    <option value="">-Select payment type-</option>
                                                                    <?php foreach ($paymentType as $paymentTypes) { ?>
                                                                        <option value="<?php echo $paymentTypes->payTypeId; ?>"><?php echo $paymentTypes->payType; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Date <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text"  class="form-control" required="required"  name="dwn_pay_date" id="dwn_pay_date" >
                                                                <input type="hidden" class="form-control" required="required"  name="tot_dwnpay" id="tot_dwnpay" value="0">
                                                                <!--<input type="hidden" class="form-control" required="required"  name="tot_extr" id="tot_extr" value="0">-->
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Due Amount <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text" step="5000" disabled class="form-control" required="required"  name="dwn-due_amount" id="dwn_due_amount" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Extra Amount <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text" step="5000" class="form-control" required="required"  name="dwn_extr_amount" id="dwn_extr_amount" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Total Due Amount</label>
                                                            <div class=" col-md-7">
                                                                <input type="text" disabled step="5000" class="form-control" required="required"  name="tot_due_amount" id="tot_due_amount" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expenses" style="text-align: left" class="control-label col-md-5">Paid Amount <span class="required">*</span></label>
                                                            <div class=" col-md-7">
                                                                <input type="text" step="5000" class="form-control" required="required"  name="dwn_pay_amount" id="dwn_pay_amount" value="0">
                                                            </div>
                                                        </div>
                                                        <div id="dwn_cheque">
                                                            <div class="form-group">
                                                                <label for="expenses" class="control-label col-md-5">Cheque No <span class="required">*</span></label>
                                                                <div class=" col-md-7">
                                                                    <input type="text" class="form-control" required="required"  name="chequeNo" id="dwn_chequeNo">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expenses" class="control-label col-md-5">Cheque Received date <span class="required">*</span></label>
                                                                <div class=" col-md-7">
                                                                    <input type="text" class="form-control" required="required"  name="chequeReciveDate" id="dwn_chequeReciveDate">

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expenses" class="control-label col-md-5">Date of Cheque <span class="required">*</span></label>
                                                                <div class=" col-md-7">
                                                                    <input type="text" class="form-control" required="required"  name="chequeDate" id="dwn_chequeDate">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expenses" class="control-label col-md-5">Cheque Reference <span class="required">*</span></label>
                                                                <div class=" col-md-7">
                                                                    <textarea  class="form-control" name="chequeReference" id="dwn_chequeReference"></textarea>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group" >
                                                            <label for="expenses_amount" class="control-label"> </label>
                                                            <input type="button" style="width: 172px" class="btn btn-info pull-right" name="dwnPay" id="dwnPay" value="Pay Down Payment">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <a href="#tab_2" id="back2" data-toggle="tab" class="btn btn-success pull-left">Back</a><a href="#tab_4" id="next4" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                            </div>
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_4">
                                            <div class="box box-info">
                                                <div class="box-body" id="payment_history">
                                                    <table id="tbl_payment_history" class="table table-hover table-responsive table-condensed">
                                                        <thead>
                                                        <tr><th colspan="6" class="text-center">Easy payment schedule</th></tr>
                                                        <tr><th>#</th><th>Payment No</th><th class="text-right">Paid Date</th><th class="text-right">Payment Type</th><th class="text-right">Paid Amount</th><th class="text-right">Extra Amount</th><th class="text-right">Insurance Amount</th><th class="text-right">Total Paid Amount</th><th class="text-right">Cheque Date</th><th class="text-right">Cheque No</th><th class="text-right">Cheque Reference</th></tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                        <th></th><th></th><th></th><th  class="text-right">Total</th><th class="text-right" id="tph_tot_prin">0.00</th><th class="text-right" id="tph_tot_pay">0.00</th><th class="text-right" id="tph_tot_int">0.00</th><th class="text-right" id="tph_tot_bal">0.00</th><th></th><th></th><th></th>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <hr>
                                                <div class="box-body" id="payment_history_dtl">
                                                    <table id="tbl_payment_history_dtl" class="table table-hover table-responsive table-condensed">
                                                        <thead>
                                                        <tr><th colspan="6" class="text-center">Easy payment schedule</th></tr>
                                                        <tr><th>#</th><th>Payment No</th><th class="text-right">Inv No</th><th class="text-right">Payment Type</th><th class="text-right">Month Term</th><th class="text-right">Paid Amount</th></tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                        <th></th><th></th><th></th><th></th><th>Total</th><th class='text-right' id="tphd_tot_bal">0.00</th>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <input type="button" id="printPayShedule" class="btn btn-info" value="Print Payment Schedule" required="required"  name="print"  >

                                                <div class="box-footer">
                                                    <a href="#tab_3" id="back3" data-toggle="tab" class="btn btn-success pull-left">Back</a>
                                                    <a href="#tab_5" id="next5" data-toggle="tab" class="btn btn-success pull-right">Next</a>
                                                </div>
                                            </div>

                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_5">
                                            <div class="box box-success">

                                                <div  class="box-body">
                                                    <h4>Pending Extra Amounts</h4>
                                                    <table id="table_extPayment"   class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Invoice No</th>
                                                            <th>Description</th>
                                                            <th>Payment Date</th>
                                                            <th>Down Payment</th>
                                                            <th>Rental Default</th>
                                                            <th>Total Due</th>
                                                            <!--<th>Settle Amount</th>-->
                                                            <!--<th>Total Due</th>-->
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th ></th>
                                                        <th></th>
                                                        <th >Total</th>
                                                        <th id="tot_extr" class="pull-left text-red text-bold"></th>
                                                        </tfoot>
                                                    </table>

                                                    <h4>Add Extra Amounts</h4><hr>
                                                    <div class="col-md-2">
                                                        <label for="expenses" class="control-label">Date <span class="required">*</span></label>
                                                        <input type="text" step="5000" class="form-control" required="required"  name="expenses_date" id="expenses_date" >
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="expenses_amount" class="control-label">Description <span class="required">*</span></label>
                                                        <textarea class="form-control" required="required"  name="expenses" id="expenses"></textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="expenses_amount" class="control-label">Extra Amount <span class="required">*</span></label>
                                                        <input type="number" step="1000" class="form-control" required="required"  name="expenses_amount" id="expenses_amount" placeholder="Enter Expenses amount" value="0">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="button" class="btn btn-primary pull-left" name="addExpenses" id="addExpenses" value="Add">
                                                    </div>
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
                                                    <input type="button" class="btn btn-info pull-right" name="saveExtra" id="saveExtra" value="Save Extra Payment">
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

            </div>
        </section>
        <!--invoice print-->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                    <div class="modal-content">
                        <div class="modal-body" >
                            <?php //receipt print
                            $this->load->view('easy/easy_recipt_print.php',true); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                            <button type="button" id="printInvoice" class="btn btn-primary btn-lg">Print</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.content-wrapper -->

<script type="text/javascript">
    function printdivs(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

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