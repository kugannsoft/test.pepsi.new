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
                    <div class="col-sm-4"><span><b><?php echo $pagetitle; ?></b></span>
                            
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <?php if($invHed->InvIsCancel==1){$disabled='disabled'; }else{$disabled='';}?>

                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-1"></div>
                            <?php if (in_array("SM162", $blockView) || $blockView == null) { ?>
                                <div class="col-sm-2">
                                    <button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print
                                    </button>
                                </div>
                            <?php } ?>
                            <!--div class="col-sm-1"><a href="<?php echo base_url('admin/Salesinvoice/view_sales_invoice_pdf/') . base64_encode($invNo); ?>" target="blank_" class="btn btn-primary btn-sm">Pdf</a></div-->
                           
                          
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                            </div>
                        </div>       
                    </div>
                        <!-- </div> -->
                    </div><!-- /.box-header -->
   
    <section class="content">
      <div class="row">
        <div class="col-lg-8">
          <input type="hidden" name="inv" id="inv" value="<?php echo $invNo;?>">
        <div class="row" id="printArea" align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
            <table style="border-collapse:collapse;width:730px;font-family: Arial, Helvetica, sans-serif;" border="0"  align="center">
            <tr style="text-align:left;font-size:15px;">
      <td colspan="2"> </td>
      
    </tr>
    <tr style="text-align:left;font-size:15px;">

        <td colspan="2" rowspan="6" style="border:0px solid #000;font-size:15px;width:430px;padding: 5px;" v-align="top">
            <?php $this->load->view('admin/_templates/company_header.php',true); ?>
            <span style="font-size: 13px;">
                <a href="<?php echo base_url('admin/payment/view_customer/').$orderHead->CusCode ?>">Customer :<?php echo $orderHead->DisplayName;?></a>
                </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <span style="font-size: 13px;" id="lbladdress2">TP : <?php echo $orderHead->LanLineNo;?> Mobile : <?php echo $orderHead->MobileNo;?></span>
         
         
        </td>
    </tr>

                <tr style="text-align:left;font-size:13px;">
                
                    <td colspan="4" style="text-align:right;"><b>&nbsp;INVOICE</b></td>
                </tr>

                <tr style="text-align:left;font-size:13px;">
                    <td style="padding-top:0px;font-size:13px;text-align:left;">Invoice No </td>
                    <td style="">:</td>
                    <td colspan="2" style="font-size:13px;text-align:right;"><?php echo $orderHead->tempInvNo ?></td>
                </tr>
                <tr style="text-align:left;font-size:13px;">
                    <td style="text-align:left;">Date</td>
                    <td >:</td>
                    <td colspan="2" style="text-align:right;"><?php echo date('Y-m-d',strtotime($orderHead->date));?>&nbsp;</td>
                </tr>
              
                <tr style="text-align:left;font-size:13px;">
                    <td style="padding-top:0px;font-size:13px;text-align:left;">Sales Rep </td>
                    <td style="">:</td>
                    <td colspan="2" style="font-size:13px;text-align:right;"><?php echo $orderHead->salesPerson ?></td>
                </tr>
               



<style type="text/css" media="screen">

    #tbl_po_data2 tbody tr td{
    padding: 5px  !important;
    border-bottom:1px solid #fff !important;
    }

