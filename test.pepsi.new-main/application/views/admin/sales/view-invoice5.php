<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
    <section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="pull-right">
        <?php if($invHed->IsCancel==1){$disabled='disabled'; }else{$disabled='';}?>
         <button type="button" <?php echo $disabled;?> id="btnCancel" class="btn btn-danger btn-lg btn-block">Cancel Invoice</button>
        </div>
        <div class="pull-right">
         <button type="button" <?php echo $disabled;?> id="btnPrint" class="btn btn-primary btn-lg btn-block">Print</button>
        </div>
    </section>
    <section class="content">
    <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
        <div class="row"  align="center" style='margin:5px;'>
                                <table style="border-collapse:collapse;width:690px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
            <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
            </tr> 
            <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6"><b><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?> &nbsp;&nbsp;  <?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo  $company['MobileNo'] ?></b></td>
            </tr>
            <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:12px;">
                <td colspan="3">&nbsp;</td>
                <td colspan="3" rowspan="8">
                    <table style="text-align:left;font-size:11px;">
                        <tr style="text-align:left;">
                            <td style='width: 70px;'> Date</td>
                            <td style='width: 10px;'> :</td>
                            <td  id="lblinvDate"> <?php echo $invHed->date;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Invoice No</td>
                            <td> :</td>
                            <td  id="lblInvNo"> <?php echo $invHed->JobInvNo;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Reg No</td>
                            <td> :</td>
                            <td id="lblregNo"> <?php echo $invHed->regNo;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Job No</td>
                            <td> :</td>
                            <td id="lbljobNo"><?php echo $invHed->jobcardNo; ?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Mileage</td>
                            <td> :</td>
                            <td id="lblviNo"> <?php echo $invjob->OdoIn;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Chassis No</td>
                            <td> :</td>
                            <td  id="lblviNo"> <?php echo $invVehi->ChassisNo;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Make</td>
                            <td> :</td>
                            <td id="lblmake"><?php echo $invVehi->make;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td> Model</td>
                            <td> :</td>
                            <td id="lblmodel"><?php echo $invVehi->model;?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="text-align:left;font-size:12px;">
                <td colspan="3" rowspan="7">
                    <TABLE  style="text-align:left;font-size:12px;margin-left: 5px;">
                        <tr style="text-align:left;">
                            <td colspan="3"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td colspan="3"><span id="lblcusCode"><?php echo $invHed->customerCode;?></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Contanct Name <span id="lblConName"> <?php echo $invVehi->contactName;?></span></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"><?php echo nl2br($invCus->Address01).",<br> ";?></td>
                        </tr>
                        <tr style="text-align:left;">
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;">
                          <td> Tel  : </td>
                          <td id="lbltel" colspan="2"> <?php echo $invCus->MobileNo.", ".$invCus->LanLineNo;?></td>
                        </tr>
                    </TABLE>
                </td>
            </tr>
            <tr style="text-align:left;font-size:12px;">
              <td colspan="6">&nbsp;</td>
            </tr>
            <?php $noofjob=0;$refno=0; ?>
        </table><br>
                      <table id="tbl_est_data" style="border-collapse:collapse;width:690px;padding:5px;font-size:13px;" border="1"> 
                          <tbody>
                            <tr style="line-height: 5px">
                                  <td style="width:20px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:150px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:150px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:60px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:80px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;" class='text-right'></td>
                                  <td style="width:50px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;" class='text-right'></td>
                                  <td style="width:50px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;" class='text-right' style="width:70px"></td>
                            </tr>
                          <?php $i=1;
                          // var_dump($invDtl);die;
                                 foreach ($invDtl AS $key=>$invdata) { ?>
                                <tr style="line-height: 5px"><td style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td><td colspan="2" style="border-top: 1px solid #000;border-bottom: 1px solid #000;"><b><?php echo $key?></b></td><td style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td><td style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td><td colspan="2" style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td></tr>
                                       <?php foreach ($invdata AS $inv) { ?>
                                <tr  style="line-height: 5px">
                                  <td style="border-bottom: 1px dotted #000;"><?php echo $i?></td>
                                  <td colspan="2"  style="border-bottom: 1px dotted #000;"><?php echo $inv->JobDescription?></td>
                                  <td class='text-right'  style="border-bottom: 1px dotted #000;"><?php echo number_format($inv->JobQty,2)?></td>
                                  <td class='text-right'  style="border-bottom: 1px dotted #000;"><?php echo number_format($inv->JobPrice,2)?></td>
                                  <td class='text-right' colspan="2"  style="border-bottom: 1px dotted #000;"><?php echo number_format($inv->JobNetAmount,2)?></td>
                                </tr>
                                       <?php $i++; } ?>
                            <?php  } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-size: 10px;font-weight: normal;text-align: left;'>Any Inquiries please contact service manager</th>
                              <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>SUB TOTAL &nbsp;&nbsp;</th>
                              <th style="border-right: 1px solid #fff;border-top: 1px solid #000;">Rs.</th>
                              <th id="totalAmount" style='text-align:right;border-top: 1px solid #000;'><?php if($invHed->InvoiceType==1){echo number_format($invHed->JobNetAmount,2); }elseif($invHed->InvoiceType==2){echo number_format($invHed->JobTotalAmount,2);}?></th>
                            </tr>
                              <?php if($invHed->JobTotalDiscount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>DISCOUNT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalDiscount" style='text-align:right'><span style="text-align: left;">Rs.</span> <?php echo number_format($invHed->JobTotalDiscount,2);?></th>
                            </tr>
                              <?php } ?>
                              <?php if($invHed->JobAdvance>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> ADVANCE &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobAdvance,2);?></th>
                            </tr>
                              <?php }?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-weight: normal;text-align: left;'>Estimate No : <span id="lblEstNo"><?php echo $invHed->JobEstimateNo;?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REF No: <?php echo $refno;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No Of Job : <span id="lblnoofjob"><?php echo $noofjob;?></span></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>   &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobNbtAmount,2);?></th>
                            </tr>
                                <?php if($invHed->JobNbtAmount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> NBT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobNbtAmount,2);?></th>
                                </tr>
                               <?php } ?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; font-weight: normal;text-align: left;'>Type Of Job : <span id="lblTypeOfJob"></span></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> TOTAL &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="netAmount" style='text-align:right'><?php echo number_format($invHed->JobNetAmount-$invHed->JobAdvance,2) ?></th>
                            </tr>

                          </tfoot>
                      </table>
                      <br/>
                      <table style="border-collapse:collapse;width:683px;padding:2px; position: relative;bottom: 20px" border="0">
                          <tbody>
                             <tr><td colspan="7">&nbsp;</td></tr>
                             <tr><td colspan="7">&nbsp;</td></tr>  
                             <tr><td colspan="7">&nbsp;</td></tr>
                            <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><?php //echo $invjob->first_name;?></td><td>&nbsp;</td><td colspan="2" style="border-top:1px dashed #000;text-align: center;font-size: 10px;">Signature Of Purchaser</td><td>&nbsp;</td></tr>
                            <tr><td style="border-top:1px dashed #000;text-align: center;width:100px;">Check by</td><td style="width: 10px;">&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:100px;">Prepared By</td><td style="width: 10px;">&nbsp;</td><td colspan="2" style="font-size: 11px;">I am satisfied with service / goods I received</td><td style="width:200px;"></td></tr>
                            <tr><td style="text-align: left;width:100px;"><b>Remarks</b></td><td colspan="6">&nbsp;</td></tr>
                            <tr><td colspan="7"  style="border:1px solid #000;height: 30px;">&nbsp;</td></tr>
                            <tr><td style="font-size: 11px;"><?php echo date('d-m-Y');?></td><td colspan="5"  style="">&nbsp;</td><td style="font-size: 11px;text-align: right;">Page 1 of 1</td></tr>
                                         
                        </tbody>
                        </table>
        </div>
      <!-- </div> -->
      <div>
      <hr>
      <table class="table table-hover table-bordered">
        <tr>
          <td colspan="4">Payment Recieved</td>
        </tr>
        <tr>
          <td>Date</td>
          <td>Mode</td>
          <td></td>
          <td>Pay Amount</td>
          <td>Payment By</td>
        </tr>
        <?php $totalpay=0;
        foreach ($inv_pay AS $invpay) { ?>
        <tr>
          <td><?php echo $invpay->JobInvDate?></td>
          <td><?php echo $invpay->JobInvPayType?></td>
          <td>:</td>
          <td class="text-right"><?php echo number_format($invpay->JobInvPayAmount,2)?></td>
          <td><?php echo $invpay->CusName?></td>
        </tr>
        <?php $totalpay+=$invpay->JobInvPayAmount;
        } ?>
        <tr>
          <td></td>
          <td><b>Total</b></td>
          <td>:</td>
          <td class="text-right"><b><?php echo number_format($totalpay,2); ?></b></td>
          <td></td>
        </tr>
      </table>
      <hr>
      
      <button id="cardPrint" <?php if($card_pay==''){  ?>disabled<?php } ?> class="btn btn-primary">Card Receipt Print</button>
      &nbsp;&nbsp;&nbsp;
      
      <button id="chequePrint" <?php if($cheque_pay==''){?>disabled<?php } ?> class="btn btn-primary">Cheque Receipt Print</button>
     
    </div>
      </section>
    
