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
                        <div class="col-sm-2">
                            <button type="button" id="btnPrint2" class="btn btn-primary btn-block">Labour Print</button>
                        </div>
                    </div> 
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="row row-eq-height">
<div class="row" align="center" style='margin:5px;'>
                    <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>
    <hr>
<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    
        <tr style="text-align:left;font-size:12px;">
            
            <td colspan="6" style=""><span id="lblcusCode1"><?php echo $estHed->EstCustomer ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align:left;font-size:20px;" colspan="3"> <b> ESTIMATE</b></td>
            <!--  <td > :</td>
            <td style="text-align:left;font-size:15px;"> <b><?php echo $estHed->EstRegNo?></b></td> -->
        </tr>
        <tr style="text-align:left;font-size:12px;">
            
            <td rowspan="3" colspan="6" valign="top" style=""  id="lblcusName1">
                <?php echo $invCus->CusName?><br>
                <?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02." ".$invCus->Address03?></td>
                <td>&nbsp;</td>
                <td colspan="3" rowspan="5" style="padding-left:20px;">
                    <table style="font-size: 12px">
                        <tbody><td colspan="3" style="text-align:left;font-size:20px;"><?php echo $estHed->EstimateNo ?><?php if($estHed->Supplimentry>0){echo " - ".$estHed->Supplimentry;} ?></td>
                        <tr></tr>
                            <tr>
                                <td>Date</td><td>:</td><td  id="lblinvDate1"><?php echo substr($estHed->EstDate,0,10)?></td>
                            </tr>
                            <tr>
                                <td>Tele</td><td>:</td><td  id="lbltel1"><?php echo $invCus->MobileNo." ".$invCus->LanLineNo;?></td>
                            </tr>
                            <tr>
                                <td>Make</td><td>:</td><td  id="lblmake1"><?php echo $invVehi->make?></td>
                            </tr>
                            <tr>
                                <td>Model </td><td>:</td><td id="lblmodel1"><?php echo $invVehi->model?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="text-align:left;font-size:12px;">
                
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:12px;">
                <!-- <td style="border-left: #000 solid 1px;border-bottom: #000 solid 1px;"> </td>
                <td  style="border-bottom: #000 solid 1px;"></td> -->
                <td >&nbsp;</td>
            </tr>
            <?php if($estHed->EstJobType==1){?>
            <tr style="text-align:left;font-size:12px;">
                <td colspan="2"> Insurance Company</td>
                <!-- <td> :</td> -->
                <td colspan="4" id="lblInsCompany1"> &nbsp;:&nbsp; &nbsp;&nbsp;<?php echo $estHed->VComName?></td>
                <td>&nbsp;</td>
            </tr>
        <?php } ?>
        <tr style="text-align:left;font-size:12px;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td  colspan="3">&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td>Contact Name</td>
            <td> :</td>
            <td  id="lblConName1"><?php echo $invCus->RespectSign.". ".$invVehi->contactName?></td>
            <td  colspan="3" style="text-align: right;"></td>
            <td> :</td>
            <!-- <td colspan="3" id="lblestimateNo1">51545</td> -->
        </tr>
        <tr style="text-align:left;font-size:15px;">
            <td> <b>V. I. No</b></td>
            <td> :</td>
            <td id="lblviNo1"> <b><?php echo $invVehi->ChassisNo?></b></td>
            <td  colspan="3" style="text-align: right;font-size:12px;"></td>
            <td> :</td>
            <td colspan="3" style="text-align: left;font-size:12px;"></td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td  style="text-align:left;font-size:14px;">Vehicle No.</td>
            <td> :</td>
            <td style="text-align:left;font-size:14px;"  id="lblregNo1"><?php echo $estHed->EstRegNo?></td>
            <td style="text-align: left;"></td>
            <td style="text-align: left;"></td>
            <td style="text-align: left;" id="lblmodelno1"></td>
            <td> </td>
            <td colspan="3"><?php //echo $estHed->EstimateNo ?></td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td colspan="10">&nbsp;</td>
        </tr>
    </table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
        padding: 0px;
    }
