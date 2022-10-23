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
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="hidden" class="form-control" name="startdate" id="startdate" >

                                    <input type="hidden" class="form-control" name="enddate" id="enddate" >
                                </div>
                                <div class="col-lg-3">
                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span>
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <select class="form-control" name="route" id="route" multiple="multiple">
                                        <option value="">--select location--</option>
                                        <?php foreach ($locations AS $loc) { ?>
                                            <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" name="route_ar" id="route_ar">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="salesperson" id="salesperson">
                                        <option value="">--select sales person--</option>
                                        <?php foreach ($staff AS $loc) { ?>
                                            <option value="<?php echo $loc->RepID ?>"><?php echo $loc->RepName ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="inv_type" id="inv_type">
                                        <option value="">--select inv type--</option>
                                        <option value="2">Tax</option>
                                        <option value="1">General</option>
                                        <option value="3">Credit</option>
                                    </select>
                                </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="product" id="product">
                                            <option value="">--select product--</option>
                                            <?php foreach ($products AS $prd) { ?>
                                                <option value="<?php echo $prd->ProductCode ?>"><?php echo $prd->Prd_Description; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="route_ar" id="route_ar">
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="department" id="department">
                                                <option value="">--select a department--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="subdepartment" id="subdepartment">
                                                <option value="">--select a sub department--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="subcategory" id="subcategory" multiple>
                                                <!--<option value="">--select a sub category--</option>-->
                                            </select>
                                            <input type="hidden" name="subcategory_ar" id="subcategory_ar">
                                        </div>
                                    </div>
                                    <div class="col-md-3" >

                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-flat btn-success">Show</button>
                                    </div>
<!--                                    <div class="col-md-1">-->
<!--                                        <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>-->
<!--                                    </div>-->
                            </form>
                            <div class="col-md-1">
                                <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                            </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body table-responsive">
                        <table id="saletable" class="table table-bordered">
                            <thead>
                            <tr>
                                <td>Inv. Date</td>
                                <td>Customer</td>
                                <td>Inv No</td>
                                <td>Product</td>
<!--                                <td>Total Amount</td>-->
                                <td>Total Amount</td>
                                <td>Dis Amount</td>
                                <td>Vat Amount</td>
                                <td>Nbt Amount</td>
                                <td>net Amount</td>
<!--                                <td>Card Amount</td>-->
<!--                                <td>Cheque Amount</td>-->
<!--                                <td>Advance Amount</td>-->
<!--                                <td>Credit Amount</td>-->
<!--                                <td>Return</td>-->
<!--                                <td>Settled Amount</td>-->
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
<!--                                <th id="totala" style="text-align: right;color: #00aaf1;"></th>-->
                                <th id="totalca" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totaldia" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalvata" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalnbta" style="text-align: right;color: #00aaf1;"></th>                               
                                <th id="totalneta" style="text-align: right;color: #00aaf1;"></th>
                              
<!--                                <th id="totalcrda" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalcha" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalada" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalcra" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalrt" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalsettlle" style="text-align: right;color: #00aaf1;"></th>-->

                            </tr>
                            <tr>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
<!--                                <td></td>-->
<!--                                <td></td>-->
<!--                                <td></td>-->
<!--                                <td></td>-->
<!--                                <td></td>-->
<!--                                <td></td>-->
<!--                                <td></td>-->
                                <td colspan="4"></td>
                                <td id="totalDue" style="color:#f00;font-weight:bold" colspan="2"></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--print view modal-->
        <div id="salesbydateprint" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- load data -->
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
    var loc =[];
    $("#route").change(function(){
        loc.length=0;

        $("#route :selected").each(function(){
            loc.push($(this).val());
        });
        $("#route_ar").val(JSON.stringify(loc));
    });

    $('#product').select2();

    $('#filterform').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "loadreportdirectproductby",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
                $('#totalca').html(accounting.formatMoney(sumcolumn('cashamount')));
                $('#totalcoa').html(accounting.formatMoney(sumcolumn('costamount')));
                $('#totaldia').html(accounting.formatMoney(sumcolumn('disamount')));
                $('#totalvata').html(accounting.formatMoney(sumcolumn('vatamount')));
                $('#totalnbta').html(accounting.formatMoney(sumcolumn('nbtamount')));
                $('#totalneta').html(accounting.formatMoney(sumcolumn('netamount')));

            }
        })
    });

    function drawTable(data) {
        for (var i = 0; i < data.length; i++) {
            drawRow(data[i]);
        }
    }
    function drawRow(rowData) {
        var row = $("<tr/>");

        $("#saletable").append(row);

        row.append($("<td>" + rowData.InvDate + "</td>"));

        row.append($("<td><a href='<?php echo base_url() ?>admin/payment/view_customer/" + (rowData.CusCode) +"' >" + rowData.RespectSign +" "+rowData.CusName+ "</a></td>"));

        row.append($("<td><a href='<?php echo base_url() ?>admin/Salesinvoice/view_sales_invoice/"+Base64.encode(rowData.SalesInvNo)+"' >" + rowData.SalesInvNo + "</a></td>"));
        row.append($("<td class='' align='right'>" + rowData.ProName + "</td>"));

        row.append($("<td class='cashamount' align='right'>" + accounting.formatMoney(rowData.CashAmount) + "</td>"));
        row.append($("<td class='disamount' align='right'>" + accounting.formatMoney(rowData.DisAmount) + "</td>"));
        row.append($("<td class='vatamount' align='right'>" + accounting.formatMoney(rowData.VatAmount) + "</td>"));
        row.append($("<td class='nbtamount' align='right'>" + accounting.formatMoney(rowData.NbtAmount) + "</td>"));
        row.append($("<td class='netamount' align='right'>" + accounting.formatMoney(rowData.NetAmount) + "</td>"));

    }

    function sumcolumn(rclass){
        var sum = 0;
        var elemnt = document.getElementsByClassName(rclass);
        $(elemnt).each(function () {
            var value = accounting.unformat($(this).text());

            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        return sum;
    }

    function loadprint() {
        $('.modal-content').load('<?php echo base_url() ?>admin/report/', function (result) {
            $('#salesbydateprint').modal({show: true});
        });
    }

    function printdiv() {
        $("#saletable").print({
            prepend:"<h3 style='text-align:center'>Product vise Sales Report</h3><hr/>",
            title:'Date vise Sales Report'
        });
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

    $("#subcategory").select2({
        placeholder: "Select a sub Category",
        allowClear: true,
        ajax: {
            url: "subcategoryjson",
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
            cache: true
        },
        minimumInputLength: 2
    });

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