</div>

 <!-- print card receipt goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice2" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                    <div class="row" id="printArea2" align="center" style='margin:5px;'>
                        <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">
        <?php //foreach ($company as $com) {  ?>
        
        <!-- <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
            <td colspan="9" style="height: 100px">&nbsp;</td>
        </tr> -->
        <tr>
        <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:600px;"></td>
    </tr>
        <tr style="text-align:left;">
            <td style="width:200px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:290px;">&nbsp;</td>
            <td style="width:20px;">&nbsp;</td>
            <td style="width:300px;">&nbsp;</td>
            <td style="width:190px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td>-->
            <td >&nbsp;</td> 
            <td colspan="2" style='font-size: 20px;text-align: center;'><b>Customer Copy</b></td>
            <td>DATE</td>
            <td>:</td>
            <td id="lbldate"><?php echo ($card_pay->JobInvDate);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>RECEIPT NO</td>
            <td>:</td>
            <td id="lblreceiptno"><?php echo ($card_pay->ReceiptNo);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Received with thanks a sum of Rupees</td>
            <td>:</td>
            <td colspan="4"  id="lblamountword"><?php 
            $amount = convert_number_to_words(($card_pay->JobAmount));
            echo strtoupper($amount)?> ONLY</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Reason for payment </td>
            <td>:</td>
            <td colspan="4"  id="lblreason"><?php echo ($card_pay->PayRemark);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">In Cash / Cheque from</td>
            <td>:</td>
            <td colspan="4" id="lblcusname"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td>:</td>
            <td colspan="4" id="lblcusaddress" rowspan="3">
              <?php echo nl2br($invCus->Address01).",<br> ";?>
            </td>
            <td>&nbsp;</td>
        </tr>
         <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>
            <td id="lblinvno"> <?php echo ($card_pay->JobInvNo);?></td>
            <td colspan="2"  ></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Vehicle No</td>
            <td>:</td>
            <td colspan="2" id="lblvno"><?php echo $invHed->regNo;?></td>
            <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>
            <td><?php echo $invCus->CusCode;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Amount</td>
            <td>:</td>
            <td colspan="2" id="lblamount">Rs.<?php echo number_format($cheque_pay->JobInvPayAmount,2);?></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Cheque No</td>
            <td>:</td>
            <td colspan="2" id="lblchequeno"><?php echo ($card_pay->JobInvNo);?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Bank</td>
            <td>:</td>
            <td colspan="2" id="lblbank"></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Date</td>
            <td>:</td>
            <td colspan="2"  id="lblchequedate"></td>
            <td></td>
            <!-- <td>&nbsp;</td> -->
            <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <!-- <td>&nbsp;</td> -->
        </tr>
        <tr style="text-align:left;">
            <td>Payment Type</td>
            <td>:</td>
            <td colspan="2"  id="lblpaytype">CARD PAYMENT</td>
            <td></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <br> <br>
    <hr> <br> <br>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">
        <?php //foreach ($company as $com) {  ?>
        
        <!-- <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
            <td colspan="9" style="height: 100px">&nbsp;</td>
        </tr> -->
        <tr>
        <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:650px;"></td>
    </tr>
        <tr style="text-align:left;">
            <td style="width:200px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:290px;">&nbsp;</td>
            <td style="width:20px;">&nbsp;</td>
            <td style="width:300px;">&nbsp;</td>
            <td style="width:190px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td>-->
            <td >&nbsp;</td> 
            <td colspan="2" style='font-size: 20px;text-align: center;'><b>Office Copy</b></td>
            <td>DATE</td>
            <td>:</td>
            <td id="lbldate"><?php echo ($card_pay->JobInvDate);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>RECEIPT NO</td>
            <td>:</td>
            <td id="lblreceiptno"><?php echo ($card_pay->ReceiptNo);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Received with thanks a sum of Rupees</td>
            <td>:</td>
            <td colspan="4"  id="lblamountword"><?php 
            $amount = convert_number_to_words(($card_pay->JobAmount));
            echo strtoupper($amount)?> ONLY</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Reason for payment </td>
            <td>:</td>
            <td colspan="4"  id="lblreason"><?php echo ($card_pay->PayRemark);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">In Cash / Cheque from</td>
            <td>:</td>
            <td colspan="4" id="lblcusname"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td>:</td>
            <td colspan="4" id="lblcusaddress" rowspan="3">
              <?php echo nl2br($invCus->Address01).",<br> ";?>
            </td>
            <td>&nbsp;</td>
        </tr>
         <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>
            <td id="lblinvno"> <?php echo ($card_pay->JobInvNo);?></td>
            <td colspan="2"  ></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Vehicle No</td>
            <td>:</td>
            <td colspan="2" id="lblvno"><?php echo $invHed->regNo;?></td>
            <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>
            <td><?php echo $invCus->CusCode;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Amount</td>
            <td>:</td>
            <td colspan="2" id="lblamount">Rs.<?php echo number_format($cheque_pay->JobInvPayAmount,2);?></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Cheque No</td>
            <td>:</td>
            <td colspan="2" id="lblchequeno"><?php echo ($card_pay->JobInvNo);?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Bank</td>
            <td>:</td>
            <td colspan="2" id="lblbank"></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Date</td>
            <td>:</td>
            <td colspan="2"  id="lblchequedate"></td>
            <td></td>
            <!-- <td>&nbsp;</td> -->
            <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <!-- <td>&nbsp;</td> -->
        </tr>
        <tr style="text-align:left;">
            <td>Payment Type</td>
            <td>:</td>
            <td colspan="2"  id="lblpaytype">CARD PAYMENT</td>
            <td></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <style>#tblData td{padding: 2px;}</style>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- print cheque recipt goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice2" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                    <div class="row" id="printArea3" align="center" style='margin:5px;'>
                        <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">
        <?php //foreach ($company as $com) {  ?>
        
        <!-- <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
            <td colspan="9" style="height: 100px">&nbsp;</td>
        </tr> -->
         <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:650px;"></td>
    </tr>
        <tr style="text-align:left;">
            <td style="width:200px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:290px;">&nbsp;</td>
            <td style="width:20px;">&nbsp;</td>
            <td style="width:300px;">&nbsp;</td>
            <td style="width:190px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td>-->
            <td >&nbsp;</td> 
            <td colspan="2" style='font-size: 20px;text-align: center;'><b>Customer Copy</b></td>
            <td>DATE</td>
            <td>:</td>
            <td id="lbldate"><?php echo ($cheque_pay->JobInvDate);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>RECEIPT NO</td>
            <td>:</td>
            <td id="lblreceiptno"><?php echo ($cheque_pay->ReceiptNo);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Received with thanks a sum of Rupees</td>
            <td>:</td>
            <td colspan="4"  id="lblamountword"><?php 
            $amount = convert_number_to_words(($cheque_pay->JobAmount));
            echo strtoupper($amount)?> ONLY</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Reason for payment </td>
            <td>:</td>
            <td colspan="4"  id="lblreason"><?php echo ($cheque_pay->PayRemark);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">In Cash / Cheque from</td>
            <td>:</td>
            <td colspan="4" id="lblcusname"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td>:</td>
            <td colspan="4" id="lblcusaddress" rowspan="3">
              <?php echo nl2br($invCus->Address01).",<br> ";?>
            </td>
            <td>&nbsp;</td>
        </tr>
         <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>
            <td id="lblinvno"> <?php echo ($cheque_pay->JobInvNo);?></td>
            <td colspan="2"  ></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Vehicle No</td>
            <td>:</td>
            <td colspan="2" id="lblvno"><?php echo $invHed->regNo;?></td>
            <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>
            <td><?php echo $invCus->CusCode;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Amount</td>
            <td>:</td>
            <td colspan="2" id="lblamount">Rs.<?php echo number_format($cheque_pay->JobInvPayAmount,2);?></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Cheque No</td>
            <td>:</td>
            <td colspan="2" id="lblchequeno"><?php echo ($cheque_pay->ChequeNo);?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Bank</td>
            <td>:</td>
            <td colspan="2" id="lblbank"><?php echo ($cheque_pay->BankName);?></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Date</td>
            <td>:</td>
            <td colspan="2"  id="lblchequedate"><?php echo ($cheque_pay->ChequeDate);?></td>
            <td></td>
            <!-- <td>&nbsp;</td> -->
            <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <!-- <td>&nbsp;</td> -->
        </tr>
        <tr style="text-align:left;">
            <td>Payment Type</td>
            <td>:</td>
            <td colspan="2"  id="lblpaytype">CHEQUE PAYMENT</td>
            <td></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <br> <br>
    <hr> <br> <br>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">
        <?php //foreach ($company as $com) {  ?>
        
        <!-- <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
            <td colspan="9" style="height: 100px">&nbsp;</td>
        </tr> -->
         <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:650px;"></td>
    </tr>
        <tr style="text-align:left;">
            <td style="width:200px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:290px;">&nbsp;</td>
            <td style="width:20px;">&nbsp;</td>
            <td style="width:300px;">&nbsp;</td>
            <td style="width:190px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td>-->
            <td >&nbsp;</td> 
            <td colspan="2" style='font-size: 20px;text-align: center;'><b>Office Copy</b></td>
            <td>DATE</td>
            <td>:</td>
            <td id="lbldate"><?php echo ($cheque_pay->JobInvDate);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>RECEIPT NO</td>
            <td>:</td>
            <td id="lblreceiptno"><?php echo ($cheque_pay->ReceiptNo);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Received with thanks a sum of Rupees</td>
            <td>:</td>
            <td colspan="4"  id="lblamountword"><?php 
            $amount = convert_number_to_words(($cheque_pay->JobAmount));
            echo strtoupper($amount)?> ONLY</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Reason for payment </td>
            <td>:</td>
            <td colspan="4"  id="lblreason"><?php echo ($cheque_pay->PayRemark);?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">In Cash / Cheque from</td>
            <td>:</td>
            <td colspan="4" id="lblcusname"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td>:</td>
            <td colspan="4" id="lblcusaddress" rowspan="3">
              <?php echo nl2br($invCus->Address01).",<br> ";?>
            </td>
            <td>&nbsp;</td>
        </tr>
         <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>
            <td id="lblinvno"> <?php echo ($cheque_pay->JobInvNo);?></td>
            <td colspan="2"  ></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Vehicle No</td>
            <td>:</td>
            <td colspan="2" id="lblvno"><?php echo $invHed->regNo;?></td>
            <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>
            <td><?php echo $invCus->CusCode;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Amount</td>
            <td>:</td>
            <td colspan="2" id="lblamount">Rs.<?php echo number_format($cheque_pay->JobInvPayAmount,2);?></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Cheque No</td>
            <td>:</td>
            <td colspan="2" id="lblchequeno"><?php echo ($cheque_pay->ChequeNo);?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Bank</td>
            <td>:</td>
            <td colspan="2" id="lblbank"><?php echo ($cheque_pay->BankName);?></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Date</td>
            <td>:</td>
            <td colspan="2"  id="lblchequedate"><?php echo ($cheque_pay->ChequeDate);?></td>
            <td></td>
            <!-- <td>&nbsp;</td> -->
            <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <!-- <td>&nbsp;</td> -->
        </tr>
        <tr style="text-align:left;">
            <td>Payment Type</td>
            <td>:</td>
            <td colspan="2"  id="lblpaytype">CHEQUE PAYMENT</td>
            <td></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <style>#tblData td{padding: 2px;}</style>
                    </div>
                  </div>
                </div>
              </div>
            </div>


 <!-- print parts goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                    <div class="row" id="printArea" align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    <?php //$this->load->view('admin/_templates/company_header.php',true); ?>

