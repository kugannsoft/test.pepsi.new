<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <form id="filterform">
                                <div class="row">
                                <div class="col-md-3">
                                       <select class="form-control" name="customer" id="customer">
                                            <option value="">--select supplier--</option>
                                        </select>
                                        <input type="hidden" name="route_ar" id="route_ar">
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                        <label for="isall" class="control-label">
                                            <input class="rpt_icheck" type="checkbox" name="isall"> 
                                            All
                                        </label>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" class="form-control" name="startdate" id="startdate"  value="<?php echo date("Y-m-d") ?>"/>
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="form-control" name="enddate" id="enddate" value="<?php echo date("Y-m-d") ?>"/>
                                        </div>
                                       
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <select class="form-control" name="route" id="route"  multiple="multiple">
                                            <option value="">--select location--</option>
                                            <?php foreach ($locations AS $loc) { ?>
                                                <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                            <?php } ?>
                                        </select><br><label for="isall" class="control-label">
                                            <input class="rpt_icheck" type="checkbox" name="showlink"> 
                                            Show GRN Link
                                        </label>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-flat btn-success">Show</button>
                                    </div>
                                    <div class="col-md-1">
                                        <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box" id="report">
                <div class="row">
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-10">To:<span class="pull-right" id="a">DATE : <?php echo date('Y-m-d');?></span><br>
                    <span id="cusName"></span><br>
                    <span id="address1"></span>
                    <span id="address2"></span></div>
                    <!-- <div class="col-md-5">DATE : <?php echo date('Y-m-d');?></div> -->
                     <div class="col-md-1">&nbsp;</div>
                     </div>
                     <div class="row">
                    <div class="box-body table-responsive">
                        <table id="saletable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Date</td>
                                    <!-- <td>Customer</td> -->
                                    <td>GRN No</td>
                                    <!-- <td>Register No</td> -->
                                    <!-- <td>Job Card No</td> -->
                                    <!-- <td>Cost Price</td> -->
                                    <td>Credit Amount</td>
                                    <td>Settled Amount</td>
                                    
                                    <td>Due Outstanding</td>
                                    <td></td>
                                    <!-- <td>Profit</td> -->
                                    <!--<td>Return Qty</td>-->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <!-- <th></th>
                                    <th></th>-->
                                    <!-- <th></th>  -->
                                    <!-- <th></th> -->
                                    <th></th>
                                    <th></th><!-- 
                                    <th></th>
                                    <th></th> -->
                                    <th  colspan="2" style="text-align: right;">Total Outstanding</th>
                                    <th id="totalpr" style="text-align: right;color: #00aaf1;"></th>
                                    <th></th>
                                    <!-- <th id="nprofit" style="text-align: right;color: #00aaf1;"></th> -->
                                </tr>
                                
                            </tfoot>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!--print view modal-->
        <div id="salesbydateprint" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- load data -->
                    <div id="Report_header" >
                        <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                            <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                                <td colspan="6" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
                            </tr> 
                            <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                                <td colspan="6"><b><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?> &nbsp;&nbsp;  <?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo $company['MobileNo'] ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $('.input-daterange').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('.rpt_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

   

$("input[name='isall']").on('ifChanged', function(event){
    var isAll = $("input[name='isall']:checked").val();
    if(isAll){
        $("#startdate").prop('disabled',true);
        $("#enddate").prop('disabled',true);
    }else{
        $("#startdate").prop('disabled',false);
        $("#enddate").prop('disabled',false);
    }
});

var showlink=0;
$("input[name='showlink']").on('ifChanged', function(event){
     showlink = $("input[name='showlink']:checked").val();
    if(showlink){
        showlink=1;
    }else{
         showlink=0;
    }

});


    var dep = 0;
    var subdep = 0;
    $("#subcategory").select2({
        placeholder: "Select a model"
    });

    var sub = [];
    $("#subcategory").change(function() {
        sub.length = 0;

        $("#subcategory :selected").each(function() {
            sub.push($(this).val());
        });
        $("#subcategory_ar").val(JSON.stringify(sub));
    });

    $("#route").select2({
        placeholder: "Select a location"
    });
    var loc = [];
    $("#route").change(function() {
        loc.length = 0;

        $("#route :selected").each(function() {
            loc.push($(this).val());
        });
        $("#route_ar").val(JSON.stringify(loc));
    });

    $('#product').select2();

    $('#filterform').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "loadsuppliercredit",
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

    var totalcredit=0;
    var totalsettle=0;
    var totaldue=0;
    
    function drawTable(data) {
        totalcredit = 0;
        totalsettle=0;
        totaldue=0;
        $("#totalcredit").html(0);
        $("#totalsettle").html(0);
        $("#totaldue").html(0);
        var subtotal =0;
        var subcredit =0;
        var subsettle =0;

        $.each(data, function(key, value) { 
            var t=0;
            $("#saletable").append("<tr style='background-color:#00a678;color:#fff;'><td colspan='6'><b>"+key+"</b></td></tr>");
subtotal =0;
subcredit =0;
subsettle =0;
            for (var i = 0; i < value.length; i++) {
                
                drawRow(value,i);
                totalcredit+=(parseFloat(value[i].CreditAmount));
                 totalsettle+=parseFloat((value[i].SettledAmount));
                 totaldue+=parseFloat((value[i].CreditAmount-value[i].SettledAmount));
                $("#totalcredit").html(accounting.formatMoney(totalcredit));
                $("#totalsettle").html(accounting.formatMoney(totalsettle));
                $("#totalpr").html(accounting.formatMoney(totaldue));
                subtotal+=parseFloat((value[i].CreditAmount-value[i].SettledAmount));
                subcredit+=parseFloat((value[i].CreditAmount));
                subsettle+=parseFloat((value[i].SettledAmount));
                if (i == (value.length - 1)) {
                    $("#saletable").append("<tr style='background-color:#99999973;color:#fff;text-align:right;'><td colspan='2'><b>Sub Total</b></td><td>"+accounting.formatMoney(subcredit)+"</td><td>"+accounting.formatMoney(subsettle)+"</td><td style='text-align:right'><b>"+accounting.formatMoney(subtotal)+"</b></td><td></td></tr>");
                    $("#saletable").append("<tr style='background-color:#fff;text-align:right;'><td colspan='6'></td></tr>");
                }
                
            }         
        });
    }
    function drawRow(rowData,index) {
        var row = $("<tr/>");
        $("#saletable").append(row);

        row.append($("<td>" + rowData[index].InvoiceDate + "</td>"));
        row.append($("<td class='cashamount' align='right'>" + (rowData[index].GRN_No) + "</td>"));
        row.append($("<td class='costamount' align='right'>" + accounting.formatMoney(rowData[index].CreditAmount) + "</td>"));
        row.append($("<td class='totalamount' align='right'>" + accounting.formatMoney(rowData[index].SettledAmount) + "</td>"));
        row.append($("<td class='profit' align='right'>" + accounting.formatMoney(rowData[index].CreditAmount-rowData[index].SettledAmount) + "</td>"));
        if(showlink==1){
            row.append($("<td class='profit' align='right'><a href='../grn/view_grn/" + Base64.encode(rowData[index].GRN_No) + "' class='btn btn-primary btn-xs' target='_blank'>GRN</a></td>"));
        }else if(showlink==0){
            row.append($("<td class='profit' align='right'></td>"));
        }
        
    }


    function sumcolumn(rclass) {
        var sum = 0;
        var elemnt = document.getElementsByClassName(rclass);
        $(elemnt).each(function() {
            var value = accounting.unformat($(this).text());

            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        return sum;
    }

    function loadprint() {
        $('.modal-content').load('<?php echo base_url() ?>admin/report/', function(result) {
            $('#salesbydateprint').modal({show: true});
        });
    }
    function printdiv() {
        $("#report").print({
            prepend: $("#Report_header").html(),
            title: 'Date vise Sales Report'
        });
    }

    function checkNull(a){
        if(a!=null){
            return (a);
        }else if(a!=' '){
            return '-';
        }else{ 
            return '-';
        }
    }
    function checkDate(a){
            if(a!='0000-00-00'){
            return (a);
        }else{ return '-';}
    }


    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var day = date.getDate();
        var month = (date.getMonth() + 1);
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        hours = hours < 10 ? '0' + hours : hours;
        day = day < 10 ? '0' + day : day;
        month = month < 10 ? '0' + month : month;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return  date.getFullYear() + "-" + month + "-" + day + " " + strTime;
    }

    $("#department").select2({
        placeholder: "Select a Department",
        allowClear: true,
        ajax: {
            url: "departmentjson",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });
    $("#department").change(function() {
        dep = $("#department option:selected").val();
        $("#subdepartment").select2('val', '');

    });

    $("#subdepartment").change(function() {
        subdep = $("#subdepartment option:selected").val();
        $("#subcategory").select2('val', '');

    });

    $("#subdepartment").select2({
        placeholder: "Select a Sub Department",
        allowClear: true,
        ajax: {
            url: "subdepartmentjson",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    dep: dep
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    $("#customer").select2({
        placeholder: "Select a supplier",
        allowClear: true,
        ajax: {
            url: "supplierjson",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    dep: dep,
                    subdep: subdep
                };
            },
            processResults: function(data) {
                
                return {
                    results: data
                };
            },
            transport: function (params, success, failure) {
    var $request = $.ajax(params);

    $request.then(success);
    $request.fail(failure);

    return $request;
  },
            cache: true
        },
        minimumInputLength: 2
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

            };

</script>