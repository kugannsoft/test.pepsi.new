<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="box collapse cart-options" id="collapseExample">
            <div class="box-header">Filter Categories</div>
            <div class="box-body categories_dom_wrapper">
            </div>
            <div class="box-footer">
                <button class="btn btn-primary close-item-options pull-right">Hide options</button>
            </div>
        </div>   
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-sm-6">

                            </div>
                            <div class="col-sm-2">
                                <a href="../job/estimate_job?type=est&id=<?php echo base64_encode($estHed->EstimateNo);?>&sup=<?php echo ($estHed->Supplimentry);?>" class="btn btn-block btn-info" >Edit</a>
                                <!-- <button type="button" id="btnPrint" class="btn btn-default btn-lg btn-block">Print</button> -->
                            </div>
                            <div class="col-sm-2">
                                <button type="button" id="btnPrint" class="btn btn-primary btn-block">Print</button>
                            </div>
                            <!--div class="col-sm-1"-->
                                <!--a href="../job/estimate_pdf?type=est&id=<?php echo base64_encode($estHed->EstimateNo);?>&sup=<?php echo ($estHed->Supplimentry);?>" class="btn btn-block btn-info" >PDF</a-->
                                <!-- <button type="button" id="btnPrint" class="btn btn-default btn-lg btn-block">Print</button> -->
                            <!--/div-->
<!--                            <div class="col-sm-2">-->
<!--                                <a href="../Salesinvoice/job_invoice?type=est&id=--><?php //echo base64_encode($estHed->EstimateNo);?><!--&sup=--><?php //echo ($estHed->Supplimentry);?><!--" class="btn btn-block btn-primary" >Invoice</a>-->
                                <!-- <button type="button" id="btnPrint2" class="btn btn-primary btn-block">Labour Print</button> -->
                            </div>
                        </div>

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="row row-eq-height">
<div class="row" id="printArea" align="center" style='margin:5px;'>
  <!-- <div style='width:710px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  '> -->


                    <!-- load comapny common header -->
   <?php $this->load->view('admin/_templates/company_header.php',true); ?>
<table class="tblhead" style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
   <!--  <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;font-weight: bold;" ><span id="lblInvType">
        <?php if($estHed->EstJobType==2){?>
        <?php }elseif($estHed->EstJobType==1) { ?>
        <?php } ?></span>
      </td>
    </tr> -->
    <tr style="text-align:left;font-size:15px;">
      <td colspan="2"> <?php if($estHed->EstJobType==2){?> Vat Reg No: <?php   echo  $invCus->DocNo; } ?></td>
      <td> &nbsp;</td>
      
      <td colspan="4"  style="font-size:18px;font-weight: bold;text-align:left; "> QUATATION</td>
    </tr>
    <tr style="text-align:left;font-size:15px;">
        <td colspan="2" rowspan="5" style="border:1px solid #000;font-size:15px;width:250px;padding: 5px;" v-align="top">
            <span><a href="<?php echo base_url('admin/payment/view_customer/').$invCus->CusCode ?>"><?php echo $invCus->DisplayName;?></a></span><br>
                <?php if ($invCus->DisType==4): ?>
                    <?php echo $invCus->ContactPerson;?><br>
                <?php endif ?>
            <?php if ($invCus->DisType!=4){ ?>
                <?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02;?> <?php echo $invCus->Address03;?><br>
              <?php }else{ ?> 
                <?php echo nl2br($invCus->ComAddress);?><br>
              <?php } ?>   
            <span id="lbladdress2">Tel : <?php echo $invCus->LanLineNo;?> Mobile : <?php echo $invCus->MobileNo;?></span>
        </td>
        <td style="font-size:14px;width:3px;"> &nbsp;</td>
        <td style="font-size:11px;width:130px;text-align: center;border-left: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;" colspan="4">FOR REFERENCE PLEASE QUOTE THE FOLLOWING NO</td>
    </tr>
    <tr style="text-align:left;font-size:15px;">
        <td> &nbsp;</td>
        <td style="text-align:left;border-left: 1px solid #000;border-top:1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;ESTIMATE NO.</td>
        <td style="border-top: 1px solid #000;"></td>
        <td colspan="2" style="text-align:left;border-right: 1px solid #000;border-top: 1px solid #000;">&nbsp;&nbsp;CUSTOMER NO.</td>
    </tr>
    <tr style="text-align:left;font-size:15px;">
        <td> &nbsp;</td>
        <td style="padding-top:0px;font-size:11px;text-align:right;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $estHed->EstimateNo ?></td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $invCus->CusCode;?></td>
    </tr>
    <tr style="text-align:left;font-size:15px;">
        <td> &nbsp;</td>
        <td style="text-align:left;border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;DATE</td>
        <td ></td>
        <td colspan="2" style="text-align:left;border-right: 1px solid #000;">&nbsp;&nbsp; ISSUED BY</td>
    </tr>
    <tr style="text-align:left;font-size:15px;">
        <td> &nbsp;</td>
        <td style="font-size:11px;text-align:right;border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $estHed->EstDate;?></td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $estHed->first_name." ".$estHed->last_name[0];?></td>
    </tr>