</style>
    <table style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
        <?php if($estHed->EstJobType==1){?>
            <thead>
                <tr>
                    <th style='padding: 3px;text-align:center;width: 20px'>ITEM</th>
                    <th style='padding: 3px;text-align:center;width: 360px'>DESCRIPTION</th>
                    <th style='padding: 3px;text-align:center;width: 20px'></th>
                    <th style='padding: 3px;text-align:center;width: 30px'>QTY</th>
                    <th style='padding: 3px;text-align:center;width: 70px'>NETT QUOTED AMOUNT</th>
                    <th style='padding: 3px;text-align:center;width: 80px'>AMENDED AMOUNT</th>
                </tr>
            </thead>
            <?php }elseif($estHed->EstJobType==2){ ?>
                <thead>
                    <tr>
                        <th style='padding: 3px;text-align:center;width: 20px'>ITEM</th>
                        <th style='padding: 3px;text-align:center;width: 360px'>DESCRIPTION</th>
                        <th style='padding: 3px;text-align:center;width: 20px'></th>
                        <th style='padding: 3px;text-align:center;width: 30px'>QTY</th>
                        <th style='padding: 3px;text-align:center;width: 70px'>UNIT PRICE</th>
                        <th style='padding: 3px;text-align:center;width: 80px'>QUOTED AMOUNT</th>
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
                     <tr ><td></td><td colspan="5" style="padding: 5px"><b><?php if($key=='Outside Parts'){echo 'SUPPLY'; }else{echo $key; }?></b></td></tr>
                     <?php foreach ($estdtl AS $dtl) { ?>
                    <tr style="font-size:13px;">
                       <td style="padding: 5px"><?php echo $i;?></td>
                       <td style="padding: 5px"><?php echo $dtl->EstJobDescription?></td>
                       <td style="padding: 5px"><?php echo $dtl->EstPartType?></td>
                       <td style="padding: 5px"><?php echo ifzero($dtl->EstQty);?></td>
                       <td class="text-right" style="padding: 5px"><?php if($dtl->EstIsInsurance==0){echo ifzero($dtl->EstNetAmount);}else{echo $dtl->EstInsurance;} ?></td>
                       <td class="text-right" style="padding: 5px"><?php //if($dtl->EstIsInsurance==0){echo $dtl->EstNetAmount;} ?></td>
                    </tr>
                    <?php $i++; $total+=$dtl->EstNetAmount;
                       } ?>
                    <?php }elseif($estHed->EstJobType==2){ ?>
                    <tr ><td></td><td colspan="5" style="padding: 5px"><b><?php if($key=='Outside Parts'){echo 'SUPPLY'; }else{echo $key; }?></b></td></tr>
                    <?php foreach ($estdtl AS $dtl) { ?>
                    <tr style="font-size:13px;">
                       <td style="padding: 5px"><?php echo $i;?></td>
                       <td style="padding: 5px"><?php echo $dtl->EstJobDescription?></td>
                       <td style="padding: 5px"><?php echo $dtl->EstPartType?></td>
                       <td style="padding: 5px"><?php echo ifzero($dtl->EstQty);?></td>
                       <td class="text-right" style="padding: 5px"><?php if($dtl->EstIsInsurance==0){echo ifzero($dtl->EstNetAmount/$dtl->EstQty);} ?></td>
                       <td class="text-right" style="padding: 5px"><?php if($dtl->EstIsInsurance==0){echo ifzero($dtl->EstNetAmount);}else{echo $dtl->EstInsurance;} ?></td>
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
                        <tr><th colspan="5" style="text-align:right;padding: 5px">Sub Total  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstimateAmount ?>&nbsp;</th></tr>
                        <?php } ?>
                        <?php if($estHed->EstNbtAmount>0 && $estHed->EstIsNbtTotal==1){ ?>
                        <tr><th colspan="5" style="text-align:right;padding: 5px">NBT  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstNbtAmount ?>&nbsp;</th></tr>
                        <?php } ?>
                        <?php if($estHed->EstVatAmount>0 && $estHed->EstIsVatTotal==1){ ?>
                        <tr><th colspan="5" style="text-align:right;padding: 5px">VAT  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstVatAmount ?>&nbsp;</th></tr>
                        <?php } ?>
                        <tr><th colspan="5" style="text-align:right;padding: 5px">Estimate Amount  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstNetAmount ?>&nbsp;</th></tr>
                    <?php  }elseif($estHed->EstJobType==1){ ?>
                        <tr><th colspan="6" style="text-align:right;padding: 5px">&nbsp;</th></tr>
                        <?php if($estHed->EstimateAmount>0 && $estHed->EstIsVatTotal==1){ ?>
                        <tr><th colspan="4" style="text-align:right;padding: 5px">Sub Total  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstimateAmount ?>&nbsp;</th><th></th></tr>
                        <?php } ?>
                        <?php if($estHed->EstNbtAmount>0 && $estHed->EstIsNbtTotal==1){ ?>
                        <tr><th colspan="4" style="text-align:right;padding: 5px">NBT  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstNbtAmount ?>&nbsp;</th><th></th></tr>
                        <?php } ?>
                        <?php if($estHed->EstVatAmount>0 && $estHed->EstIsVatTotal==1){ ?>
                        <tr><th colspan="4" style="text-align:right;padding: 5px">VAT  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstVatAmount ?>&nbsp;</th><th></th></tr>
                        <?php } ?>
                        <tr><th colspan="4" style="text-align:right;padding: 5px">Estimate Amount  </th><th style='text-align:right;padding: 5px'><?php echo $estHed->EstNetAmount ?>&nbsp;</th><th></th></tr>
                    <?php } ?>
                        <tr><th colspan="6"  style="text-align:left">Remark: <span id="lblremark1"><?php echo $estHed->remark ?></span><br><br>
                        <table border="1" style="margin-left:10px;margin-bottom: 10px">
                            <tr>
                                <td style="padding: 5px 3px;font-weight: none">GP - GENUINE PARTS</td><td style="padding:  5px 3px;font-weight: none">NON - NONGENUINE PARTS</td><td style="padding:  5px 3px;font-weight: none">UP - USED PARTS</td>
                            </tr>
                        </table>
                        </th></tr>
                        <tr>
                            <th colspan="6" style="text-align:left;font-size: 12px;">
                               <!--  <ul>
                                    <li>Please Make 50 % advance payment at the time of estimate/s approval to commence repairs.</li>
                                    <li>If any defects / areas needing attention is found after dismantling or during the repair process, we reserve the right
