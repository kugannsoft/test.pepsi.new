<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
#gridarea {
    display: flex;
    overflow: scroll;
    background: rgba(136, 153, 119, 0.23);
    height: 400px;
    padding: 2px;
}

#tbl_est_data tbody tr td {
    padding: 13px;
}

.editrowClass {
    background-color: #f1b9b9;
}

.fullpad div {
    padding-left: 0px;
    padding-right: 0px;
}
</style>
<div class="content-wrapper" id="app">
    <div class="box-header" style="background: #b4f3c8">
        <div class="col-sm-4"><span><b><?php echo $pagetitle; ?></b></span>

        </div>
        <div class="col-sm-8">
            <div class="row">
                <?php if($invHed->InvIsCancel==1){$disabled='disabled'; }else{$disabled='';}?>

                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-1"></div>
                <?php if (in_array("SM162", $blockView) || $blockView == null) { ?>
                <div class="col-sm-2">
                    <button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print
                    </button>
                </div>
                <?php } ?>
                <!--div class="col-sm-1"><a href="<?php echo base_url('admin/Salesinvoice/view_sales_invoice_pdf/') . base64_encode($invNo); ?>" target="blank_" class="btn btn-primary btn-sm">Pdf</a></div-->
                <div class="col-sm-1"><a
                        href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?action=1&id=') . base64_encode($invNo); ?>"
                        target="blank_" class="btn btn-info btn-sm">Clone</a></div>
                <?php if (in_array("SM42", $blockEdit) || $blockEdit == null) { ?>
                <!-- <div class="col-sm-1"><?php if ($ispayment == 0 && $invHed->InvIsCancel == 0) { ?>
                    <a href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?action=2&id=') . base64_encode($invNo); ?>"
                        target="blank_" class="btn btn-info btn-sm">Edit</a>
                    <?php } ?>
                </div> -->
                <?php } ?>
                <?php if (in_array("SM42", $blockDelete) || $blockDelete == null) { ?>
                <div class="col-sm-2"><?php if ($invHed->InvIsCancel == 0) { ?>
                    <button type="button" <?php echo $disabled; ?> id="btnCancel"
                        class="btn btn-danger btn-sm btn-block">Cancel</button><?php } ?>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
        </div>

        <!-- </div> -->
    </div><!-- /.box-header -->
    <!-- <section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="pull-right">
        <?php if($invHed->InvIsCancel==1){$disabled='disabled'; }else{$disabled='';}?>
         <button type="button" <?php echo $disabled;?> id="btnCancel" class="btn btn-danger btn-lg btn-block">Cancel Invoice</button>
        </div>
        <div class="pull-right">
         <button type="button" id="btnPrint" class="btn btn-primary btn-lg btn-block">Print</button><button type="button" id="btnPrint2" class="btn btn-primary btn-lg btn-block">Print 2</button>
        </div>
    </section> -->

    <section class="content">
        <div class="row">
            <div class="col-lg-8">

                <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
                <div class="row" id="printArea" align="left" style='margin:5px;'>
                    <!-- load comapny common header -->
                    <?php  $this->load->view('admin/_templates/company_header.php',true); ?>
                    <table style="border-collapse:collapse;width:730px;font-family: Arial, Helvetica, sans-serif;"
                        border="0" align="left">
                        <tr style="text-align:left;font-size:15px;">
                            <td colspan="2"> <?php if($invHed->SalesInvType==2){?> Vat Reg No:
                                <?php   echo  $invCus->DocNo; } ?></td>
                        
                        </tr>

                        <tr style="text-align:left;font-size:15px;">
                           
                        <tr style="text-align:left;font-size:13px;">
                         

                            <td colspan="4" style="text-align:right;"><b>&nbsp;INVOICE</b></td>
                        </tr>
                 
                        <tr style="text-align:left;font-size:13px;">
                            <td style="text-align:left;">Customer Code</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;"><?php echo $invHed->SalesCustomer; ?></td>
                            <td></td>
                            <td style="text-align:left;">Invoice Number</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;"><?php echo $invHed->SalesInvNo; ?></td>
                        </tr>
                        <tr style="text-align:left;font-size:13px;">
                            <td style="text-align:left;">Invoice Customer</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;"><?php echo $invCus->CusName; ?></td>
                            <td></td>

                            <td style="text-align:left;">Invoice Date</td>
                            <td style="text-align:left;">:</td>

                            <td style="text-align:right;"><?php echo date('Y-m-d', strtotime($invHed->SalesDate)); ?>
                            </td>

                        </tr>



                        <tr style="text-align:left;font-size:13px;">
                            <td style="text-align:left;">Customer Address</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;">
                                <?php echo $invCus->Address01; ?>
                                <?php echo $invCus->Address02; ?>
                                <?php echo $invCus->Address03; ?>
                            </td>
                            <td></td>

                            <td style="text-align:left;">Invoice Time</td>
                            <td style="text-align:left;">:</td>

                            <td style="text-align:right;"><?php echo date('H:i:s', strtotime($invHed->SalesDate)); ?>
                            </td>


                        </tr>
                        <tr style="text-align:left;font-size:13px;">
                            <td style="text-align:left;">Customer Contact No</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;">
                                <?php echo $invCus->MobileNo; ?>
                            </td>
                            <td></td>
                            <td style="text-align:left;">Invoice Route</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;"><?php echo $SalesPerson->name; ?></td>
                        </tr>
                        <tr style="text-align:left;font-size:13px;">
                            <td style="text-align:left;">Previous Outstanding</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;">
                                <?php echo ($cusOutstanding->CusOustandingAmount)-($invHed->SalesCreditAmount); ?></td>
                            <td></td>

                            <td style="text-align:left;">Invoiced By</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;"><?php echo $SalesPerson->RepName; ?></td>
                        </tr>
                        <tr style="text-align:left;font-size:13px;">
                            <td style="text-align:left;">Total Outstanding</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;">
                                <?php echo $cusOutstanding->CusOustandingAmount; ?>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td style="text-align:left;">Number of Items</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:right;"><?php echo $itemCount; ?></td>
                         
                            </td>
                        </tr>

                        <!--    <tr style="text-align:left;font-size:12px;">-->
                        <!--        <td> &nbsp;</td>-->
                        <!--        <td style="text-align:left;border-left: 1px solid #000;border-top:1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;INVOICE NO.</td>-->
                        <!--        <td style="border-top: 1px solid #000;"></td>-->
                        <!--        <td colspan="2" style="text-align:left;border-right: 1px solid #000;border-top: 1px solid #000;">&nbsp;&nbsp;ORDER NO.</td>-->
                        <!--    </tr>-->
                        <!--    <tr style="text-align:left;font-size:12px;">-->
                        <!--        <td> &nbsp;</td>-->
                        <!--        <td style="padding-top:0px;font-size:11px;text-align:right;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">--><?php //echo $invHed->SalesInvNo ?>
                        <!--&nbsp;&nbsp;</td>-->
                        <!--        <td style="border-bottom: 1px solid #000;"></td>-->
                        <!--        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;">--><?php //echo $invHed->SalesPONumber; ?>
                        <!--&nbsp;&nbsp;</td>-->
                        <!--    </tr>-->
                        <!--    <tr style="text-align:left;font-size:12px;">-->
                        <!--        <td> &nbsp;</td>-->
                        <!--        <td style="text-align:left;border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;DATE</td>-->
                        <!--        <td ></td>-->
                        <!--        <td colspan="2" style="text-align:left;border-right: 1px solid #000;">&nbsp;&nbsp;CUSTOMER NO.</td>-->
                        <!--    </tr>-->
                        <!--    <tr style="text-align:left;font-size:13px;">-->
                        <!--        <td> &nbsp;</td>-->
                        <!--        <td style="font-size:11px;text-align:right;border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;">--><?php //echo $invHed->SalesDate;?>
                        <!--&nbsp;&nbsp;</td>-->
                        <!--        <td style="border-bottom: 1px solid #000;"></td>-->
                        <!--        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;">--><?php // echo $invCus->CusCode;?>
                        <!--&nbsp;&nbsp;</td>-->
                        <!--    </tr>-->
                        <!--    <tr style="text-align:left;font-size:12px;">-->
                        <!--        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:left;font-size:13px;border-left: 1px solid #000;border-right: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;INSURER </td><td></td><td colspan="2" style="border-right: 1px solid #000;">&nbsp;&nbsp;ISSUED BY</td>-->
                        <!--    </tr>-->
                        <!--    <tr style="text-align:left;font-size:12px;">-->
                        <!--        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:right;font-size:11px;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">--><?php ////if($invHed->SalesInvType==1){?>
                        <!----><?php //echo $invHed->VComName; //}?>
                        <!--&nbsp;&nbsp;</td><td style="border-bottom: 1px solid #000;"></td><td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;">--><?php // echo $invHed->first_name." ".$invHed->last_name[0];?>
                        <!--&nbsp;&nbsp;</td>-->
                        <!--    </tr>-->
                        <!--        </table>-->
                        <!--        <table  class="tblhead"  style="margin-top:3px;font-size:12px;border-collapse:collapse;width:730px;font-family: Arial, Helvetica, sans-serif;" >-->
                        <!--  <tr style=" border: 1px solid black;">-->
                        <!--    <td  style="border: 1px solid black;width: 150px;">REG. NO. <br> &nbsp;&nbsp; <span style="text-align: center;font-size:11px;">--><?php //echo $invHed->SalesVehicle;?>
                        <!--</span></td>-->
                        <!--    <td  style="border: 1px solid black;width: 150px;">CHASSIS NO. <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;">--><?php //if(isset($invVehi)){ echo $invVehi->ChassisNo;}?>
                        <!--</span></td>-->
                        <!--    <td  style="border: 1px solid black;width: 150px;">MAKE <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;">--><?php //if(isset($invVehi)){ echo $invVehi->make;} ?>
                        <!--</span></td>-->
                        <!--    <td  style="border: 1px solid black;width: 150px;">MODEL <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;">--><?php // if(isset($invVehi)){ echo $invVehi->model;}?>
                        <!--</span></td>-->
                        <!--  </tr>-->
                        <!--  </table>-->


                        <style type="text/css" media="screen">
                        #tbl_po_data2 tbody tr td {
                            padding: 5px !important;
                            border-bottom: 1px solid #fff !important;
                        }
                        </style>
                        <table id="tbl_po_data" style="border-collapse:collapse;width:730px;padding:5px;font-size:15px;"
                            border="0">
                            <?php if($invHed->SalesInvType==2 || $invHed->SalesInvType==3){?>
                            <thead id="taxHead" border="1">
                                <tr>
                                    <td colspan="5"
                                        style="border-top:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff; text-align: right;">
                                    </td>
                                </tr>
                                <tr
                                    style="background-color:#5d5858 !important; color:#fff !important; line-height:20px; border-bottom:1px solid #000000; border-top:1px solid #000000;">
                                    <th style="width:80px; padding:3px; color:#fff; text-align:center;">Item Code</th>
                                    <th style="width:180px; padding:3px; color:#fff; text-align:center;">Description
                                    </th>
                                    <th style="width:60px; padding:3px; color:#fff; text-align:center;">Unit Per Case
                                    </th>
                                    <th style="width:60px; padding:3px; color:#fff; text-align:center;">Qty</th>
                                    <th style="width:60px; padding:3px; color:#fff; text-align:center;">Free Qty</th>
                                    <th style="width:80px; padding:3px; color:#fff; text-align:center;">Unit Price</th>
                                    <th style="width:80px; padding:3px; color:#fff; text-align:center;">Discount %</th>
                                    <th style="width:120px; padding:3px; color:#fff; text-align:center;">Discount Amount
                                    </th>
                                    <th style="width:80px; padding:3px; color:#fff; text-align:center;">Amount</th>
                                </tr>
                            </thead>

                            <?php }elseif($invHed->SalesInvType==1){?>
                            <thead id="invHead" border="1">
                                <tr
                                    style="background-color:#5d5858 !important; color:#fff !important; line-height:20px; border:1px solid #000000;">
                                    <th style="width:80px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Item Code</th>
                                    <th style="width:180px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Description</th>
                                    <th style="width:60px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Unit Per Case</th>
                                    <th style="width:60px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Qty</th>
                                    <th style="width:60px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Free Qty</th>
                                    <th style="width:80px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Unit Price</th>
                                    <th style="width:80px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Discount %</th>
                                    <th style="width:120px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Discount Amount</th>
                                    <th style="width:80px; padding:3px; text-align:center; border:1px solid #000000;">
                                        Amount</th>
                                </tr>
                            </thead>

                            <?php } ?>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($invDtl as $invdata) {
                                        if ($invdata->Is_Return != 0) continue;

                                        if ($invHed->SalesInvType == 1 || $invHed->SalesInvType == 3) {
                                           
                                    ?>
                                <tr style="line-height:14px; border:1px solid #000000;">
                                    <td style="width:80px; border-right:1px solid #000000;">
                                        <?php echo $invdata->SalesProductCode; ?></td>
                                    <td style="width:180px; border-right:1px solid #000000;">
                                        <?php echo $invdata->SalesProductName."<br>".$invdata->SalesSerialNo; ?>
                                    </td>
                                    <td style="width:60px; border-right:1px solid #000000; text-align:center;">
                                        <?php echo number_format(($invdata->SalesUnitPerCase), 0); ?>
                                    </td>
                                    <td style="width:60px; border-right:1px solid #000000; text-align:center;">
                                        <?php echo number_format(($invdata->SalesQty), 0); ?>
                                    </td>
                                    <td style="width:60px; border-right:1px solid #000000; text-align:center;">
                                        <?php echo number_format(($invdata->SalesFreeQty), 0); ?>
                                    </td>
                                    <td style="width:80px; border-right:1px solid #000000; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format(($invdata->SalesUnitPrice), 2); ?>
                                    </td>
                                    <td style="width:80px; border-right:1px solid #000000; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format(($invdata->SalesDisPercentage), 2); ?>
                                    </td>
                                    <td style="width:120px; border-right:1px solid #000000; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format(($invdata->SalesDisValue), 2); ?>
                                    </td>
                                    <td style="width:80px; border-right:1px solid #000000; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format(($invdata->SalesInvNetAmount), 2); ?>
                                    </td>
                                </tr>
                                <?php
    } elseif ($invHed->SalesInvType == 2) {
        // Tax invoice
?>
                                <tr style="line-height:14px; border:1px solid #000000;">
                                    <td style="width:80px; border-bottom:1px solid #e4dbdb;">
                                        <?php echo $invdata->SalesProductCode; ?></td>
                                    <td style="width:180px; border-bottom:1px solid #e4dbdb;">
                                        <?php echo $invdata->SalesProductName . "<br>" . $invdata->SalesSerialNo; ?>
                                    </td>
                                    <td style="width:60px; border-right:1px solid #000000; text-align:center;">
                                        <?php echo number_format($invdata->SalesUnitPerCase, 0); ?>
                                    </td>
                                    <td style="width:60px; border-bottom:1px solid #e4dbdb; text-align:center;">
                                        <?php echo number_format($invdata->SalesQty, 0); ?>
                                    </td>
                                    <td style="width:60px; border-right:1px solid #000000; text-align:center;">
                                        <?php echo number_format($invdata->SalesFreeQty, 0); ?>
                                    </td>
                                    <td style="width:80px; border-bottom:1px solid #e4dbdb; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format($invdata->SalesUnitPrice, 2); ?>
                                    </td>
                                    <td style="width:80px; border-bottom:1px solid #e4dbdb; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format($invdata->SalesDisPercentage, 2); ?>
                                    </td>
                                    <td style="width:120px; border-bottom:1px solid #e4dbdb; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format($invdata->SalesDisValue, 2); ?>
                                    </td>
                                    <td style="width:80px; border-bottom:1px solid #e4dbdb; text-align:right;"
                                        class="text-right">
                                        <?php echo number_format($invdata->SalesTotalAmount, 2); ?>
                                    </td>
                                </tr>
                                <?php
    }
    $i++;
}
?>

                            </tbody>

                            <tfoot>



                                <?php
                            $payment_term ='';
                            if($invHed->SalesInvType==2){ ?>
                                <tr style="line-height:25px; border-top:1px solid #000000;  border-right:1px solid #000000;"
                                    id="rowTotal">
                                    <td colspan="6"
                                        style="border-top: 1px #000000 solid;border-right: 1px #000000 solid;"></td>
                                    <td style="text-align:right;padding: 3px;">Total Amount</td>
                                    <td id="lbltotalPOAmount" style='text-align:right;padding: 3px;'>
                                        <?php echo number_format($invHed->SalesInvAmount,2);?></td>
                                </tr><?php }else{ ?>
                                <tr style="line-height:25px; border-top:1px solid #000000; border-right:1px solid #000000;"
                                    id="rowTotal">
                                    <td colspan="7" style="border-bottom: 1px #00000 solid;"></td>
                                    <td
                                        style="text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;">
                                        Total Amount</td>
                                    <td id="lbltotalPOAmount"
                                        style='text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>
                                        <?php echo number_format($invHed->SalesInvAmount,2);?></td>
                                </tr>

                                <?php } ?>

                                <?php
                            $payment_term ='';
                            if($invHed->SalesInvType==2){ ?>
                                <tr style="line-height:25px; border-right:1px solid #000000;" id="rowTotal">
                                    <td colspan="6"
                                        style="border-top: 1px #000000 solid;border-right: 1px #000000 solid;"></td>
                                    <td style="text-align:right;padding: 3px;">Dis Amount</td>
                                    <td id="lbltotalPOAmount" style='text-align:right;padding: 3px;'>
                                        <?php echo number_format($invHed->SalesDisAmount,2);?></td>
                                </tr><?php }else{ ?>
                                <tr style="line-height:25px; border-right:1px solid #000000;" id="rowTotal">
                                    <td colspan="7" style="border-bottom: 1px #00000 solid;"></td>
                                    <td
                                        style="text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;">
                                        Dis Amount</td>
                                    <td id="lbltotalPOAmount"
                                        style='text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>
                                        <?php echo number_format($invHed->SalesDisAmount,2);?></td>
                                </tr>

                                <?php } ?>

                                <?php
                            $payment_term ='';
                            if($invHed->SalesInvType==2){ ?>
                                <tr style="line-height:25px; border-right:1px solid #000000;" id="rowTotal">
                                    <td colspan="6"
                                        style="border-top: 1px #000000 solid;border-right: 1px #000000 solid;"></td>
                                    <td style="text-align:right;padding: 3px;">Net Amount</td>
                                    <td id="lbltotalPOAmount" style='text-align:right;padding: 3px;'>
                                        <?php echo number_format($invHed->SalesNetAmount,2);?></td>
                                </tr><?php }else{ ?>
                                <tr style="line-height:25px;  border-right:1px solid #000000;" id="rowTotal">
                                    <td colspan="7" style="border-bottom: 1px #00000 solid;"></td>
                                    <td
                                        style="text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;">
                                        Net Amount</td>
                                    <td id="lbltotalPOAmount"
                                        style='text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>
                                        <?php echo number_format($invHed->SalesNetAmount,2);?></td>
                                </tr>

                                <?php } ?>

                                <?php
                            $payment_term ='';
                            if($invHed->SalesInvType==2){ ?>
                                <tr style="line-height:25px; border-right:1px solid #000000;" id="rowTotal">
                                    <td colspan="6"
                                        style="border-top: 1px #000000 solid;border-right: 1px #000000 solid;"></td>
                                    <td style="text-align:right;padding: 3px;">Credit Pay:</td>
                                    <td id="lbltotalPOAmount" style='text-align:right;padding: 3px;'>
                                        <?php echo number_format($invHed->SalesCreditAmount,2);?></td>
                                    <td colspan="6"
                                        style="border-top: 1px #000000 solid;border-right: 1px #000000 solid;"></td>
                                    <td style="text-align:right;padding: 3px;">Credit Pay:</td>
                                    <td id="lbltotalPOAmount" style='text-align:right;padding: 3px;'>
                                        <?php echo number_format($invHed->SalesCreditAmount,2);?></td>
                                </tr><?php }else{ ?>
                                <tr style="line-height:25px; border-right:1px solid #000000;" id="rowTotal">
                                    <td colspan="7" style="border-bottom: 1px #00000 solid;"></td>
                                    <td
                                        style="text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;">
                                        Credit Pay:</td>
                                    <td id="lbltotalPOAmount"
                                        style='text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>
                                        <?php echo number_format($invHed->SalesCreditAmount,2);?></td>
                                </tr>

                                <?php } ?>

                                <?php if($invHed->SalesCashAmount>0){
                                    
                                    ?>

                                    <tr style="line-height:25px; border-right:1px solid #000000;" id="rowTotal">
                                    <td colspan="7" style="border-bottom: 1px #00000 solid;"></td>
                                    <td
                                        style="text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;">
                                        Cash Amount:</td>
                                    <td id="lbltotalPOAmount"
                                        style='text-align:right;padding: 3px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>
                                        <?php echo number_format($invHed->SalesCashAmount,2);?></td>
                                </tr>
                                    
                                <?php } ?>
                                
                                <?php if($invHed->SalesVatAmount>0 && $invHed->SalesInvType==2){?>
                                <tr style="line-height:25px;" id="rowVAT">
                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;">
                                    </td>
                                    <td style="text-align:right">VAT Amount </td>
                                    <td id="lbltotalVat" style='text-align:right'>
                                        <?php echo number_format($invHed->SalesVatAmount,2);?></td>
                                </tr><?php } ?>
                                <?php if($invHed->SalesNbtAmount>0 && $invHed->SalesInvType==2){?>
                                <tr style="line-height:25px;" id="rowNBT">
                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;">
                                    </td>
                                    <td style="text-align:right">NBT Amount </td>
                                    <td id="lbltotalNbt" style='text-align:right'>
                                        <?php echo number_format($invHed->SalesNbtAmount,2);?></td>
                                </tr>
                                <?php } ?>
                                <?php if($invHed->SalesShipping>0){?>
                                <tr style="line-height:25px;" id="rowDiscount">
                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;">
                                    </td>
                                    <td style="text-align:right"><?php echo $invHed->SalesShippingLabel; ?> </td>
                                    <td id="lbltotalDicount" style='text-align:right'>
                                        <?php echo number_format($invHed->SalesShipping,2);?></td>
                                </tr>
                                <?php }?>
                                <!--                            --><?php //if($invHed->SalesVatAmount>0 || $invHed->SalesNbtAmount>0 || $invHed->SalesShipping>0 || $invHed->SalesDisAmount>0){?>
                                <!--                                <tr style="line-height:25px;" id="rowNET">-->
                                <!--                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="font-weight:bold;text-align:right">Total  </td><td id="lbltotalNet"   style='font-weight:bold;text-align:right'>--><?php //echo number_format($invHed->SalesNetAmount,2);?>
                                <!--</td>-->
                                <!--                                </tr>-->
                                <!--                            --><?php //} ?>

                                <!---->
                                <!--                            --><?php //if($invHed->SalesInvType==2){
