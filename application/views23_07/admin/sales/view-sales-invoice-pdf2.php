<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style>
       /*@page { margin: 100px 25px; }*/
    header { position: fixed; top: 45px; left: 10px; right: 0px;  height: 10px; }
    /*footer { position: fixed; bottom: -20px; left: 20px; right: 0px; height: 10px;float: right; }*/
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .pagenum:before { content: counter(page); }
    .footer { position: fixed; bottom: 0px; }
    .main{
      margin-bottom: 10px;
      margin-top: -25px;}
      body{margin-top: 5px;
        margin-bottom: 5px;
        margin-left: 20px;
        height: auto;}

        #tbl_est_data tbody tr td{
        padding: 3px;
    }
    #tbl_est_data2 tbody tr td{
        padding: 13px;
    }
    .text-right{
      text-align: right;
    }
</style>
</head>

<?php $noofjob=0;$refno=0; ?>
<body>
  <div class="footer" style="text-align:center;">Avinda Enterprises Your Trusted Partner For Mercedes-Benz Solutions</div>
  <div class="main">

    <?php $this->load->view('admin/_templates/company_header.php',true); ?>
<table style="border-collapse:collapse;width:690px;font-family: Arial, Helvetica, sans-serif;" border="0"  align="center">
            <tr style="text-align:left;font-size:13px;">
      <td colspan="2"> <?php if($invHed->SalesInvType==2){?> Vat Reg No: <?php   echo  $invCus->DocNo; } ?></td>
      <td> &nbsp;</td>
      
      <td colspan="4"  style="font-size:18px;font-weight: bold;text-align:right; "> SALES INVOICE</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="2" rowspan="5" style="border:1px solid #000;font-size:13px;width:180px;padding: 5px;" v-align="top">
            <span><?php echo $invCus->DisplayName;?></span><br>
                <?php if ($invCus->DisType==4): ?>
                    <?php echo $invCus->ContactPerson;?><br>
                <?php endif ?>
            <span >
              <?php if ($invCus->DisType!=4){ ?>
                <?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02;?> <?php echo $invCus->Address03;?>
              <?php }else{ ?> 
                <?php echo nl2br($invCus->ComAddress);?>
              <?php } ?>
            </span><br>    
            <span id="lbladdress2">Tel : <?php echo $invCus->LanLineNo;?> Mobile : <?php echo $invCus->MobileNo;?></span>
        </td>
        <td style="font-size:14px;width:3px;"> &nbsp;</td>
        <td style="font-size:11px;width:130px;text-align: center;border-left: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;" colspan="4">FOR REFERENCE PLEASE QUOTE THE FOLLOWING NO</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="width:90px;text-align:left;border-left: 1px solid #000;border-top:1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;INVOICE NO.</td>
        <td style="width:1px;border-top: 1px solid #000;"></td>
        <td colspan="2" style="width:60px;text-align:left;border-right: 1px solid #000;border-top: 1px solid #000;">&nbsp;&nbsp;ORDER NO.</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="padding-top:0px;font-size:11px;text-align:right;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $invHed->SalesInvNo ?>&nbsp;&nbsp;</td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $invHed->SalesPONumber; ?>&nbsp;&nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="text-align:left;border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;DATE</td>
        <td ></td>
        <td colspan="2" style="text-align:left;border-right: 1px solid #000;">&nbsp;&nbsp;CUSTOMER NO.</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td style="font-size:11px;text-align:right;border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $invHed->SalesDate;?>&nbsp;&nbsp;</td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $invCus->CusCode;?>&nbsp;&nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:left;font-size:13px;border-left: 1px solid #000;border-right: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;INSURER </td><td></td><td colspan="2" style="border-right: 1px solid #000;">&nbsp;&nbsp;ISSUED BY</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:right;font-size:11px;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php //if($invHed->SalesInvType==1){?><?php echo $invHed->VComName; //}?>&nbsp;&nbsp;</td><td style="border-bottom: 1px solid #000;"></td><td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $invHed->first_name." ".$invHed->last_name;?>&nbsp;&nbsp;</td>
    </tr>
        </table>
        <table  class="tblhead"  style="margin-top:3px;font-size:12px;border-collapse:collapse;width:690px;font-family: Arial, Helvetica, sans-serif;" >
  <tr style=" border: 1px solid black;">
    <td  style="border: 1px solid black;width: 150px;">REG. NO. <br> &nbsp;&nbsp; <span style="text-align: center;font-size:11px;"><?php echo $invHed->SalesVehicle;?></span></td>
    <td  style="border: 1px solid black;width: 150px;">CHASSIS NO. <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invVehi)){ echo $invVehi->ChassisNo;}?></span></td>
    <td  style="border: 1px solid black;width: 150px;">MAKE <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invVehi)){ echo $invVehi->make;} ?></span></td>
    <td  style="border: 1px solid black;width: 150px;">MODEL <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php  if(isset($invVehi)){ echo $invVehi->model;}?></span></td>
  </tr>
  </table>
    <table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:15px;font-family: Arial, Helvetica, sans-serif;" border="0">
                <?php if($invHed->SalesInvType==2 || $invHed->SalesInvType==3){?>
                    <thead id="taxHead">
                        <tr><td colspan="5" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td></tr>
                        <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:23px;">
                            <th style='padding: 3px;color:#fff !important;'>#</th>
                            <th style='padding: 3px;color:#fff !important;'>Item & Description</th>
                            <!-- <th style='padding: 3px;'></th> -->
                            <th style='padding: 3px;color:#fff !important;'>Qty</th>
                            
                            <th style='padding: 3px;color:#fff !important;text-align:right;' >Rate</th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Amount</th>
                        </tr>
                    </thead>
                  <?php }elseif($invHed->SalesInvType==1){?>
                    <thead  id="invHead">
                        <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:23px;">
                            <th style='padding: 3px;color:#fff !important;'>#</th>
                            <th style='padding: 3px;color:#fff !important;'>Item & Description</th>
                            <!-- <th style='padding: 3px;'></th> -->
                            <th style='padding: 3px;color:#fff !important;'>Qty</th>
                            
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Rate</th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Amount</th>
                        </tr>
                    </thead>
                    <?php } ?>
                    <tbody>
                    <?php 
 $i=1;
                     //var_dump($invDtlArr);
                    foreach ($invDtl AS $invdata) {

                      if($invHed->SalesInvType==1 || $invHed->SalesInvType==3){
                      //normal invoice
                       
                         ?>
                        <tr style="line-height:23px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $i;?></td>
        
                          <td style="border-bottom:1px solid #e4dbdb;" ><?php echo $invdata->SalesProductName."<br>".$invdata->SalesSerialNo;?></td>
                         <td style="border-bottom:1px solid #e4dbdb;"><?php echo number_format(($invdata->SalesQty),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesUnitPrice),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesInvNetAmount),2)?></td>
                        </tr>
                    <?php $i++; 
                         
                      }elseif($invHed->SalesInvType==2){
                      //Tax Invoice
                        
                         ?>
                        <tr style="line-height:23px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $i;?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" ><?php echo $invdata->SalesProductName."<br>".$invdata->SalesSerialNo;?></td>
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo number_format(($invdata->SalesQty),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesUnitPrice),2)?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format(($invdata->SalesTotalAmount),2)?></td>
                        </tr>
                    <?php $i++; 
                        
                      }
                    }//foreach end
                       ?>                    
                    </tbody>
                    <tfoot>
                    <?php
                    $payment_term ='';
                     if($invHed->SalesInvType==2){ ?>
                        <tr style="line-height:25px;" id="rowTotal"><td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;padding: 3px;">Sub Total </td><td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invHed->SalesInvAmount,2);?></td></tr><?php }else{ ?> 
                        <tr style="line-height:25px;" id="rowTotal"><td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;padding: 3px;">Sub Total </td><td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'><?php echo number_format($invHed->SalesInvAmount,2);?></td></tr>
                        <?php } ?>
                        <?php if($invHed->SalesDisAmount>0){?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Discount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesDisAmount,2);?></td>
                         </tr>
                          <?php }?>
                         <?php if($invHed->SalesVatAmount>0 && $invHed->SalesInvType==2){?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">VAT Amount  </td><td id="lbltotalVat"   style='text-align:right'><?php echo number_format($invHed->SalesVatAmount,2);?></td>
                         </tr><?php } ?>
                          <?php if($invHed->SalesNbtAmount>0 && $invHed->SalesInvType==2){?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">NBT Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesNbtAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesShipping>0){?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right"><?php echo $invHed->SalesShippingLabel; ?>  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesShipping,2);?></td>
                         </tr>
                          <?php }?>
                         <?php if($invHed->SalesVatAmount>0 || $invHed->SalesShipping>0 || $invHed->SalesNbtAmount>0 || $invHed->SalesDisAmount>0){?>
                        <tr style="line-height:25px;" id="rowNET">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="font-weight:bold;text-align:right">Total  </td><td id="lbltotalNet"   style='font-weight:bold;text-align:right'><?php echo number_format($invHed->SalesNetAmount,2);?></td>
                        </tr>
                        <?php } ?>
                        <?php if($invHed->SalesAdvancePayment>0){
                            $payment_term="Advance";
                          ?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Advance Amount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesAdvancePayment,2);?></td>
                         </tr>
                          <?php }?>
                        <?php if($invHed->SalesCashAmount>0){
                          $payment_term="Cash";
                          ?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Cash Amount  </td><td id="lbltotalDicount"   style='text-align:right'><?php echo number_format($invHed->SalesCashAmount,2);?></td>
                         </tr>
                          <?php }?>
                          <?php if($invHed->SalesBankAmount>0){
                          $payment_term="Bank";
                          ?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Bank Transfer  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesBankAmount,2);?></td>
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
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Card Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesCCardAmount,2);?></td>
                        </tr>
                         <?php } ?>
                         <?php if($invHed->SalesCreditAmount>0){
                          $payment_term="Credit";
                          ?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right;font-weight:bold;background-color:#e4dbdb !important;">TOTAL PAYABLE  </td><td id="lbltotalVat"   style='font-weight:bold;text-align:right;background-color:#e4dbdb !important;'><?php echo number_format($invHed->SalesCreditAmount,2);?></td>
                         </tr><?php } ?>

                          
                    </tfoot>
                </table>
                 <table style="border-collapse:collapse;width:600px;font-size:15px;font-family: Arial, Helvetica, sans-serif;" border="0">
                           <tr><td colspan="5" style="text-align:right;width:500px;">&nbsp;</td></tr> 
                           <tr>
                            <td style="width:170px;text-align: left">&nbsp;</td>
                            <td style="width:5px;">&nbsp;</td>
                            <td style="width:150px;text-align: center">&nbsp;</td>
                            <td style="width:5px;">&nbsp;</td>
                            <td style="width:170px;text-align: left">&nbsp;</td>
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
                            <td style="text-align: center;font-size:12px;">I have received mentioned items.</td>
                        </tr>
                        <?php if($invHed->SalesCreditAmount>0){ ?>
                         <tr>
                            <td style="width:170px;text-align: left"></td>
                            <td style="width:5px;">&nbsp;</td>
                            <td style="width:150px;text-align: center"></td>
                            <td style="width:5px;">&nbsp;</td>
                            <td style="width:170px;text-align: left"></td>
                        </tr> 
                       <tr>
                            <td style="border-bottom:1px dashed #000;" >&nbsp;</td>
                            <td style="">&nbsp;</td>
                            <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                            <td style="">&nbsp;</td>
                           <td style="border-bottom:1px dashed #000;">&nbsp;</td>
                        </tr>
                         <tr>
                            <td style="text-align: center">On behalf of Customer Signature
                            </td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">Name</td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center">NIC</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                            <td style="">&nbsp;</td>
                            <td style="text-align: center"></td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr> 
                        <!-- <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>  -->
                        <!-- <tr><td colspan="5" style="text-align:center;font-size: 18px;"><i>Avinda Enterprises Your Trusted Partner For Mercedes-Benz Solutions</i></td></tr> -->
                    </table>
  </div> 

  </body>

   </html>