</style>
<table id="tbl_po_data" style="border-collapse:collapse;width:730px;padding:5px;font-size:15px;" border="0">
             
                    <thead id="taxHead" border="1">
                        <tr><td colspan="5" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td></tr>
                        <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:20px; border-bottom:1px solid #000000; border-top:1px solid #000000; ">
                            <th style='padding: 3px;color:#fff; text-align:center;'>Code</th>
                            <th style='padding: 3px;color:#fff; text-align:center;'>Description</th>
                            
                            <th style='padding: 3px;color:#fff; text-align:center;'>Qty</th>

                            <th style='padding: 3px;color:#fff; text-align:center;' >Unit Price</th>
                            <th style='padding: 3px;color:#fff; text-align:center;'>Discount</th>
                            <th style='padding: 3px;color:#fff; text-align:center;'>Amount</th>
                        </tr>
                    </thead>
                
                    <tbody>
                    <?php 
                    $i=1;
                     //var_dump($invDtlArr);
                    foreach ($orderDtls AS $invdata) {
                       
                         ?>
                        <tr style="line-height:20px; border-bottom:1px solid #000000; border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;">
                          <td style="border-right:1px solid #000000;"><?php echo $invdata->productCode;?></td>
                          <td style="border-right:1px solid #000000;"><?php echo $invdata->productName;?></td>
                          
                          <td style="border-right:1px solid #000000; text-align:center;"><?php echo number_format(($invdata->saleQuantity),0)?></td>
                          <td style="border-right:1px solid #000000; text-align:right;" class='text-right'><?php echo number_format(($invdata->unitPrice),2)?></td>
                          <td style="border-right:1px solid #000000; text-align:right;" class='text-right'><?php echo number_format(($invdata->disAmount),2)?></td>
                          <td style="border-right:1px solid #000000; text-align:right;" class='text-right'><?php echo number_format(($invdata->totalNetAmount),2)?></td>
                        </tr>
                    <?php $i++; 
                          
                      
                    }
                    
                       ?>                    
                    </tbody>
                    <tfoot>
                   
                     
                        <tr style="line-height:25px; border-top:1px solid #000000;  border-right:1px solid #000000;" id="rowTotal">
                        <td colspan="4" style="border-top: 1px #000000 solid;border-right: 1px #000000 solid;"></td>
                        <td style="text-align:right;padding: 3px;border-right: 1px #000000 solid;border-bottom: 1px #000 solid;">Sub Total </td>
                        <td id="lbltotalPOAmount"   style='text-align:right;padding: 3px;border-bottom: 1px #000000 solid;'><?php echo number_format($orderHead->grossAmount,2);?></td>
                        </tr>
                        <?php if($orderHead->isInvoiceDiscount ==1){?>
                         <tr style="line-height:25px;" id="rowDiscount">
                          <td colspan="4" style="border-left: 1px #fff solid;"></td>
                          <td style="text-align:right;border-right: 1px #000 solid;border-bottom: 1px #000 solid;border-left: 1px #000 solid;">Discount  </td>
                          <td id="lbltotalDicount"   style='text-align:right;border-bottom: 1px #000 solid;border-right: 1px #000 solid;'><?php echo number_format($orderHead->discountAmount,2);?></td>
                         </tr>
                          <?php }?>
                         <!-- <?php if($invHed->SalesVatAmount>0 && $invHed->SalesInvType==2){?>
                         <tr style="line-height:25px;" id="rowVAT">
                          <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">VAT Amount  </td><td id="lbltotalVat"   style='text-align:right'><?php echo number_format($invHed->SalesVatAmount,2);?></td>
                         </tr><?php } ?>
                          <?php if($invHed->SalesNbtAmount>0 && $invHed->SalesInvType==2){?>
                        <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">NBT Amount  </td><td id="lbltotalNbt"   style='text-align:right'><?php echo number_format($invHed->SalesNbtAmount,2);?></td>
                        </tr>
                         <?php } ?> -->
                        
                        <tr style="line-height:25px;" id="rowNET">
                          <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;">

                          </td><td style="font-weight:bold;text-align:right;border-left: 1px #000 solid;border-bottom: 1px #000 solid;">Total  </td>
                          <td id="lbltotalNet"   style='font-weight:bold;text-align:right;border-bottom: 1px #000 solid;border-left: 1px #000 solid;border-right: 1px #000 solid;'><?php echo number_format($orderHead->netTotal,2);?></td>
                        </tr>
                       
                       
                        
                        
                      

                   
                    

                        

                    </table>
                           </td>
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


      </div>
    
</section>
    <div>
    </div>
</div>
<?php //die; ?>
 <!-- print parts goes here -->
        
<!-- print 2 -->
        
<script type="text/javascript">

var inv =$("#inv").val();

$("#btnPrint").click(function(){
$('#printArea').focus().print();
});

$("#btnPrint2").click(function(){
$('#printArea2').focus().print();
});






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