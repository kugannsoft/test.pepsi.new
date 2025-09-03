<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style>
       /*@page { margin: 100px 25px; }*/
    header { position: fixed; top: 35px; left: 15px; right: 0px;  height: 200px; }
    /*footer { position: fixed; bottom: -20px; left: 20px; right: 0px; height: 10px;float: right; }*/
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .pagenum:before { content: counter(page); }
    .main{
      margin-bottom: 20px;
      margin-top: -25px;}
      body{margin-top: 220px;
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
    @page { size: 595pt   595pt; }
</style>
</head>

<?php $noofjob=0;$refno=0; ?>
<body>
  <header>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
        <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:120px;">&nbsp;</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:200px;">&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;">&nbsp;</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;">&nbsp;</td>
        </tr>
        <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:120px;vertical-align:top;padding-left: 5px;text-align: left;font-size: 10px" colspan="3" rowspan="4"><br><span id="lblCusName"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?></span><br><span id="lblAddress"><?php echo nl2br($invCus->Address01).",<br> ";?></span></td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;">&nbsp;</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;">&nbsp;</td>
        </tr> 
        <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;">&nbsp;</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;">&nbsp;</td>
        </tr>
        <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;">&nbsp;</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;">&nbsp;</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:120px;">PAGE</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:200px;"  id="lblPage"><span class="pagenum"></span></td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;text-align:left;">DATE</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;"  id="lblInvDate"><?php echo $invHed->InvDate;?></td>
        </tr>
        <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:120px;">OUR REFERENCE</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:200px;"  id="lblOurRef"><?php echo $invHed->InvJobCardNo;?></td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;text-align:left;">INVOICE NO</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;"  id="lblInvNo"><?php echo $invHed->InvNo;?></td>
        </tr>
        <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
            <td style="width:120px;">CUSTOMER CODE</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:200px;" id="lblCusCode"><?php echo $invHed->InvCustomer;?></td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:120px;text-align:left;">YOUR REFERENCE</td>
            <td style="width:5px;">&nbsp;</td>
            <td style="width:250px;" id="lblYourRef"><?php  if($invVehi){echo $invVehi->RegNo;}else{ echo '-'; }?></td>
        </tr>
    </table>
  </header>
  <div class="main">
    <table id="tblData"  style="border-collapse:collapse;width:700px;font-size:10px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                <thead>
                    <tr style="text-align:center;border:#000 solid 1px;">
                        <td style="text-align:center;border:#000 solid 1px;">ITEM CODE</td>
                        <td style="text-align:center;border:#000 solid 1px;">PART NO.</td>
                        <td style="text-align:center;border:#000 solid 1px;">PART NAME</td>
                        <td style="text-align:center;border:#000 solid 1px;"> QTY</td>
                        <td style="text-align:center;border:#000 solid 1px;">RATE</td>
                        <td style="text-align:center;border:#000 solid 1px;">TOTAL AMOUNT</td>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($invDtl as $inv) { ?>
                    <tr>
                      <td style="text-align:left;"><?php echo $inv->InvProductCode?></td>
                      <td><?php //echo $inv->InvProductCode?></td>
                      <td style="text-align:left;"><?php echo $inv->Description?></td>
                      <td style="text-align:right;"><?php echo $inv->InvQty?></td>
                      <td style="text-align:right;"><?php echo $inv->InvUnitPrice?></td>
                      <td style="text-align:right;"><?php echo $inv->InvTotalAmount?></td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right;border-top:#000 solid 1px;">Sub Total</td>
                    <!--<td></td>-->
                        <td style="text-align:right;border-top:#000 solid 1px;"  id="invTotal"><?php echo number_format($invHed->InvAmount,2);?></td>
                    </tr>
                    <tr id="discountRow">
                        <td colspan="5" style="text-align: right;">Discount</td>
                        <!--<td></td>-->
                        <td style="text-align:right"  id="invTotalDis"><?php echo number_format($invHed->InvDisAmount,2);?></td>
                    </tr>
                    <tr  id="nbtAmountRow">
                        <td colspan="5"  style="text-align: right;">NBT</td>
                        <!--<td></td>-->
                        <td style="text-align:right"  id="invNbt"><?php echo number_format($invHed->InvNbtAmount,2);?></td>
                    </tr>
                    <tr  id="vatAmountRow">
                        <td colspan="5"  style="text-align: right;">VAT</td>
                        <!--<td></td>-->
                        <td style="text-align:right"  id="invVat"><?php echo number_format($invHed->InvVatAmount,2);?></td>
                    </tr>
                    <tr  id="netAmountRow">
                        <td colspan="5"  style="text-align: right;">Total Amount</td>
                        <!--<td></td>-->
                        <td style="text-align:right"  id="invNet"><?php echo number_format($invHed->InvNetAmount,2);?></td>
                    </tr>
                </tfoot>
            </table>
  </div> 
  </body></html>