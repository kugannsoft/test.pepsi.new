<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
    <section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="pull-right">
        <?php if($invHed->IsCancel==1){$disabled='disabled'; }else{$disabled='';}?>
         <button type="button" <?php echo $disabled;?> id="btnCancel" class="btn btn-danger btn-lg btn-block">Cancel Invoice</button>
        </div>
        <div class="pull-right">
         <button type="button" <?php echo $disabled;?> id="btnPrint" class="btn btn-primary btn-lg btn-block">Print</button>
        </div>
    </section>
    <section class="content">
    <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
        <div class="row"  align="center" style='margin:5px;'>
                                <table style="border-collapse:collapse;width:690px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
            <!-- <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
            </tr>  -->
            <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="10" style="height: 200px;">&nbsp;
                <!-- <b><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?> &nbsp;&nbsp;  <?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo  $company['MobileNo'] ?></b> -->
                </td>
            </tr>
            <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                <td colspan="10">&nbsp;</td>
            </tr>
            <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                <td colspan="10">VAT NO : 104058787 7000</td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td colspan="5">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td>&nbsp;</td>
                <td> Customer Code</td>
                <td> :</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> Customer Code</td>
                <td> :</td>
                <td id="lblcusCode"> <?php echo $invHed->customerCode;?></td>
                <td colspan="3" style="text-align:center;font-size:20px;"> <b>Genaral Invoice</b></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> Customer Name</td>
                <td> :</td>
                <td id="lblcusName"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?></td>
                <td > Date</td>
                <td> :</td>
                <td  id="lblinvDate"> <?php echo $invHed->date;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> Address</td>
                <td> :</td>
                <td rowspan="3" id="lblAddress" valign="top"><?php echo $invCus->Address01.",<br> ".$invCus->Address02;?></td>
                <td> Tel</td>
                <td> :</td>
                <td  id="lbltel"> <?php echo $invCus->MobileNo.", ".$invCus->LanLineNo;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> </td>
                <td></td>
                <td > Make</td>
                <td> :</td>
                <td  id="lblmake"><?php echo $invVehi->make;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> </td>
                <td> </td>
                <td > Model No</td>
                <td> :</td>
                <td  id="lblmodel"><?php echo $invVehi->model;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> Contact Name</td>
                <td>:</td>
                <td  id="lblConName"> <?php echo $invVehi->contactName;?></td>
                <td > Estimate No</td>
                <td> :</td>
                <td  id="lblestimateNo"><?php echo $invHed->JobEstimateNo;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> V. I. No </td>
                <td>:</td>
                <td id="lblviNo"> <?php echo $invVehi->ChassisNo;?></td>
                <td>Invoice No</td>
                <td>:</td>
                <td id="lblInvNo"> <?php echo $invHed->JobInvNo;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td>Reg No</td>
                <td>:</td>
                <td  id="lblregNo"> <?php echo $invHed->regNo;?></td>
                <td > </td>
                <td> </td>
                <td> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
                      <table id="tbl_est_data" style="border-collapse:collapse;width:690px;padding:5px;font-size:13px;" border="1">
                          <thead>
                              <tr>
                                  <th style='padding: 3px;'>Item</th>
                                  <th style='padding: 3px;' colspan="2">Description</th>
                                  <!-- <th style='padding: 3px;'></th> -->
                                  <th style='padding: 3px;'>Qty</th>
                                  <th style='padding: 3px;'>Unit Price</th>
                                  <th style='padding: 3px;'>Net Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php $i=1;
                          // var_dump($invDtl);die;
                                 foreach ($invDtl AS $key=>$invdata) { ?>
                                 <tr style="line-height: 5px"><td colspan="6"><?php echo $key?></td></tr>
                                       <?php foreach ($invdata AS $inv) { ?>
                                            <tr  style="line-height: 5px">
                              <td><?php echo $i?></td>
                              <td colspan="2"><?php echo $inv->JobDescription?></td>
                              <td class='text-right'><?php echo number_format($inv->JobQty,2)?></td>
                              <td class='text-right'><?php echo number_format($inv->JobPrice,2)?></td>
                              <td class='text-right'><?php echo number_format($inv->JobNetAmount,2)?></td>
                            </tr>
                                       <?php $i++; } ?>
                            
                            <?php  } ?>
                          </tbody>
                          <tfoot>
                              <tr><th colspan="5" style='text-align:right'>Total Amount &nbsp;&nbsp;</th><th id="totalAmount" style='text-align:right'><?php echo number_format($invHed->JobTotalAmount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Total Discount &nbsp;&nbsp;</th><th id="totalDiscount" style='text-align:right'><?php echo number_format($invHed->JobTotalDiscount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Advance &nbsp;&nbsp;</th><th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobAdvance,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>VAT Amount &nbsp;&nbsp;</th><th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobVatAmount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>NBT Amount &nbsp;&nbsp;</th><th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobNbtAmount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Net Amount &nbsp;&nbsp;</th><th id="netAmount" style='text-align:right'><?php echo number_format($invHed->JobNetAmount-$invHed->JobAdvance,2) ?></th></tr>
                              <tr><th colspan="6"></th></tr>
                          </tfoot>
                      </table>
                      <br/>
                      <div id="foot" style="border: 1px #000 solid;width:690px;padding: 5px;">
                        <table style="border-collapse:collapse;width:683px;padding:2px;" border="0">
                          <tbody>
                            <tr><td colspan="4" style='text-align:center'>I Certify that there are no
valubles in the car.</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td style="border-top:1px dashed #000;text-align: center;width:200px;">Name</td><td>&nbsp;</td><td>&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:200px;">Customer Authorisation</td></tr>
                            
</tbody>
</table>
</div>
                    </div>

    </section>
    <div>
      <table class="table table-hover table-bordered">
        <tr>
          <td colspan="4">Payment Recieved</td>
        </tr>
        <tr>
          <td>Date</td>
          <td>Mode</td>
          <td></td>
          <td>Pay Amount</td>
          <td>Payment By</td>
        </tr>
        <?php $totalpay=0;
        foreach ($inv_pay AS $invpay) { ?>
        <tr>
          <td><?php echo $invpay->JobInvDate?></td>
          <td><?php echo $invpay->JobInvPayType?></td>
          <td>:</td>
          <td class="text-right"><?php echo number_format($invpay->JobInvPayAmount,2)?></td>
          <td><?php echo $invpay->CusName?></td>
        </tr>
        <?php $totalpay+=$invpay->JobInvPayAmount;
        } ?>
        <tr>
          <td></td>
          <td><b>Total</b></td>
          <td>:</td>
          <td class="text-right"><b><?php echo number_format($totalpay,2); ?></b></td>
          <td></td>
        </tr>
      </table>
    </div>
</div>
 <!-- print parts goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                    <div class="row" id="printArea" align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>

<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
            <tr style="text-align:left;font-size:13px;">
                <td> Customer Code</td>
                <td> :</td>
                <td id="lblcusCode"> <?php echo $invHed->customerCode;?></td>
                <td colspan="3" style="text-align:center;font-size:20px;"> <b>Genaral Invoice</b></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> Customer Name</td>
                <td> :</td>
                <td id="lblcusName"><?php echo $invCus->RespectSign.", ".$invCus->CusName;?></td>
                <td > Date</td>
                <td> :</td>
                <td  id="lblinvDate"> <?php echo $invHed->date;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> Address</td>
                <td> :</td>
                <td rowspan="3" id="lblAddress" valign="top"><?php echo $invCus->Address01.",<br> ".$invCus->Address02;?></td>
                <td> Tel</td>
                <td> :</td>
                <td  id="lbltel"> <?php echo $invCus->MobileNo.", ".$invCus->LanLineNo;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> </td>
                <td></td>
                <td > Make</td>
                <td> :</td>
                <td  id="lblmake"><?php echo $invVehi->make;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> </td>
                <td> </td>
                <td > Model No</td>
                <td> :</td>
                <td  id="lblmodel"><?php echo $invVehi->model;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> Contact Name</td>
                <td>:</td>
                <td  id="lblConName"> <?php echo $invVehi->contactName;?></td>
                <td > Estimate No</td>
                <td> :</td>
                <td  id="lblestimateNo"><?php echo $invHed->JobEstimateNo;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td> V. I. No </td>
                <td>:</td>
                <td id="lblviNo"> <?php echo $invVehi->ChassisNo;?></td>
                <td>Invoice No</td>
                <td>:</td>
                <td id="lblInvNo"> <?php echo $invHed->JobInvNo;?></td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td>Reg No</td>
                <td>:</td>
                <td  id="lblregNo"> <?php echo $invHed->regNo;?></td>
                <td > </td>
                <td> </td>
                <td> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:13px;">
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
                      <table id="tbl_est_data" style="border-collapse:collapse;width:690px;padding:5px;font-size:13px;" border="1">
                          <thead>
                              <tr>
                                  <th style='padding: 3px;'>Item</th>
                                  <th style='padding: 3px;' colspan="2">Description</th>
                                  <!-- <th style='padding: 3px;'></th> -->
                                  <th style='padding: 3px;' class='text-right'>Qty</th>
                                  <th style='padding: 3px;' class='text-right'>Unit Price</th>
                                  <th style='padding: 3px;' class='text-right'>Net Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php $i=1;
                          // var_dump($invDtl);die;
                                 foreach ($invDtl AS $key=>$invdata) { ?>
                                 <tr style="line-height: 5px"><td colspan="6"><?php echo $key?></td></tr>
                                       <?php foreach ($invdata AS $inv) { ?>
                                            <tr  style="line-height: 5px">
                              <td><?php echo $i?></td>
                              <td colspan="2"><?php echo $inv->JobDescription?></td>
                              <td class='text-right'><?php echo number_format($inv->JobQty,2)?></td>
                              <td class='text-right'><?php echo number_format($inv->JobPrice,2)?></td>
                              <td class='text-right'><?php echo number_format($inv->JobNetAmount,2)?></td>
                            </tr>
                                       <?php $i++; } ?>
                            
                            <?php  } ?>
                          </tbody>
                          <tfoot>
                              <tr><th colspan="5" style='text-align:right'>Total Amount &nbsp;&nbsp;</th><th id="totalAmount" style='text-align:right'><?php echo number_format($invHed->JobTotalAmount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Total Discount &nbsp;&nbsp;</th><th id="totalDiscount" style='text-align:right'><?php echo number_format($invHed->JobTotalDiscount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Advance &nbsp;&nbsp;</th><th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobAdvance,2);?></th></tr>
                               <tr><th colspan="5" style='text-align:right'>VAT Amount &nbsp;&nbsp;</th><th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobVatAmount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>NBT Amount &nbsp;&nbsp;</th><th id="totalAdvance" style='text-align:right'><?php echo number_format($invHed->JobNbtAmount,2);?></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Net Amount &nbsp;&nbsp;</th><th id="netAmount" style='text-align:right'><?php echo number_format($invHed->JobNetAmount-$invHed->JobAdvance,2) ?></th></tr>
                              <tr><th colspan="6"></th></tr>
                          </tfoot>
                      </table>
                      <br/>
                      <div id="foot" style="border: 1px #000 solid;width:690px;padding: 5px;">
                        <table style="border-collapse:collapse;width:683px;padding:2px;" border="0">
                          <tbody>
                            <tr><td colspan="4" style='text-align:center'>I Certify that there are no
valubles in the car.</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td style="border-top:1px dashed #000;text-align: center;width:200px;">Name</td><td>&nbsp;</td><td>&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:200px;">Customer Authorisation</td></tr>
                            
</tbody>
</table>
</div>
<h3 class="pag pag1"></h3>
  <div class="insert"></div>
  <style type="text/css" media="screen">
    body {
  text-align: justify;
}

@page {
  size: A4;
  margin: 5%;
  padding: 0 0 10%;
}

h3.pag {
  display: none;
  position: absolute;
  page-break-before: always;
  page-break-after: always;
  bottom: 0;
  right: 0;
}

h3::before {
  position: relative;
  bottom: -15px;
}

@media print {
  h3.pag {
    display: initial;
  }
  .print {
    display: none;
  }
}
  </style>
  

                    </div>
          
                </div>
              </div>
            </div>
        </div>
<script type="text/javascript">

var inv =$("#inv").val();

$("#btnPrint").click(function(){
$('#printArea').focus().print();
});

$("#btnCancel").click(function(){

  var r = confirm('Do you want to cancel this invoice?');
    if (r === true) {
        cancelInvoice(inv);
    }else{

    }
});


  var bottom = 0;
  var pagNum = 2; /* First sequence - Second number */
  $(document).ready(function() {
    /* For each 10 paragraphs, this function: clones the h3 with a new page number */
    $("table:nth-child(10n)").each(function() {
      bottom -= 100;
      botString = bottom.toString();
      var $counter = $('h3.pag1').clone().removeClass('pag1');
      $counter.css("bottom", botString + "vh");
      numString = pagNum.toString();
      $counter.addClass("pag" + numString);
      ($counter).insertBefore('.insert');
      pagNum = parseInt(numString);
      pagNum++; /* Next number */
    });
    var pagTotal = $('.pag').length; /* Gets the total amount of pages by total classes of paragraphs */
    pagTotalString = pagTotal.toString();
    $("h3[class^=pag]").each(function() {
      /* Gets the numbers of each classes and pages */
      var numId = this.className.match(/\d+/)[0];
      document.styleSheets[0].addRule('h3.pag' + numId + '::before', 'content: "Page ' + numId + ' of ' + pagTotalString + '";');
    });
  });


function printinv(invoice) {
  $.ajax({
        url:'salesinvoice/printinvoicecreate',
        dataType:'json',
        type:'POST',
        data:{invno:invoice},
        success:function(data) {
          alert(data);
          var resultData = data;
          $("#tbl_est_data tbody").empty();
          $('#lblcusCode').html(resultData.head.JCustomer);
          $('#lblcusName').html(resultData.head.CusName);
          $('#lblinvDate').html(resultData.head.Date);
          $('#lblAddress').html(resultData.head.Address01);
          $('#lbltel').html(resultData.head.MobileNo);
          $('#lblmake').html(resultData.head.Make);
          $('#lblmodel').html(resultData.head.Model);
          $('#lblConName').html(resultData.head.contactName);
          $('#lblestimateNo').html(resultData.head.JobEstimateNo);
          $('#lblInvNo').html(resultData.head.JobInvNo);
          $('#lblviNo').html(resultData.head.ChassisNo);
          $('#lblregNo').html(resultData.head.RegNo);
          $('#totalAmount').html(accounting.formatMoney(resultData.head.JobTotalAmount));
          $('#totalDiscount').html(accounting.formatMoney(resultData.head.JobTotalDiscount));
          $('#netAmount').html(accounting.formatMoney(resultData.head.JobNetAmount-resultData.head.JobAdvance));
          $('#totalAdvance').html(accounting.formatMoney(resultData.head.JobAdvance));
          if(resultData.head.IsPayment==0){
                $("#btnPayment").show();
                var url ="payment/job_payment/"+Base64.encode(resultData.head.JobInvNo);
                $("#btnPayment").prop("disabled", false);
                $("#btnPayment").attr("href",url);
              }else{
                 $("#btnPayment").hide();
              }
          var k = 1;
                $.each(resultData.list, function(key, value) {
                    $("#tbl_est_data").append("<tr><td colspan='6' style='padding: 4px 3px 4px 50px;'><b>" + key + "</b></td></tr>");
                    for (var i = 0; i < value.length; i++) {  
                            $("#tbl_est_data tbody").append("<tr><td style='text-align:center;padding: 3px;'>" + (k) + "</td><td style='padding: 3px;'>" + value[i].JobDescription + "</td><td style='padding: 3px;'> </td><td style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobQty) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobPrice) + "</td><td  style='text-align:right;padding: 3px;'>" + accounting.formatMoney(value[i].JobNetAmount) + "</td></tr>");
                        k++;
                    }
                });

           setTimeout(function(){$('#printArea').focus().print();},1000);
        }
      });
}

function cancelInvoice(invoice) {
  $.ajax({
        url:'../../salesinvoice/cancelInvoice',
        dataType:'json',
        type:'POST',
        data:{jobinvno:invoice},
        success:function(data) {
            if(data==1){
 $.notify("Invoice canceled successfully.", "success");
 $("#btnCancel").attr('disabled', true);
            }else if(data==2){
 $.notify("Error. Customer has done payment for this invoice. If you want to cancel this invoice please cancel the payment", "danger");
 $("#btnCancel").attr('disabled', false);
            }else if(data==3){
 $.notify("Error. Invoice has already canceled.", "danger");
 $("#btnCancel").attr('disabled', false);
            }else{
               $.notify("Error. Invoice not canceled successfully.", "danger");
               $("#btnCancel").attr('disabled', false);
            }

         
        }
      });
}

var Base64 = {
                
                _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
               
                encode: function(input) {
                    var output = "";
                    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                    var i = 0;

                    input = Base64._utf8_encode(input);

                    while (i < input.length) {

                        chr1 = input.charCodeAt(i++);
                        chr2 = input.charCodeAt(i++);
                        chr3 = input.charCodeAt(i++);

                        enc1 = chr1 >> 2;
                        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                        enc4 = chr3 & 63;

                        if (isNaN(chr2)) {
                            enc3 = enc4 = 64;
                        } else if (isNaN(chr3)) {
                            enc4 = 64;
                        }

                        output = output +
                                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

                    }

                    return output;
                },
               
                decode: function(input) {
                    var output = "";
                    var chr1, chr2, chr3;
                    var enc1, enc2, enc3, enc4;
                    var i = 0;

                    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

                    while (i < input.length) {

                        enc1 = this._keyStr.indexOf(input.charAt(i++));
                        enc2 = this._keyStr.indexOf(input.charAt(i++));
                        enc3 = this._keyStr.indexOf(input.charAt(i++));
                        enc4 = this._keyStr.indexOf(input.charAt(i++));

                        chr1 = (enc1 << 2) | (enc2 >> 4);
                        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                        chr3 = ((enc3 & 3) << 6) | enc4;

                        output = output + String.fromCharCode(chr1);

                        if (enc3 != 64) {
                            output = output + String.fromCharCode(chr2);
                        }
                        if (enc4 != 64) {
                            output = output + String.fromCharCode(chr3);
                        }

                    }

                    output = Base64._utf8_decode(output);

                    return output;

                },
               
                _utf8_encode: function(string) {
                    string = string.replace(/\r\n/g, "\n");
                    var utftext = "";

                    for (var n = 0; n < string.length; n++) {

                        var c = string.charCodeAt(n);

                        if (c < 128) {
                            utftext += String.fromCharCode(c);
                        }
                        else if ((c > 127) && (c < 2048)) {
                            utftext += String.fromCharCode((c >> 6) | 192);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }
                        else {
                            utftext += String.fromCharCode((c >> 12) | 224);
                            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }

                    }

                    return utftext;
                },
           
                _utf8_decode: function(utftext) {
                    var string = "";
                    var i = 0;
                    var c = c1 = c2 = 0;

                    while (i < utftext.length) {

                        c = utftext.charCodeAt(i);

                        if (c < 128) {
                            string += String.fromCharCode(c);
                            i++;
                        }
                        else if ((c > 191) && (c < 224)) {
                            c2 = utftext.charCodeAt(i + 1);
                            string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                            i += 2;
                        }
                        else {
                            c2 = utftext.charCodeAt(i + 1);
                            c3 = utftext.charCodeAt(i + 2);
                            string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                            i += 3;
                        }

                    }

                    return string;
                }

            }
</script>