<table style="border-collapse:collapse;width:700px;margin:5px;font-family: times, Helvetica, sans-serif;" border="0">
 <!-- <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
            </tr>  -->
            <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="height: 50px;">
               <!--  <b><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?> &nbsp;&nbsp;  <?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo  $company['MobileNo'] ?></b>-->
                </td> 
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><span id="invType" style="font-size: 20px;position: relative;left:70px"><b><?php if($invHed->InvoiceType==1){?>CASH <?php }elseif($invHed->InvoiceType==2){ ?> TAX <?php } ?><br>INVOICE</b></span></td><td colspan="3" style="">&nbsp;</td></tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: right;">VAT NO : 1040587877000&nbsp;&nbsp;</td><td colspan="3" style="">&nbsp;</td></tr>
            <!-- <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: right;">&nbsp;</td><td colspan="3" style="">&nbsp;</td></tr> -->
            <!-- <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: right;">&nbsp;</td><td colspan="3" style="">&nbsp;</td></tr> -->
            <tr style="text-align:left;font-size:12px;">
                <td colspan="3" style="width:380px">&nbsp;</td>
                <td colspan="3" rowspan="8" valign="top" style="padding-top:15px;width:320px;">
                    <table style="text-align:left;font-size:11px;">
                        <tr style="text-align:left;">
                            <td style='width: 70px;'> Date</td>
                            <td style='width: 10px;'> :</td>
                            <td  id="lblinvDate"> <?php echo $invHed->date;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Invoice No</td>
                            <td> :</td>
                            <td  id="lblInvNo"> <?php echo $invHed->JobInvNo;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Reg No</td>
                            <td> :</td>
                            <td id="lblregNo"> <?php echo $invHed->regNo;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Job No</td>
                            <td> :</td>
                            <td id="lbljobNo"><?php echo $invHed->jobcardNo; ?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Mileage</td>
                            <td> :</td>
                            <td id="lblviNo"> <?php echo $invjob->OdoIn;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Chassis No</td>
                            <td> :</td>
                            <td  id="lblviNo"> <?php echo $invVehi->ChassisNo;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Make</td>
                            <td> :</td>
                            <td id="lblmake"><?php echo $invVehi->make;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td> Model</td>
                            <td> :</td>
                            <td id="lblmodel"><?php echo $invVehi->model;?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="text-align:left;font-size:10px;">
                <td colspan="3" rowspan="7"  style="padding-top:9px;"><br>
                    <TABLE  style="text-align:left;font-size:12px;margin-left: 5px;">
                        <tr style="text-align:left;">
                            <td colspan="3"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td colspan="3"><span id="lblcusCode"><?php echo $invHed->customerCode;?></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Contanct Name <span id="lblConName"> <?php echo $invVehi->contactName;?></span></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"><?php echo nl2br($invCus->Address01)."<br>";?></td>
                        </tr>
                        <tr style="text-align:left;">
                          <td> Tel  : </td>
                          <td id="lbltel" colspan="2"> <?php echo $invCus->MobileNo." ".$invCus->LanLineNo;?></td>
                        </tr>
                    </TABLE>
                </td>
            </tr>
           <!--  <tr style="text-align:left;font-size:12px;">
              <td colspan="6">&nbsp;</td>
            </tr> -->
            <?php $noofjob=0;$refno=0; ?>
        </table>
                      <table id="tbl_est_data" style="border-collapse:collapse;width:690px;padding:5px;font-size:13px;" border="1"> 
                          <tbody>
                            <tr style="line-height: 5px">
                                  <td style="width:20px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:150px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:150px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:60px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;"></td>
                                  <td style="width:80px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;" class='text-right'></td>
                                  <td style="width:50px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;" class='text-right'></td>
                                  <td style="width:50px;border-top: 1px solid #fff;border-left: 1px solid #fff;border-right: 1px solid #fff;" class='text-right' style="width:70px"></td>
                            </tr>
                          <?php $i=1;
                          // var_dump($invDtl);die;
                                 foreach ($invDtl AS $key=>$invdata) { ?>
                                <tr style="line-height: 5px"><td style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td><td colspan="2" style="border-top: 1px solid #000;border-bottom: 1px solid #000;"><b><?php echo $key?></b></td><td style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td><td style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td><td colspan="2" style="border-top: 1px solid #000;border-bottom: 1px solid #000;"></td></tr>
                                       <?php foreach ($invdata AS $inv) { ?>
                                <tr  style="line-height: 5px">
                                  <td style="border-bottom: 1px dotted #000;"><?php echo $i?></td>
                                  <td colspan="2"  style="border-bottom: 1px dotted #000;"><?php echo $inv->JobDescription?></td>
                                  <td class='text-right'  style="border-bottom: 1px dotted #000;"><?php echo number_format($inv->JobQty,2)?></td>
                                  <td class='text-right'  style="border-bottom: 1px dotted #000;"><?php echo number_format($inv->JobPrice,2)?></td>
                                  <td class='text-right' colspan="2"  style="border-bottom: 1px dotted #000;"><?php echo number_format($inv->JobNetAmount,2)?></td>
                                </tr>
                                       <?php $i++; } ?>
                            <?php  } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-size: 10px;font-weight: normal;text-align: left;'>Any Inquiries please contact service manager</th>
                              <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>SUB TOTAL &nbsp;&nbsp;</th>
                              <th style="border-right: 1px solid #fff;border-top: 1px solid #000;">Rs.</th>
                              <th id="totalAmount" style='text-align:right;border-top: 1px solid #000;'><?php if($invHed->InvoiceType==1){echo number_format($invHed->JobNetAmount,2); }elseif($invHed->InvoiceType==2){echo number_format($invHed->JobTotalAmount,2);}?></th>
                            </tr>
                              <?php if($invHed->JobTotalDiscount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>DISCOUNT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalDiscount" style='text-align:right'><span style="text-align: left;">Rs.</span> <?php echo number_format($invHed->JobTotalDiscount,2);?></th>
                            </tr>
                              <?php } ?>
                              <?php if($invHed->JobAdvance>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> ADVANCE &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobAdvance,2);?></th>
                            </tr>
                              <?php }?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-weight: normal;text-align: left;'>Estimate No : <span id="lblEstNo"><?php echo $invHed->JobEstimateNo;?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REF No: <?php echo $refno;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No Of Job : <span id="lblnoofjob"><?php echo $noofjob;?></span></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>   &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobNbtAmount,2);?></th>
                            </tr>
                                <?php if($invHed->JobNbtAmount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> NBT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobNbtAmount,2);?></th>
                                </tr>
                               <?php } ?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; font-weight: normal;text-align: left;'>Type Of Job : <span id="lblTypeOfJob"></span><?php echo $invjob->CusType?></span></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> TOTAL &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="netAmount" style='text-align:right'><?php echo number_format($invHed->JobNetAmount-$invHed->JobAdvance,2) ?></th>
                            </tr>

                          </tfoot>
                      </table>
                      <br/>
                      <table style="border-collapse:collapse;width:683px;padding:2px; position: absolute;bottom: 20px" border="0">
                          <tbody>
                             <tr><td colspan="7">&nbsp;</td></tr>
                             <tr><td colspan="7">&nbsp;</td></tr>  
                             <tr><td colspan="7">&nbsp;</td></tr>
                            <tr>
                            <td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><?php //echo $invjob->first_name;?></td><td>&nbsp;</td><td colspan="2" style="border-top:1px dashed #000;text-align: center;font-size: 10px;">Signature Of Purchaser</td><td>&nbsp;</td></tr>

                            <tr><td style="border-top:1px dashed #000;text-align: center;width:100px;">Check by</td><td style="width: 10px;">&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:100px;">Prepared By</td><td style="width: 10px;">&nbsp;</td><td colspan="2" style="font-size: 11px;">I am satisfied with service / goods I received</td><td style="width:200px;"></td></tr>
                            <tr><td style="text-align: left;width:100px;"><b>Remarks</b></td><td colspan="6">&nbsp;</td></tr>
                            <tr><td colspan="7"  style="border:1px solid #000;height: 30px;">&nbsp;</td></tr>
                            <tr><td style="font-size: 11px;"><?php echo date('d-m-Y');?></td><td colspan="5"  style="">&nbsp;</td><td style="font-size: 11px;text-align: right;">Page 1 of 1</td></tr>
                                         
                        </tbody>
                        </table>
