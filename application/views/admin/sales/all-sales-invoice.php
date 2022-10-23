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
                            <b><span class="alert alert-success pull-left" id="lastProduct"></span></b>
                            <a href="<?php echo base_url('admin/Salesinvoice/job_invoice'); ?>"
                               class="btn btn-flat btn-primary pull-right">Add New Invoice</a>
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
	                        <td>Inv</td><td>Inv</td>
	                        <td>Job</td><td>Cus Code</td>
                            <td>Cus Code</td>
	                        <td>Customer</td> <td>Customer</td>
	                        <td>Reg No</td>
	                        <td>JInv Date</td>
	                        <td>Estimate</td>
	                        <td>Payment</td>
                            <td>Status</td>
                            <td>###</td>
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

                <!--  {"data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        if(row.IsPayment==0){
                        return '<a href="payment/job_payment/' + Base64.encode(row.JobInvNo) +'" class="btn btn-xs btn-primary" >Pay</a> &nbsp;';
                        }else{
                            return '<a href="#" disabled class="btn btn-xs btn-primary" >Pay</a> &nbsp;';
                        }
                    }
                } -->
</div>
<script type="text/javascript">
	var invoicetbl = $('#invoicetbl').dataTable({
	"processing": true,
	"serverSide": true,
	"order": [[8, "desc"]],
	"language": {
	    "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
	},
	"ajax": {
	    "url": "AllSalesinvoice/loadallinvoices",
	    "type": "POST"
	},
	"columns":
	        [
                {
                    <?php if (in_array("SM45", $blockView) || $blockView == null) { ?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return '<a href="Salesinvoice/view_invoice/' + Base64.encode(row.JobInvNo) + '" >' + row.JobInvNo + '</a>';
                    }
                    <?PHP  } else {?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return row.JobInvNo;
                    }
                    <?php }?>
                },
	            {"data": "JobInvNo","visible": false,"searchable": true},

                {
                    <?php if (in_array("M3", $blockView) || $blockView == null) { ?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return '<a href="<?php echo base_url() ?>admin/job/view_job_card/' + Base64.encode(row.JobCardNo) + '" >' + row.JobCardNo + '</a>';
                    }
                    <?PHP  } else {?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return row.JobCardNo;
                    }
                    <?php }?>
                },

	            {"data": "JobCardNo","visible": false,"searchable": true},

                {"data": "JCustomer"},
                {
                    <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.JCustomer) +'" >'+row.CusName+'</a>';
                    }
                    <?PHP  } else {?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return row.CusName;
                    }
                    <?php }?>
                },
                {"data": "DisplayName","visible": false,"searchable": true},
	            
	            {"data": "JRegNo"},
	            {"data": "JobInvoiceDate", searchable: false},
	            {"data": "JobEstimateNo", searchable: false},
                {"data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                if(row.IsPayment==1 && row.IsCompelte==1){
                                    return '<label class="label label-success">Complete</label>';
                                }else if(row.IsPayment==1){
                                    return '<label class="label label-danger">Credit</label>';
                                }else if(row.IsPayment==0){
                                    return '<label class="label label-warning">Pending</label>';
                                }else if(row.IsPayment==2){
                                    return '<label class="label label-danger">Canceled</label>';
                                }
                            }
                },
                {"data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                  if(row.IsCancel==1){
                                   return '<label class="label label-danger">Canceled</label>';
                                }else if(row.IsCancel==0){
                                    return '<label class="label label-success">Active</label>';
                                }
                            }
                },
	            {
                    <?php if (in_array("SM45", $blockEdit) || $blockEdit == null) { ?>
	                "data": null, orderable: false, searchable: false,
	                mRender: function (data, type, row) {
                        if(row.IsPayment==0 && row.IsCancel==0){
	                    return '<a href="Salesinvoice/job_invoice?type=inv&id=' + Base64.encode(row.JobInvNo) +'" class="btn btn-xs btn-default" >Edit</a> &nbsp;';
                        }else{
                            return '<a href="#" disabled class="btn btn-xs btn-default" >Edit</a> &nbsp;';
                        }
	                }
                    <?PHP  } else {?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        if(row.IsPayment==0 && row.IsCancel==0){
                            return '<a href="Salesinvoice/job_invoice?type=inv&id=' + Base64.encode(row.JobInvNo) +'" class="btn btn-xs btn-default" disabled>Edit</a> &nbsp;';
                        }else{
                            return '<a href="#" disabled class="btn btn-xs btn-default" >Edit</a> &nbsp;';
                        }
                    }
                    <?php }?>
	            },
                {
                    <?php if (in_array("SM45", $blockView) || $blockView == null) { ?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return '<a href="Salesinvoice/view_invoice/' + Base64.encode(row.JobInvNo) + '" class="btn btn-xs btn-default" >View</a> &nbsp;';
                    }
                    <?PHP  } else {?>
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return '<a href="Salesinvoice/view_invoice/' + Base64.encode(row.JobInvNo) + '" class="btn btn-xs btn-default" disabled>View</a> &nbsp;';
                    }
                    <?php }?>
                },
                {"data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        if(row.IsPayment==0 && row.IsCancel==0){
                        return '<a href="payment/job_payment/' + Base64.encode(row.JobInvNo) +'" class="btn btn-xs btn-primary" >Pay</a> &nbsp;';
                        }else{
                            return '<a href="#" disabled class="btn btn-xs btn-primary" >Pay</a> &nbsp;';
                        }
                    }
                }
	        ]
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