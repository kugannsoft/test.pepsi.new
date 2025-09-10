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
                                    <label for="customer" class="col-sm-5 control-label">Invoice No <span class="required">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" required="required"  name="invoice" id="invoice" placeholder="Enter Invoice number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!--<label for="invDate" class="col-sm-5 control-label">Cancel Date <span class="required">*</span></label>-->
                                    <div class="col-sm-6">
                                        <!--<input type="text" class="form-control" required="required"  name="invDate" id="invDate" value="<?php echo date('Y-m-d') ?>" placeholder="">-->
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                        <input type="hidden" name="a5print" id="a5print" value="<?php echo $company['A5Print'] ?>">
                                    </div>
                                </div>
                                <!--                                <div class="form-group">
                                                                    <label for="invDate" class="col-sm-5 control-label">Remark <span class="required">*</span></label>
                                                                    <div class="col-sm-6">
                                                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                                                    </div>
                                                                </div>-->
                            </div>
                            <div class="col-sm-6">
                                <table class="table">
                                    <tr><td></td><td></td><td class="text-right"></td></tr>
                                    <tr><td>Total Amount</td><td>:</td><td class="text-right" id="totalAmount"></td></tr>
                                    <tr><td>Total Discount</td><td>:</td><td class="text-right"  id="totalDis"></td></tr>
                                    <tr><td>Total Net Amount</td><td>:</td><td class="text-right"  id="totalNet"></td></tr>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span id="lbl_batch_no"></span></b>
                                <br><button class="btn btn-info pull-right" id='print'>Print Invoice</button>
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
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Serial No</th>
                                        <th>Total Quantity</th>
                                        <th>Free Qty</th>
                                        <th>Selling Price</th>
                                        <th>Discount</th>
                                        <th class="text-right">Total Net Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!--<span id="lastTranaction">Last Cancel Invoice : </span>-->
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

    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content"><div class="modal-body" >
                        <div class="row"  id="printArea" align="center" style='margin:5px;'>
                            <table style="border-collapse:collapse;width:290px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <?php //foreach ($company as $com) {  ?>
                                <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                                    <td colspan="4" style="font-size:40px;font-family: Arial, Helvetica, sans-serif;"><b><?php echo $company['CompanyName'] ?></b></td>
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
                                    <td colspan="4"><img valign="bottom" src="http://vcom.nsoft.lk/upload/phone.png" style="height:28px;"> &nbsp;<?php echo $company['LanLineNo'] ?></td>
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
                                        <td style="text-align:center;border:#000 solid 1px;">Qty</td>
                                        <td style="text-align:center;border:#000 solid 1px;">Description</td>
                                        <td style="text-align:center;border:#000 solid 1px;">Price</td>
                                        <td style="text-align:center;border:#000 solid 1px;">T. Amount</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
                        <div class="row"  id="printArea2" align="center" style='margin:5px;width:600px;'>
                            <div style="margin:0;padding:0;width:600px;">
                                <table style="border-collapse:collapse;width:600px;padding:5px;font-family: Arial, Helvetica, sans-serif;" border="0">

                                    <?php  if ($_SESSION['location'] == 10) { ?>
                                        <tr>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'><img style="position:absolute;top:300px;left:125px;width:300px; z-index: 0;opacity: 0.2;" src="http://vcom.nsoftpos.com/upload/Huawei.jpg" /></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:100px;'></td>
                                        </tr>
                                        <tr>
                                            <td style='width:100px;'>
                                                <img style="width:100px;" src="http://vcom.nsoftpos.com/upload/Huawei.jpg">
                                            </td>
                                            <td colspan='3' style='text-align:center;width:280px;font-size:50px;'><b><?php echo $company['CompanyName'] ?></b><br /><span style="font-size:40px">&nbsp;&nbsp;<?php echo $company['CompanyName2'] ?></span></td>
                                            <td colspan='2' style='width:180px;'>
                                                <img style="position:absolute;top:30px;right:10px;width:200px; z-index: 0;opacity: 0.8;" src="http://vcom.nsoftpos.com/upload/hum.jpg" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >&nbsp;</td>
                                            <td colspan="2" style="text-align: center;font-size:30px;background-color:#f00;opacity:0.6;color:#CF3;font-weight: bold"><?php echo $company['LanLineNo'] ?></td>
                                            <td >&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td >&nbsp;</td>
                                            <td colspan="2" style="text-align: center;font-size:25px;background-color:#f00;opacity:0.6;color:#CF3;font-weight: bold"><?php echo $company['Fax'] ?></td>
                                            <td >&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr style="text-align:center;font-size:17px;font-weight: bold;font-family: Arial, Helvetica, sans-serif;background-color:#f00;color:#000">
                                            <td colspan="6"> <?php echo strtoupper($company['AddressLine01']) ?><?php echo strtoupper($company['AddressLine02']) ?><?php echo strtoupper($company['AddressLine03']) ?></td>
                                        </tr>
                                    <?php } elseif ($_SESSION['location'] == 3) { ?>
                                        <tr>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'><img style="position:absolute;top:300px;left:125px;width:300px; z-index: 0;opacity: 0.2;" src="http://vcom.nsoftpos.com/upload/apple.png" /></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:100px;'></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <!--<img style="position:absolute;top:5px;right:10px;width:700px; z-index: 0;opacity: 1;" src="../../upload/navo.jpg" />-->
                                                <img style="width:100%;" src="http://vcom.nsoftpos.com/upload/navo.jpg">
                                            </td>
    <!--                                        <td style='width:100px;'>
                                                <img style="width:100px;" src="http://vcom.nsoftpos.com/upload/Huawei.jpg">
                                            </td>
                                            <td colspan='3' style='text-align:center;width:280px;font-size:43px;'><b><?php echo $company['CompanyName'] ?></b><br /><span style="font-size:36px">&nbsp;&nbsp;<?php echo $company['CompanyName2'] ?></span></td>
                                            <td colspan='2' style='width:180px;'>
                                                <img style="position:absolute;top:30px;right:10px;width:200px; z-index: 0;opacity: 0.8;" src="http://vcom.nsoftpos.com/upload/hum.jpg" />
                                            </td>-->
                                        </tr>
                                        <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;background-color:#89c390;color:#000">
                                            <td colspan="6"> <?php echo strtoupper($company['AddressLine01']) ?><?php echo strtoupper($company['AddressLine02']) ?><?php echo strtoupper($company['AddressLine03']) ?></td>
                                        </tr>
                                    <?php } elseif ($_SESSION['location'] == 2) { ?>
                                        <tr>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'><img style="position:absolute;top:400px;left:125px;width:300px; z-index: 0;opacity: 0.2;" src="http://vcom.nsoftpos.com/upload/appl2.png" /></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:100px;'></td>
                                        </tr>
                                        <tr>
    <!--                                        <td style='width:100px;'>
                                                <img style="width:100px;" src="http://vcom.nsoftpos.com/upload/Huawei.jpg">
                                            </td>-->
                                            <td colspan='4' style='text-align:left;width:280px;font-size:60px;'><b><?php echo $company['CompanyName'] ?></b><br /><span style="font-size:40px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $company['CompanyName2'] ?></span></td>
                                            <td colspan='2' style='width:180px;'>
                                                <img style="position:absolute;top:10px;right:10px;width:200px; z-index: 0;opacity: 0.8;" src="http://vcom.nsoftpos.com/upload/hum.jpg" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >&nbsp;</td>
                                            <td colspan="2" style="font-size:25px;background-color:#f00;opacity:0.6;color:#CF3"><?php echo $company['LanLineNo'] ?></td>
                                            <td >&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left;">Email : </td>
                                            <td colspan="3" style="text-align:left;">janakaprasadh123@yahoo.com<br />
                                                janakaprasadh1234@gmail.com
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;background-color:#89c390;color:#000">
                                            <td colspan="6"> <?php echo strtoupper($company['AddressLine01']) ?><?php echo strtoupper($company['AddressLine02']) ?><?php echo strtoupper($company['AddressLine03']) ?></td>
                                        </tr>

                                    <?php } elseif ($_SESSION['location'] == 7) { ?>
                                        <tr>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'></td>
                                            <td style='width:100px;'><img style="position:absolute;top:300px;left:125px;width:300px; z-index: 0;opacity: 0.2;" src="http://vcom.nsoftpos.com/upload/apple.png" /></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:80px;'></td>
                                            <td style='width:100px;'></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <!--<img style="position:absolute;top:5px;right:10px;width:700px; z-index: 0;opacity: 1;" src="../../upload/navo.jpg" />-->
                                                <img style="width:100%;" src="http://vcom.nsoftpos.com/upload/loona.jpg">
                                            </td>
    <!--                                        <td colspan='3' style='text-align:center;width:280px;font-size:43px;'><b><?php echo $company['CompanyName'] ?></b><br /><span style="font-size:36px">&nbsp;&nbsp;<?php echo $company['CompanyName2'] ?></span></td>
                                            <td colspan='2' style='width:180px;'>
                                                <img style="position:absolute;top:30px;right:10px;width:200px; z-index: 0;opacity: 0.8;" src="http://vcom.nsoftpos.com/upload/hum.jpg" />
                                            </td>-->
                                        </tr>
                                        <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;background-color:#89c390;color:#000">
                                            <td colspan="6"> <?php echo strtoupper($company['AddressLine01']) ?><?php echo strtoupper($company['AddressLine02']) ?><?php echo strtoupper($company['AddressLine03']) ?></td>
                                        </tr>
                                    <?php } ?>


                                    <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:right;font-size:13px;">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr style="font-size:13px;">
                                        <td style="text-align:right;">Name : </td>
                                        <td colspan="2" id="customer" >&nbsp;</td>
                                        <td colspan="2" style="text-align:right;font-size:15px;">Invoice No : </td>
                                        <td id="invNumber2" style="text-align:right;font-size:15px;">&nbsp;</td>
                                    </tr>
                                    <tr >
                                        <td style="text-align:right;font-size:15px;">Address : </td>
                                        <td colspan="2" rowspan="2" id="address" valign="top" >&nbsp;</td>
                                        <td colspan="2"  style="text-align:right;font-size:15px;"> Date : </td>
                                        <td id="invoiceDate2"  style="text-align:right;font-size:15px;">&nbsp;</td>
                                    </tr>
                                    <tr >
                                        <td style="text-align:right;font-size:15px;"></td>
                                        <td >&nbsp;</td>
                                        <td style="text-align:right;font-size:15px;"></td>
                                        <td >&nbsp;</td>
                                    </tr>
                                </table>
                                <style>#tblData td{padding: 4px;vertical-align: text-top;}</style>
                                <table id="tblData"  style="border-collapse:collapse;width:600px;height:350px;font-size:14px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                    <thead>
                                        <tr style="text-align:center;border:#000 solid 1px;font-weight: bold">
                                            <td style="width:50px;text-align:center;border:#000 solid 1px;"> Qty</td>
                                            <td style="width:300px;text-align:center;border:#000 solid 1px;">Description</td>
                                            <td style="width:120px;text-align:center;border:#000 solid 1px;">Unit Price(Rs)</td>
                                            <td style="width:130px;text-align:center;border:#000 solid 1px;">Net Amount(Rs)</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot style='border:#000 solid 1px;'>
                                        <tr >
                                            <td></td>
                                            <td>N.I.C No.</td>
                                            <td style="text-align: right;border-right:1px #000 solid;font-weight: bold ">Full Amount</td>
                                           <td style="text-align:right;font-weight: bold"  id="invTotal2">0.00</td>
                                        </tr>
