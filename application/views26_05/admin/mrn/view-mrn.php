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
        <?php if($invHed->IsConfirm==1){$disabled='disabled'; }else{$disabled='';}?>
        <?php if ($_SESSION['location']==$invHed->ToLocation && $invHed->MrnIsReceive==1): ?>
          <button type="button" <?php echo $disabled;?> id="btnCancel" class="btn btn-success btn-lg btn-block">Confirm</button> &nbsp;
        <?php endif ?>
         
        </div>
        <div class="pull-right">
         <button type="button" id="btnPrint" class="btn btn-primary btn-lg btn-block">Print</button>&nbsp;
        </div>
    </section>
    <section class="content">
    <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
        <div class="row"  align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>
<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;font-weight: bold;" >Parts Request Note</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>MRN No</td>
        <td>:</td>
        <td colspan="2" id="lblPoNo"><?php echo $invHed->MrnNo;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>Request Date</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"> <?php echo $invHed->MrnDate;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>Job No</td>
        <td>:</td>
        <td colspan="2"><?php echo $invHed->MrnJobNo;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>Recieved Date</td>
        <td>:</td>
        <td colspan="2" ><?php echo $invHed->ReceivedDate;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>Request From</td>
        <td>:</td>
        <td colspan="2" ><?php echo $invHed->location;?></td>
    </tr>
</table>
<style type="text/css" media="screen">

    #tbl_po_data tbody tr td{
    padding: 13px;
}
</style>
<table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
  <thead id="taxHead">
    <tr>
      <td colspan="2" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td>
    </tr>
    <tr>
      <th style='padding: 3px;width:50px'>Qty</th>
      <th style='padding: 3px;width:50px'>Code</th>
      <th style='padding: 3px;width:250px'>Description</th>
      <th style='padding: 3px;width:50px'>Brand</th>
      <th style='padding: 3px;width:50px'>Price</th>
      <th style='padding: 3px;width:30px'>Status</th>
      <th style='padding: 3px;width:80px'>Recieved Date</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      //var_dump($invDtlArr);
      foreach ($invDtlArr AS $key=>$invdata) {
        //normal invoice
          $i=0;
          while ($i<count($invdata)) {
         ?>
          <tr>
            <td><?php echo number_format(($invdata[$i]->RequestQty),2)?></td>
            <td><?php  echo(($invdata[$i]->ProductCode))?></td>
            <td ><?php echo $invdata[$i]->ProName."<br>".$invdata[$i]->Serial;?></td>
            <td><?php echo ($invdata[$i]->ProBrand)?></td>
            <td><?php echo number_format(($invdata[$i]->SellingPrice),2)?></td>
            <td >
              <?php if($invdata[$i]->Request==1 && $invdata[$i]->Receive==0){
                  echo "<label class='label label-warning'>Requested</label>";
                }elseif ($invdata[$i]->Request==1 && $invdata[$i]->Receive==1) {
                  echo "<label class='label label-success'>Recieved</label>";
                } ?>
            </td>
            <td ><?php echo $invdata[$i]->ReceiveDate;?></td>
            </tr>
      <?php $i++; 
            
          } 
      }
         ?>                    
    </tbody>
  </table>
  <table style="width:700px;" border="0">
   <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
    <tr><td style="text-align:right;">Remark : </td><td colspan="4"><?php echo $invHed->MrnRemark;?></td></tr>
    
      <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
       <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr> <tr>
        <td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td>
        <td style="">&nbsp;</td>
        <td style="width:200px">&nbsp;</td>
        <td style="">&nbsp;</td>
       <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:100px;text-align: center">Issued By</td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"></td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"> Signature</td>                            
    </tr>
    <tr>
        <td style="width:100px;text-align: center">( <?php echo $invHed->first_name; ?> )</td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"></td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"></td>                            
    </tr>
