<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style>
       /*@page { margin: 100px 25px; }*/
    header { position: fixed; top: 5px; left: 5px; right: 0px;  height: 5px; }
    /*footer { position: fixed; bottom: -20px; left: 20px; right: 0px; height: 10px;float: right; }*/
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .pagenum:before { content: counter(page); }
    .footer { position: fixed; bottom: 0px; }
    .main{
      margin-bottom: 50px;
      margin-top: 5px;}
      body{margin-top: 5px;
        margin-bottom: 10px;
        margin-left: 10px;
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
  <!-- <header> -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>
            <table style="border-collapse:collapse;width:680px;font-family: Arial, Helvetica, sans-serif;" border="0"  align="center">
            <tr style="text-align:left;font-size:13px;">
      <td colspan="2"> <?php if($invHed->InvoiceType==2){?> Vat Reg No: <?php   echo  $invCus->DocNo; } ?></td>
      <td> &nbsp;</td>
      
      <td colspan="4"  style="font-size:18px;font-weight: bold;text-align:right; "> JOB INVOICE</td>
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
        <td colspan="2" style="width:60px;text-align:left;border-right: 1px solid #000;border-top: 1px solid #000;">&nbsp;&nbsp;ESTIMATE NO.</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="padding-top:0px;font-size:11px;text-align:right;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $invHed->JobInvNo ?>&nbsp;&nbsp;</td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $invHed->JobEstimateNo; ?>&nbsp;&nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="text-align:left;border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;DATE</td>
        <td ></td>
        <td colspan="2" style="text-align:left;border-right: 1px solid #000;">&nbsp;&nbsp;CUSTOMER NO.</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td style="font-size:11px;text-align:right;border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $invHed->date;?>&nbsp;&nbsp;</td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $invCus->CusCode;?>&nbsp;&nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:left;font-size:13px;border-left: 1px solid #000;border-right: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;INSURER </td><td></td><td colspan="2" style="border-right: 1px solid #000;">&nbsp;&nbsp;ISSUED BY</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:right;font-size:11px;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php if($invHed->InvoiceType==1){?><?php echo $invHed->VComName; }?>&nbsp;&nbsp;</td><td style="border-bottom: 1px solid #000;"></td><td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $invHed->first_name." ".$invHed->last_name;?>&nbsp;&nbsp;</td>
    </tr>
    
            <?php if($invjob){
              $noofjob=$job_count->noofjobs;$refno=0;$nextService=$invjob->OdoIn+$invjob->OdoOut;
            }else{
              $noofjob=0;$refno=0;$nextService=0;
            } ?>
        </table>
        <table  class="tblhead"  style="margin-top:3px;font-size:12px;border-collapse:collapse;width:690px;font-family: Arial, Helvetica, sans-serif;" >
  <tr style=" border: 1px solid black;">
    <td  style="border: 1px solid black;width: 150px;">REG. NO. <br> &nbsp;&nbsp; <span style="text-align: center;font-size:11px;"><?php echo $invHed->regNo;?></span></td>
    <td  style="border: 1px solid black;width: 150px;">CHASSIS NO. <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invVehi)){ echo $invVehi->ChassisNo;}?></span></td>
    <td  style="border: 1px solid black;width: 150px;">MAKE <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invVehi)){ echo $invVehi->make;} ?></span></td>
    <td  style="border: 1px solid black;width: 150px;">MODEL <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php  if(isset($invVehi)){ echo $invVehi->model;}?></span></td>
  </tr>
  <tr style=" border: 1px solid black;">
    <td  style="border: 1px solid black;width: 150px;">MILEAGE<br> &nbsp;&nbsp; <span style="text-align: center;font-size:11px;"><?php if($invjob){echo ml_to_km($invjob->OdoOut,$invjob->OdoOutUnit);}?> KM</span></td>
    <td  style="border: 1px solid black;width: 150px;">LAST SERVICE DATE. <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invjob)){ echo $last_job;}?></span></td>
    <td  style="border: 1px solid black;width: 150px;">NEXT SERVICE <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invjob)){ echo nextodo($invjob->OdoOut,$invjob->OdoOutUnit,$invjob->NextService);} ?> KM</span></td>
    <td  style="border: 1px solid black;width: 150px;">JOB NO. <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php echo $invHed->jobcardNo ?></span></td>
  </tr>
