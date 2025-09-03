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
                                <div class="col-md-4">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" name="startdate" value="<?php echo date("Y-m-d") ?>"/>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control" name="enddate" value="<?php echo date("Y-m-d") ?>"/>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <select class="form-control" name="route" id="route" multiple="multiple">
                                        <option value="">--select location--</option>
                                        <?php foreach ($locations AS $loc) { ?>
                                            <option value="<?php echo $loc->location_id ?>"><?php echo $loc->location ?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" name="route_ar" id="route_ar">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-flat btn-success">Show</button>
                                </div>
                            </form>
                            <div class="col-md-2">
                                <button onclick="printdiv()" class="btn btn-flat btn-default">Print</button>
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
                                    <td>Float No</td>
                                    <td>Date</td>
                                    <td>Mode</td>
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
            url: "loadreport9",
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
        var earntot = 0;
        var exptot = 0;
        $.each(data, function (key, value) {
            $("#saletable").append("<tr style='background-color:#00a678;color:#fff;'><td colspan='7'><b>" + key + "</b></td></tr>");
            for (var i = 0; i < value.length; i++) {
                drawRow(value, i);

                if(value[i].Mode=='Out'){
                    earntot += 0; exptot += parseFloat(value[i].CashAmount);
                }else if(value[i].Mode=='In'){
                    exptot += 0; earntot += parseFloat(value[i].CashAmount);
                }

                if (i == (value.length - 1)) {
                    $("#saletable").append("<tr style='background-color:#A9A9A9;color:#fff;'><td align='right' colspan='4' >Total</td><td align='right'><b>" + accounting.formatMoney(exptot) + "</b></td><td align='right'><b>" + accounting.formatMoney(earntot) + "</b></td><td><b></b></td></tr>");
                    $("#saletable").append("<tr><td colspan='7'>&nbsp;</td></tr>");
                    earntot = 0;
                    exptot = 0;
                }
            }
        });

    }
    function drawRow(rowData, index) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        var earn = 0;
        var exp = 0;
        if(rowData[index].Mode=='Out'){
            earn = 0;exp=rowData[index].CashAmount;
        }else if(rowData[index].IsExpenses=='In'){
            exp = 0;earn=rowData[index].CashAmount;
        }
        row.append($("<td class='cashamount' align='right'>" + (rowData[index].InOutID) + "</td>"));
        row.append($("<td class='creditamount' align='right'>" + (rowData[index].InOutDate) + "</td>"));
        row.append($("<td class='ccardamount' align='right'>" + (rowData[index].Mode) + "</td>"));
        row.append($("<td class='chequeamount' align='right'>" +(rowData[index].Remark) + "</td>"));
        row.append($("<td class='totalamount' align='right'>" + accounting.formatMoney(exp) + "</td>"));
        row.append($("<td class='totalneta' align='right'>" + accounting.formatMoney(earn) + "</td>"));
        row.append($("<td class='disamount' align='right'>" + rowData[index].first_name + "</td>"));
        
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
            prepend:"<h3 style='text-align:center'>Date vise cash float Report</h3><hr/>",
            title:'Date vise Sales Report'
        });
    }
</script>