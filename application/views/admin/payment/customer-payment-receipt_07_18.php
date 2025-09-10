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
    <div class="box-header" style="background: #b4f3c8">
        <div class="col-sm-5"><?php echo $pagetitle; ?></div>
        <div class="col-sm-7">
            <div class="row">
                <?php $invNo=$invno; //if($invHed->InvIsCancel==1){$disabled='disabled'; }else{$disabled='';}?>
                
                <div class="col-sm-1"></div>
                
                <div class="col-sm-2"><button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print</button></div>
                <div class="col-sm-2"><button type="button" id="btnPrint2" class="btn btn-primary btn-sm btn-block">Customer Print</button></div>
                <div class="col-sm-2"><button type="button" id="btnPrint3" class="btn btn-primary btn-sm btn-block">Office Print</button></div>
                <!--div class="col-sm-1">
                <a href="<?php echo base_url('admin/payment/view_customer_receipt_pdf?payNo=').base64_encode($invNo); ?>" target="blank_" class="btn btn-primary btn-sm">Pdf</a>
                </div!-->
                <div class="col-sm-1">
               <!--  <a href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?action=1&id=').base64_encode($invNo); ?>" target="blank_" class="btn btn-info btn-sm">Clone</a> -->
                </div>
                <div class="col-sm-1">
        <!--         <a href="<?php echo base_url('admin/Salesinvoice/addSalesInvoice?action=2&id=').base64_encode($invNo); ?>" target="blank_" class="btn btn-info btn-sm">Edit</a> -->
                </div>
                <div class="col-sm-2">
                <?php //if($invHed->InvIsCancel==0){?>
                <!-- <button type="button" <?php echo $disabled;?>  id="btnCancel" class="btn btn-danger btn-sm btn-block">Cancel</button><?php// } ?></div> -->
            </div>
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>       
        </div>
            </div>
    </div><!-- /.box-header -->
    <section class="content">
      <div class="row">
        <div class="col-lg-8">
          <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
        <div class="row"  align="center" style='margin:5px;'>
                       <div class="row"  id="printArea3" align="center" style='margin:5px;'>
                       <div id="customercopy">
    <!-- company header -->
     <?php $this->load->view('admin/_templates/company_header.php',true); ?>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">
       
        <tr style="text-align:left;">
            <td style="width:200px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:290px;">&nbsp;</td>
            <td style="width:20px;">&nbsp;</td>
            <td style="width:320px;">&nbsp;</td>
            <td style="width:170px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td>-->
            <td >&nbsp;</td> 
            <td colspan="2" style='font-size: 20px;text-align: center;'><b>Customer Copy</b></td>
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
            <td colspan="4"  id="chq_rcpamountword"><?php echo $pay_amount; ?></td>
            <td>&nbsp;</td>
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
            <td colspan="2" id="chq_rcpbank"><?php echo $pay->BankName; ?></td>
            <td></td>
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
    </div>
    <!--<br> -->
    <!--<hr> <br> -->
    <!--<div id="officecopy">-->
    
    <?php //$this->load->view('admin/_templates/company_header.php',true); ?>
    <!--<table  style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">-->
        <?php //foreach ($company as $com) {  ?>
        
       
    <!--    <tr style="text-align:left;">-->
    <!--        <td style="width:200px;">&nbsp;</td>-->
    <!--        <td  style="width:20px;">&nbsp;</td>-->
    <!--        <td  style="width:380px;">&nbsp;</td>-->
    <!--        <td  style="width:20px;">&nbsp;</td>-->
    <!--        <td  style="width:380px;">&nbsp;</td>-->
    <!--        <td  style="width:290px;">&nbsp;</td>-->
    <!--        <td style="width:20px;">&nbsp;</td>-->
    <!--        <td style="width:300px;">&nbsp;</td>-->
    <!--        <td style="width:190px;">&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
            <!-- <td>&nbsp;</td>-->
    <!--        <td >&nbsp;</td> -->
    <!--        <td colspan="2" style='font-size: 20px;text-align: center;'><b>Office Copy</b></td>-->
    <!--        <td>DATE</td>-->
    <!--        <td>:</td>-->
    <!--        <td id="chq_rcpdate1"><?php echo $pay->PayDate; ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>RECEIPT NO</td>-->
    <!--        <td>:</td>-->
    <!--        <td id="chq_rcpreceiptno"><?php echo $pay->CusPayNo; ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3">Received with thanks a sum of Rupees</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4"  id="chq_rcpamountword"><?php echo $pay_amount; ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td></td>-->
    <!--        <td colspan="4">&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3">Reason for payment </td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4"  id="chq_rcpreason"><?php echo $pay->Remark; ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3">In Cash / Cheque from</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4" id="chq_rcpcusname"><?php echo $pay->DisplayName; ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4" id="chq_rcpcusaddress" rowspan="3"><?php echo $pay->Address01."<br>".$pay->Address02." ".$pay->Address03; ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--     <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>-->
            <!-- <td id="chq_rcpinvno"></td> -->
    <!--        <td colspan="3"  > : <?php if($inv){echo $inv->InvNo;} ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Vehicle No</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="chq_rcpvno"><?php if($inv){echo $inv->vehicle;} ?></td>-->
    <!--        <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;</td>-->
    <!--        <td id="chq_rcpcuscode"> :  <?php echo $pay->CusCode; ?></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Amount</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="chq_rcpamount">Rs.<?php echo number_format($pay->PayAmount,2); ?></td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Cheque No</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="chq_rcpchequeno"><?php echo $pay->ChequeNo; ?></td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Bank</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="chq_rcpbank"><?php echo $pay->BankName; ?></td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Date</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2"  id="chq_rcpchequedate"><?php echo $pay->ChequeDate; ?></td>-->
    <!--        <td></td>-->
            <!-- <td>&nbsp;</td> -->
    <!--        <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
            <!-- <td>&nbsp;</td> -->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Payment Type</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2"  id="chq_rcppaytype"><?php echo $pay->PayMethod; ?> Payment</td>-->
    <!--        <td></td>-->
    <!--        <td colspan="2"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--</table>-->
    <!--</div>-->
