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
                    <div class="col-sm-4"><span><b><?php echo $pagetitle; ?></b> <a  href="<?php echo base_url('admin/payment/view_customer/').$invCus->CusCode; ?>" ><?php echo $invCus->CusName; ?><span class="pull-left"><i class="fa fa-user "></i></span></a></span>
                            
                    </div>
                    <div class="col-sm-8">
                        <div class="row">                           
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2"><button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print</button></div>
                            <div class="col-sm-2">
                            <!-- <button type="button"  id="btnCancel" class="btn btn-danger btn-sm btn-block">Cancel</button> -->
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                            </div>
                        </div>       
                    </div>
                        
                    </div>
                            
                    <br>
                    <form id="form1"  action="">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="isall" class="control-label">
                                <input class="rpt_icheck" type="checkbox" name="isall" <?php if(isset($_REQUEST['isall'])){ ?> checked <?php } ?>> All</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> 
                        <i class="fa fa-caret-down"></i>
                        <input type="hidden" name="startdate" id="startdate" >
                        <input type="hidden" name="enddate" id="enddate" >
                        <input type="hidden" name="CusCode" value=<?php echo ($credit->CusCode) ?>>
                    </div>
                    </div>
                    <div class="col-md-1">
                        <button type="submit"  id="btnShow" class="btn btn-flat btn-success">Show</button>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" id="btnPdf" class="btn btn-flat btn-success">PDF</button>
                    </div>
                    </div>
                  </form>
                    

    <section class="content">
      <div class="row">
        <div class="col-lg-8">
          <input type="hidden" name="inv" id="inv" value="">
        <div class="row" id="printArea" align="center" style='margin:5px;'>
                                <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>

<style type="text/css" media="screen">

    #tbl_po_data2 tbody tr td{
    padding: 5px  !important;
    border-bottom:1px solid #fff !important;
}
</style>

