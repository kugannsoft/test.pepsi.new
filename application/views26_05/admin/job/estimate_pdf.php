<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style>
       /*@page { margin: 100px 25px; }*/
    header { position: fixed; top: 10px; left: 10px; right: 0px;  height: 50px; }
    /*footer { position: fixed; bottom: -20px; left: 20px; right: 0px; height: 10px;float: right; }*/
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .pagenum:before { content: counter(page); }
    .main{
      margin-bottom: 10px;
      margin-top: 5px;}
      body{margin-top: -15px;
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
  <div class="main">

    <div class="row" id="printArea" align="center" style='margin:5px;'>
                    <!-- load comapny common header -->
   <?php $this->load->view('admin/_templates/company_header.php',true); ?>
<table class="tblhead" style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
      <td colspan="2"> <?php if($estHed->EstJobType==1){?> Vat Reg No: <?php   echo  $invCus->DocNo; } ?></td>
      <td> &nbsp;</td>
      
      <td colspan="4"  style="font-size:18px;font-weight: bold;text-align:right; "> ESTIMATE</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="2" rowspan="5" style="border:1px solid #000;font-size:13px;width:210px;padding: 5px;" v-align="top">
            <span><?php echo $invCus->DisplayName;?></span><br>
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
        <td style="font-size:11px;width:100px;text-align: center;border-left: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;" colspan="4">FOR REFERENCE PLEASE QUOTE THE FOLLOWING NO</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="width:10px;"> &nbsp;</td>
        <td style="width:110px;text-align:left;border-left: 1px solid #000;border-top:1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;ESTIMATE NO.</td>
        <td style="width:5px;border-top: 1px solid #000;"></td>
        <td colspan="2" style="width:80px;text-align:left;border-right: 1px solid #000;border-top: 1px solid #000;">&nbsp;&nbsp;SUPPLIMENTRY NO.</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="padding-top:0px;font-size:11px;text-align:right;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $estHed->EstimateNo ?></td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php if($estHed->Supplimentry>0){ echo $estHed->Supplimentry;}?></td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td> &nbsp;</td>
        <td style="text-align:left;border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;&nbsp;DATE</td>
        <td ></td>
        <td colspan="2" style="text-align:left;border-right: 1px solid #000;">&nbsp;&nbsp;CUSTOMER NO.</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td style="font-size:11px;text-align:right;border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $estHed->EstDate;?></td>
        <td style="border-bottom: 1px solid #000;"></td>
        <td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $invCus->CusCode;?></td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:left;font-size:13px;border-left: 1px solid #000;border-right: 1px solid #000;border-right: 1px solid #000;"><?php if($estHed->EstJobType==1){?>&nbsp;&nbsp;INSURER <?php } ?></td><td></td><td colspan="2" style="border-right: 1px solid #000;">&nbsp;&nbsp;ISSUED BY</td>
    </tr>
    <tr style="text-align:left;font-size:12px;">
        <td style="text-align:left;font-size:13px;" colspan="2"></td><td></td><td style="text-align:right;font-size:11px;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php if($estHed->EstJobType==1){?><?php echo $estHed->VComName; }?></td><td style="border-bottom: 1px solid #000;"></td><td colspan="2" style="font-size:11px;text-align:right;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php  echo $estHed->first_name." ".$estHed->last_name;?></td>
    </tr>
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
<table  class="tblhead"  style="font-size:12px;border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" >
  <tr style=" border: 1px solid black;">
    <td  style="border: 1px solid black;width: 150px;">REG. NO. <br> &nbsp;&nbsp; <span style="text-align: center;font-size:11px;"><?php echo $estHed->EstRegNo;?></span></td>
    <td  style="border: 1px solid black;width: 150px;">CHASSIS NO. <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invVehi)){ echo $invVehi->ChassisNo;}?></span></td>
    <td  style="border: 1px solid black;width: 150px;">MAKE <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php if(isset($invVehi)){ echo $invVehi->make;} ?></span></td>
    <td  style="border: 1px solid black;width: 150px;">MODEL <br> &nbsp;&nbsp;<span style="text-align: center;font-size:11px;"><?php  if(isset($invVehi)){ echo $invVehi->model;}?></span></td>
  </tr>

