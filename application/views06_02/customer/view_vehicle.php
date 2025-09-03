<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper"> 
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <button onclick="addm()" class="btn btn-flat btn-primary pull-right">Create Customer</button>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr><td>Vehicle No</td><td>:</td><td><?php echo $regno; ?></td></tr>
                                <tr><td>Make</td><td>:</td><td><?php echo $vehi->make; ?></td></tr>
                                <tr><td>Model</td><td>:</td><td><?php echo $vehi->model; ?></td></tr>
                                <tr><td>Chassis No</td><td>:</td><td><?php echo $vehi->ChassisNo; ?></td></tr>
                                <tr><td>Service Interval</td><td>:</td><td><?php echo $vehi->EngineNo; ?></td></tr>
                                <tr><td>Last Mileage</td><td>:</td><td><?php if($lastserv){echo $lastserv->OdoOut;} ?> KM</td></tr>
                                <tr><td>Last Service</td><td>:</td><td><?php if($lastserv){echo $lastserv->Date;} ?></td></tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Date</th><th>Customer</th><th>Job No</th><th>Service Advisor</th><th></th></tr>
                            </thead>
                            <tbody>

                                <?php if ($jobs) { ?>
                                   
                                <?php foreach ($jobs as $job): ?>
                                    <tr><td><?php echo $job->appoimnetDate; ?></td><td><a href="../../payment/view_customer/<?php echo base64_encode($job->JCustomer) ?>"><?php echo $job->DisplayName; ?></a></td><td><a href="../../job/view_job_card/<?php echo base64_encode($job->JobCardNo) ?>"><?php echo $job->JobCardNo; ?></a></td><td><?php echo $job->first_name." ".$job->last_name; ?></td></tr>
                                <?php endforeach; }?>
                                
                            </tbody>
                        </table>

                        <table id="tbl_est_data" style="font-family: Arial, Helvetica, sans-serif;border-collapse:collapse;width:100%;padding:5px;font-size:13px; " align="center" border="0"> 
                          <tbody>
                            <tr style="background-color:#5d5858 !important;">
                                  <td style="font-weight:bold;color:#fff !important;">Date</td>
                                  <td colspan="2" style="font-weight:bold;color:#fff !important;">Item & Description</td>
                                  <!-- <td style="width:150px;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;"></td> -->
                                  <td style="font-weight:bold;color:#fff !important;">Qty</td>
                                  <!-- <td style="font-weight:bold;color:#fff !important;" class='text-right'>Rate</td> -->
                                  <!-- <td style="width:50px;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;" class='text-right'></td> -->
                                  <!-- <td colspan="2" style="font-weight:bold;color:#fff !important;" class='text-right'>Amount</td> -->
                            </tr>
                          <?php $i=1;
                          // var_dump($invDtl);die;
                                 foreach ($invDtl AS $key=>$invdata) {
                                 // if($key!='PARTS2'){ ?>
                                <tr style="background-color:#e4dbdb !important;color:#000 !important;"><td style=""></td><td colspan="2" style=""><b><?php echo $key?></b></td><td style=""></td><td style=""></td><td colspan="2" style=""></td></tr>
                                       <?php  foreach ($invdata AS $inv) { ?>
                                <tr  style="">
                                  <td style="border-bottom:1px dotted #e4dbdb;"><?php echo $inv->JobinvoiceTimestamp?></td>
                                  <td colspan="2"  style="border-bottom:1px dotted #e4dbdb;"><?php echo $inv->JobDescription?></td>
                                  <td class='text-right'  style="border-bottom:1px dotted #e4dbdb;"><?php echo number_format($inv->JobQty,2)?></td>
                                  <!-- <td class='text-right'  style="border-bottom:1px dotted #e4dbdb;"><?php //echo number_format($inv->JobPrice,2)?></td> -->
                                  <!-- <td class='text-right' colspan="2"  style="border-bottom:1px dotted #e4dbdb;"><?php //echo number_format($inv->JobTotalAmount,2)?></td> -->
                                </tr>
                                       <?php $i++; } ?>
                            <?php  } ?>
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
            "order": [[0, "desc"]],
            "language": {
                "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
            },
            "ajax": {
                "url": "allVehicles",
                "type": "POST"
            },
            "columns":
                    [
                        {"data": "RegNo"},
                        {"data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<a href="<?php echo base_url() ?>admin/payment/view_customer/' + (row.CusCode) +'" >'+row.CusName+'</a>';
                            }
                        },
                        {"data": "CusName","visible": false,"searchable": true},
                        {"data": "model", searchable: false},
                        {"data": "MobileNo"},
                        {"data": "contactName", searchable: false},
                        {"data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<a href="../job/index/'+ Base64.encode(row.RegNo) +'" class="btn btn-xs btn-success" >Add Job</a>';
                            }
                        },
                        {"data": null, orderable: false, searchable: false,
                            mRender: function (data, type, row) {
                                return '<a href="../job/estimate_job?type=cus&ccode='+ Base64.encode(row.CusCode) +'&regno='+ Base64.encode(row.RegNo) +'" class="btn btn-xs btn-success" >Add Estimate</a>';
                            }
                        }
                    ]
    });

    function editm(d) {
        $('.modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_customeredit/' + d, function (result) {
            $('#customermodal').modal({show: true});
        });
    }
    function addm() {
        $('.modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_customeradd/', function (result) {
            $('#customermodal').modal({show: true});
        });
    }
    function addvehiclem(v) {
        $('.modal-content').load('<?php echo base_url() ?>admin/customer/loadmodal_vehicleadd/'+ v, function (result) {
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