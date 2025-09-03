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
                                            <option value="">--select customer--</option>
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
                                    <div class="col-md-3" style='display:none'>
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
                                        </select>
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
                    <div class="col-md-10"><span class="pull-right" id="a">DATE : <?php echo date('Y-m-d');?></span><br>
                    <!-- <span id="cusName"></span><br>
                    <span id="address1"></span>
                    <span id="address2"></span> -->
                </div>
                    <!-- <div class="col-md-5">DATE : <?php echo date('Y-m-d');?></div> -->
                     <div class="col-md-1">&nbsp;</div>
                     </div>
                     <div class="row">
                    <div class="box-body table-responsive">
                        <table id="saletable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Name</td>
                                    <td>Vehicle</td>
                                    <td>Address</td>
                                    <!-- <td>Cost Price</td> -->
                                    <td>Phone</td>
                                   <!--  <td>Settled Amount</td>
                                    
                                    <td>Due Outstanding</td> -->
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
                                    <th></th> 
                                    <th></th>
                                    <th></th>
                                    <th></th><!-- 
                                    <th></th>
                                    <th></th> -->
                                   <!--  <th  colspan="2" style="text-align: right;">Total Outstanding</th>
                                    <th id="totalpr" style="text-align: right;color: #00aaf1;"></th> -->
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
            url: "loadcustomersummary",
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

    function drawTable(data) {
        for (var i = 0; i < data.length; i++) {
            drawRow(data[i],i);
        }
    }
    function drawRow(rowData,n) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        
        row.append($("<td>" + (n+1) + "</td>"));
        row.append($("<td class='cashamount' align='left'>" + rowData.RespectSign+". "+rowData.CusName + "</td>"));
        row.append($("<td class='creditamount' align='left'>" + (rowData.RegNo) + "</td>"));
        row.append($("<td class='ccardamount' align='left'>" +(rowData.Address01) + "</td>"));
        row.append($("<td class='costamount' align='left'>" + rowData.MobileNo+", "+rowData.LanLineNo + "</td>"));
        
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
        placeholder: "Select a customer",
        allowClear: true,
        ajax: {
            url: "customerjson",
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

</script>