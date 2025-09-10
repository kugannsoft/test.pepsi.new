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
                        <form id="filterform">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" class="form-control" name="startdate"  value="<?php echo date("Y-m-d") ?>"/>
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="form-control" name="enddate"  value="<?php echo date("Y-m-d") ?>"/>
                                        </div>
                                        <input type="hidden" class="form-control" required="required"  name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="isall" class="control-label">
                                            <input class="rpt_icheck" type="checkbox" checked="" name="isall">
                                            All
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select tabindex="3" class="form-control" name="location_from" id="location_from">
                                            <option value="">Select from location</option>
                                            <?php foreach ($locations AS $loc) { ?>
                                                <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="productsearch" id="productsearch">
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control"  name="supplier" id="supplier">
                                        <option value="">--select a supplier--</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-flat btn-success">Show</button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group input-group">
                                        <!-- <select tabindex="3" class="form-control" name="location_from" id="location_from">
                                                <option value="">Select from location</option>
                                        <?php foreach ($locations AS $loc) { ?>
                                            <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                        <?php } ?>
                                            </select> -->
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group"></div>
                                    </div>
                                </div>
                                <div class="col-md-3" >
                                    <!--<button type="reset" class="btn btn-flat btn-danger">Reset</button>-->
                                </div>
                            </div></form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body  table-responsive">
                        <table id="saletable" class="table table-bordered  table-hover">
                            <thead>
                            <tr style="font-size: large">
                                <td>#</td>
                                <!-- <td>Date</td> -->
                                <td>Product Code</td>
                                <td>Product Name</td>
                                <td>Qty</td>
                                <td>Free Qty</td>
<!--                                <td>Cost Price</td>-->
                                <td>Total Amount</td>
                                <td>Discount</td>
                                <td>Total Net</td>
                                <td>Selling Price</td>
                                <!-- <td>Profit</td>
                                <td>User</td>
                                <td>Stock In</td> -->
                                <td>Is Cancel</td>
                                <td>Serial no</td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr style='background-color:#3c8dbc;color:#fff;'>
                                <!-- <td></td> -->
                                <td></td>
                                <td></td>
                                <td><b>Total</b></td>
                                <td id="totalstock"></td>
<!--                                <td></td>-->
                                <td></td>
                                <td id="totalvalue"></td>
                                <td id="totaldis"></td>
                                <td id="totalprofit"></td>
                                <td></td>
                                <td></td>
                                <td></td>
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

    var loc = $("#location").val();

    $("#location_to option").each(function() {
        if ($(this).val() == loc) {
            $(this).attr('disabled', true);
            $("#location_to").val('');
        }
    });

    $("#location_from").change(function() {
        var selval = $(this).val();
        $("#location_to option").each(function() {
            $(this).attr('disabled', false);
            if ($(this).val() == selval) {
                $(this).attr('disabled', true);
                $("#location_to").val('');
            }
        });
    });

    $('.rpt_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    var dep = 0;
    var subdep = 0;
    $("#productsearch").select2({
        placeholder: "Select a product",
        allowClear: true,
        ajax: {
            url: "productjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    $("#supplier").select2({
        placeholder: "Select a supplier",
        allowClear: true,
        ajax: {
            url: "supplierjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    $("#department").select2({
        placeholder: "Select a Department",
        allowClear: true,
        ajax: {
            url: "departmentjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });
    $("#department").change(function(){
        dep = $("#department option:selected").val();
        $("#subdepartment").select2('val','');

    });

    $("#subdepartment").change(function(){
        subdep = $("#subdepartment option:selected").val();
        $("#subcategory").select2('val','');

    });

    $("#subdepartment").select2({
        placeholder: "Select a Sub Department",
        allowClear: true,
        ajax: {
            url: "subdepartmentjson",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    dep :dep
                };
            },
            processResults: function (data) {
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
            data: function (params) {
                return {
                    q: params.term,
                    dep :dep,
                    subdep :subdep
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });


    $('#filterform').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "grnreportjson",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
            }
        });
    });
    var totalCostValue=0;
    var totalValue=0;
    var totalProfit=0;
    function drawTable(data) {
        var gr_qty = 0;
        var gr_net = 0;
        totalCostValue = 0;
        totalValue=0;
        totalProfit=0;
        totalStock=0;
        totalDis=0;
        $("#totalcost").html(0);
        $("#totalvalue").html(0);
        $("#totalprofit").html(0);
        $("#totalstock").html(0);
        $.each(data, function(key, value) {
            $("#saletable").append("<tr  ><td colspan='12'><b>"+key+"</b></td></tr>");
            for (var i = 0; i < value.length; i++) {
                drawRow(value,i);
                gr_qty += parseFloat(value[i].GRN_Qty);
                gr_net += parseFloat(value[i].GRN_NetAmount);

                totalStock+=(parseFloat(value[i].GRN_Qty));
                totalCostValue+=(parseFloat(value[i].GRN_UnitCost));
                totalValue+=(parseFloat(value[i].GRN_Amount));
                totalProfit+=(parseFloat(value[i].GRN_NetAmount));
                totalDis+=(parseFloat(value[i].GRN_DisAmount));
                $("#totaldis").html(accounting.formatMoney(totalDis));
                $("#totalcost").html(accounting.formatMoney(totalCostValue));
                $("#totalvalue").html(accounting.formatMoney(totalValue));
                $("#totalprofit").html(accounting.formatMoney(totalProfit));
                $("#totalstock").html(accounting.formatMoney(totalStock));
                if (i == (value.length - 1)) {
                    $("#saletable").append("<tr style='background-color:#A9A9A9;color:#fff;'><td colspan='3' >Total</td><td>" + accounting.formatMoney(gr_qty) + "</td><td><b></b></td><td class='cos'></td><td><b></b></td><td><b>" + accounting.formatMoney(gr_net) + "</b></td><td><b></b></td><td></td><td><b></b></td></tr>");
                    $("#saletable").append("<tr><td colspan='11'>&nbsp;</td></tr>");
                    gr_qty = 0;
                    gr_net = 0;
                }
            }
        });
    }

    function drawRow(rowData,index) {

        if(parseFloat(rowData[index].Stock) < rowData[index].Prd_ROL){
            var row = $("<tr class='stockout'>");
        }else{
            var row = $("<tr>");
        }
        var stockIn = "";
        if(rowData[index].TransIsInProcess==1){
            stockIn = "<span class='label label-warning'>Pending</span>";
        }else if(rowData[index].TransIsInProcess==0){
            stockIn = "<span class='label label-success'>Success</span>";
        }

        var cancel = "";
        if(rowData[index].GRN_IsCancel==1){
            cancel = "<span class='label label-danger'>Canceled</span>";
        }else if(rowData[index].GRN_IsCancel==0){
            cancel = "<span class='label label-success'>Active</span>";
        }
        var date = new Date(rowData[index].TransDate);
        $("#saletable").append(row);
        row.append($("<td>" + (index+1) + "</td>"));
        row.append($("<td>" + rowData[index].GRN_Product + "</td>"));
        row.append($("<td>" + rowData[index].Prd_Description + "</td>"));
        row.append($("<td>" + rowData[index].GRN_Qty + "</td>"));
        row.append($("<td>" + rowData[index].GRN_FreeQty + "</td>"));
        row.append($("<td>" + accounting.formatMoney(rowData[index].GRN_Amount) + "</td>"));
        row.append($("<td>" + rowData[index].GRN_DisAmount + "</td>"));
        row.append($("<td>" + rowData[index].GRN_NetAmount + "</td>"));
        row.append($("<td>" + rowData[index].GRN_Selling + "</td>"));
        row.append($("<td>" + cancel + "</td>"));
        row.append($("<td>" + rowData[index].SerialNo + "</td>"));
    }
    function printdiv() {
        $("#saletable").print({
            prepend: "<h3 style='text-align:center'>Product Detail Report</h3><hr/>",
            title: 'Date vise Sales Report'
        });
    }

    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var day = date.getDate();
        var month = (date.getMonth()+1);
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        hours = hours <10 ? '0'+hours : hours;
        day = day <10 ? '0'+day : day;
        month = month <10 ? '0'+month : month;
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return  date.getFullYear()+"-"+ month + "-" + day + " " + strTime;
    }
</script>