<!--    <tr style="text-align:left;font-size:12px;">-->
<!--        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:left;font-size:13px;border-left: 1px solid #000;border-right: 1px solid #000;border-right: 1px solid #000;">--><?php //if($estHed->EstJobType==1){?><!--&nbsp;&nbsp;INSURER --><?php //} ?><!--</td><td></td><td colspan="2" style="border-right: 1px solid #000;">&nbsp;&nbsp;ISSUED BY</td>-->
<!--    </tr>-->
<!--    <tr style="text-align:left;font-size:12px;">-->
<!--        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:right;font-size:11px;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">--><?php //if($estHed->EstJobType==1){?><!----><?php //echo $estHed->VComName; }?><!--</td><td style="border-bottom: 1px solid #000;"></td><td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;">--><?php // echo $estHed->first_name." ".$estHed->last_name[0];?><!--</td>-->
<!--    </tr>-->
    <?php if($estHed->EstJobType==1){?>
    <!--  <tr style="text-align:left;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;">VAT Reg. No : <?php echo $company['Email02'] ?></td>
    </tr> -->
    <?php }else{ ?>
    <!-- <tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;"></td>
    </tr> -->
    <?php } ?>
</table>
<!--<table  class="tblhead"  style="font-size:12px;border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" >-->
<!--  <tr style=" border: 1px solid black;">-->
<!--    <td  style="border: 1px solid black;width: 150px;">REG. NO. <br> &nbsp;&nbsp; <span style="text-align: center;font-size:11px;">--><?php //echo $estHed->EstRegNo;?><!--</span></td>-->
<!--    <td  style="border: 1px solid black;width: 150px;">CHASSIS NO. <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;">--><?php //if(isset($invVehi)){ echo $invVehi->ChassisNo;}?><!--</span></td>-->
<!--    <td  style="border: 1px solid black;width: 150px;">MAKE <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;">--><?php //if(isset($invVehi)){ echo $invVehi->make;} ?><!--</span></td>-->
<!--    <td  style="border: 1px solid black;width: 150px;">MODEL <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;">--><?php // if(isset($invVehi)){ echo $invVehi->model;}?><!--</span></td>-->
<!--  </tr>-->
<!---->
<!--</table>-->
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
        padding: 0px;
    }
