<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style>
       /*@page { margin: 100px 25px; }*/
    /*header { position: fixed; top: 5px; left: 15px; right: 0px;  height: 10px; }*/
    /*footer { position: fixed; bottom: -20px; left: 20px; right: 0px; height: 10px;float: right; }*/
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .pagenum:before { content: counter(page); }
    .main{
      margin-bottom: 50px;
      margin-top: -25px;}
      body{margin-top: 20px;
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
  <!-- <header>
    
  </header> -->
  <div class="main">
    <div class="row" id="printArea" align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>

<style type="text/css" media="screen">

    #tbl_po_data2 tbody tr td{
    padding: 5px  !important;
    border-bottom:1px solid #fff !important;
}
</style>

<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="font-size:13px;">
        <td></td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:right;font-size:20px;font-weight: bold; padding-top: 5px;
          padding-bottom: 5px;
          padding-left: 5px;" >Statement of Accounts</td>
    </tr>
    <tr style="font-size:13px;">
        <td></td>
        <td> </td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" style="text-align:right;font-size:12px;font-weight: bold; padding-top: 5px;
          padding-bottom: 5px;
          padding-left: 5px;border-bottom:1px solid #000;" >From  <?php echo $startdate; ?> To  <?php echo $enddate; ?> </td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="8">&nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td>To :</td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:left;font-size:15px;font-weight: bold;background-color: #b3b3b3; padding-top: 5px;
          padding-bottom: 5px;
          padding-left: 5px;" >Account Summary</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="4" rowspan="4" style="font-size:14px;width:350px;">
            <span id="lblcusName"><?php echo $invCus->DisplayName;?></span><br>
            <span id="lblcusName"><?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02."<br>".$invCus->Address03;?></span>
        </td>
        <td></td>
        <td style="text-align:left;width:150px;">Opening Balance</td>
        <td> Rs : </td>
        <td style="text-align:right;"><?php echo number_format($opbalance,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Invoiced Amount</td>
        <td> Rs : </td>
        <td style="text-align:right;" id="lblPoNo"><?php echo number_format($InvAmount,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Amount Paid </td>
        <td> Rs : </td>
        <td  style="text-align:right;" ><?php echo number_format($InvPayment,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Balance Due</td>
        <td> Rs : </td>
        <td style="text-align:right;" ><?php echo number_format($InvAmount- $InvPayment+$opbalance,2)?></td>
    </tr>
</table>
        <table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;font-family: Arial, Helvetica, sans-serif;" border="0">
                    <thead id="taxHead">
                        <tr><td colspan="5" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td></tr>
                            <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:20px;">
                            <th style='padding: 3px;color:#fff !important;'>Date</th>
                            <th style='padding: 3px;color:#fff !important;'>Transactions</th>
                            <th style='padding: 3px;color:#fff !important;'>Details</th> 
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Amount  </th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Payments</th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Balance</th>
                        </tr>
                    </thead>                 
                    <tbody> 
                        <tr style="line-height:20px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $startdate ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;">****Opening Balance***</td>
                          <td style="border-bottom:1px solid #e4dbdb;">-</td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo  number_format($opbalance,2) ?></td>
                        </tr>
                        <?php $total=0; foreach ($cr as $crr) { ?>      
                        <tr style="line-height:20px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $crr->InvoiceDate ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $crr->InvoiceNo ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;">-</td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format($crr->CreditAmount,2) ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format($crr->SettledAmount,2) ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo  number_format($crr->CreditAmount - $crr->SettledAmount,2) ?></td>
                        </tr>  
                        <?php $total +=$crr->CreditAmount - $crr->SettledAmount;  } ?>                                     
                    </tbody>
                    <tfoot>                         
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Balance Due</td>                        
                          <td> </td>
                          <td style="text-align:right;padding-right:15px;font-weight:bold;">Rs :  <?php echo number_format($total+$opbalance,2)?></td>
                        </tr>                         
                    </tfoot>
        </table>
          
    <style type="text/css" media="screen">
    #tbl_po_data tbody tr td{
        padding: 13px;
    }
</style>
</div>
  </div> 
  </body></html>