<h3 class="pag pag1"></h3>
  <div class="insert"></div>
  <style type="text/css" media="screen">
    body {
  text-align: justify;
}

@page {
  size: A4;
  margin: 5%;
  padding: 0 0 10%;
}

h3.pag {
  display: none;
  position: absolute;
  page-break-before: always;
  page-break-after: always;
  bottom: 0;
  right: 0;
}

h3::before {
  position: relative;
  bottom: -15px;
}

@media print {
  h3.pag {
    display: initial;
  }
  .print {
    display: none;
  }
}
  </style>
  
  <?php 
function convert_number_to_words($number) {

                        $hyphen = ' ';
                        $conjunction = ' and ';
                        $separator = ' ';
                        $negative = 'negative ';
                        $decimal = ' point ';
                        $dictionary = array(
                            0 => 'zero',
                            1 => 'one',
                            2 => 'two',
                            3 => 'three',
                            4 => 'four',
                            5 => 'five',
                            6 => 'six',
                            7 => 'seven',
                            8 => 'eight',
                            9 => 'nine',
                            10 => 'ten',
                            11 => 'eleven',
                            12 => 'twelve',
                            13 => 'thirteen',
                            14 => 'fourteen',
                            15 => 'fifteen',
                            16 => 'sixteen',
                            17 => 'seventeen',
                            18 => 'eighteen',
                            19 => 'nineteen',
                            20 => 'twenty',
                            30 => 'thirty',
                            40 => 'fourty',
                            50 => 'fifty',
                            60 => 'sixty',
                            70 => 'seventy',
                            80 => 'eighty',
                            90 => 'ninety',
                            100 => 'hundred',
                            1000 => 'thousand',
                            1000000 => 'million',
                            1000000000 => 'billion',
                            1000000000000 => 'trillion',
                            1000000000000000 => 'quadrillion',
                            1000000000000000000 => 'quintillion'
                        );

                        if (!is_numeric($number)) {
                            return false;
                        }

                        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                            // overflow
                            trigger_error(
                                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
                            );
                            return false;
                        }

                        if ($number < 0) {
                            return $negative . convert_number_to_words(abs($number));
                        }

                        $string = $fraction = null;

                        if (strpos($number, '.') !== false) {
                            list($number, $fraction) = explode('.', $number);
                        }

                        switch (true) {
                            case $number < 21:
                                $string = $dictionary[$number];
                                break;
                            case $number < 100:
                                $tens = ((int) ($number / 10)) * 10;
                                $units = $number % 10;
                                $string = $dictionary[$tens];
                                if ($units) {
                                    $string .= $hyphen . $dictionary[$units];
                                }
                                break;
                            case $number < 1000:
                                $hundreds = $number / 100;
                                $remainder = $number % 100;
                                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                                if ($remainder) {
                                    $string .= $conjunction . convert_number_to_words($remainder);
                                }
                                break;
                            default:
                                $baseUnit = pow(1000, floor(log($number, 1000)));
                                $numBaseUnits = (int) ($number / $baseUnit);
                                $remainder = $number % $baseUnit;
                                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                                if ($remainder) {
                                    $string .= $remainder < 100 ? $conjunction : $separator;
                                    $string .= convert_number_to_words($remainder);
                                }
                                break;
                        }

                        if (null !== $fraction && is_numeric($fraction)) {
                            $string .= $decimal;
                            $words = array();
                            foreach (str_split((string) $fraction) as $number) {
                                $words[] = $dictionary[$number];
                            }
                            $string .= implode(' ', $words);
                        }

                        return $string;
                    }
  ?>

                    </div>
          
                </div>
              </div>
            </div>
        </div>