</div>         
        </div>
        </div>
        <div class="col-lg-4">
           <table class="table">
            <tr><td>Create by</td><td>:</td><td><?php echo $pay->first_name." ".$pay->last_name ?></td></tr>
            <tr><td>Create Date</td><td>:</td><td><?php echo $pay->PayDate ?></td></tr>
            <?php if($cancel): ?>
            <tr><td>Cancel By</td><td>:</td><td><?php echo $cancel->first_name." ".$cancel->last_name ?></td></tr>
            <tr><td>Cancel Date</td><td>:</td><td><?php echo $cancel->CancelDate ?></td></tr>
            <tr><td>Remark</td><td>:</td><td><?php echo $cancel->CancelRemark ?></td></tr>
          <?php endif; ?>
        <!--  <?php if($invUpdate):  ?>
          <tr><td colspan="3">Last Updates</td></tr>
          <?php  foreach ($invUpdate AS $up) { ?>
            <tr><td><?php echo $up->UpdateDate ?></td><td>:</td><td><?php echo $up->first_name." ".$up->last_name ?></td></tr>
          <?php }
          endif; ?> -->
          </table> 
        </div>
      </div>
    
</section>
    <div>
    </div>
</div>
 <!-- print parts goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                    <div class="row" id="printArea" align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    
                    </div>
                </div>
              </div>
            </div>
        </div>
<!-- print 2 -->
        
<script type="text/javascript">

var inv =$("#inv").val();

$("#btnPrint").click(function(){
$('#printArea3').focus().print();
});

$("#btnPrint2").click(function(){
$('#customercopy').focus().print();
});

$("#btnPrint3").click(function(){
$('#officecopy').focus().print();
});

$("#btnCancel").click(function(){

  var r = prompt('Do you really want to cancel this payment? Please enter a remark.');

    if (r == null || r=='') {
      return false; 
    }else{
      cancelInvoice(inv,r);
      return false;
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

function cancelInvoice(invoice,remark) {
  $.ajax({
        url:'../../salesinvoice/cancelSalesInvoice',
        dataType:'json',
        type:'POST',
        data:{salesinvno:invoice,remark:remark},
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