//
//                                ?>
                                <!--                                <tr style="line-height:25px;" id="rowDiscount">-->
                                <!--                                    <td colspan="7" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;"> Total Dis Amount </td>-->
                                <!--                                    <td id="lbltotalDicount"   style='text-align:right; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>--><?php //echo number_format($invHed->SalesDisValue,2);?>
                                <!--</td>-->
                                <!--                                </tr>-->
                                <!--                            --><?php //} else { ?>
                                <!--                            <tr style="line-height:25px;">-->
                                <!--                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right"> </td><td id=""   style='text-align:right'></td>-->
                                <!--                                </tr>-->
                                <!---->
                                <!--                            --><?php //} ?>
                                <!--                            --><?php //if($invHed->SalesInvType==2){
//
//                                ?>
                                <!--                                <tr style="line-height:25px;" id="rowDiscount">-->
                                <!--                                    <td colspan="7" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;"> Net Amount</td>-->
                                <!--                                    <td id="lbltotalDicount"   style='text-align:right; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>--><?php //echo number_format($invHed->SalesCashAmount,2);?>
                                <!--</td>-->
                                <!--                                </tr>-->
                                <!--                            --><?php //} else { ?>
                                <!--                                <tr style="line-height:25px;">-->
                                <!--                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right"> </td><td id=""   style='text-align:right'></td>-->
                                <!--                                </tr>-->
                                <!---->
                                <!--                            --><?php //} ?>
                                <!--                            --><?php //if($invHed->SalesInvType==2){
