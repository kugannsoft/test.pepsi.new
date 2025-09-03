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
                                        <input type="hidden" class="form-control" name="startdate" value="<?php echo date("Y-m-d") ?>"/>
                                        <!-- <span class="input-group-addon">to</span> -->
                                        <input type="text" class="form-control" name="enddate"  id="enddate" value="<?php echo date("Y-m-d") ?>"/>
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
        <div class="row" id="printReport">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body table-responsive">
                        <b>Balance</b> : <span id='startBal' style='font-weight:bold;font-size:20px;'></span>
                        <table id="saletable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Date</td>
                                    <td>Invoice No</td>
                                    <td>Vehicle No</td>
                                    <!-- <td>Job</td> -->
                                    <td colspan="10">Job Description</td>
                                    <!-- <td>Credit Amount</td>
                                    <td>Card Amount</td>
                                    <td>Cheque Amount</td> -->
                                    <!-- <td>Company Amount</td> -->
                                   <!--  <td>Total Amount</td>
                                    <td>Dis Amount</td>
                                    <td>Advance</td>
                                    <td>VAT</td> -->
                                    <!-- <td></td> -->
                                    <td>Amount</td>
                                    <!-- <td>Return</td> -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right;color: #00aaf1;" colspan="10"></th>
                                    <!-- <th id="totalcra" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcrda" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcha" style="text-align: right;color: #00aaf1;"></th> -->
                                    <!-- <th id="totalcoa" style="text-align: right;color: #00aaf1;"></th> -->
                                    <!-- <th id="totala" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totaldia" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalneta" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalvata" style="text-align: right;color: #00aaf1;"></th> -->
                                    <!-- <th id="totalnbta" style="text-align: right;color: #00aaf1;"></th> -->
                                    <th id="totalpr" style="text-align: right;color: #00aaf1;"></th>
                                    <!-- <th id="totalrt" style="text-align: right;color: #00aaf1;"></th> -->
                                </tr>
                            </tfoot>
                        </table>
                        <table id="saletable2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> -->
                                    <td colspan="12" style="text-align: right;"></td>
                                    <td style="text-align: right;">Total Cash Sale</td>
                                    <td style="text-align: right;" id="cashSale"></td>
                                </tr>
                                <tr>
                                    <!-- <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> -->
                                    <td colspan="12" style="text-align: right;">Remark</td>
                                    <td style="text-align: right;">Cash In</td>
                                    <td style="text-align: right;">Cash Out</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
            url: "loadjobdaysalesum",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody,#saletable2 tbody').empty();
                drawTable(JSON.parse(data));

                $('#totalca').html(accounting.formatMoney(sumcolumn('cashamount')));
                $('#totalcra').html(accounting.formatMoney(sumcolumn('creditamount')));
                $('#totalcrda').html(accounting.formatMoney(sumcolumn('ccardamount')));
                $('#totalcha').html(accounting.formatMoney(sumcolumn('chequeamount')));
                $('#totalcoa').html(accounting.formatMoney(sumcolumn('costamount')));
                $('#totala').html(accounting.formatMoney(sumcolumn('totalamount')));
                $('#totaldia').html(accounting.formatMoney(sumcolumn('disamount')));
                $('#totalneta').html(accounting.formatMoney(sumcolumn('netamount')));
                $('#totalvata').html(accounting.formatMoney(sumcolumn('vatamount')));
                $('#totalnbta').html(accounting.formatMoney(sumcolumn('nbtamount')));
                $('#totalpr').html(accounting.formatMoney(sumcolumn('profit')));
                
            }
        })
    });
    var startBalance = 0;
    var totalCashIn=0;
    var totalCashOut=0;
    var totalSale = 0;
    var cashinhand=0;
    var totalCash=0;
    var posCash = 0;
    var prevjobSale=0;
    var prevposSale = 0;
    var totalNetSale=0;
    function drawTable(data) {
        startBalance = 0;
        totalCashIn=0;
        totalCashOut=0;
        totalSale = 0;
        cashinhand=0;
        totalCash=0;
        posCash = 0;
        prevjobSale=0;
        prevposSale = 0;
        totalNetSale=0;
     $("#startBal").html(accounting.formatMoney(startBalance));
        for (var i = 0; i < data.pro.length; i++) {
            drawRow(data.pro[i]);
        }

        for (var i = 0; i < data.product.length; i++) {
            drawProductRow(data.product[i]);
        }

        for (var i = 0; i < data.procash.length; i++) {
            posCash+=parseFloat(data.procash[i].CashAmount);
        }

        for (var i = 0; i < data.prevcash.length; i++) {
            prevjobSale+=parseFloat(data.prevcash[i].NetAmount);
        }

        for (var i = 0; i < data.prevprocash.length; i++) {
            prevposSale+=parseFloat(data.prevprocash[i].NetAmount);
        }

        for (var i = 0; i < data.inout.length; i++) {
            drawRowOut(data.inout[i]);
        }

        for (var i = 0; i < data.bal.length; i++) {
           startBalance=parseFloat(data.bal[i].BALANCE_AMOUNT);
        }

        for (var i = 0; i < data.cash.length; i++) {
           totalCash+=parseFloat(data.cash[i].JobInvPayAmount);
        }

        $("#startBal").html(accounting.formatMoney(startBalance));
        $("#cashSale").html(accounting.formatMoney(posCash+totalCash));
        cashinhand =startBalance+totalCash+posCash-totalCashOut+totalCashIn;
        totalNetSale = totalSale + prevjobSale+prevposSale;
        
        $("#saletable2 tbody").append("<tr><td colspan='13' class='text-right' style='font-weight:bold;font-size:16px;'>Cash In Hand</td><td class='text-right'  style='font-weight:bold;font-size:16px;'>"+ accounting.formatMoney(cashinhand)+"</td></tr><tr><td colspan='13' class='text-right'>&nbsp;</td><td class='text-right'></td></tr><tr><td colspan='13' class='text-right' style='font-weight:bold;font-size:16px;'>Total Sale</td><td class='text-right'  style='font-weight:bold;font-size:16px;'>"+ accounting.formatMoney(totalNetSale)+"</td></tr>");

    }

    function drawRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.NetAmount);
        
        row.append($("<td>" + rowData.InvDate + "</td>"));
        row.append($("<td>" + rowData.JobInvNo + "</td>"));
        row.append($("<td>" + rowData.JRegNo + "</td>"));
        row.append($("<td colspan='10' align='left'>" + rowData.JobDescription + "</td>"));
        row.append($("<td class='profit' align='right'>" + accounting.formatMoney(rowData.NetAmount-rowData.AdvanceAmount) + "</td>"));
    }

    function drawProductRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.NetAmount);
        
        row.append($("<td>" + rowData.InvDate + "</td>"));
        row.append($("<td>" + rowData.InvNo + "</td>"));
        row.append($("<td>" + rowData.InvProductCode + "</td>"));
        row.append($("<td colspan='10' align='left'>" + rowData.AppearName + "</td>"));
        row.append($("<td class='profit' align='right'>" + accounting.formatMoney(rowData.NetAmount) + "</td>"));
    }

    function drawRowOut(rowData) {
        var row = $("<tr/>");
        $("#saletable2").append(row);

        if(rowData.Mode=='Out'){
            totalCashOut+=parseFloat(rowData.CashAmount);
            row.append($("<td colspan='12'  align='right'>" + rowData.Remark + "</td>"));
            row.append($("<td class='nbtamount2' align='right'>" + accounting.formatMoney(0) + "</td>"));
            row.append($("<td class='profit2' align='right'>" + accounting.formatMoney(rowData.CashAmount) + "</td>"));
        }else if(rowData.Mode=='In'){
            totalCashIn+=parseFloat(rowData.CashAmount);
            row.append($("<td colspan='12'  align='right'>" + rowData.Remark + "</td>"));
            row.append($("<td class='nbtamount2' align='right'>" + accounting.formatMoney(rowData.CashAmount) + "</td>"));
            row.append($("<td class='profit2' align='right'>" + accounting.formatMoney(0) + "</td>"));
        }
        
        
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
        var datebalance = $("#enddate").val();
        $("#printReport").print({
            prepend:"<h3 style='text-align:center'>Daily Cash Balance Report "+datebalance+"</h3><hr/>",
            title:'Daily Cash Balance Report '+datebalance
        });
    }
</script>