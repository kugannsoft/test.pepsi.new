<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
    <div class="row"  align="center" style='margin:5px;'>
                       <div class="row"  id="printArea3" align="center" style='margin:5px;'>
                       <div id="customercopy">
    <!-- company header -->
     <?php $this->load->view('admin/_templates/company_header.php',true); ?>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">
       
        <tr style="text-align:left;">
            <td style="width:80px;">&nbsp;</td>
            <td  style="width:10px;">&nbsp;</td>
            <td  style="width:120px;">&nbsp;</td>
            <td  style="width:10px;">&nbsp;</td>
            <td  style="width:50px;">&nbsp;</td>
            <td  style="width:100px;">&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:150px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td>-->
            <!-- <td >&nbsp;</td>  -->
            <td colspan="3" style='font-size: 20px;text-align: center;'><b> Payment Receipt</b></td>
            <td>DATE</td>
            <td>:</td>
            <td id="chq_rcpdate"><?php echo $pay->PayDate; ?></td>
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
            <td id="chq_rcpreceiptno"><?php echo $pay->CusPayNo; ?></td>
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
            <td colspan="5"  id="chq_rcpamountword"><?php echo $pay_amount; ?></td>
            <!-- <td>&nbsp;</td> -->
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
            <td colspan="4"  id="chq_rcpreason"><?php echo $pay->Remark; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">In Cash / Cheque from</td>
            <td>:</td>
            <td colspan="4" id="chq_rcpcusname"><?php echo $pay->DisplayName; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td>:</td>
            <td colspan="4" id="chq_rcpcusaddress" rowspan="3"><?php echo $pay->Address01."<br>".$pay->Address02." ".$pay->Address03; ?></td>
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
            <!-- <td id="chq_rcpinvno"></td> -->
            <td colspan="3"  > : <?php if($inv){echo $inv->InvNo;} ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Vehicle No</td>
            <td>:</td>
            <td colspan="2" id="chq_rcpvno"><?php if($inv){echo $inv->vehicle;} ?></td>
            <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;</td>
            <td id="chq_rcpcuscode"> :  <?php echo $pay->CusCode; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Amount</td>
            <td>:</td>
            <td colspan="2" id="chq_rcpamount">Rs.<?php echo number_format($pay->PayAmount,2); ?></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Cheque No</td>
            <td>:</td>
            <td colspan="2" id="chq_rcpchequeno"><?php echo $pay->ChequeNo; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Bank</td>
            <td>:</td>
            <td colspan="3" id="chq_rcpbank"><?php echo $pay->BankName; ?></td>
            <!-- <td></td> -->
            <td></td>
            <td>&nbsp;</td>
            <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Date</td>
            <td>:</td>
            <td colspan="2"  id="chq_rcpchequedate"><?php echo $pay->ChequeDate; ?></td>
            <td></td>
            <!-- <td>&nbsp;</td> -->
            <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <!-- <td>&nbsp;</td> -->
        </tr>
        <tr style="text-align:left;">
            <td>Payment Type</td>
            <td>:</td>
            <td colspan="2"  id="chq_rcppaytype"><?php echo $pay->PayMethod; ?> Payment</td>
            <td></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    </div><br> 
 <br> 
    <!--  --> 
        </div>
</body>
</html> 