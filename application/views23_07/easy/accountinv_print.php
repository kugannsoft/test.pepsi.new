
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
    #gridarea {
        display: flex;
        overflow:scroll;
        background: rgba(136, 153, 119, 0.23);
        height: 400px;
        padding: 2px;
    }

    #tbl_est_data tbody tr td{
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
        <div class="col-sm-4">
            <!--            <span><b>--><?php //echo $pagetitle; ?><!--</b></span>-->

        </div>
        <div class="col-sm-8">
            <div class="row">
                <?php if($invoice_hed->IsCancel==1){$disabled='disabled'; }else{$disabled='';}?>

                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-1"></div>
                <?php if (in_array("SM162", $blockView) || $blockView == null) { ?>
                    <div class="col-sm-2">
                        <button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print
                        </button>
                    </div>
                <?php } ?>

                <?php if (in_array("SM42", $blockDelete) || $blockDelete == null) { ?>
                    <div class="col-sm-2"><?php if ($invoice_hed->IsCancel == 0) { ?>
                        <button type="button" <?php echo $disabled; ?> id="btnCancel"
                                class="btn btn-danger btn-sm btn-block">Cancel</button><?php } ?></div>
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

    </section> -->
    <section class="content">
        <div class="row">
            <div class="col-lg-8">
                <input type="hidden" name="inv" id="inv" value="<?php echo $invoice_hed->InvNo;?>">
                <div class="row" id="printArea" align="center" style='margin:5px;'>
                    <!-- load comapny common header -->
                    <?php $this->load->view('admin/_templates/company_header.php',true); ?>
                    <table style="border-collapse:collapse;width:700px;font-family: Arial, Helvetica, sans-serif;" border="0"  align="center">
                        <tr style="text-align:left;font-size:13px;">
                            <td colspan="2"> </td>
                            <td> &nbsp;</td>

                            <td colspan="4"  style="font-size:18px;font-weight: bold;text-align:right; "> EASY PAYMENT INVOICE</td>
                        </tr>
                        <tr style="text-align:left;font-size:13px;">
                            <td colspan="2" rowspan="5" style="border:1px solid #000;font-size:13px;width:250px;padding: 5px;" v-align="top">
                                <span>Customer Name:&nbsp;<a href="<?php echo base_url('admin/payment/view_customer/').$invoice_hed->CusCode ?>"><?php echo $invoice_hed->DisplayName;?></a></span><br>

                                <span >
              <?php if ($invoice_hed->DisType!=4){ ?>Customer No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php  echo $invoice_hed->CusCode;?><br>Customer Address&nbsp;:
                  <?php echo nl2br($invoice_hed->Address01)."<br>".$invoice_hed->Address02;?> <?php echo $invoice_hed->Address03;?>
              <?php }else{ ?>
                  <?php echo nl2br($invoice_hed->ComAddress);?>
              <?php } ?>
            </span><br>
                                <span id="lbladdress2">Tel : <?php echo $invoice_hed->LanLineNo;?> Mobile : <?php echo $invoice_hed->MobileNo;?></span>
                            </td>
                            <td style="font-size:14px;width:3px;"> &nbsp;</td>
                            <td style="font-size:11px;width:130px;text-align: center;border-left: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;" colspan="4">FOR REFERENCE PLEASE QUOTE THE FOLLOWING NO</td>
                            <!--                            <td style="font-size:11px;width:130px;text-align: left;border-left: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;" colspan="1">REFRRAL NO : --><?php //echo $invoice_hed->refNo; ?><!--</td>-->
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> &nbsp;</td>
                            <td style="text-align:left;border-left: 1px solid #000;border-top:1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;INVOICE NO.</td>
                            <td style="border-top: 1px solid #000;"></td>
                            <td colspan="2" style="text-align:left;border-right: 1px solid #000;border-top: 1px solid #000;">&nbsp;&nbsp;ACCOUNT NO.</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> &nbsp;</td>
                            <td style="padding-top:0px;font-size:11px;text-align:right;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $invoice_hed->InvNo ?>&nbsp;&nbsp;</td>
                            <td style="border-bottom: 1px solid #000;"></td>
                            <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $invoice_hed->AccNo; ?>&nbsp;&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> &nbsp;</td>
                            <td style="text-align:left;border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;DATE</td>
                            <td ></td>
                            <td colspan="2" style="text-align:left;border-right: 1px solid #000;">&nbsp;&nbsp;REFERENCE NO</td>
                        </tr>
                        <tr style="text-align:left;font-size:13px;">
                            <td> &nbsp;</td>
                            <td style="font-size:11px;text-align:right;border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $invoice_hed->InvDate;?>&nbsp;&nbsp;</td>
                            <td style="border-bottom: 1px solid #000;"></td>
                            <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $invoice_hed->refNo; ?>&nbsp;&nbsp;</td>
                        </tr>

                    </table>
                    <table  class="tblhead"  style="margin-top:3px;font-size:12px;border-collapse:collapse;width:700px;font-family: Arial, Helvetica, sans-serif;" >

                    </table>


                    <style type="text/css" media="screen">

                        #tbl_po_data2 tbody tr td{
                            padding: 5px  !important;
                            border-bottom:1px solid #fff !important;
                        }

                    </style>
                    <table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="0">
                        <?php if($invoice_hed->InvType==1){?>
                            <thead id="taxHead">
                            <tr><td colspan="5" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td></tr>
                            <tr style="background-color:#5d5858;color:#fff !important;line-height:30px;">
                                <th style='padding: 3px;color:#fff;'>#</th>
                                <th style='padding: 3px;color:#fff;'>Item & Description</th>
                                <!-- <th style='padding: 3px;'></th> -->
                                <th style='padding: 3px;color:#fff;'>Qty</th>
                                <th style='padding: 3px;color:#fff;text-align:right;' >Rate</th>
                                <th style='padding: 3px;color:#fff;text-align:right;'>Amount</th>
                            </tr>
                            </thead>
                        <?php }elseif($invoice_hed->InvType==2){?>
                            <thead  id="invHead">
                            <!--                            <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:30px;">-->
                            <!--                                <th style='padding: 3px;color:#fff !important;'>#</th>-->
                            <!--                                <th style='padding: 3px;color:#fff !important;'>Loan Amount</th>-->
                            <!--                                 <th style='padding: 3px;'></th> -->
                            <!--                                <th style='padding: 3px;color:#fff !important;'>Qty</th>-->
                            <!--                                <th style='padding: 3px;color:#fff !important;text-align:right;'>Rate</th>-->
                            <!--                                <th style='padding: 3px;color:#fff !important;text-align:right;'>Amount</th>-->
                            <!--                            </tr>-->
                            </thead>
                        <?php } ?>
                        <tbody>
                        <?php
                        $i=1;
                        //var_dump($invDtlArr);
                        if($invoice_hed->InvType==1){
                            foreach ($invoice_dtl AS $invdata) {

                                //normal invoice

                                ?>
                                <tr style="line-height:30px;">
                                    <td style="border-bottom:1px solid #e4dbdb;"><?php echo $i;?></td>
                                    <td style="border-bottom:1px solid #e4dbdb;" ><?php echo $invdata->Prd_AppearName;?>  - <?php echo $invdata->InvProductCode;?></td>
                                    <td style="border-bottom:1px solid #e4dbdb;"><?php echo number_format(($invdata->InvQty),0)?></td>
                                    <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->InvUnitPrice),2)?></td>
                                    <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->InvNetAmount),2)?></td>
                                </tr>
                                <?php $i++;
                            }
                        } elseif($invoice_hed->InvType==2){
//                        foreach ($invoice_dtl AS $invdata) {
//                            ?>
                            <!--                            <tr style="line-height:30px;">-->
                            <!--                                <td style="border-bottom:1px solid #e4dbdb;">--><?php //echo $i;?><!--</td>-->
                            <!--                                <td style="border-bottom:1px solid #e4dbdb;" >--><?php //echo $invdata->Prd_AppearName;?><!-- - (--><?php //echo $invdata->InvProductCode;?><!--</td>-->
                            <!--                                <td style="border-bottom:1px solid #e4dbdb;">--><?php //echo number_format(($invdata->InvQty),2)?><!--</td>-->
                            <!--                                <td style="border-bottom:1px solid #e4dbdb;" class='text-right'>--><?php //echo number_format(($invdata->InvUnitPrice),2)?><!--</td>-->
                            <!--                                <td style="border-bottom:1px solid #e4dbdb;" class='text-right'>--><?php //echo number_format(($invdata->InvNetAmount),2)?><!--</td>-->
                            <!--                            </tr>-->
                            <!--                            --><?php //$i++;
//                                }
                        }

                        //foreach end
                        // print_r($returnDtlArr);

                        ?>
                        </tbody>
                        <tfoot>
                        <?php
                        $payment_term ='';
                        if($invoice_hed->InvType==1){ ?>
                            <tr style="line-height:25px;" id="rowTotal">
                            <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td>
                            <td style="text-align:right;padding: 3px;">Sub Total </td>
                            <td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invoice_hed->TotalAmount,2);?></td>
                            </tr><?php }else{ ?>
                            <tr style="line-height:25px;" id="rowTotal"><td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;padding: 3px;">Sub Total </td><td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invoice_hed->TotalAmount,2);?></td></tr>
                        <?php } ?>
                        <?php if($invoice_hed->TotalExAmount>0 && $invoice_hed->InvType==1){?>
                            <tr style="line-height:25px;" id="exAmount">
                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Extra Amount(+)  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invoice_hed->TotalExAmount,2);?></td>
                            </tr>
                        <?php } ?>
                        <?php if($invoice_hed->TotalExCharges>0){?>
                            <tr style="line-height:25px;" id="exCharge">
                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Extra Charge(+)  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invoice_hed->TotalExCharges,2);?></td>
                            </tr>
                        <?php } ?>
                        <?php $finalTotal = ($invoice_hed->TotalAmount + $invoice_hed->TotalExAmount + $invoice_hed->TotalExCharges)  ?>
                        <tr style="line-height:25px;" id="totalaPay">
                            <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="font-weight:bold;text-align:right"><b>Total</b>  </td><td id="lbltotalaPay"   style='font-weight:bold;text-align:right'><?php echo number_format($finalTotal,2);?></td>
                        </tr>
                        <?php if($invoice_hed->DisAmount>0){?>
                            <tr style="line-height:25px;" id="rowDiscount">
                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Discount(-)  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invoice_hed->DisAmount,2);?></td>
                            </tr>
                        <?php }?>
                        <?php if($invoice_hed->DownPayment>0 && $invoice_hed->InvType==1){?>
                            <tr style="line-height:25px;" id="downPay">
                            <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Down Payment(-)  </td><td id="lbltotalVat"   style='text-align:right'><?php echo number_format($invoice_hed->DownPayment,2);?></td>
                            </tr><?php } ?>
                        <?php if($invoice_hed->Interest>0){?>
                            <tr style="line-height:25px;" id="rowDiscount">
                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Interest(+)  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invoice_hed->Interest,2);?></td>
                            </tr>
                        <?php }?>
                        <tr style="line-height:25px;" id="rowNET">
                            <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="font-weight:bold;text-align:right">Due Amount  </td><td id="lbltotalNet"   style='font-weight:bold;text-align:right'><?php echo number_format($invoice_hed->FinalAmount,2);?></td>
                        </tr>



                        <!--                        --><?php //if($invHed->SalesCashAmount>0){
                        //                            $payment_term="Cash";
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowDiscount">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cash Amount  </td><td id="lbltotalDicount"   style='text-align:right'>--><?php //echo number_format($invHed->SalesCashAmount,2);?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                        --><?php //} else { ?>
                        <!--                            <tr style="line-height:25px;">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right"> </td><td id=""   style='text-align:right'></td>-->
                        <!--                            </tr>-->
                        <!---->
                        <!--                        --><?php //} ?>
                        <!--                        --><?php //if($invHed->SalesBankAmount>0){
                        //                            $payment_term="Bank";
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowNBT">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Bank Transfer  </td><td id="lbltotalNbt"   style='text-align:right'>--><?php //echo number_format($invHed->SalesBankAmount,2);?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                        --><?php //} ?>
                        <!--                        --><?php //if($invHed->SalesAdvancePayment>0){
                        //                            $payment_term="Advance";
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowNBT">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Advance  </td><td id="lbltotalNbt"   style='text-align:right'>--><?php //echo number_format($invHed->SalesAdvancePayment,2);?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                        --><?php //} ?>
                        <!--                        --><?php //if($invHed->SalesChequeAmount>0){
                        //                            $payment_term="Cheque";
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowNBT">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cheque  Amount  </td><td id="lbltotalNbt"   style='text-align:right'>--><?php //echo number_format($invHed->SalesChequeAmount,2);?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                        --><?php //} ?>
                        <!--                        --><?php //if($invHed->SalesCCardAmount>0){
                        //                            $payment_term="Card";
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowNBT">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Card Amount  </td><td id="lbltotalNbt"   style='text-align:right'>--><?php //echo number_format($invHed->SalesCCardAmount,2);?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                        --><?php //} ?>
                        <!--                        --><?php //if($invHed->SalesReturnPayment>0){
                        //                            $payment_term="Card";
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowNBT">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Return Payment  </td><td id="lbltotalNbt"   style='text-align:right'>--><?php //echo number_format($invHed->SalesReturnPayment,2);?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                        --><?php //} ?>
                        <!---->
                        <!---->
                        <!--                        --><?php //if($invHed->SalesCreditAmount>0){
                        //                            $payment_term="Credit";
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowVAT">-->
                        <!--                            <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;font-weight:bold;background-color:#e4dbdb !important;">TOTAL PAYABLE  </td><td id="lbltotalVat"   style='font-weight:bold;text-align:right;background-color:#e4dbdb !important;'>--><?php //echo number_format($invHed->SalesCreditAmount,2);?><!--</td>-->
                        <!--                            </tr>--><?php //} ?>

                        <!--                        --><?php //if($invHed->SalesReturnAmount>0){
                        //
                        //                            ?>
                        <!--                            <tr style="line-height:25px;" id="rowNBT">-->
                        <!--                                <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Return Amount  </td><td id="lbltotalNbt"   style='text-align:right'>--><?php //echo number_format($invHed->SalesReturnAmount,2);?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr><td colspan="5">-->
                        <!--                            Return Items-->
                        <!--                            <p>-->
                        <!--                            --><?php // if($returnDtlArr){ foreach ($returnDtlArr AS $rtinvdata) { ?>
                        <!--                                --><?php //echo $rtinvdata->SalesProductName ?><!-----><?php //echo $rtinvdata->SalesReturnQty ?><!--, &nbsp;-->
                        <!--                            --><?php //} ?><!--</p>-->
                        <!---->
                        <!---->
                        <!--                                </td></tr>-->
                        <!--                            --><?php //}
                        //                        } ?>
                        <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;</td></tr>
                        <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;<b>Guarantee Details</b></td></tr>
                        <tr>
                            <td colspan="5">
                                <table style="width:700px;" >
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Name</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Address</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">NIC</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Mobile No</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($invoice_gurent as $value) {
                                        ?>
                                        <tr>
                                            <td style="border: #2c3b41 solid 1px"><?php echo $value->DisplayName;?></td>
                                            <td style="border: #2c3b41 solid 1px"><?php echo $value->Address01;?>, <?php echo $value->Address02;?></td>
                                            <td style="border: #2c3b41 solid 1px"><?php echo $value->Nic;?></td>
                                            <td style="border: #2c3b41 solid 1px"><?php echo $value->MobileNo;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;</td></tr>
                        <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;<b>Payment Schedule Details</b></td></tr>
                        <tr>
                            <td colspan="5">
                                <table style="width:700px;" >
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">No</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Date</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Month</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Installment</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Principal</th>
                                        <th class="text-center" style="border: #2c3b41 solid 1px">Interest</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total_int = 0;
                                    $total_cap = 0;
                                    $i = 1;
                                    foreach ($item_data as $value) {
                                        $total_int+=$value->Interest;
                                        $total_cap+=$value->Principal;
                                        $total_bal=$total_int+$total_cap;
                                        ?>
                                        <tr>
                                            <td class="text-center" style="border: #2c3b41 solid 1px"><?php echo $i;?></td>
                                            <td class="text-center" style="border: #2c3b41 solid 1px"><?php echo $value->PaymentDate;?></td>
                                            <td class="text-center" style="border: #2c3b41 solid 1px"><?php echo $value->Month;?></td>
                                            <td class="text-right" style="border: #2c3b41 solid 1px"><?php echo $value->MonPayment;?>&nbsp;&nbsp;</td>
                                            <td class="text-right" style="border: #2c3b41 solid 1px"><?php echo number_format($value->Principal,2);?>&nbsp;&nbsp;</td>
                                            <td class="text-right" style="border: #2c3b41 solid 1px"><?php echo number_format($value->Interest,2);?>&nbsp;&nbsp;</td>
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                    <tfoot>
                                    <th colspan="4" class="text-right"></th>
                                    <th class="text-right"><?php echo number_format($total_cap,2); ?></th>
                                    <th class="text-right"><?php echo number_format($total_int,2); ?></th>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table style="width:700px;" border="0">
                                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                                    <tr><td colspan="5" style="text-align:left;"><b></b><?php // echo $invHed->salesInvRemark; ?></td></tr>

                                    <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;<b>Term & Conditions</b></td></tr>
                                    <tr><td colspan="5" style="text-align:left;">
                                            <ul>
                                                <?php  if($invHed->SalesInvType == 3){?>

                                                <?php }else{ ?>
                                                    <?php foreach ($term as $val) { ?>
                                                        <li><?php echo $val->InvCondition; ?></li>
                                                    <?php } ?>
                                                <?php }  ?>

                                            </ul>
                                        </td></tr>
                                    <tr><td colspan="5" style="text-align:right;width:550px;">&nbsp;</td></tr>
                                    <tr>
                                        <td style="width:150px;text-align: left">&nbsp;</td>
                                        <td style="width:100px;">&nbsp;</td>
                                        <td style="width:150px;text-align: center">&nbsp;</td>
                                        <td style="width:100px;">&nbsp;</td>
                                        <td style="width:200px;text-align: left">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
                                        <td style="">&nbsp;</td>
                                        <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                                        <td style="">&nbsp;</td>
                                        <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center">Issued By</td>
                                        <td style="">&nbsp;</td>
                                        <td style="text-align: center">Checked By</td>
                                        <td style="">&nbsp;</td>
                                        <td style="text-align: center">Customer Signature</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center"> <?php //echo $invHed->first_name; ?> </td>
                                        <td style="">&nbsp;</td>
                                        <td style="text-align: center"></td>
                                        <td style="">&nbsp;</td>
                                        <td style="text-align: center">I have received mentioned items.</td>
                                    </tr>
                                    <!--                                    --><?php //if($invHed->SalesReceiver!=''){ ?>
                                    <!--                                        <tr>-->
                                    <!--                                            <td style="width:150px;text-align: left">&nbsp;</td>-->
                                    <!--                                            <td style="width:100px;">&nbsp;</td>-->
                                    <!--                                            <td style="width:150px;text-align: center">&nbsp;</td>-->
                                    <!--                                            <td style="width:100px;">&nbsp;</td>-->
                                    <!--                                            <td style="width:200px;text-align: left">&nbsp;</td>-->
                                    <!--                                        </tr>-->
                                    <!--                                        <tr>-->
                                    <!--                                            <td  >&nbsp;</td>-->
                                    <!--                                            <td style="">&nbsp;</td>-->
                                    <!--                                            <td style="border-bottom:1px dashed #000;text-align: center;">--><?php //echo $invHed->SalesReceiver; ?><!--</td>-->
                                    <!--                                            <td style="">&nbsp;</td>-->
                                    <!--                                            <td style="border-bottom:1px dashed #000;text-align: center;">--><?php //echo $invHed->SalesRecNic; ?><!--</td>-->
                                    <!--                                        </tr>-->
                                    <!--                                        <tr>-->
                                    <!--                                            <td style="text-align: center">-->
                                    <!--                                            </td>-->
                                    <!--                                            <td style="">&nbsp;</td>-->
                                    <!--                                            <td style="text-align: center">Name</td>-->
                                    <!--                                            <td style="">&nbsp;</td>-->
                                    <!--                                            <td style="text-align: center">NIC</td>-->
                                    <!--                                        </tr>-->
                                    <!--                                        <tr>-->
                                    <!--                                            <td style="text-align: center;"></td>-->
                                    <!--                                            <td style="">&nbsp;</td>-->
                                    <!--                                            <td style="text-align: center"></td>-->
                                    <!--                                            <td style="">&nbsp;</td>-->
                                    <!--                                            <td style="text-align: center"></td>-->
                                    <!--                                        </tr>-->
                                    <!--                                    --><?php //} ?>
                                    <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                                    <tr><td colspan="5" style="text-align:center;font-size: 18px;"><i></i></td></tr>
                                </table>
                            </td>
                        </tr>

                        </tfoot>
                    </table>
                    <?php $this->load->view('admin/_templates/company_footer_new.php',true); ?>

                    <style type="text/css" media="screen">
                        #tbl_po_data tbody tr td{
                            padding: 13px;
                        }
                    </style>
                </div>
            </div>
            <div class="col-lg-1">
                <!--                <table class="table table-hover">-->
                <!--                    <thead>-->
                <!--                    <th> <center> All Sales Invoice</center></th>-->
                <!--                    </thead>-->
                <!--                    <tbody>-->
                <!--                    --><?php //foreach($sale as $v){?>
                <!--                        <tr>-->
                <!--                            <td><a href="--><?php //echo base_url('admin/Salesinvoice/view_sales_invoice/').base64_encode($v->SalesInvNo); ?><!--">--><?php //echo $v->SalesInvNo;?><!--</a></td>-->
                <!--                        </tr>-->
                <!--                    --><?php //}?>
                <!--                    </tbody>-->
                <!--                </table>-->
            </div>
            <div class="col-lg-3">
                <!--                <table class="table">-->
                <!--                    <tr><td>Create by</td><td>:</td><td>--><?php //echo $invHed->first_name." ".$invHed->last_name ?><!--</td></tr>-->
                <!--                    <tr><td>Create Date</td><td>:</td><td>--><?php //echo $invHed->SalesDate ?><!--</td></tr>-->
                <!--                    --><?php //if($invCancel): ?>
                <!--                        <tr><td>Cancel By</td><td>:</td><td>--><?php //echo $invCancel->first_name." ".$invHed->last_name ?><!--</td></tr>-->
                <!--                        <tr><td>Cancel Date</td><td>:</td><td>--><?php //echo $invCancel->CancelDate ?><!--</td></tr>-->
                <!--                        <tr><td>Remark</td><td>:</td><td>--><?php //echo $invCancel->Remark ?><!--</td></tr>-->
                <!--                    --><?php //endif; ?>
                <!--                    --><?php //if($invUpdate):  ?>
                <!--                        <tr><td colspan="3">Last Updates</td></tr>-->
                <!--                        --><?php // foreach ($invUpdate AS $up) { ?>
                <!--                            <tr><td>--><?php //echo $up->UpdateDate ?><!--</td><td>:</td><td>--><?php //echo $up->first_name." ".$up->last_name ?><!--</td></tr>-->
                <!--                        --><?php //}
                //                    endif; ?>
                <!--                </table>-->
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

    var inv =$("#inv").val();

    $("#btnPrint").click(function(){
        $('#printArea').focus().print();
    });

    $("#btnPrint2").click(function(){
        $('#printArea2').focus().print();
    });


    $("#btnCancel").click(function(){

        var r = prompt('Do you really want to cancel this invoice? Please enter a remark.');

        if (r == null || r=='') {
            return false;
        }else{
            cancelInvoice(inv,r);
            return false;
        }
    });



    function cancelInvoice(invoice,remark) {
        $.ajax({
            url:'../../salesinvoice/cancelSalesInvoice',
            dataType:'json',
            type:'POST',
            data:{salesinvno:invoice,remark:remark},
            success:function(data) {
                if(data==1){
                    $.notify("Invoice canceled successfully.", "success");
                    $("#btnCancel").attr('disabled', true);
                }else if(data==2){
                    $.notify("Error. Customer has done payment for this invoice. If you want to cancel this invoice please cancel the payment", "danger");
                    $("#btnCancel").attr('disabled', false);
                }else if(data==3){
                    $.notify("Error. Invoice has already canceled.", "danger");
                    $("#btnCancel").attr('disabled', false);
                }else if(data==4){
                    $.notify("Error. This Invoice not in your Location Please contact Your Admin.", "danger");
                    $("#btnCancel").attr('disabled', false);
                }else{
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

                }

                else if ((c > 127) && (c < 2048)) {

                    utftext += String.fromCharCode((c >> 6) | 192);

                    utftext += String.fromCharCode((c & 63) | 128);

                }

                else {

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

                }

                else if ((c > 191) && (c < 224)) {

                    c2 = utftext.charCodeAt(i + 1);

                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));

                    i += 2;

                }

                else {

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
