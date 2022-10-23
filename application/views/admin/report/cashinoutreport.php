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
                                <div class="col-md-2">
                                    <select class="form-control" name="type" id="type">
                                        <option value="">--select Type--</option>
                                        <?php foreach ($transType AS $loc) { ?>
                                            <option value="<?php echo $loc->TransactionCode ?>"><?php echo $loc->TransactionName ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="emp" id="emp">
                                        <option value="">--select Employee--</option>
                                        <?php foreach ($salesperson AS $loc) { ?>
                                            <option value="<?php echo $loc->RepID ?>"><?php echo $loc->RepName ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" name="startdate" value="<?php echo date("Y-m-d") ?>"/>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control" name="enddate" value="<?php echo date("Y-m-d") ?>"/>
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
                                    <button type="submit" class="btn btn-flat btn-success">Show</button>
                                </div>
                                <div class="col-md-1">
                                    <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
                                </div>
                            </form>
                            
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
                                    <td>Float No</td>
                                    <td>Date</td>
                                    <td>Expense Type</td>
                                    <td>Remark</td>
                                    <td>Expense Amount</td>
                                    <td>Earning Amount</td>
                                    <td>User</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th id="totalca" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcra" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcrda" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcha" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcoa" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totala" style="text-align: right;color: #00aaf1;"></th>
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
 
    $('#filterform').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "loadreport10",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
                
                $('#totalcha').html(accounting.formatMoney(sumcolumn('totalamount')));
                $('#totalcoa').html(accounting.formatMoney(sumcolumn('totalneta')));
            }
        });
    });

    function drawTable(data) {
        for (var i = 0; i < data.length; i++) {
            drawRow(data[i]);
        }
    }
    function drawRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        var earn = 0;
        var exp = 0;
        if(rowData.Mode=='Out'){
            earn = 0;exp=rowData.CashAmount;
        }else if(rowData.Mode=='In'){
            exp = 0;earn=rowData.CashAmount;
        }
        row.append($("<td class='cashamount' align='right'>" + (rowData.InOutID) + "</td>"));
        row.append($("<td class='creditamount' align='right'>" + (rowData.InOutDate) + "</td>"));
        row.append($("<td class='ccardamount' align='right'>" + (rowData.Remark) + "</td>"));
        row.append($("<td class='chequeamount' align='right'>" +(rowData.Mode) + "</td>"));
        row.append($("<td class='totalamount' align='right'>" + accounting.formatMoney(exp) + "</td>"));
        row.append($("<td class='totalneta' align='right'>" + accounting.formatMoney(earn) + "</td>"));
        row.append($("<td class='disamount' align='right'>" + accounting.formatMoney(rowData.first_name) + "</td>"));
        
    }
    function sumcolumn(rclass) {
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
            prepend:"<h3 style='text-align:center'>Date vise Sales Report</h3><hr/>",
            title:'Date vise Sales Report'
        });
    }
</script>