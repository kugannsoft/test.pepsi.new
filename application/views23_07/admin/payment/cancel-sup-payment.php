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
            <div class="col-lg-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Supplier <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" autofocus required="required"  name="customer" id="customer" placeholder="Enter Supplier">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="col-sm-5 control-label">Payment No <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="invoice" id="invoice" placeholder="Enter Payment number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Cancel Date <span class="required">*</span></label>
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
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td>Suppiler </td>
                                        <td> : </td>
                                        <td> <span id="supCode"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile No</td>
                                        <td> : </td>
                                        <td> <span id="city"></span></td>
                                    </tr>
<!--                                    <tr>-->
<!--                                        <td>Credit Limit</td>-->
<!--                                        <td> : </td>-->
<!--                                        <td class="text-right"> <span id="creditLimit"></span></td>-->
<!--                                    </tr>-->
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
<!--                                    <tr>-->
<!--                                        <td>Available Limit</td>-->
<!--                                        <td> : </td>-->
<!--                                        <td class="text-right"><span id="availableCreditLimit"></span> </td>-->
<!--                                    </tr>-->

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td> </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b></b>
                                <br><button class="btn btn-info pull-right" id='pay'>Cancel Supplier Payment</button>
                                <button class="btn btn-info" id='print'>Print Invoice</button>
                            </div>
                            <div class="col-lg-8">
                                <span id="errPayment"></span>
                            </div>
                        </div>



                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="tbl_payment" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mode</th>
                                        <th>Cheque Date</th>
                                        <th>Cheque No</th>
                                        <th >Bank Name</th>
                                        <th  class="text-right">Total Net Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                        <span id="lastTranaction">Last Cancel payment : </span>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
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
    
     div.ui-datepicker{
        font-size:10px;
    }
</style>
<script type="text/javascript">


</script>