<?php 
  function ml_to_km($odo,$odounit){
    $km=0;
    //miles to kilometers
    if($odounit==1){
      $km=$odo;
    }elseif ($odounit==2) {
       $km=number_format($odo*1.60934);
    }
return $km;
  }

  function nextodo($odo,$odounit,$odonext){
    $km=0;
    //miles to kilometers
    if($odounit==1){
      $km=$odo+$odonext;
    }elseif ($odounit==2) {
       $km=number_format(($odo*1.60934)+$odonext);
    }
return $km;
  }
 ?>
</table>
  <!-- </header> -->
  <div class="main">
    <table id="tbl_est_data" style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:680px;font-size:13px;" border="0"> 
                          <tbody>
                            <tr style="line-height: 20px;background-color:#5d5858 !important;color:#fff !important;">
                                 <td style="font-weight:bold;width:40px;"></td>
                                  <td colspan="2" style="font-weight:bold;width:270px;">Item & Description</td>
                                  <!-- <td style="width:150px;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;"></td> -->
                                  <td style="font-weight:bold;width:40px;">Qty</td>
                                  <td style="font-weight:bold;width:80px;" class='text-right'>Rate</td>
                                  <!-- <td style="width:50px;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;" class='text-right'></td> -->
                                  <td colspan="2" style="width:90px;font-weight:bold;" class='text-right'>Amount</td>
                            </tr>
                          <?php $i=1;
                                 foreach ($invDtl AS $key=>$invdata) { 
                                  if($key!='PARTS2'){  ?>
                                <tr style="line-height: 20px;background-color:#e4dbdb !important;color:#000 !important;">
                                <td style="">&nbsp;</td>
                                <td colspan="2" style=""><b><?php echo $key?></b></td>
                                <td style="">&nbsp;</td>
                                <td style="">&nbsp;</td><td colspan="2" style="">&nbsp;</td>
                                </tr>
                                       <?php } 
                                       foreach ($invdata AS $inv) { ?>
                                <tr style="line-height:20px">
                                  <td style="border-bottom:1px dotted #e4dbdb;"><?php echo $i?></td>
                                  <td colspan="2" style="border-bottom:1px dotted #e4dbdb;"><?php echo $inv->JobDescription?></td>
                                  <td class='text-right' style="border-bottom:1px dotted #e4dbdb;"><?php echo number_format($inv->JobQty,2)?></td>
                                  <td class='text-right' style="border-bottom:1px dotted #e4dbdb;"><?php echo number_format($inv->JobPrice,2)?></td>
                                  <td class='text-right' colspan="2" style="border-bottom:1px dotted #e4dbdb;"><?php echo number_format($inv->JobTotalAmount,2)?></td>
                                </tr>
                                       <?php $i++; } ?>
                            <?php  } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-size: 10px;font-weight: normal;text-align: left;border-right:1px #fff solid;'>Any Inquiries please contact service manager</th>
                              <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>SUB TOTAL &nbsp;&nbsp;</th>
                              <th style="border-right: 1px solid #fff;">Rs.</th>
                              <th id="totalAmount" style='text-align:right;border-left: 1px solid #fff;'><?php if($invHed->InvoiceType==1){echo number_format($invHed->JobTotalAmount,2); }elseif($invHed->InvoiceType==2){echo number_format($invHed->JobTotalAmount,2);}?></th>
                            </tr>
                              <?php if($invHed->JobTotalDiscount>0){?>
                            <tr>
                                <th colspan="4" style='border-top: 1px solid #fff;text-align:right;border-left:1px solid #fff ;border-bottom:1px solid #fff ;border-right: 1px solid #000;'></th>
                                <th style='border-left: 1px solid #000;border-top: 1px solid #000;text-align:right;border-right:1px #fff solid;border-bottom:1px #fff solid;'>DISCOUNT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalDiscount" style='text-align:right;border-left: 1px solid #fff;'><span style="text-align: left;"></span> <?php echo number_format($invHed->JobTotalDiscount,2);?></th>
                            </tr>
                              <?php } ?>
                              <?php if($invHed->JobAdvance>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> ADVANCE &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right;border-left: 1px solid #fff;'><?php echo number_format($invHed->JobAdvance,2);?></th>
                            </tr>
                              <?php }?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;border-top:1px #fff solid;border-right:1px #fff solid;font-weight: normal;text-align: left;'></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-top:1px #fff solid;border-bottom:1px #fff solid;'>  VAT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right;border-left: 1px solid #fff;'><?php echo number_format($invHed->JobVatAmount,2);?></th>
                            </tr>
                                <?php if($invHed->JobNbtAmount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;border-top:1px #fff solid;border-right:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;border-top:1px #fff solid;'> NBT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right;border-left: 1px solid #fff;'><?php echo number_format($invHed->JobNbtAmount,2);?></th>
                            </tr>
                           <?php } ?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;border-top:1px #fff solid;border-right:1px #fff solid; font-weight: normal;text-align: left;'></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-top :1px #fff solid;border-bottom:1px #fff solid;'> TOTAL &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="netAmount" style='text-align:right;border-left: 1px solid #fff;'><?php echo number_format($invHed->JobNetAmount-$invHed->JobAdvance,2) ?></th>
                            </tr>
                          </tfoot>
                      </table>
                     <!--  <table style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:683px;padding:2px;" border="0">
                          <tbody>
                             <tr><td colspan="7">&nbsp;</td></tr>
                             <tr><td colspan="7">&nbsp;</td></tr>
                             <tr>
                              <td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><?php //echo $invjob->first_name;?></td><td>&nbsp;</td><td colspan="2"></td><td>&nbsp;</td>
                            </tr>
                            <tr><td style="border-top:1px dashed #000;text-align: center;width:100px;">Check by</td><td style="width: 20px;">&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:100px;">Prepared By</td><td style="width:20px;">&nbsp;</td><td colspan="2" style="border-top:1px dashed #000;text-align: center;font-size: 10px;">Signature Of Purchaser</td><td style="width:200px;"></td></tr>
                            <tr><td style="text-align: center;width:100px;"></td><td style="width: 20px;">&nbsp;</td><td style="text-align: center;width:100px;"></td><td style="width: 20px;">&nbsp;</td><td colspan="2" style="font-size: 11px;">I am satisfied with service / goods I received</td><td style="width:200px;"></td></tr>
                            <tr><td style="text-align: left;width:100px;"><b>Remarks</b></td><td colspan="6">&nbsp;</td></tr>
                            <tr><td colspan="7"  style="border:1px solid #000;height: 30px;">&nbsp;</td></tr>
                            <tr><td style="font-size: 11px;"><?php //echo date('d-m-Y');?></td><td colspan="5"  style="">&nbsp;</td><td style="font-size: 11px;text-align: right;"></td></tr>
                                         
                        </tbody>
                        </table> -->
                        <table style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:683px;padding:2px; position: relative;bottom: 20px; " align="center" border="0">
          
                          <tbody>
                             <tr><td colspan="7">&nbsp;</td></tr>
                             <tr><td colspan="7">&nbsp;</td></tr>                             <tr>
                              <td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><?php //echo $invjob->first_name;?></td><td>&nbsp;</td><td colspan="2"></td><td>&nbsp;</td>
                            </tr>
                            <tr><td style="border-top:1px dashed #000;text-align: center;width:150px;">Issued By</td><td style="width: 50px;">&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:150px;">Checked by</td><td style="width:50px;">&nbsp;</td><td colspan="2" style="border-top:1px dashed #000;text-align: center;font-size: 10px;width:150px;">Signature Of Purchaser</td><td style="width:50px;"></td></tr>
                            <tr><td style="text-align: center;width:100px;"></td><td style="width: 20px;">&nbsp;</td><td style="text-align: center;width:100px;"></td><td style="width: 20px;">&nbsp;</td><td colspan="2" style="font-size: 11px;">I am satisfied with service / goods I received</td><td style="width:50px;"></td></tr>
                            <tr><td style="text-align: left;width:100px;"><b>Remarks</b></td><td colspan="6">&nbsp;</td></tr>
                            <tr><td colspan="7"  style="padding: 2px;">&nbsp;<?php echo nl2br($invHed->InvRemark); ?></td></tr>
                            <tr><td colspan="7"  style="padding: 2px;"><span>Terms & Conditions</span>
                                <ul>
                                   <?php foreach ($term as $val) { ?>
                                       <li><?php echo $val->InvCondition; ?></li>
                                   <?php } ?>
                                </ul> </td></tr>

                            <tr><td style="font-size: 11px;"><?php //echo date('d-m-Y');?></td><td colspan="5"  style="">&nbsp;</td><td style="font-size: 11px;text-align: right;"></td></tr>
                                         
                        </tbody>
                        </table>
  </div> 

  </body>
  
  </html>