<script type="text/javascript">

var inv =$("#inv").val();

$("#btnPrint").click(function(){
$('#printArea').focus().print();
});

$("#cardPrint").click(function(){
$('#printArea2').focus().print();
});

$("#chequePrint").click(function(){
$('#printArea3').focus().print();
});

$("#btnCancel").click(function(){

  var r = confirm('Do you want to cancel this invoice?');
    if (r === true) {
        cancelInvoice(inv);
    }else{

    }
});


  var bottom = 0;
  var pagNum = 2; /* First sequence - Second number */
  $(document).ready(function() {
    /* For each 10 paragraphs, this function: clones the h3 with a new page number */
    $("table:nth-child(10n)").each(function() {
      bottom -= 100;
      botString = bottom.toString();
      var $counter = $('h3.pag1').clone().removeClass('pag1');
      $counter.css("bottom", botString + "vh");
      numString = pagNum.toString();
      $counter.addClass("pag" + numString);
      ($counter).insertBefore('.insert');
      pagNum = parseInt(numString);
      pagNum++; /* Next number */
    });
    var pagTotal = $('.pag').length; /* Gets the total amount of pages by total classes of paragraphs */
    pagTotalString = pagTotal.toString();
    $("h3[class^=pag]").each(function() {
      /* Gets the numbers of each classes and pages */
      var numId = this.className.match(/\d+/)[0];
      document.styleSheets[0].addRule('h3.pag' + numId + '::before', 'content: "Page ' + numId + ' of ' + pagTotalString + '";');
    });
  });


