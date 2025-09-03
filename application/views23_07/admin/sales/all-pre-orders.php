<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">

</style>
<div class="content-wrapper" id="app">
    <section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <?php
                        if (in_array("SM43", $blockAdd) || $blockAdd == null) {
                            ?>
                            <!-- <b><span class="alert alert-success pull-left" id="lastProduct"></span></b>
                            <a href="<?php echo base_url('admin/Salesinvoice/job_invoice'); ?>"
                               class="btn btn-flat btn-primary pull-right">Add New Invoice</a> -->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" id="invoicetbl">
                    <thead>
                    <tr>

                        <td>Temp Order No</td>
                        <td>Order Date & Time</td>
                        <td>Sales Person</td>
                        <td>Route</td>
                        <td>Order Amount</td>

                        <td>Status</td>
                        <td>###</td>
                        <td>###</td>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </section>
</div>


<!--<script type="text/javascript">-->
<!--	var invoicetbl = $('#invoicetbl').dataTable({-->
<!--        "processing": true,-->
<!--        "serverSide": true,-->
<!--        "searching": true,-->
<!--        "order": [[6, "desc"]],-->
<!--        "language": {-->
<!--            "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"-->
<!--        },-->
<!--        "ajax": {-->
<!--            "url": "../Salesinvoice/loadallpreorders",-->
<!--            "type": "POST",-->
<!--        },-->
<!--        "columns": [-->
<!--            {"data": "tempInvNo","visible": true,"searchable": true},-->
<!--            {"data": "date","visible": true,"searchable": true},-->
<!--            {"data": "RepName","visible": true,"searchable": true},-->
<!--            {"data": "name","visible": true,"searchable": true},-->
<!--            -->
<!--            {"data": "grossAmount","visible": true,"searchable": false},-->
<!--            {"data": "isActive",-->
<!--                "render": function (data, type, row) {-->
<!--                    return data == 1 ? '<label class="label label-danger">pending</label>'-->
<!--                                    : '<label class="label label-success">Active</label>';-->
<!--                }-->
<!--            },-->
<!--            {-->
<!--                "data": "tempInvNo",-->
<!--                "render": function (data, type, row) {-->
<!--                    var encodedId = Base64.encode(data ? data.toString() : "");-->
<!--                    var disabled = --><?php //echo (in_array("SM42", $blockView) || $blockView == null) ? "false" : "true"; ?>//;
<!--//                    return `<a href="../Salesinvoice/view_sales_pre_orders/${encodedId}" class="btn btn-xs btn-default" ${disabled ? 'disabled="disabled"' : ''}>View</a>`;-->
<!--//                }-->
<!--//            }-->
<!--//        ]-->
<!--//    });-->
<!--//-->
<!--</script> -->

<script type="text/javascript">
    $(document).ready(function () {

        var invoicetbl = $('#invoicetbl').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [[0, "desc"]],
            "language": {
                "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
            },
            "ajax": {
                "url": "../Salesinvoice/loadallpreorders",
                "type": "POST"
            },
            "columns":
                [
                    {"data": "tempInvNo"},
                    {"data": "date"},
                    {"data": "RepName"},
                    {"data": "name"},
                    {
                        "data": "grossAmount",
                        "render": function (data, type, row) {
                            return parseFloat(data).toFixed(2);
                        }
                    },


                    {"data": "isActive",
                        "render": function (data, type, row) {
                            return data == 1 ? '<label class="label label-danger">pending</label>'
                                : '<label class="label label-success">Invoiced</label>';
                        }
                    },


                    {
                        "data": "tempInvNo",
                        "render": function (data, type, row) {
                            var encodedId = Base64.encode(data ? data.toString() : "");
                            var disabled = <?php echo (in_array("SM42", $blockView) || $blockView == null)  ? "false" : "true"; ?>;
                            if (disabled || row.isActive == 0){
                                return `<a href="#" class="btn btn-xs btn-default" disabled="disabled" title="Blocked or Already Active">Save Invoice</a>`;
                            } else {
                                return `<a href="../Salesinvoice/addPreSalesInvoice/${encodedId}" class="btn btn-xs btn-default">Save Invoice</a>`;

                            }
                        }
                    },

                    {
                        "data": "tempInvNo",
                        "render": function (data, type, row) {
                            var encodedId = Base64.encode(data ? data.toString() : "");
                            var disabled = <?php echo (in_array("SM42", $blockView) || $blockView == null) ? "false" : "true"; ?>;
                            return `<a href="../Salesinvoice/view_sales_pre_orders/${encodedId}" class="btn btn-xs btn-default" ${disabled ? 'disabled="disabled"' : ''}>View</a>`;
                        }
                    }

                ]
        });
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