</style>
    <table style="border-collapse:collapse;width:700px;padding:5px;font-size:15px;font-family: Arial, Helvetica, sans-serif;" border="0">
        <?php if($estHed->EstJobType==1){?>
            <thead>
                <tr style="background-color:#5d5858 !important;color:#fff !important;">
                    <th style='padding: 3px;text-align:center;width: 5px;color:#fff  !important;'>#</th>
                    <th style='padding: 3px;text-align:left;width: 200px;color:#fff  !important;'>DESCRIPTION</th>
                    <th style='padding: 3px;text-align:center;width: 30px;color:#fff  !important;'></th>
                    <th style='padding: 3px;text-align:center;width: 40px;color:#fff  !important;'>QTY</th>
                    <th style='padding: 3px;text-align:center;width: 70px;color:#fff  !important;'>AMOUNT</th>
                    <th style='padding: 3px;text-align:center;width: 70px;color:#fff !important;'>AMENDED AMOUNT</th>
                </tr>
            </thead>
            <?php }elseif($estHed->EstJobType==2){ ?>
                <thead>
                <tr style="background-color:#5d5858 !important;color:#fff !important;">
                  
                        <th style='padding: 3px;text-align:center;width: 5px;color:#fff !important;'>#</th>
                        <th style='padding: 3px;text-align:left;width: 270px;color:#fff !important;'>DESCRIPTION</th>
                        <th style='padding: 3px;text-align:center;width: 20px;color:#fff !important;'></th>
                        <th style='padding: 3px;text-align:center;width: 30px;color:#fff !important;'>QTY</th>
                        <th style='padding: 3px;text-align:center;width: 70px;color:#fff !important;'>UNIT PRICE</th>
                        <th style='padding: 3px;text-align:center;width: 80px;color:#fff !important;'>AMOUNT</th>
                    </tr>
                </thead>
            <?php } ?>
                <tbody>
                    <?php $i=1;$total=0;
                    if($supNo>0){
                        $i=$estlastNo+1;
                    }else if($supNo==0){
                        $i=1;
                    }else{
                        $i=1;
                    }
                    function ifzero($num){
                        if($num==0){
                            return '-';
                        }else{
                            return number_format($num,2);
                        }
                    }
                    foreach ($estDtl as $key=>$estdtl) { ?>
                     <?php if($estHed->EstJobType==1){
                        //insurance format
                      
                        ?>
<!--                     <tr  style="background-color:#e4dbdb !important;color:#000 !important;"><td style="padding: 5px"></td><td colspan="5" style="padding: 5px"><b>--><?php //echo $key; ?><!--</b></td></tr>-->
                     <?php 
                      foreach ($estdtl AS $dtl) { ?>
                    <tr style="font-size:15px;">
                       <td style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo $i;?></td>
                       <td style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo $dtl->EstJobDescription?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo $dtl->EstPartType?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo ifzero($dtl->EstQty);?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php if($dtl->EstIsInsurance==0){echo ifzero($dtl->EstNetAmount);}else{echo $dtl->EstInsurance;} ?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php //if($dtl->EstIsInsurance==0){echo $dtl->EstNetAmount;} ?></td>
                    </tr>
                    <?php $i++; $total+=$dtl->EstNetAmount;
                       } ?>
                    <?php }elseif($estHed->EstJobType==2){ 
                        ?>
<!--                    <tr style="background-color:#e4dbdb !important;color:#000 !important;"><td></td><td colspan="5" style="padding: 5px"><b>--><?php //echo $key;?><!--</b></td></tr>-->
                    <?php 
                     foreach ($estdtl AS $dtl) { ?>
                    <tr style="font-size:15px;">
                       <td style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo $i;?></td>
                       <td style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo $dtl->EstJobDescription?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo $dtl->EstPartType?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php echo ifzero($dtl->EstQty);?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php if($dtl->EstIsInsurance==0){echo ifzero($dtl->EstNetAmount/$dtl->EstQty);} ?></td>
                       <td class="text-right" style="border-bottom:1px solid #e4dbdb;padding: 5px"><?php if($dtl->EstIsInsurance==0){echo ifzero($dtl->EstNetAmount);}else{echo $dtl->EstInsurance;} ?></td>
                    </tr>
                    <?php $i++; $total+=$dtl->EstNetAmount;
                       } ?>
                <?php } ?>
                <?php  } ?>
                    </tbody>
                    <tfoot>
                    <?php if($estHed->EstJobType==2){ ?>
                        <tr><th colspan="6" style="text-align:right;padding: 5px">&nbsp;</th></tr>
                        <?php if($estHed->EstimateAmount>0 && $estHed->EstIsVatTotal==1){ ?>
                        <tr><th colspan="5" style="text-align:right;padding: 5px">Sub Total  </th><th style='text-align:right;padding: 5px'><?php echo number_format($estHed->EstimateAmount,2) ?>&nbsp;</th></tr>
                        <?php } ?>
                        <?php if($estHed->EstNbtAmount>0 && $estHed->EstIsNbtTotal==1){ ?>
                        <tr><th colspan="5" style="text-align:right;padding: 5px">NBT  </th><th style='text-align:right;padding: 5px'><?php echo number_format($estHed->EstNbtAmount,2) ?>&nbsp;</th></tr>
                        <?php } ?>
                        <?php if($estHed->EstVatAmount>0 && $estHed->EstIsVatTotal==1){ ?>
                        <tr><th colspan="5" style="text-align:right;padding: 5px">VAT  </th><th style='text-align:right;padding: 5px'><?php echo number_format($estHed->EstVatAmount,2) ?>&nbsp;</th></tr>
                        <?php } ?>
                        <tr><th colspan="5" style="text-align:right;padding: 5px;background-color:#e4dbdb !important;">Total Amount  </th><th style='text-align:right;padding: 5px;background-color:#e4dbdb !important;'><?php echo number_format($estHed->EstNetAmount,2) ?>&nbsp;</th></tr>
                    <?php  }elseif($estHed->EstJobType==1){ ?>
                        <tr><th colspan="6" style="text-align:right;padding: 5px">&nbsp;</th></tr>
                        <?php if($estHed->EstimateAmount>0 && $estHed->EstIsVatTotal==1){ ?>
                        <tr><th colspan="4" style="text-align:right;padding: 5px">Sub Total  </th><th style='text-align:right;padding: 5px'><?php echo number_format($estHed->EstimateAmount,2) ?>&nbsp;</th><th></th></tr>
                        <?php } ?>
                        <?php if($estHed->EstNbtAmount>0 && $estHed->EstIsNbtTotal==1){ ?>
                        <tr><th colspan="4" style="text-align:right;padding: 5px">NBT  </th><th style='text-align:right;padding: 5px'><?php echo number_format($estHed->EstNbtAmount,2) ?>&nbsp;</th><th></th></tr>
                        <?php } ?>
                        <?php if($estHed->EstVatAmount>0 && $estHed->EstIsVatTotal==1){ ?>
                        <tr><th colspan="4" style="text-align:right;padding: 5px">VAT  </th><th style='text-align:right;padding: 5px'><?php echo number_format($estHed->EstVatAmount,2) ?>&nbsp;</th><th></th></tr>
                        <?php } ?>
                        <tr><th colspan="2"></th><th colspan="2" style="text-align:right;padding: 5px;background-color:#e4dbdb !important;">Total Amount  </th><th style='text-align:right;padding: 5px;background-color:#e4dbdb !important;'><?php echo number_format($estHed->EstNetAmount,2) ?>&nbsp;</th><th></th></tr>
                    <?php } ?>
                        <tr><th colspan="6"  style="text-align:left">Remark: <span id="lblremark1"><?php echo $estHed->remark ?></span><br><br>
                        <table border="1" style="border-collapse:collapse;margin-left:10px;margin-bottom: 10px">
                            <tr>
                            <?php  foreach ($parttype as $part) {  ?>
                                <td style="padding: 5px 3px;font-weight: none"><?php    echo $part->ShortName." - ".$part->QualityName ?></td>
                                <!-- <td style="padding:  5px 3px;font-weight: none">NON - NONGENUINE PARTS</td><td style="padding:  5px 3px;font-weight: none">UP - USED PARTS</td> -->
                            <?php   } ?>
                            </tr>
                        </table>
                        </th></tr>
                    <!--<tr><td colspan="6" style="text-align:center;"><b>Items received in good condition in exact quantity with accessories.</b></td><br><br></tr>-->
                     <tr><td colspan="6" style="text-align:center;"><b>Terms : Availability of Stocks and Quotetd prices are subject to the time of receiving  your order confirmation and payment. Quotation Valid : 1 Day</b></td><br><br></tr>
