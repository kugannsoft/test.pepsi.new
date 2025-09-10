<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style>
       /*@page { margin: 100px 25px; }*/
    header { position: fixed; top: 5px; left: 15px; right: 0px;  height: 10px; }
    /*footer { position: fixed; bottom: -20px; left: 20px; right: 0px; height: 10px;float: right; }*/
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .pagenum:before { content: counter(page); }
    .footer { position: fixed; bottom: 0px; }
    .main{
      margin-bottom: 50px;
      margin-top: 5px;}
      body{margin-top: 30px;
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
  <!-- <header> -->
    <?php $this->load->view('admin/_templates/company_header_new.php',true); ?>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
      <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="border-bottom:solid #000 1px;"></td></tr>
     <!--  <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><span id="invType" style="font-size: 20px;position: relative;left:70px"><b><?php if($invHed->InvoiceType==1){?>CASH <?php }elseif($invHed->InvoiceType==2){ ?> TAX <?php } ?><br>INVOICE</b></span></td><td colspan="3" style="">&nbsp;</td></tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: right;">VAT NO : 1040587877000&nbsp;&nbsp;</td><td colspan="3" style="">&nbsp;</td></tr> -->
            <tr style="text-align:left;font-size:10px;">
                <td colspan="3" style="padding-top:9px;width:380px;">
                    <table style="text-align:left;font-size:12px;margin-left: 5px;position:relative; top:15px;font-weight: normal;">
                        <tr style="text-align:left;">
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;">
                            <td colspan="3"><span id="lblcusCode"><?php echo $invHed->customerCode;?></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Contact Name   &nbsp; &nbsp;<?php echo $invVehi->contactName;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"><?php echo $invCus->DisplayName;?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"><?php echo nl2br($invCus->Address01)."<br>";?></td>
                        </tr>
                        <tr style="text-align:left;">
                          <td> Tel  : </td>
                          <td id="lbltel" colspan="2"> <?php echo $invCus->MobileNo." ".$invCus->LanLineNo;?></td>
                        </tr>
                    </table>
                </td>
                <td colspan="3" valign="top" style="padding-top:15px;width:320px;">
                    <table style="text-align:left;font-size:11px;">
                      <tr style="text-align:left;">
                          <td style='width: 70px;'> Date</td>
                          <td style='width: 10px;'> :</td>
                          <td  id="lblinvDate"><?php echo $invHed->date;?></td>
                      </tr>
                      <tr style="text-align:left;">
                          <td > Reg No</td>
                          <td> :</td>
                          <td id="lblregNo"><?php echo $invHed->regNo;?></td>
                      </tr>
                      <tr style="text-align:left;">
                          <td > Job No</td>
                          <td> :</td>
                          <td id="lbljobNo"><?php echo $invHed->jobcardNo; ?></td>
                      </tr>
                      <tr style="text-align:left;">
                            <td > Estimate No</td>
                            <td> :</td>
                            <td  id="lblInvNo"> <?php echo $invHed->JobEstimateNo;?></td>
                        </tr>
                      <tr style="text-align:left;">
                          <td > Mileage</td>
                          <td> :</td>
                          <td id="lblviNo"><?php if($invjob){echo $invjob->OdoOut;}?></td>
                      </tr>
                      <tr style="text-align:left;">
                          <td > Chassis No</td>
                          <td> :</td>
                          <td  id="lblviNo"><?php echo $invVehi->ChassisNo;?></td>
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
            <!-- <tr style="text-align:left;font-size:10px;">
                
            </tr> -->
          </table>
  <!-- </header> -->
  <div class="main">
    <table id="tbl_est_data" style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:680px;padding:5px;font-size:13px;" border="0"> 
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
                      <table style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:683px;padding:2px;" border="0">
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
                        </table>
  </div> 

  </body>
  
  </html>