function printinv(invoice) {
  $.ajax({
        url:'salesinvoice/printinvoicecreate',
        dataType:'json',
        type:'POST',
        data:{invno:invoice},
        success:function(data) {
          alert(data);
          var resultData = data;
          $("#tbl_est_data tbody").empty();
          $('#lblcusCode').html(resultData.head.JCustomer);
          $('#lblcusName').html(resultData.head.CusName);
          $('#lblinvDate').html(resultData.head.Date);
          $('#lblAddress').html(resultData.head.Address01);
          $('#lbltel').html(resultData.head.MobileNo);
          $('#lblmake').html(resultData.head.Make);
          $('#lblmodel').html(resultData.head.Model);
          $('#lblConName').html(resultData.head.contactName);
          $('#lblestimateNo').html(resultData.head.JobEstimateNo);
          $('#lblInvNo').html(resultData.head.JobInvNo);
          $('#lblviNo').html(resultData.head.ChassisNo);
          $('#lblregNo').html(resultData.head.RegNo);
          $('#totalAmount').html(accounting.formatMoney(resultData.head.JobTotalAmount));
          $('#totalDiscount').html(accounting.formatMoney(resultData.head.JobTotalDiscount));
          $('#netAmount').html(accounting.formatMoney(resultData.head.JobNetAmount-resultData.head.JobAdvance));
          $('#totalAdvance').html(accounting.formatMoney(resultData.head.JobAdvance));
          if(resultData.head.IsPayment==0){
                $("#btnPayment").show();
                var url ="payment/job_payment/"+Base64.encode(resultData.head.JobInvNo);
                $("#btnPayment").prop("disabled", false);
                $("#btnPayment").attr("href",url);
              }else{
                 $("#btnPayment").hide();
              }
          var k = 1;
                $.each(resultData.list, function(key, value) {
                    $("#tbl_est_data").append("<tr><td colspan='6' style='padding: 4px 3px 4px 50px;'><b>" + key + "</b></td></tr>");
                    for (var i = 0; i < value.length; i++) {  
                            $("#tbl_est_data tbody").append("<tr><td style='text-align:center;padding: 3px;'>" + (k) + "</td><td style='padding: 3px;'>" + value[i].JobDescription + "</td><td style='padding: 3px;'> </td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobQty) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobPrice) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobNetAmount) + "</td></tr>");
                        k++;
                    }
                });

           setTimeout(function(){$('#printArea').focus().print();},1000);
        }
      });
}

function cancelInvoice(invoice) {
  $.ajax({
        url:'../../salesinvoice/cancelInvoice',
        dataType:'json',
        type:'POST',
        data:{jobinvno:invoice},
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