//
//                                ?>
                                <!--                                <tr style="line-height:25px;" id="rowDiscount">-->
                                <!--                                    <td colspan="7" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;"> Credit Payment </td>-->
                                <!--                                    <td id="lbltotalDicount"   style='text-align:right; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;'>--><?php //echo number_format($invHed->SalesInvAmount,2);?>
                                <!--</td>-->
                                <!--                                </tr>-->
                                <!--                            --><?php //} else { ?>
                                <!--                                <tr style="line-height:25px;">-->
                                <!--                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right"> </td><td id=""   style='text-align:right'></td>-->
                                <!--                                </tr>-->
                                <!---->
                                <!--                            --><?php //} ?>
                                <!-- <?php if($invHed->SalesBankAmount>0){
                                $payment_term="Bank";
                                ?>
                                <tr style="line-height:25px;" id="rowNBT">
                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Bank Transfer  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesBankAmount,2);?></td>
                                </tr>
                            <?php } ?>
                            <?php if($invHed->SalesChequeAmount>0){
                                $payment_term="Cheque";
                                ?>
                                <tr style="line-height:25px;" id="rowNBT">
                                    <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cheque  Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesChequeAmount,2);?></td>
                                </tr>
                            <?php } ?>
                            <?php if($invHed->SalesCCardAmount>0){
                                $payment_term="Card";
                                ?>
                                <tr style="line-height:25px;" id="rowNBT">
                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Card Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesCCardAmount,2);?></td>
                                </tr>
                            <?php } ?>
                            <?php if($invHed->SalesReturnPayment>0){
                                $payment_term="Card";
                                ?>
                                <tr style="line-height:25px;" id="rowNBT">
                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Return Payment  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesReturnPayment,2);?></td>
                                </tr>
                            <?php } ?>


                            <?php if($invHed->SalesCreditAmount>0){
                                $payment_term="Credit";
                                ?>
<!--                                <tr style="line-height:25px;" id="rowVAT">-->
                                <!--                          <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;font-weight:bold;background-color:#e4dbdb !important;">TOTAL PAYABLE  </td><td id="lbltotalVat"   style='font-weight:bold;text-align:right;background-color:#e4dbdb !important;'>--><?php ////echo number_format($invHed->SalesCreditAmount,2);?>
                                <!--<!--</td>-->
                                <!--                                </tr>-->
                                <!-- <?php } ?>
                            <?php if($invHed->SalesReturnAmount>0){

                                ?>
                                <tr style="line-height:25px;" id="rowNBT">
                                    <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Return Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesReturnAmount,2);?></td>
                                </tr>
                                <tr><td colspan="6">
                                Return Items
                                <p>
                                <?php  if($returnDtlArr){ foreach ($returnDtlArr AS $rtinvdata) { ?>
                                    <?php echo $rtinvdata->SalesProductName ?>-<?php echo $rtinvdata->SalesReturnQty ?>, &nbsp;
                                <?php } ?></p>


                                    </td></tr>
                                <?php } } ?> 
