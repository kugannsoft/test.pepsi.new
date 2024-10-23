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
                <div class="box">
                    <div class="box-body">
                        <?php if (in_array("SM21", $blockAdd) || $blockAdd == null) { ?>
                            <button onclick="addm()" class="btn btn-flat btn-primary pull-right">Create Customer
                            </button>
                            <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="customertbl">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Name</td>
                                <td>NIC</td>
                                <td>No</td>
                                <td>Phone</td>
                                <td>Credit Limit</td>
                                <td>###</td>
                                <td>###</td>
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
            </div>
        </div>
    </section>
</div>
<div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
            <!-- load data -->
        </div>
    </div>
</div>

<script>
    var customertbl = $('#customertbl').dataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "desc"]],
        "language": {
            "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
        },
        "ajax": {
            "url": "allCustomers",
            "type": "POST"
        },
        "columns": [

            {
                <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '" >' + row.CusCode + '</a>';
                }
                <?PHP  } else {?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return row.CusCode;
                }
                <?php }?>
            },
            {"data": "CusCode", "visible": false, "searchable": true},

            {
                <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '" >' + row.CusName + '</a>';
                }
                <?PHP  } else {?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return row.CusName;
                }
                <?php }?>
            },
            {"data": "CusName", "visible": false, "searchable": true},
            {"data": "Nic", searchable: true},
            {"data": "CusBookNo"},
            {"data": "MobileNo"},
            {"data": "CreditLimit", searchable: false},
            {
                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    if (row.IsActive == 1) {
                        return '<span class="label label-xs label-success" >Active</span>';
                    } else if (row.IsActive == 0) {
                        return '<span class="label label-xs label-danger" >Inactive</span>';
                    }

                }
            },
            {
                <?php if (in_array("SM22", $blockAdd) || $blockAdd == null) { ?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<a href="<?php echo base_url() ?>admin/job/?ccode=' + Base64.encode(row.CusCode) + '"  class="btn btn-xs btn-info" >Job</a>';
                }
                <?PHP  } else {?>
                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<a href="<?php echo base_url() ?>admin/job/?ccode=' + Base64.encode(row.CusCode) + '"  class="btn btn-xs btn-info" disabled>Job</a>';
                }
                <?php }?>
            },
            {
                <?php if (in_array("SM21", $blockEdit) || $blockEdit == null) { ?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<button onclick="editm(\'' + row.CusCode + '\')" class="btn btn-xs btn-default" >Edit</button>';
                }
                <?PHP  } else {?>
                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<button onclick="editm(\'' + row.CusCode + '\')" class="btn btn-xs btn-default" disabled>Edit</button>';
                }
                <?php }?>
            },
            {
                <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '"  class="btn btn-xs btn-default" >View</a>';
                }
                <?PHP  } else {?>
                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '"  class="btn btn-xs btn-default" disabled>View</a>';
                }
                <?php }?>
            },
            {
                <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>

                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                   if (row.IsActive == 0) {
                    return '<button value="' + row.CusCode + '" id="' + row.CusCode + '"  Class="delete btn btn-xs btn-danger">Delete</button> &nbsp;';
                } else {
                    return '<button value="' + row.CusCode + '" id="' + row.CusCode + '" Class="delete btn btn-xs btn-danger" disabled>Delete</button> &nbsp;';
                        }
                }
                <?PHP  } else {?>
                "data": null, orderable: false, searchable: false,
                mRender: function (data, type, row) {
                    return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) + '"  class="btn btn-xs btn-default" disabled>View</a>';
                }
                <?php }?>
            }
        ]
    });

    $(document).on('click', '.delete', function () {
        var id = $(this).attr("id");
        if (confirm("Are you want to Delete Customer ? Please Check this customer have Invoices or Not")){
            $.ajax({
                type: "post",
                url: "../Customer/cancel_syn_customer",
                data: {id: id},
                success: function (json) {
                    location.reload();
                }
            });
        }else {

        }
    });

    function editm(d) {
        $('.modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_customeredit/' + d, function (result) {
            $('#customermodal').modal({show: true});
        });
    }
    function addm() {
        $('.modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_customeradd/', function (result) {
            $('#customermodal').modal({show: true, backdrop: 'static', keyboard: false});
        });
    }
    function addvehiclem(v) {
        $('.modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_vehicleadd/' + v, function (result) {
            $('#customermodal').modal({show: true});
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

    };
</script>