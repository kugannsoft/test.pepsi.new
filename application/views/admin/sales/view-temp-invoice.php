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
    <div class="box-header" style="background: #b4f3c8">
                    <div class="col-sm-4"><span><b><?php echo $pagetitle; ?></b></span>
                            
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <?php if($invHed->IsCancel==1){$disabled='disabled'; }else{$disabled='';}?>
                            
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2">
                              <!-- <button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print</button> -->
                            </div>
                            <div class="col-sm-1">
                              <!-- <a href="<?php echo base_url('admin/Salesinvoice/print_invoice_pdf/').base64_encode($invNo); ?>" target="blank_" class="btn btn-primary btn-sm">Pdf</a> -->
                            </div>
                            <div class="col-sm-1">
                              <!-- <a href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?id=').base64_encode($invNo); ?>" target="blank_" class="btn btn-info btn-sm">Clone</a> -->
                            </div>
                            <div class="col-sm-2"><?php if($invHed->IsCancel==0){?>
                            <!-- <button type="button" <?php echo $disabled;?>  id="btnCancel" class="btn btn-danger btn-sm btn-block">Cancel</button> -->
                            <?php } ?>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                            </div>
                        </div>       
                    </div>
                        <!-- </div> -->
                    </div>
    <section class="content">
      <div class="row">
        <div class="col-lg-7">
    <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
        <div class="row" id="printArea"  align="center" style='margin:5px;'>
          <?php $this->load->view('admin/_templates/company_header.php',true); ?>
            <table style="border-collapse:collapse;width:690px;font-family: Arial, Helvetica, sans-serif;" border="0"  align="center">
            <tr style="text-align:left;font-size:13px;">
      <td colspan="2"> <?php if($invHed->InvoiceType==2){?> Vat Reg No: <?php   echo  $invCus->DocNo; } ?></td>
      <td> &nbsp;</td>
      
      <td colspan="4"  style="font-size:18px;font-weight: bold;text-align:left; "> JOB INVOICE</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="2" rowspan="5" style="border:1px solid #000;font-size:13px;width:250px;padding: 5px;" v-align="top">
            <span><a href="<?php echo base_url('admin/payment/view_customer/').$invCus->CusCode ?>"><?php echo $invCus->DisplayName;?></a></span><br>
                <?php if ($invCus->DisType==4): ?>
                    <?php echo $invCus->ContactPerson;?><br>
                <?php endif ?>
            <span ><?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02;?> <?php echo $invCus->Address03;?></span><br>    
            <span id="lbladdress2">Tel : <?php echo $invCus->LanLineNo;?> Mobile : <?php echo $invCus->MobileNo;?></span>
        </td>
        <td style="font-size:14px;width:3px;"> &nbsp;</td>
        <td style="font-size:11px;width:130px;text-align: center;border-left: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;" colspan="4">FOR REFERENCE PLEASE QUOTE THE FOLLOWING NO</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="text-align:left;border-left: 1px solid #000;border-top:1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;INVOICE NO.</td>
        <td style="border-top: 1px solid #000;"></td>
        <td colspan="2" style="text-align:left;border-right: 1px solid #000;border-top: 1px solid #000;">&nbsp;&nbsp;ESTIMATE NO.</td>
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
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:left;font-size:13px;border-left: 1px solid #000;border-right: 1px solid #000;border-right: 1px solid #000;"><?php if($invHed->InvoiceType==1){?>&nbsp;&nbsp;INSURER <?php } ?></td><td></td><td colspan="2" style="border-right: 1px solid #000;">&nbsp;&nbsp;ISSUED BY</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:right;font-size:11px;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php if($invHed->InvoiceType==1){?><?php echo $invHed->VComName; }?>&nbsp;&nbsp;</td><td style="border-bottom: 1px solid #000;"></td><td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $invHed->first_name." ".$invHed->last_name;?>&nbsp;&nbsp;</td>
    </tr>
            <!-- <tr style="text-align:center;font-size:14px;padding-bottom:5px;">
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
                            <td > Estimate No</td>
                            <td> :</td>
                            <td  id="lblInvNo"> <?php echo $invHed->JobEstimateNo;?></td>
                        </tr>
                        
                        <tr style="text-align:left;">
                            <td > Mileage</td>
                            <td> :</td>
                            <td id="lblviNo"> <?php if($invjob){echo $invjob->OdoOut;}?></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Chassis No</td>
                            <td> :</td>
                            <td  id="lblviNo"> <?php if($invVehi){ echo $invVehi->ChassisNo;}?></td>
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
                            <td colspan="3"><span id="lblcusCode"><?php echo $invHed->customerCode;?></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Contact Name <span id="lblConName"> <?php echo $invVehi->contactName;?></span></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"><a href="<?php echo base_url('admin/payment/view_customer/').$invCus->CusCode ?>"><?php echo $invCus->DisplayName;?></a></td>
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
            </tr> -->
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
<br>
                      <table id="tbl_est_data" style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:690px;padding:5px;font-size:13px; " align="center" border="0"> 
                          <tbody>
                            <tr style="lline-height:18px;;background-color:#5d5858 !important;">
                                  <td style="font-weight:bold;width:20px;color:#fff !important;">#</td>
                                  <td colspan="2" style="font-weight:bold;width:300px;color:#fff !important;">Item & Description</td>
                                  <!-- <td style="width:150px;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;"></td> -->
                                  <td style="font-weight:bold;width:60px;color:#fff !important;">Qty</td>
                                  <td style="font-weight:bold;width:90px;color:#fff !important;" class='text-right'>Rate</td>
                                  <!-- <td style="width:50px;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;" class='text-right'></td> -->
                                  <td colspan="2" style="width:100px;font-weight:bold;color:#fff !important;" class='text-right'>Amount</td>
                            </tr>
                          <?php $i=1;
                          // var_dump($invDtl);die;
                                 foreach ($invDtl AS $key=>$invdata) {
                                 // if($key!='PARTS2'){ ?>
                                <tr style="lline-height:18px;;background-color:#e4dbdb !important;color:#000 !important;"><td style=""></td><td colspan="2" style=""><b><?php echo $key?></b></td><td style=""></td><td style=""></td><td colspan="2" style=""></td></tr>
                                       <?php  foreach ($invdata AS $inv) { ?>
                                <tr  style="lline-height:18px;">
                                  <td style="border-bottom:1px dotted #e4dbdb;"><?php echo $i?></td>
                                  <td colspan="2"  style="border-bottom:1px dotted #e4dbdb;"><?php echo $inv->JobDescription?></td>
                                  <td class='text-right'  style="border-bottom:1px dotted #e4dbdb;"><?php echo number_format($inv->JobQty,2)?></td>
                                  <td class='text-right'  style="border-bottom:1px dotted #e4dbdb;"><?php echo number_format($inv->JobPrice,2)?></td>
                                  <td class='text-right' colspan="2"  style="border-bottom:1px dotted #e4dbdb;"><?php echo number_format($inv->JobTotalAmount,2)?></td>
                                </tr>
                                       <?php $i++; } ?>
                            <?php  } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-size: 10px;font-weight: normal;text-align: left;'>Any Inquiries please contact service manager</th>
                              <th style='text-align:right;border-left:1px #fff solid;'>SUB TOTAL &nbsp;&nbsp;</th>
                              <th style="border-right: 1px solid #fff;">Rs.</th>
                              <th id="totalAmount" style='text-align:right;'><?php if($invHed->InvoiceType==1){echo number_format($invHed->JobTotalAmount,2); }elseif($invHed->InvoiceType==2){echo number_format($invHed->JobTotalAmount,2);}?></th>
                            </tr>
                              <?php if($invHed->JobTotalDiscount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>DISCOUNT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalDiscount" style='text-align:right'><span style="text-align: left;"></span> <?php echo number_format($invHed->JobTotalDiscount,2);?></th>
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
                              <?php if($invHed->JobVatAmount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-weight: normal;text-align: left;'></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> VAT  &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobVatAmount,2);?></th>
                            </tr>
                            <?php }?>
                                <?php if($invHed->JobNbtAmount>0){?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> NBT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobNbtAmount,2);?></th>
                                </tr>
                               <?php } ?>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; font-weight: normal;text-align: left;'></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> TOTAL &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="netAmount" style='text-align:right'><?php echo number_format($invHed->JobNetAmount-$invHed->JobAdvance,2) ?></th>
                            </tr>

                          </tfoot>
                      </table>
                      <br/>
                      <table style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:683px;padding:2px; position: relative;bottom: 20px; " align="center" border="0">
          
                          <tbody>
                             <tr><td colspan="7">&nbsp;</td></tr>
                             <tr><td colspan="7">&nbsp;</td></tr>                             <tr>
                              <td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><?php //echo $invjob->first_name;?></td><td>&nbsp;</td><td colspan="2"></td><td>&nbsp;</td>
                            </tr>
                            <tr><td style="border-top:1px dashed #000;text-align: center;width:100px;">Check by</td><td style="width: 20px;">&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:100px;">Prepared By</td><td style="width:20px;">&nbsp;</td><td colspan="2" style="border-top:1px dashed #000;text-align: center;font-size: 10px;">Signature Of Purchaser</td><td style="width:200px;"></td></tr>
                            <tr><td style="text-align: center;width:100px;"></td><td style="width: 20px;">&nbsp;</td><td style="text-align: center;width:100px;"></td><td style="width: 20px;">&nbsp;</td><td colspan="2" style="font-size: 11px;">I am satisfied with service / goods I received</td><td style="width:200px;"></td></tr>
                            <tr><td style="text-align: left;width:100px;"><b>Remarks</b></td><td colspan="6">&nbsp;</td></tr>
                            <tr><td colspan="7"  style="border:1px solid #000;padding: 2px;"><?php echo nl2br($invHed->InvRemark); ?></td></tr>
                            <tr><td style="font-size: 11px;"><?php //echo date('d-m-Y');?></td><td colspan="5"  style="">&nbsp;</td><td style="font-size: 11px;text-align: right;"></td></tr>
                                         
                        </tbody>
                        </table>
        </div>
      <!-- </div> -->
    </div>
        <div class="col-lg-1">
    <table class="table table-hover">
                                <thead>
                                    <th> <center> All Temparary Invoice</center></th>
                                </thead>
                                        <tbody>
                                        <?php foreach($temjob as $v){?>
                                        <tr>
                                           <td><a href="<?php echo base_url('admin/Salesinvoice/view_temp_invoice/').base64_encode($v->JobInvNo); ?>"><?php echo $v->JobInvNo;?></a></td>
                                           </tr>
                                           <?php }?>
                                        </tbody>
                                    </table>