<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="font-size:13px;">
        <td></td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:right;font-size:20px;font-weight: bold; padding-top: 5px;
          padding-bottom: 5px;
          padding-left: 5px;" >Statement of Accounts</td>
    </tr>
    <tr style="font-size:13px;">
        <td></td>
        <td> </td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" style="text-align:right;font-size:12px;font-weight: bold; padding-top: 5px;
          padding-bottom: 5px;
          padding-left: 5px;border-bottom:1px solid #000;" >From  <?php echo $startdate; ?> To  <?php echo $enddate; ?> </td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="8">&nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td>To :</td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:left;font-size:15px;font-weight: bold;background-color: #b3b3b3; padding-top: 5px;
          padding-bottom: 5px;
          padding-left: 5px;" >Account Summary</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="4" rowspan="6" style="font-size:14px;width:350px;">
            <span id="lblcusName"><?php echo $invCus->DisplayName;?></span><br>
            <span id="lblcusName"><?php echo nl2br($invCus->Address01)."<br>".$invCus->Address02."<br>".$invCus->Address03;?></span>
        </td>
        <td></td>
        <td style="text-align:left;width:150px;">Statment Balance</td>
        <td> Rs : </td>
        <td style="text-align:right;"><?php echo number_format($opbalance,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Invoiced Amount</td>
        <td> Rs : </td>
        <td style="text-align:right;" id="lblPoNo"><?php echo number_format($InvAmount,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Amount Paid </td>
        <td> Rs : </td>
        <td  style="text-align:right;" ><?php echo number_format($InvPayment,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Return Amount </td>
        <td> Rs : </td>
        <td  style="text-align:right;" ><?php echo number_format($return_payment,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Over Return Amount </td>
        <td> Rs : </td>
        <td  style="text-align:right;" ><?php echo number_format($return__complete_payments,2) ?></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td style="text-align:left;">Balance Due</td>
        <td> Rs : </td>
        <td style="text-align:right;" ><?php echo number_format($InvAmount - $InvPayment-$return_payment+$opbalance+$return__complete_payments,2)?></td>
    </tr>
</table>
<form id="filterform">
        <table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="0">
                    <thead id="taxHead">
                        <tr><td colspan="5" style="border-top:1px solid #fff;border-left:1px solid #fff;border-right:1px solid #fff;text-align: right;"></td></tr>
                            <tr style="background-color:#5d5858 !important;color:#fff !important;line-height:20px;">
                            <th style='padding: 3px;color:#fff !important;'>Date</th>
                            <th style='padding: 3px;color:#fff !important;'>Transactions</th>
                            <th style='padding: 3px;color:#fff !important;'>Details</th> 
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Amount  </th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Payments</th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Returns</th>
                            <th style='padding: 3px;color:#fff !important;text-align:right;'>Balance</th>
                        </tr>
                    </thead>                 
                    <tbody> 
                        <tr style="line-height:20px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $startdate ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;">**** Statment Balance ****</td>
                          <td style="border-bottom:1px solid #e4dbdb;">-</td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo  number_format($opbalance,2) ?></td>
                        </tr>
                        <?php $total=0; 
                        foreach ($cr as $crr) { ?>
                        <tr style="line-height:20px;">
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $crr->InvoiceDate ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;"><?php echo $crr->InvoiceNo ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;">-</td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format($crr->CreditAmount,2) ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format($crr->SettledAmount,2) ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format($crr->returnAmounts,2) ?></td>
                          <td style="border-bottom:1px solid #e4dbdb;" class='text-right'><?php echo number_format($crr->CreditAmount - $crr->SettledAmount - $crr->returnAmounts,2) ?></td>
                        </tr>
                        <?php $total +=$crr->CreditAmount - ($crr->SettledAmount + $crr->returnAmounts);  } ?>
                    </tbody>
                    <tfoot>
                    <tr style="line-height:25px;" id="rowNBT">
                        <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Over Returns</td>
                        <td> </td>
                        <td style="text-align:right;padding-right:15px;font-weight:bold;">Rs :  <?php echo number_format($return__complete_payments,2)?></td>
                    </tr>
                    <tr style="line-height:25px;" id="rowNBT">
                          <td colspan="4" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></td><td style="text-align:right">Balance Due</td>
                          <td> </td>
                            <td style="text-align:right;padding-right:15px;font-weight:bold;">Rs :  <?php echo number_format($total+$opbalance+$return__complete_payments,2)?></td>
                        </tr>                         
                    </tfoot>
        </table>
</form>           
    <style type="text/css" media="screen">
    #tbl_po_data tbody tr td{
        padding: 13px;
    }
</style>
</div>
        </div>
        <div class="col-lg-4"></div>
      </div>
    
</section>
    <div>
    </div>
</div>
 <!-- print parts goes here -->
        
<!-- print 2 -->
        
<script type="text/javascript">

$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('#startdate').val(start.format('YYYY-MM-DD'));
        $('#enddate').val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});



var inv =$("#inv").val();

$("#btnPrint").click(function(){
$('#printArea').focus().print();
});

$("#btnPrint2").click(function(){
$('#printArea2').focus().print();
});

$("#btnShow").click(function(){
    $("#form1").attr("action","");
});

$("#btnPdf").click(function(){
    $("#form1").attr("action","<?php echo base_url('admin/payment/customer_statement_pdf'); ?>");
});


$("#btnCancel").click(function(){

  var r = confirm('Do you want to cancel this invoice?');
    if (r === true) {
        cancelInvoice(inv);
    }else{

    }
});

  var bottom = 0;
  var pagNum = 2; 

  $(document).ready(function() {
   

    $("table:nth-child(10n)").each(function() {
      bottom -= 100;
      botString = bottom.toString();
      var $counter = $('h3.pag1').clone().removeClass('pag1');
      $counter.css("bottom", botString + "vh");
      numString = pagNum.toString();
      $counter.addClass("pag" + numString);
      ($counter).insertBefore('.insert');
      pagNum = parseInt(numString);
      pagNum++; 
    });

    var pagTotal = $('.pag').length; 

    pagTotalString = pagTotal.toString();
    $("h3[class^=pag]").each(function() {
     
      var numId = this.className.match(/\d+/)[0];
      document.styleSheets[0].addRule('h3.pag' + numId + '::before', 'content: "Page ' + numId + ' of ' + pagTotalString + '";');
    });
  });

function cancelInvoice(invoice) {
  $.ajax({
        url:'../../salesinvoice/cancelSalesInvoice',
        dataType:'json',
        type:'POST',
        data:{salesinvno:invoice},
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

 $('#filterform').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "loadcustomercredit",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                $("#cusName,#address1,#address2,#totalpr").empty();
                if(data){
                    var res=JSON.parse(data); 
                    drawTable(res.cr);
                    $('#cusName').html(res.cr[0].RespectSign+' '+res.cr[0].CusName);$('#address1').html(res.cr[0].Address01);
                    $('#address2').html(res.cr[0].Address02);
                     $('#totalpr').html(accounting.formatMoney(sumcolumn('profit')));
                }
            }
        })
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