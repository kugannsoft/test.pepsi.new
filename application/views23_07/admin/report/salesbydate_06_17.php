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
                                        </select>
                                    </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-flat btn-success">Show</button>
                                </div>
                            </form>
                            <div class="col-md-1">
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
                                    <td>Inv. Date</td>
                                    <td>Customer</td>
                                    <td>Inv No</td>
                                    <td>Total Amount</td>
                                    <td>Dis Amount</td>
                                    <td>Vat Amount</td>
                                    <td>Nbt Amount</td>
                                    <td>net Amount</td>
                                    <td>Cost Amount</td>
                                    <td>Profit</td>
                                    <td>Cash Amount</td>
                                    <td>Card Amount</td>
                                    <td>Cheque Amount</td>
                                    <td>Advance Amount</td>
                                    <td>Credit Amount</td>                                    
                                    <td>Return</td>
                                    <td>Settled Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th id="totala" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totaldia" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalvata" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalnbta" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalneta" style="text-align: right;color: #00aaf1;"></th>

                                    <th id="totalcoa" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalpr" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalca" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcrda" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcha" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalada" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalcra" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalrt" style="text-align: right;color: #00aaf1;"></th>
                                    <th id="totalsettlle" style="text-align: right;color: #00aaf1;"></th>
                                    
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="4">Total Outstanding</td>
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
            url: "loadreport1",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody').empty();
                drawTable(JSON.parse(data));
                $('#totalca').html(accounting.formatMoney(sumcolumn('cashamount')));
                $('#totalcra').html(accounting.formatMoney(sumcolumn('creditamount')));
                $('#totalcrda').html(accounting.formatMoney(sumcolumn('ccardamount')));
                $('#totalcha').html(accounting.formatMoney(sumcolumn('chequeamount')));
                $('#totalada').html(accounting.formatMoney(sumcolumn('advanceamount')));
                $('#totalcoa').html(accounting.formatMoney(sumcolumn('costamount')));
                $('#totala').html(accounting.formatMoney(sumcolumn('totalamount')));
                $('#totaldia').html(accounting.formatMoney(sumcolumn('disamount')));
                $('#totalvata').html(accounting.formatMoney(sumcolumn('vatamount')));
                $('#totalnbta').html(accounting.formatMoney(sumcolumn('nbtamount')));
                $('#totalneta').html(accounting.formatMoney(sumcolumn('netamount')));
                $('#totalpr').html(accounting.formatMoney(sumcolumn('profit')));
                $('#totalrt').html(accounting.formatMoney(sumcolumn('return')));
                $('#totalsettlle').html(accounting.formatMoney(sumcolumn('settlleamount')));
                $('#totalDue').html(accounting.formatMoney(sumcolumn('creditamount')-sumcolumn('settlleamount')));

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
        row.append($("<td>" + rowData.RespectSign +" "+rowData.CusName+ "</td>"));
        row.append($("<td>" + rowData.SalesInvNo + "</td>"));
        row.append($("<td class='totalamount' align='right'>" + accounting.formatMoney(rowData.InvAmount) + "</td>"));
        row.append($("<td class='disamount' align='right'>" + accounting.formatMoney(rowData.DisAmount) + "</td>"));
        row.append($("<td class='vatamount' align='right'>" + accounting.formatMoney(rowData.VatAmount) + "</td>"));
        row.append($("<td class='nbtamount' align='right'>" + accounting.formatMoney(rowData.NbtAmount) + "</td>"));
        row.append($("<td class='netamount' align='right'>" + accounting.formatMoney(rowData.NetAmount) + "</td>"));
        row.append($("<td class='costamount' align='right'>" + accounting.formatMoney(rowData.CostAmount) + "</td>"));
        
        row.append($("<td class='profit' align='right'>" + accounting.formatMoney(rowData.InvAmount-rowData.DisAmount-rowData.CostAmount) + "</td>"));
        row.append($("<td class='cashamount' align='right'>" + accounting.formatMoney(rowData.CashAmount) + "</td>"));
        row.append($("<td class='ccardamount' align='right'>" + accounting.formatMoney(rowData.CCardAmount) + "</td>"));
        row.append($("<td class='chequeamount' align='right'>" + accounting.formatMoney(rowData.ChequeAmount) + "</td>"));
        row.append($("<td class='advanceamount' align='right'>" + accounting.formatMoney(rowData.AdvanceAmount) + "</td>"));
        row.append($("<td class='creditamount' align='right'>" + accounting.formatMoney(rowData.CreditAmount) + "</td>"));
        
        row.append($("<td class='return' align='right'>" + accounting.formatMoney(rowData.ReturnAmount) + "</td>"));
        row.append($("<td class='settlleamount' align='right'>" + accounting.formatMoney(rowData.SettledAmount) + "</td>"));
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
            title:'Date Wise Sales Report'
        });
    }

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
</script>