</div>
    <div class="col-lg-4">
      <table class="table">
            <tr><td>Create by</td><td>:</td><td><?php echo $invHed->first_name." ".$invHed->last_name ?></td></tr>
            <tr><td>Create Date</td><td>:</td><td><?php echo $invHed->date ?></td></tr>
            <tr><td>Job. Inv. No</td><td>:</td><td><?php if($invHed->IsInvoice==1){?>Created<?php }else{ ?>Pending<?php } ?></td></tr>
            <?php //if($invCancel): ?>
           <!--  <tr><td>Cancel By</td><td>:</td><td><?php echo $invCancel->first_name." ".$invHed->last_name ?></td></tr>
            <tr><td>Cancel Date</td><td>:</td><td><?php echo $invCancel->CancelDate ?></td></tr>
            <tr><td>Remark</td><td>:</td><td><?php echo $invCancel->Remark ?></td></tr> -->
          <?php //endif; ?>
          <?php if($invUpdate):  ?>
          <tr><td colspan="3">Last Updates</td></tr>
          <?php  foreach ($invUpdate AS $up) { ?>
            <tr><td><?php echo $up->UpdateDate ?></td><td>:</td><td><?php echo $up->first_name." ".$up->last_name ?></td></tr>
          <?php }
          endif; ?>
          </table>
    </div></div>
      <!-- </div> -->
      <div>
      <hr>
    </div>
      </section>
</div>