<!--                        <tr>-->
<!--                            <th colspan="6" style="text-align:left;font-size: 12px;">-->
<!--                                <span>Terms & Conditions</span>-->
<!--                                <ul>-->
<!--                                   --><?php //foreach ($term as $val) { ?>
<!--                                       <li>--><?php //echo $val->InvCondition; ?><!--</li>-->
<!--                                   --><?php //} ?>
<!--                                </ul> -->
<!--                            </th>-->
<!--                        </tr>-->
                        <tr>
                            <th style="padding:0px;" colspan="6"><table style="border-collapse:collapse;width:700px;font-family: Arial, Helvetica, sans-serif;" border="0">
                    <tr><td colspan="8" style="text-align:left;">
                    <!-- COMPUTER BASE SIKKENS 2K COLOUR MIXING AND BAKE BOOTH PAINTING -->
                    </td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>

                    <tr>
<!--                        <td style="width: 100px;font-size: 11px;text-align: center;"></td>-->
                        <td style="width: 25px;">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Issued By</td>
                        <td style="width: 25px">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Checked By</td>
                        <td style="width: 25px">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Customer Signature</td>
                        <td style="width: 15px;">&nbsp;</td>
                    </tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    <tr>
                        <td colspan="8" style="border-bottom:1px double #000;text-align: center;"></td>
                    </tr>
                    <tr style="text-align: center; tab-size: 20px">
                        <td colspan="8"><b>All Hardware fittings should be fitted only after the site is completed of polishing or painting chemical treatment etc. By doing so all your iron and
                                brass door & window fitting will not have any chemical reaction.</b></td>
                    </tr>
                   
                </table></th>
                        </tr>

                    </tfoot>
                </table>
                







                <input type="Hidden" name="estNo" id="estNo" value="<?php echo $EstimateNo;?>">
                <input type="Hidden" name="supNo" id="supNo" value="<?php echo $supNo;?>">
            <!-- </div> -->
                        </div>
                    </div>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-4">
                                <table class="table" style="font-size:11px;">
                                    <tr><td>Create by</td><td>:</td><td><?php echo $estHed->first_name." ".$estHed->last_name[0]; ?></td></tr>
                                    <tr><td>Create Date</td><td>:</td><td><?php echo $estHed->EstDate ?></td></tr>
                                   
                                  <?php if($invUpdate):  ?>
                                  <tr><td colspan="3">Last Updates</td></tr>
                                  <?php  foreach ($invUpdate AS $up) { ?>
                                    <tr><td><?php echo $up->UpdateDate ?></td><td>:</td><td><?php echo $up->first_name." ".$up->last_name ?></td></tr>
                                  <?php }
                                  endif; ?>
                              </table>
                            </div>
                        </div>
                        <div class="row">
                        <style type="text/css">
                            .tblhead tr td{
                                padding: 1px 7px 1px 2px;
                            }
                        </style>
                            
                        </div>


                        <br><br>
                                <div class="row">
                                    <?php foreach ($est_doc as $doc) { ?>
                                    <div class="col-sm-12">
                                        <label>Attachments : <a target="_blank" class="pull-right" href="<?php echo base_url("upload/est_doc/$doc->doc_name");?>" >
                                            &nbsp; <img src="<?php echo base_url("upload/pdf.jpg");?>" width="20">
                                        </a></label>
                                    </div>
                                    <?php } ?>
                                </div>



                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
    <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="cusModal">
                <!-- load data -->
            </div>
        </div>
    </div>
    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
        <?php //jobcard print 
          // if( $estHed->EstJobType==1){ 
          //   $this->load->view('admin/job/estimate_print.php',true);
          // }else{
          //   $this->load->view('admin/job/general_estimate_print.php',true);
          // }
          ?>
        </div>
    </div>

    <!--labour print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice2" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
        <?php //jobcard print 
        //  if( $estHed->EstJobType==1){ 
        //     $this->load->view('admin/job/ins_estimate_labour_print.php',true);
        // }else{
        //     $this->load->view('admin/job/estimate_labour_print.php',true);
        // }
         ?>
        </div>
    </div>
