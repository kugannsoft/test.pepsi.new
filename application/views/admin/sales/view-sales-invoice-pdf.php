<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style>
       /*@page { margin: 100px 25px; }*/
    header { position: fixed; top: 45px; left: 15px; right: 0px;  height: 20px; }
    /*footer { position: fixed; bottom: -20px; left: 20px; right: 0px; height: 10px;float: right; }*/
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .pagenum:before { content: counter(page); }
    .footer { position: fixed; bottom: 0px; }
    .main{
      margin-bottom: 50px;
      margin-top: -25px;}
      body{margin-top: 50px;
        margin-bottom: 10px;
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

    <?php $this->load->view('admin/_templates/company_header_new.php',true); ?>
<table style="border-collapse:collapse;width:90%;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;font-weight: bold;" ><span id="lblInvType">
        <?php if($invHed->SalesInvType==2){?>
        Tax Invoice
        <?php }elseif($invHed->SalesInvType==1) { ?>
        Invoice
        <?php } ?></span> </td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td colspan="2">Bill To :</td>
<td> &nbsp;</td>
        <td>Invoice Date</td>
      <td></td>
      <td colspan="2"> <?php echo $invHed->SalesDate;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td colspan="2" rowspan="4" style="font-size:14px;width: 250px">
            <span id="lblcusName"><?php echo $invCus->DisplayName;?></span><br>
            <span id="lbladdress1"><?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02;?></span>
            <!-- <span id="lbladdress2"><?php echo $invCus->Address03;?></span><br> -->
        </td>
        <td> &nbsp;</td>
        <td>PO Number</td>
        <td></td>
        <td colspan="2" id="lblPoNo"><?php echo $invHed->SalesPONumber;?></td>
    </tr>
    
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2" > &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td style="width: 100px;">Vehicle Number</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"><?php echo $invHed->SalesVehicle;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>VIN Number</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"><?php if(isset($invVehi)){ echo $invVehi->ChassisNo;}?></td>
    </tr>
   <tr style="text-align:right;font-size:13px;">
        <td style="text-align:left;font-size:13px;" colspan="2">Bill Issued By : <?php if(isset($invSales)){echo $invSales->RepName; } ?></td><td></td><td style="text-align:left;font-size:13px;"></td><td>:</td><td colspan="2"></td>
    </tr>
    <?php if($invHed->SalesInvType==2){?>
     <tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;">VAT Reg. No : <?php echo $company['Email02'] ?></td>
    </tr><?php }else{ ?><tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;"></td>
    </tr><?php } ?>
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
                <table style="border-collapse:collapse;width:700px;font-size:15px;font-family: Arial, Helvetica, sans-serif;" border="0">
                        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                         <tr><td colspan="5" style="text-align:left;">&nbsp;&nbsp;<b>Term & Conditions</b></td></tr>
                         <tr><td colspan="5" style="text-align:left;">
                           <ul>
                             <li>No cash refunds.</li>
                             <li>If supplied part is faulty has to be tested at Avinda workshop before returned.</li>
                             <li>Returns accepted only within a week of transaction date.</li>
                             <?php if($invHed->SalesCreditAmount>0){ ?>
                             <li>Payment to be made within 1 month of transaction date</li>
                             <?php } ?>
                           </ul>
                         </td></tr>
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