</table>
<style type="text/css" media="screen">
    #tbl_po_data tbody tr td{
        padding: 13px;
    }
</style>
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
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>
<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;font-weight: bold;" >Parts Request Note</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>MRN No</td>
        <td>:</td>
        <td colspan="2" id="lblPoNo"><?php echo $invHed->MrnNo;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>Request Date</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"> <?php echo $invHed->MrnDate;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>Job No</td>
        <td>:</td>
        <td colspan="2"><?php echo $invHed->MrnJobNo;?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> &nbsp;</td>
        <td>Recieved Date</td>
        <td>:</td>
        <td colspan="2" ><?php echo $invHed->ReceivedDate;?></td>
    </tr>
</table>
<style type="text/css" media="screen">

    #tbl_po_data2 tbody tr td{
    padding: 15px 13px 13px 13px;
}
</style>
<table id="tbl_po_data2" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
  <thead id="taxHead">
    <tr>
      <td colspan="2" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td>
    </tr>
    <tr><th style='padding: 3px;width:50px'>Qty</th>
      <th style='padding: 3px;width:50px'>Code</th>
      <th style='padding: 3px;width:250px'>Description</th>
      <th style='padding: 3px;width:50px'>Brand</th>

      <th style='padding: 3px;width:50px'>Price</th>
      <th style='padding: 3px;width:30px'>Status</th>
      <th style='padding: 3px;width:80px'>Recieved Date</th></tr>
  </thead>
  <tbody>
    <?php 
      //var_dump($invDtlArr);
      foreach ($invDtlArr AS $key=>$invdata) {
        //normal invoice
          $i=0;
          while ($i<count($invdata)) {
         ?>
          <tr>
            <td><?php echo number_format(($invdata[$i]->RequestQty),2)?></td>
            <td><?php  echo(($invdata[$i]->ProductCode))?></td>
            <td ><?php echo $invdata[$i]->ProName."<br>".$invdata[$i]->Serial;?></td>
            <td><?php echo ($invdata[$i]->ProBrand)?></td>
            <td><?php echo number_format(($invdata[$i]->SellingPrice),2)?></td>
            <td >
              <?php if($invdata[$i]->Request==1 && $invdata[$i]->Receive==0){
                  echo "Requested";
                }elseif ($invdata[$i]->Request==1 && $invdata[$i]->Receive==1) {
                  echo "Recieved";
                } ?>
            </td>
            <td ><?php echo $invdata[$i]->ReceiveDate;?></td>
            </tr>
      <?php $i++; 
            
          } 
      }
         ?>                    
    </tbody>
  </table>
  <table style="width:700px;" border="0">
   <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
    <tr><td style="text-align:right;">Remark : </td><td colspan="4"><?php echo $invHed->MrnRemark;?></td></tr>
    
      <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
       <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr> <tr>
        <td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td>
        <td style="">&nbsp;</td>
        <td style="width:200px">&nbsp;</td>
        <td style="">&nbsp;</td>
       <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:100px;text-align: center">Issued By</td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"></td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"> Signature</td>                            
    </tr>
    <tr>
        <td style="width:100px;text-align: center">( <?php echo $invHed->first_name; ?> )</td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"></td>
        <td style="">&nbsp;</td>
        <td style="width:200px;text-align: center"></td>                            
    </tr>
</table>
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
  var r = confirm('Do you want to confirm this mrn?');
    if (r === true) {
        cancelInvoice(inv);
    }else{

    }
});

  var bottom = 0;
  var pagNum = 2; 

function cancelInvoice(invoice) {
  $.ajax({
        url:'../../mrn/confirmMrn',
        dataType:'json',
        type:'POST',
        data:{mrnno:invoice},
        success:function(data) {
            if(data==1){
              $.notify("Parts Request confirmed successfully.", "success");
              $("#btnCancel").attr('disabled', true);
            }else{
               $.notify("Error. Parts Request not confirmed successfully.", "danger");
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