<!--                                        <tr id="discountRow2">
                                            <td colspan="3" style="text-align: right;border-right:1px #000 solid;">Total Discount</td>
                                            <td style="text-align:right"  id="invTotalDis2">0.00</td>
                                        </tr>
                                        <tr  id="netAmountRow2">
                                            <td colspan="3"  style="text-align: right;border-right:1px #000 solid;">Net Amount</td>
                                            <td style="text-align:right"  id="invNet2">0.00</td>
                                        </tr>-->
                                        <tr  id="cusPayRow2">
                                            <td></td>
                                            <td>SIM No.</td>
                                            <td  style="text-align: right;border-right:1px #000 solid;font-weight: bold">Advance</td>
                                            <td style="text-align:right"  id="invCusPay2">0.00</td>
                                        </tr>
                                        <tr  id="balanceRow2">
                                            <td colspan="3" id="crdLabel2" style="text-align: right;border-right:1px #000 solid;font-weight: bold">Balance</td>
                                            <td style="text-align:right"  id="invBalance2">0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <table  style="position:absolute;top:700px;border-collapse:collapse;width:600px;font-size:14px;margin:5px 5px 30px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                    <tr>
                                        <td style='width:100px;'></td>
                                        <td style='width:100px;'></td>
                                        <td style='width:100px;'></td>
                                        <td style='width:80px;'></td>
                                        <td style='width:80px;'></td>
                                        <td style='width:100px;'></td>
                                    </tr>
                                    <tr style="text-align:center">
                                        <td style="border-top:dotted 1px #000;">Prepared by</td>
                                        <td>&nbsp;</td><td>&nbsp;</td>
                                        <td >&nbsp;</td>
                                        <td colspan="2" style="border-top:dotted 1px #000;">Customer Signature</td>
                                    </tr>
                                    <tr style="text-align:center">
                                        <td colspan="6" >&nbsp;</td>
                                    </tr>
                                    <?php if ($_SESSION['location'] == 10) { ?>
                                        <tr style="text-align:left;font-size:17px;">
                                            <td colspan="6" >Any compliant to sms <?php echo $company['MobileNo'] ?></td>
                                        </tr>
                                        <tr style="text-align:left;font-size:15px;">
                                            <td colspan="6">Every mobile phones have 1 year warranty . Every accessory for 6 months warranty .</td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td colspan="6">
                                                &nbsp;<!--<img src="f.png" style='width:100%'>--> 
                                            </td>
                                        </tr> 
                                        <tr style="text-align:center;font-size:20px;">
                                            <td colspan="6" style='background-color:#f00;color:#000'><b>Thank you come again.</b></td>
                                        </tr>
                                    <?php } elseif ($_SESSION['location'] == 3) { ?>
                                        <tr style="text-align:left">
                                            <td colspan="6" >Any compliant to sms <?php echo $company['MobileNo'] ?></td>
                                        </tr>
                                        <tr style="text-align:left">
                                            <td colspan="6">Every mobile phones have 1 year warranty . Every accessory for 6 months warranty .</td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td colspan="6"><img src="http://vcom.nsoftpos.com/upload/ft.jpg" style='width:100%'> </td>
                                        </tr> 
    <!--                                    <tr style="text-align:center;font-size:15px;">
                                            <td colspan="6" style='background-color:#f00;color:#CF3'><b>Thank you come again.</b></td>
                                        </tr>-->
                                    <?php } elseif ($_SESSION['location'] == 2) { ?>
                                        <tr style="text-align:center">
                                            <td colspan="6"><i>ජංගම දුරකථන සඳහා වසර 1ක වගකීමක්ද, අමතර කොටස් සඳහා මාස 6ක වගකීමක්ද සහිතයි. </i></td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td colspan="6" ><b> අපගේ සේවාවෙන් ඔබ තෘප්තිමත් නොවන්නේ නම් <?php echo $company['MobileNo'] ?> අංකයට කෙටි පණිවිඩයක් යොමු කරන්න.</b></td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td colspan="6"><img src="http://vcom.nsoftpos.com/upload/ft.jpg" style='width:100%'> </td>
                                        </tr> 
    <!--                                    <tr style="text-align:center;font-size:15px;">
                                            <td colspan="6" style='background-color:#f00;color:#CF3'><b>Thank you come again.</b></td>
                                        </tr>-->
                                    <?php } elseif ($_SESSION['location'] == 7) { ?>
                                        <tr style="text-align:left">
                                            <td colspan="6" >Any compliant to sms <?php echo $company['MobileNo'] ?></td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td colspan="6">සියළුම විද්‍යුත් උපකරණ සඳහා මාස 6 ක වගකීමක් ඇත.</td>
                                        </tr>
                                        <tr style="text-align:center">
                                            <td colspan="6"><img src="http://vcom.nsoftpos.com/upload/loonaft.jpg" style='width:100%'> </td>
                                        </tr>
                                    <?php } ?>

                                    <tr style="text-align:left;font-size:12px;">
                                        <td colspan="4" style="text-align:left;font-size:12px;"><i>Software By NSOFT  &copy; All Rights Reserved&nbsp;</i></td>
                                        <td>&nbsp;</td><td style="text-align:left;font-size:12px;"><i>&nbsp;www.nsoft.lk</i></td>
                                    </tr>
                                </table>
                            </div>
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