to submit a supplementary estimate for your approval.</li>
                                    <li>Service charges are valid for 90 days from the date of issue.</li>
                                    <li>We will not be responsible for quality of job for any work carried out using non genuine or used parts.</li>
                                    <li>Delivery subject to availability of parts & man power.</li>
                                    <li>Replaced parts should be collected at the time of delivery or within 01 week from the date of invoice. We will not be
responsible for any replaced parts thereafter.</li>
                                    <li>All payments related to the repairs are required to be settled in full prior to the delivery of the vehicle.</li>
                                    <li>Any deductions made by insurer according to the policy conditions on your insurance policy, we will not deducted
from our final invoice.</li>
                                </ul> -->
                            </th>
                        </tr></tfoot>
                </table>
                <table style="border-collapse:collapse;width:700px;padding:5px;" border="0">
                    <tr><td colspan="7" style="text-align:left;border-left:1px #000 solid;border-right:1px #000 solid;padding-left: 3px;">
                    <!-- COMPUTER BASE SIKKENS 2K COLOUR MIXING AND BAKE BOOTH PAINTING -->
                    </td></tr>
                    <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr>
                    <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr>
                    <tr><td colspan="7" style="text-align:left;border-left:1px #000 solid;border-right:1px #000 solid;font-size: 10px;padding-left: 3px;"></td></tr>
                    <tr>
                        <td style="width: 180px;font-size: 10px;border-left:1px #000 solid;padding-left: 3px;">VAT would be added to net invoice value</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Name & Signature ( Customer)</td>
                        <td style="width: 15px">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Name & Signature ( Assesor)</td>
                        <td style="width: 15px">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Signature</td>
                        <td style="width: 15px;border-right:1px #000 solid;">&nbsp;</td>
                    </tr>
                    <tr><td colspan="6" style="text-align:right;border-left:1px #000 solid;border-bottom:1px #000 solid;width:400px;">&nbsp;</td><td style="border-bottom:1px #000 solid;border-right:1px #000 solid;"></td></tr>
                </table>
                <input type="Hidden" name="estNo" id="estNo" value="<?php echo $EstimateNo;?>">
                <input type="Hidden" name="supNo" id="supNo" value="<?php echo $supNo;?>">
            </div>
                        </div>
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
          if( $estHed->EstJobType==1){ 
            $this->load->view('admin/job/estimate_print.php',true);
          }else{
            $this->load->view('admin/job/general_estimate_print.php',true);
            }?>
        </div>
    </div>

    <!--labour print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice2" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
        <?php //jobcard print 
         if( $estHed->EstJobType==1){ 
            $this->load->view('admin/job/ins_estimate_labour_print.php',true);
        }else{
            $this->load->view('admin/job/estimate_labour_print.php',true);
        }
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
                     $("#lblConName,#lblConNamelb").html(resultData.vehicle_data.contactName);
                     $("#lblregNo,#lblregNolb").html(resultData.vehicle_data.RegNo);
                     $("#lblmake,#lblmakelb").html(resultData.vehicle_data.make);
                     $("#lblmodel,#lblmodellb").html(resultData.vehicle_data.model);
                     $("#lblviNo,#lblviNolb").html(resultData.vehicle_data.ChassisNo);
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