</table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
        padding: 0px;
    }
</style>
    <table style="border-collapse:collapse;width:550px;padding:5px;font-size:13px;font-family: Arial, Helvetica, sans-serif;" border="0">
        <?php if($estHed->EstJobType==1){?>
            <thead>
                <tr style="background-color:#5d5858 !important;color:#fff !important;">
                    <th style='padding: 3px;text-align:center;width: 2px;color:#fff  !important;'>#</th>
                    <th style='padding: 3px;text-align:left;width: 100px;color:#fff  !important;'>DESCRIPTION</th>
                    <th style='padding: 3px;text-align:center;width: 50px;color:#fff  !important;'></th>
                    <th style='padding: 3px;text-align:center;width: 50px;color:#fff  !important;'>QTY</th>
                    <th style='padding: 3px;text-align:center;width: 50px;color:#fff  !important;'>AMOUNT</th>
                    <th style='padding: 3px;text-align:center;width: 50px;color:#fff !important;'>AMENDED AMOUNT</th>
                </tr>
            </thead>
            <?php }elseif($estHed->EstJobType==2){ ?>
                <thead>
                <tr style="background-color:#5d5858 !important;color:#fff !important;">
                  
                        <th style='padding: 3px;text-align:center;width: 5px;color:#fff !important;'>#</th>
                        <th style='padding: 3px;text-align:left;width: 120px;color:#fff !important;'>DESCRIPTION</th>
                        <th style='padding: 3px;text-align:center;width: 10px;color:#fff !important;'></th>
                        <th style='padding: 3px;text-align:center;width: 20px;color:#fff !important;'>QTY</th>
                        <th style='padding: 3px;text-align:center;width: 60px;color:#fff !important;'>UNIT PRICE</th>
                        <th style='padding: 3px;text-align:center;width: 60px;color:#fff !important;'>AMOUNT</th>
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
                     <tr  style="background-color:#e4dbdb !important;color:#000 !important;"><td style="padding: 5px"></td><td colspan="5" style="padding: 5px"><b><?php echo $key; ?></b></td></tr>
                     <?php 
                      foreach ($estdtl AS $dtl) { ?>
                    <tr style="font-size:13px;">
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
                    <tr style="background-color:#e4dbdb !important;color:#000 !important;"><td></td><td colspan="5" style="padding: 5px"><b><?php echo $key;?></b></td></tr>
                    <?php 
                     foreach ($estdtl AS $dtl) { ?>
                    <tr style="font-size:13px;">
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
                        <tr>
                            <th colspan="6" style="text-align:left;font-size: 12px;">
                                <span>Terms & Conditions</span>
                                <ul>
                                   <?php foreach ($term as $val) { ?>
                                       <li><?php echo $val->InvCondition; ?></li>
                                   <?php } ?>
                                </ul> 
                            </th>
                        </tr>
                        <tr>
                            <th style="padding:0px;" colspan="6"><table style="border-collapse:collapse;width:700px;font-family: Arial, Helvetica, sans-serif;" border="0">
                    <tr><td colspan="8" style="text-align:left;">
                    <!-- COMPUTER BASE SIKKENS 2K COLOUR MIXING AND BAKE BOOTH PAINTING -->
                    </td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    <tr><td colspan="8" style="text-align:right;">&nbsp;</td></tr>
                    
                    <tr>
                        <td style="width: 100px;font-size: 11px;text-align: center;"></td>
                        <td style="width: 25px;">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Issued By</td>
                        <td style="width: 25px">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Checked By</td>
                        <td style="width: 25px">&nbsp;</td>
                        <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Customer Signature</td>
                        <td style="width: 15px;">&nbsp;</td>
                    </tr>
                   
                </table></th>
                        </tr>

                    </tfoot>
                </table>
                <input type="Hidden" name="estNo" id="estNo" value="<?php echo $EstimateNo;?>">
                <input type="Hidden" name="supNo" id="supNo" value="<?php echo $supNo;?>">
            </div>
  </div> 
  </body></html>