</div>
<style>
    .shop-items:hover{
        background-color: #00ca6d;
        color: #fff;
    }

    .form-group {
        margin-bottom: 5px;
    }

    div.ui-datepicker{
        font-size:10px;
    }

    #cus_details{
        font-size: 18px;
    }

    .borderdot{
        border-bottom: 1px dashed #000;
    }

    .bordertopbottom{
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
    }
</style>
<script type="text/javascript">
        var estNo='';
        estNo=$("#estNo").val();
        var supNo='';
        supNo=$("#supNo").val();
        loadEstimateData(estNo,supNo);
        $("#btnPrint").click(function(){
            $('#printArea').focus().print();
        });

        $("#btnPrint2").click(function(){
            $('#printArea2').focus().print();
        });

    var cusCode = 0;
    var customer_name ='';
    var outstanding = 0;
    var available_balance = 0;
    var outstanding = 0;

     function ifzero(num){
        if(num==0){
            return '-';
        }else{
            return accounting.formatMoney(num);
        }
    }

     function ifnull(num){
        if(num==''){
            return ' ';
        }else if(num=='null'){
            return '';
        }else{
            return (num);
        }
    }


         function loadEstimateData(estNo, supNo) {
             clearInvoiceData();
             var totalEstAmount = 0;
             $.ajax({
                 type: "POST",
                 url: "../job/getEstimateDataById",
                 data: { estNo: estNo, supNo: supNo },
                 success: function(data) {
                     var resultData = JSON.parse(data);

                     cusCode = resultData.cus_data.CusCode;
                     outstanding = resultData.cus_data.CusOustandingAmount;
                     available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                     customer_name = resultData.cus_data.CusName;
                     $("#lblcusName,#lblcusNamelb").html(resultData.cus_data.RespectSign + ". " + resultData.cus_data.CusName+"<br>"+nl2br(resultData.cus_data.Address01));
                     $("#lblcusCode,#lblcusCodelb").html(resultData.cus_data.CusCode);
                     $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                     $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                     $("#cusOutstand").html(accounting.formatMoney(outstanding));
                     $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                     $("#lblAddress,#lblAddresslb").html(nl2br(resultData.cus_data.Address01) + ", " + resultData.cus_data.Address02);
                     $("#cusAddress2,#cusAddress2lb").html(resultData.cus_data.Address03);
                     $("#lbltel,#lbltellb").html(resultData.cus_data.MobileNo+ " " + resultData.cus_data.LanLineNo);

                     $("#lblestimateNo,#lblestimateNolb").html(resultData.est_hed.EstimateNo);

                     if(resultData.est_hed.Supplimentry>0){
                        $("#lblsupNo,#lblsupNolb").html(resultData.est_hed.Supplimentry);
                     }

                     if(resultData.est_hed.EstJobType==1){
                        $("#lblesttype,#lblesttypelb").html("INSURANCE");
                    }else if(resultData.est_hed.EstJobType==2){
                        $("#lblesttype,#lblesttypelb").html("GENERAL");
                    }

                    if(resultData.est_hed.EstVatAmount>0 && resultData.est_hed.EstIsVatTotal==1){
                        $("#rowVat,#rowVatlb,#is_rowVat").show();
                    }else{
                        $("#rowVat,#rowVatlb,#is_rowVat").hide();
                    }

                    if(resultData.est_hed.EstimateAmount>0 && resultData.est_hed.EstIsVatTotal==1){
                        $("#rowSubTotal,#rowSubTotallb,#is_rowTotal").show();
                    }else{
                        $("#rowSubTotal,#rowSubTotallb,#is_rowTotal").hide();
                    }

                    if(resultData.est_hed.EstNbtAmount>0 && resultData.est_hed.EstIsNbtTotal==1){
                        $("#rowNbt,#rowNbtlb,#is_rowNbt").show();
                    }else{
                        $("#rowNbt,#rowNbtlb,#is_rowNbt").hide();
                    }

                     $("#lblInsCompany,#lblInsCompanylb").html(resultData.est_hed.VComName);
                     $("#lblinvDate,#lblinvDatelb").html(resultData.est_hed.EstDate);
                     $("#lblremark,#lblremarklb").html(resultData.est_hed.remark);
                     $("#lbltotalEsSubAmount,#lbltotalEsSubAmountlb,#is_total").html(accounting.formatMoney(resultData.est_hed.EstimateAmount));
                     $("#lbltotalEsAmount,#lbltotalEsAmountlb,#is_net").html(accounting.formatMoney(resultData.est_hed.EstNetAmount));
                     $("#lbltotalEsVatAmount,#lbltotalEsVatAmountlb,#is_vat").html(accounting.formatMoney(resultData.est_hed.EstVatAmount));
                     $("#lbltotalEsNbtAmount,#lbltotalEsNbtAmountlb,#is_Nbt").html(accounting.formatMoney(resultData.est_hed.EstNbtAmount));
                     $("#lbltotalNet,#lbltotalNetlb,#is_net").html(accounting.formatMoney(resultData.est_hed.EstNetAmount));

                    var k = 1;
                    if(supNo>0){
                        k=parseFloat(resultData.estlastNo)+1;
                    }else if(supNo==0){
                        k=1;
                    }else{
                        k=1;
                    }

                    if(resultData.est_hed.EstJobType==1){
                        $.each(resultData.est_dtl, function(key, value) {
                            $("#tbl_est_data").append("<tr><td class='bordertopbottom'></td><td  class='bordertopbottom' style='padding: 1px 3px 1px 50px;'><b>" + getKey(key) + "</b></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td></tr>");
                             for (var i = 0; i < value.length; i++) {
                                 if (value[i].EstIsInsurance == 1) {
                                     $("#tbl_est_data").append("<tr><td style='text-align:center;padding:  1px 3px;' class='borderdot'>" + (k) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstInsurance) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'></td></tr>");
                                 } else {
                                     totalEstAmount += parseFloat(value[i].EstNetAmount);
                                     $("#tbl_est_data").append("<tr><td class='borderdot' style='text-align:center;padding:  1px 3px;'>" + (k) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'></td></tr>")
                                 }
                                 k++;
                             }
                        });
                    }else if(resultData.est_hed.EstJobType==2){
                        $.each(resultData.est_dtl, function(key, value) {
                            $("#tbl_est_data").append("<tr><td class='bordertopbottom'></td><td class='bordertopbottom' style='padding: 1px 3px 1px 50px;'><b>" + getKey(key) + "</b></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td><td class='bordertopbottom'></td></tr>");
                             for (var i = 0; i < value.length; i++) {
                                if (value[i].EstIsInsurance == 1) {
                                     $("#tbl_est_data").append("<tr><td class='borderdot' style='text-align:center;padding:1px 3px;'>" + (k) + "</td><td class='borderdot' style='padding: 1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding: 1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount/value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstInsurance) + "</td></tr>");
                                 } else {
                                     totalEstAmount += parseFloat(value[i].EstNetAmount);
                                     $("#tbl_est_data").append("<tr><td class='borderdot' style='text-align:center;padding: 1px 3px;'>" + (k) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount/value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount) + "</td></tr>")
                                 }
                                 k++;
                             }
                        });
                    }
                    totalEstAmount = 0;

                    var l = 1;
                    if(supNo>0){
                        l=parseFloat(resultData.estlastNo)+1;
                    }else if(supNo==0){
                        l=1;
                    }else{
                        l=1;
                    }

                    if(resultData.est_hed.EstJobType==1){
                        $.each(resultData.est_dtl, function(key, value) {
                            $("#tbl_est_data_lb").append("<tr><td ></td><td   style='padding: 1px 3px 1px 50px;'><b>" + getKey(key) + "</b></td><td ></td><td ></td><td></td><td ></td></tr>");
                             for (var i = 0; i < value.length; i++) {
                                 if (value[i].EstIsInsurance == 1) {
                                     $("#tbl_est_data_lb").append("<tr><td style='text-align:center;padding:  1px 3px;' class='borderdot'>" + (l) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstInsurance) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'></td></tr>");
                                 } else {
                                     totalEstAmount += parseFloat(value[i].EstNetAmount);
                                     $("#tbl_est_data_lb").append("<tr><td class='borderdot' style='text-align:center;padding:  1px 3px;'>" + (l) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'></td></tr>")
                                 }
                                 l++;
                             }
                        });
                    }else if(resultData.est_hed.EstJobType==2){
                        $.each(resultData.est_dtl, function(key, value) {
                            $("#tbl_est_data_lb").append("<tr><td ></td><td style='padding: 1px 3px 1px 50px;'><b>" + getKey(key) + "</b></td><td ></td><td ></td><td ></td><td ></td></tr>");
                             for (var i = 0; i < value.length; i++) {
                                if (value[i].EstIsInsurance == 1) {
                                     $("#tbl_est_data_lb").append("<tr><td class='borderdot' style='text-align:center;padding:1px 3px;'>" + (l) + "</td><td class='borderdot' style='padding: 1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding: 1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount/value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + (value[i].EstInsurance) + "</td></tr>");
                                 } else {
                                     totalEstAmount += parseFloat(value[i].EstNetAmount);
                                     $("#tbl_est_data_lb").append("<tr><td class='borderdot' style='text-align:center;padding: 1px 3px;'>" + (l) + "</td><td class='borderdot' style='padding:  1px 3px;'>" + value[i].EstJobDescription + "</td><td class='borderdot' style='padding:  1px 3px;'>" + ifnull(value[i].EstPartType) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount/value[i].EstQty) + "</td><td class='borderdot' style='text-align:right;padding:  1px 3px;'>" + ifzero(value[i].EstNetAmount) + "</td></tr>")
                                 }
                                 l++;
                             }
                        });
                    }
                }
             });
         }

  function clearInvoiceData() {
        $("#tbl_est_data tbody").html('');
        $("#lblcusName").html('');
        $("#lblcusCode").html('');
        $("#creditLimit").html('');
        $("#creditPeriod").html('');
        $("#cusOutstand").html('');
        $("#availableCreditLimit").html('');
        $("#lblAddress").html('');
        $("#cusAddress2").html('');
        $("#lbltel").html('');
        $("#lblConName").html('');
        $("#lblregNo").html('');
        $("#lblmake").html('');
        $("#lblmodel").html('');
        $("#lblviNo").html('');
        $("#lblestimateNo").html('');
        $("#lblinvDate").html('');
    }

     function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    function getKey(txt){
    var text ='';
    if(txt=='Outside Parts'){
        text='SUPPLY';
    }else if(txt=='PARTS'){
        text='SUPPLY';
    }else{
        text=txt;
    }
    return text;
}
</script>