<br> -->
                                <table id="tbl_po_data"
                                    style="border-collapse:collapse;width:730px;padding:5px;font-size:15px;" border="0">
                                    <?php if($invHed->SalesInvType==2 || $invHed->SalesInvType==3){?>
                                    <thead id="taxHead" border="1">
                                        <tr>
                                            <td colspan="5"
                                                style="border-top:1px solid #fff; border-left:1px solid #fff; border-right:1px solid #fff; text-align: right;">
                                            </td>
                                        </tr>
                                        <tr
                                            style="background-color:#5d5858 !important; color:#fff !important; line-height:20px; border-bottom:1px solid #000000; border-top:1px solid #000000;">
                                            <th style="width:80px; padding:3px; color:#fff; text-align:center;">Invoice
                                                Date</th>
                                            <th style="width:80px; padding:3px; color:#fff; text-align:center;">Invoice
                                                No</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Net
                                                Amount</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Credit
                                                Amount</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Settled
                                                Amount</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Due
                                                Amount</th>

                                        </tr>
                                    </thead>

                                    <?php }elseif($invHed->SalesInvType==1){?>
                                    <thead id="invHead" border="1">
                                        <tr
                                            style="background-color:#5d5858 !important; color:#fff !important; line-height:20px; border:1px solid #000000;">
                                            <th style="width:80px; padding:3px; color:#fff; text-align:center;">Invoice
                                                Date</th>
                                            <th style="width:80px; padding:3px; color:#fff; text-align:center;">Invoice
                                                No</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Net
                                                Amount</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Credit
                                                Amount</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Settled
                                                Amount</th>
                                            <th style="width:60px; padding:3px; color:#fff; text-align:center;">Due
                                                Amount</th>
                                        </tr>
                                    </thead>

                                    <?php } ?>
                                    <tbody>
                                        <?php if ($invHed->SalesInvType == 1 || $invHed->SalesInvType == 3 || $invHed->SalesInvType == 2): ?>
                                        <?php if (!empty($creditInvoiceList)) : ?>
                                        <?php foreach ($creditInvoiceList as $creditInvoice): ?>
                                        <tr style="line-height:14px; border:1px solid #000000;">
                                            <td style="width:80px; padding:2px 4px; border-right:1px solid #000000;">
                                                <?php echo date('Y-m-d', strtotime($creditInvoice->InvoiceDate)); ?>
                                            </td>

                                            <td style="width:180px; padding:2px 4px; border-right:1px solid #000000;">
                                                <?php echo $creditInvoice->InvoiceNo; ?></td>
                                            <td style="width:60px; padding:2px 4px; border-right:1px solid #000000;">
                                                <?php echo number_format($creditInvoice->NetAmount, 2); ?></td>
                                            <td style="width:60px; padding:2px 4px; border-right:1px solid #000000;">
                                                <?php echo number_format($creditInvoice->CreditAmount, 2); ?></td>
                                            <td style="width:60px; padding:2px 4px; border-right:1px solid #000000;">
                                                <?php echo number_format($creditInvoice->SettledAmount, 2); ?></td>
                                            <td style="width:60px; padding:2px 4px; border-right:1px solid #000000;">
                                                <?php echo number_format($creditInvoice->CreditAmount - $creditInvoice->SettledAmount - $creditInvoice->returnAmount, 2); ?>
                                            </td>
                                        </tr>

                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="6" style="text-align:center;">No previous credit invoices
                                                found.</td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </tbody>



                            </tfoot>
                        </table>
                        <br>
                        <table id="tbl_po_data" style="border-collapse:collapse;width:730px;padding:5px;font-size:15px;"
                            border="0">

                            <thead id="taxHead" border="1">
                                <tr>
                                    <td colspan="5"
                                        style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;">
                                    </td>
                                </tr>
                                <tr
                                    style="background-color:#5d5858 !important;color:#fff !important;line-height:20px; border-bottom:1px solid #000000; border-top:1px solid #000000; ">
                                    <th style='padding: 3px;color:#fff; text-align:center;'>Code</th>
                                    <th style='padding: 3px;color:#fff; text-align:center;'>Description</th>

                                    <th style='padding: 3px;color:#fff; text-align:center;'> Return Qty</th>
                                    <th style='padding: 3px;color:#fff; text-align:center;'>Return Type</th>


                                </tr>
                            </thead>

                            <tbody>
                                <?php
