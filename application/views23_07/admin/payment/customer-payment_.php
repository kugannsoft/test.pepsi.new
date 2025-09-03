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
        <style>
            .rowselected{background-color: #f0ad4e;}
        </style>
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <!--<form class="form-horizontal">-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Customer <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" autofocus required="required"  name="customer" id="customer" placeholder="Enter Customer" value="<?php echo $customer; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Receipt Type <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="receiptType">
                                            <!--<option value="0">-Select-</option>-->
                                            <option value="1">Credit</option>
                                            <option value="2">Advance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Payment Date <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="invDate" id="invDate" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="invlocation" value="<?php echo $_SESSION['location'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnremark"class="col-sm-5 control-label"> Remark<span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea name="grnremark"  tabindex="2" id="remark" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="payType" class="col-sm-5 control-label">Payment Method<span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="payType">
                                            <!--<option value="0">-Select-</option>-->
                                            <option value="1">Cash</option>
                                            <option value="3">Cheque</option>
                                            <option value="5">Advance</option>
                                            <option value="7">Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="load_return">
                                    <label for="returnInvoice" class="col-sm-5 control-label">Return Invoices<span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="returnInvoice" id="returnInvoice" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="payAmount" class="col-sm-5 control-label">Payment Amount<span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="payAmount" id="payAmount" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <td>Customer </td>
                                        <td> : </td>
                                        <td> <span id="cusCode"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile No</td>
                                        <td> : </td>
                                        <td> <span id="city"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Credit Limit</td>
                                        <td> : </td>
                                        <td class="text-right"> <span id="creditLimit"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Credit period</td>
                                        <td> : </td>
                                        <td> <span id="creditPeriod"></span> </td>
                                    </tr>
                                    <tr>
                                        <td>Outstanding</td>
                                        <td> : </td>
                                        <td class="text-right"><span id="cusOutstand"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Available Limit</td>
                                        <td> : </td>
                                        <td class="text-right"><span id="availableCreditLimit"></span> </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td> </td>
                                    </tr>
                                </table>
                                <br>
                                <!--<b> Return Amount : <span id="returnPayment"></span> </b><br>-->
                                <b> Total Payment : <span id="totalPayment"></span> </b><br><br><br>
<!--                                             <b> Cash Payment : <span id="cashPayment"></span> </b><br>
                                  <b> Cheque Payment : <span id="chequePayment"></span> </b>-->

                                <span class="thumbnail"> &nbsp; &nbsp; Automatically &nbsp;<input type="radio"  class="prd_icheck" checked="checked" name="payAuto" id="payAuto" value="1">  &nbsp; &nbsp; Manual &nbsp; <input type="radio" class="prd_icheck" name="payAuto" id="payAuto2" value="2"> </span>
                            </div>
                        </div>
                        <div class="row" id='bankData'>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="bank" class="control-label">Bank Account<span class="required">*</span></label>
                                    <select class="form-control" required="required"  name="bank_acc" id="bank_acc">
                                        <option value="">Select a Bank Account</option>
                                        <?php foreach($bank_acc as $banks){?>
                                            <option value="<?php echo $banks->acc_id; ?>"><?php echo $banks->acc_name." / ".$banks->acc_no." - ".$banks->BankName; ?></option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                         </div>
                          <div class="row" id='advanceData'>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="bank" class="control-label">Advance Payment No <span class="required">*</span></label>
                                    <input class="form-control" required="required"  name="advanceno" id="advanceno">
                                </div>
                            </div>
                        </div>
                        <div class="row" id='chequeData'>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="bank" class="control-label">Bank <span class="required">*</span></label>
                                    <select class="form-control" required="required"  name="bank" id="bank"></select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="chequeNo" class="control-label">Cheque No <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeNo" id="chequeNo">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="chequeReciveDate" class="control-label">Cheque Received date <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeReciveDate" id="chequeReciveDate">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="chequeDate" class="control-label">Date of Cheque<span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="chequeDate" id="chequeDate">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="chequeReference" class="control-label">Cheque Reference<span class="required"></span></label>
                                    <textarea  class="form-control" name="chequeReference" id="chequeReference">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span id="errPayment"></span></b>
                                    <button class="btn btn-primary" id='btnPrint' disabled>Print Receipt</button>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-success" id='pay'>Save Payment</button>
                                    &nbsp; <button class="btn btn-danger" disabled id='reset'>Reset</button>
                                </div>
                                <!--<div class="form-group">-->
                                    <div class="input-group">
                                        <label for="ismultiprice" class="control-label">
                                            <input  class="prd_icheck"  type="checkbox" checked name="disablePrint" id="disablePrint" value="1">
                                            Disable Print
                                        </label>
                                    </div>
                                <!--</div>-->
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    <!--</form>-->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="tbl_payment" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th class="text-right">Net Amount</th>
                                        <th class="text-right">Credit Amount</th>
                                        <th class="text-right">Settle Amount</th>
                                        <th class="text-right">Due Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot id="over_payment_rows">
                                </tfoot>
                            </table>
                        </div>                    
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
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
</div>
<style>
    .shop-items:hover{
        background-color: #00ca6d;
        color: #fff;
    }

    div.ui-datepicker{
        font-size:10px;
    }
    
</style>
<script type="text/javascript"></script>