$i = 1;
foreach ($invDtl as $invdata) {
    if ($invdata->Is_Return == 1) {
        ?>
                                <tr style="line-height:14px; border:1px solid #000000;">
                                    <td style="width:80px; border-right:1px solid #000000;">
                                        <?php echo $invdata->SalesProductCode; ?></td>
                                    <td style="width:80px; border-right:1px solid #000000;">
                                        <?php echo $invdata->SalesProductName; ?></td>
                                    <td style="width:80px; border-right:1px solid #000000;">
                                        <?php echo $invdata->SalesQty; ?></td>
                                    <td style="width:80px; border-right:1px solid #000000;">
                                        <?php
                echo ($invdata->ReturnType == 1) ? 'Normal Return' :
                    (($invdata->ReturnType == 2) ? 'Damaged Return' :
                    (($invdata->ReturnType == 3) ? 'Expired Return' : 'Sales'));
                ?>
                                    </td>
                                </tr>
                                <?php
        $i++;
    }
}
?>
                            </tbody>

                            <tfoot>



                                <?php if($orderHead->isInvoiceDiscount ==1){?>
                                <tr style="line-height:25px;" id="rowDiscount">
                                    <td colspan="5" style="border-left: 1px #fff solid;"></td>
                                    <td
                                        style="text-align:right;border-right: 1px #000 solid;border-bottom: 1px #000 solid;border-left: 1px #000 solid;">
                                        Discount </td>
                                    <td id="lbltotalDicount"
                                        style='text-align:right;border-bottom: 1px #000 solid;border-right: 1px #000 solid;'>
                                        <?php echo number_format($orderHead->discountAmount,2);?></td>
                                </tr>
                                <?php }?>
                                <!-- <?php if($invHed->SalesVatAmount>0 && $invHed->SalesInvType==2){?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">VAT Amount  </td><td id="lbltotalVat"   style='text-align:right'><?php echo number_format($invHed->SalesVatAmount,2);?></td>
                         </tr><?php } ?>
                          <?php if($invHed->SalesNbtAmount>0 && $invHed->SalesInvType==2){?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">NBT Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesNbtAmount,2);?></td>
                        </tr>
                         <?php } ?> -->


                        </table>
                        </td>
                        </tr>

                        </tfoot>
                    </table>


                    <tr>
                        <td colspan="6">
                            <table style="width:730px; font-size:14px;" border="0">
                                <!--                          <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>-->
                                <!--                          <tr><td colspan="6" style="text-align:left;font-size:14px;"><b>Remarks&nbsp;&nbsp;:&nbsp;&nbsp;</b>--><?php //echo $invHed->salesInvRemark; ?>
                                <!--</td></tr>-->

                                <!--                          <tr><td colspan="6" style="text-align:justify; font-size:12px;"><b><u>Warranty Claims</u></b><br><b>Warranty cover only Manufactures defects, damages or defects due to other causes such as negligence, mususe, improper operation-->
                                <!--                          , power fluctuation lightning or other natural disaster, sabotage or accident etc. Are not included under this warranty, Repairs or replacement necessitated by such-->
                                <!--                          causes are not covered by the warranty are subject to change for labour, time and material.</b></td></tr>-->
                                <!--                          -->
                                <!--                          <tr><td colspan="6" style="text-align:center;"><b>Goods Once Sold will not return Money.</b></td></tr>-->
                                <!--                          <tr><td colspan="5" style="text-align:left;">-->
                                <!--                           <ul>-->
                                <!--                             <!<li>No cash refunds.</li>-->
                                <!--                             <li>If supplied part is faulty has to be tested at Avinda workshop before returned.</li>-->
                                <!--                             <li>Returns accepted only within a week of transaction date.</li> -->
                                <!--                             --><?php // if($invHed->SalesInvType == 3){?>
                                <!--                                      <li>Returns accepted only within a week of transaction date - Used and electrical items returns not accepted unless approved at point of sale by management</li> -->
                                <!--                                      <li>No cash refunds</li>-->
                                <!--                                      <li>Any supplied faulty parts have to be tested at Avinda workshop to confirm failure</li>-->
                                <!--                                      <li>Payment to be made within 30 days of transaction date</li>-->
                                <!--          -->
                                <!--                                  --><?php //}else{ ?>
                                <!--                                        --><?php //foreach ($term as $val) { ?>
                                <!--                                        <li>--><?php //echo $val->InvCondition; ?>
                                <!--</li>-->
                                <!--                                        --><?php //} ?>
                                <!--                                   --><?php //}  ?>
                                <!---->
                                <!--                           </ul>-->
                                <!--                         </td></tr>-->
                                <!--                           <tr><td colspan="5" style="text-align:right;width:550px;">&nbsp;</td></tr> -->
                                <tr>
                                    <td style="width:150px;text-align: left">&nbsp;</td>
                                    <td style="width:100px;">&nbsp;</td>
                                    <td style="width:150px;text-align: center">&nbsp;</td>
                                    <td style="width:100px;">&nbsp;</td>
                                    <td style="width:200px;text-align: left">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                                    <td style="">&nbsp;</td>
                                    <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                                    <td style="">&nbsp;</td>
                                    <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-size:15px;">Recived By</td>
                                    <td style="">&nbsp;</td>
                                    <td style="text-align: center">Authorised By</td>
                                    <td style="">&nbsp;</td>
                                    <td style="text-align: center;font-size:15px;">Issued By</td>
                                    <!--                            <td style="text-align: center">--><?php //if($invHed->SalesReceiver!=''){ ?>
                                    <!--On behalf of --><?php //} ?>
                                    <!--Authorized Signature</td>-->
                                </tr>
                                <!--                        <tr>-->
                                <!--                            <td style="text-align: center"> --><?php ////echo $invHed->first_name; ?>
                                <!-- </td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--                            <td style="text-align: center"></td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--                            <td style="text-align: center"></td>-->
                                <!--                        </tr>-->
                                <!--<!                      --><?php ////if($invHed->SalesReceiver!=''){ ?>
                                <!--                         <tr>-->
                                <!--                            <td style="width:150px;text-align: left">&nbsp;</td>-->
                                <!--                            <td style="width:100px;">&nbsp;</td>-->
                                <!--                            <td style="width:150px;text-align: center">&nbsp;</td>-->
                                <!--                            <td style="width:100px;">&nbsp;</td>-->
                                <!--                            <td style="width:200px;text-align: left">&nbsp;</td>-->
                                <!--                        </tr>-->
                                <!--<tr>-->
                                <!--                            <td  >&nbsp;</td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--<td colspan="6" style="border-bottom:1px double #000;text-align: center;"><?php echo $invHed->SalesReceiver; ?></td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--                           <td style="border-bottom:1px dashed #000;text-align: center;">--><?php //echo $invHed->SalesRecNic; ?>
                                <!--</td>-->
                                <!--</tr>-->
                                <!--<tr style="text-align: center; tab-size: 20px">-->
                                <!--    <td colspan="6"><b></b></td>-->
                                <!--</tr>-->
                                <!--                         <tr>-->
                                <!--                            <td style="text-align: center">-->
                                <!--                            </td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--                            <td style="text-align: center">Name</td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--                            <td style="text-align: center">NIC</td>-->
                                <!--                        </tr>-->
                                <!--                        <tr>-->
                                <!--                            <td style="text-align: center;"></td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--                            <td style="text-align: center"></td>-->
                                <!--                            <td style="">&nbsp;</td>-->
                                <!--                            <td style="text-align: center"></td>-->
                                <!--                        </tr>-->
                                <!--                        --><?php //} ?>
                                <!--<tr><td colspan="6" style="text-align:right;">&nbsp;</td></tr> -->
                                <!--<tr><td colspan="6" style="text-align:center;font-size: 18px;"><i></i></td></tr>-->
                            </table>
                        </td>
                    </tr>

                    </tfoot>
                    </table>

                    <style type="text/css" media="screen">
                    #tbl_po_data tbody tr td {
                        padding: 13px;
                    }
                    </style>
                </div>
            </div>
            <div class="col-lg-1">
                <table class="table table-hover">
                    <thead>
                        <th>
                            <center> All Sales Invoice</center>
                        </th>
                    </thead>
                    <tbody>
                        <?php foreach($sale as $v){?>
                        <tr>
                            <td><a
                                    href="<?php echo base_url('admin/Salesinvoice/view_sales_invoice/').base64_encode($v->SalesInvNo); ?>"><?php echo $v->SalesInvNo;?></a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3">
                <table class="table">
                    <tr>
                        <td>Create by</td>
                        <td>:</td>
                        <td><?php echo $invHed->first_name." ".$invHed->last_name ?></td>
                    </tr>
                    <tr>
                        <td>Create Date</td>
                        <td>:</td>
                        <td><?php echo $invHed->SalesDate ?></td>
                    </tr>
                    <?php if($invCancel): ?>
                    <tr>
                        <td>Cancel By</td>
                        <td>:</td>
                        <td><?php echo $invCancel->first_name." ".$invHed->last_name ?></td>
                    </tr>
                    <tr>
                        <td>Cancel Date</td>
                        <td>:</td>
                        <td><?php echo $invCancel->CancelDate ?></td>
                    </tr>
                    <tr>
                        <td>Remark</td>
                        <td>:</td>
                        <td><?php echo $invCancel->Remark ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($invUpdate):  ?>
                    <tr>
                        <td colspan="3">Last Updates</td>
                    </tr>
                    <?php  foreach ($invUpdate AS $up) { ?>
                    <tr>
                        <td><?php echo $up->UpdateDate ?></td>
                        <td>:</td>
                        <td><?php echo $up->first_name." ".$up->last_name ?></td>
                    </tr>
                    <?php }
                    endif; ?>
                </table>
            </div>
        </div>

    </section>
    <div>
    </div>
</div>
<?php //die; ?>
<!-- print parts goes here -->

<!-- print 2 -->

<script type="text/javascript">
var inv = $("#inv").val();

$("#btnPrint").click(function() {
    $('#printArea').focus().print();
});

$("#btnPrint2").click(function() {
    $('#printArea2').focus().print();
});


$("#btnCancel").click(function() {

    var r = prompt('Do you really want to cancel this invoice? Please enter a remark.');

    if (r == null || r == '') {
        return false;
    } else {
        cancelInvoice(inv, r);
        return false;
    }
});



function cancelInvoice(invoice, remark) {
    $.ajax({
        url: '../../salesinvoice/cancelSalesInvoice',
        dataType: 'json',
        type: 'POST',
        data: {
            salesinvno: invoice,
            remark: remark
        },
        success: function(data) {
            if (data == 1) {
                $.notify("Invoice canceled successfully.", "success");
                $("#btnCancel").attr('disabled', true);
            } else if (data == 2) {
                $.notify(
                    "Error. Customer has done payment for this invoice. If you want to cancel this invoice please cancel the payment",
                    "danger");
                $("#btnCancel").attr('disabled', false);
            } else if (data == 3) {
                $.notify("Error. Invoice has already canceled.", "danger");
                $("#btnCancel").attr('disabled', false);
            } else if (data == 4) {
                $.notify("Error. This Invoice not in your Location Please contact Your Admin.", "danger");
                $("#btnCancel").attr('disabled', false);
            } else {
                $.notify("Error. Invoice not canceled successfully.", "danger");
                $("#btnCancel").attr('disabled', false);
            }
        }
    });
}



var Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",



    encode: function(input) {

        var output = "";

        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;

        var i = 0;



        input = Base64._utf8_encode(input);



        while (i < input.length) {



            chr1 = input.charCodeAt(i++);

            chr2 = input.charCodeAt(i++);

            chr3 = input.charCodeAt(i++);



            enc1 = chr1 >> 2;

            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);

            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);

            enc4 = chr3 & 63;



            if (isNaN(chr2)) {

                enc3 = enc4 = 64;

            } else if (isNaN(chr3)) {

                enc4 = 64;

            }



            output = output +

                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +

                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);



        }



        return output;

    },



    decode: function(input) {

        var output = "";

        var chr1, chr2, chr3;

        var enc1, enc2, enc3, enc4;

        var i = 0;



        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");



        while (i < input.length) {



            enc1 = this._keyStr.indexOf(input.charAt(i++));

            enc2 = this._keyStr.indexOf(input.charAt(i++));

            enc3 = this._keyStr.indexOf(input.charAt(i++));

            enc4 = this._keyStr.indexOf(input.charAt(i++));



            chr1 = (enc1 << 2) | (enc2 >> 4);

            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);

            chr3 = ((enc3 & 3) << 6) | enc4;



            output = output + String.fromCharCode(chr1);



            if (enc3 != 64) {

                output = output + String.fromCharCode(chr2);

            }

            if (enc4 != 64) {

                output = output + String.fromCharCode(chr3);

            }



        }



        output = Base64._utf8_decode(output);



        return output;



    },



    _utf8_encode: function(string) {

        string = string.replace(/\r\n/g, "\n");

        var utftext = "";



        for (var n = 0; n < string.length; n++) {



            var c = string.charCodeAt(n);



            if (c < 128) {

                utftext += String.fromCharCode(c);

            } else if ((c > 127) && (c < 2048)) {

                utftext += String.fromCharCode((c >> 6) | 192);

                utftext += String.fromCharCode((c & 63) | 128);

            } else {

                utftext += String.fromCharCode((c >> 12) | 224);

                utftext += String.fromCharCode(((c >> 6) & 63) | 128);

                utftext += String.fromCharCode((c & 63) | 128);

            }



        }



        return utftext;

    },



    _utf8_decode: function(utftext) {

        var string = "";

        var i = 0;

        var c = c1 = c2 = 0;



        while (i < utftext.length) {



            c = utftext.charCodeAt(i);



            if (c < 128) {

                string += String.fromCharCode(c);

                i++;

            } else if ((c > 191) && (c < 224)) {

                c2 = utftext.charCodeAt(i + 1);

                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));

                i += 2;

            } else {

                c2 = utftext.charCodeAt(i + 1);

                c3 = utftext.charCodeAt(i + 2);

                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));

                i += 3;

            }



        }



        return string;

    }



}
</script>