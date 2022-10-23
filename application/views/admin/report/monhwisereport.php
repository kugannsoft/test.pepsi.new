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
                                        <!--                                        <input type="hidden" class="form-control" name="startdate" value="--><?php //echo date("Y-m-d") ?><!--"/>-->
                                        <input type="text" class="form-control" name="startdate" value="<?php echo date("Y-m-d") ?>"/>
                                        <span class="input-group-addon">to</span>
                                        <!--                                        <input type="text" class="form-control" name="enddate"  id="enddate" value="--><?php //echo date("Y-m-d") ?><!--"/>-->
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
                        <table id="saletable" class="table table-bordered">
                            <thead>
                            <tr style="background-color: #1fbfb8">
                                <td>Date</td>
                                <td>Cash</td>
                                <td>Card</td>
                                <td>Cheque</td>
                                <td>Bank</td>
                                <td>Total</td>
                                <td>Expenses</td>
                                <td>Balance</td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th id="totalpcash" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalpcard" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalpcheque" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalpbank" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalorderadvance" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalpadvance" style="text-align: right;color: #00aaf1;"></th>
                                <th id="totalpcredit" style="text-align: right;color: #00aaf1;"></th></tr>
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
            url: "loadmonthlywisereport",
            data: $(this).serialize(),
            success: function (data) {
                $('#saletable tbody,#saletable2 tbody').empty();
                drawTable(JSON.parse(data));

                $('#totalca').html(accounting.formatMoney(sumcolumn('cashamount')));
                $('#totalcra').html(accounting.formatMoney(sumcolumn('creditamount')));
                $('#totalcrda').html(accounting.formatMoney(sumcolumn('ccardamount')));
                $('#totalcha').html(accounting.formatMoney(sumcolumn('chequeamount')));
                $('#totalcoa').html(accounting.formatMoney(sumcolumn('costamount')));
                $('#totalpadvance').html(accounting.formatMoney(sumcolumn('advance')));
                $('#totalorderadvance').html(accounting.formatMoney(sumcolumn('oderadvance')));
                $('#totalpcredit').html(accounting.formatMoney(sumcolumn('credit')));
                $('#totalpcheque').html(accounting.formatMoney(sumcolumn('cheque')));
                $('#totalpbank').html(accounting.formatMoney(sumcolumn('bank')));
                $('#totalpcard').html(accounting.formatMoney(sumcolumn('card')));
                $('#totalpcash').html(accounting.formatMoney(sumcolumn('cash')));
                $('#totalpsale').html(accounting.formatMoney(sumcolumn('net')));

            }
        })
    });
    var startBalance = 0;
    var totalCashIn=0;
    var totalCashOut=0;
    var totalExpIn=0;
    var totalExpOut=0;
    var totalSale = 0;
    var totalSale = 0;
    var cashinhand=0;
    var totalCash=0;
    var posCash = 0;
    var prevjobSale=0;
    var prevposSale = 0;
    var totalNetSale=0;
    var totalsalaryAdvance=0;
    var totalSupPay=0;
    var posCard=0; var jobCard=0;
    var jobadvance=0;
    var cuspayment= 0;
    var jobadvancecard=0;
    var cuspaymentcard= 0;
    var endBalance=0;
    var endFloat=0;
    var cashSale=0;
    function drawTable(data) {
        startBalance = 0;
        endBalance=0;
        totalCashIn=0;
        totalCashOut=0;
        totalSale = 0;
        cashinhand=0;
        totalCash=0;
        posCash = 0;
        posCredit = 0;
        jobCredit = 0;
        cuspayment=0;
        prevjobSale=0;
        prevposSale = 0;
        totalNetSale=0;
        totalsalaryAdvance=0;
        endFloat=0;
        cashSale=0;
        totalSupPay=0;

        startBalance=parseFloat(data.startbal);

        const dataSet = [data.part,data.easy,data.easycuspay,data.cusodercuspay,data.expearn];
        const flatData = dataSet.flat();
        const months = [...new Set(flatData.map(e => e.sdDate))];

       var monthDataSet =  months.map((m) => {
            const filteredData = flatData.filter((e) => e.sdDate === m);

        const addUp = [];
        filteredData.forEach((record, index) => {
            if (!addUp.length) {
            addUp.push(record);
            return;
        }

        const prevRec = addUp[index - 1];

        const SalesCashAmount =
            parseFloat(record.SalesCashAmount || 0) +
            parseFloat(prevRec.SalesCashAmount || 0);
        const SalesCCardAmount =
            parseFloat(record.SalesCCardAmount || 0) +
            parseFloat(prevRec.SalesCCardAmount || 0);
        const SalesChequeAmount =
            parseFloat(record.SalesChequeAmount || 0) +
            parseFloat(prevRec.SalesChequeAmount || 0);
        const SalesBankAmount =
            parseFloat(record.SalesBankAmount || 0) +
            parseFloat(prevRec.SalesBankAmount || 0);
        const Expenses =
            parseFloat(record.Expenses || 0) +
            parseFloat(prevRec.Expenses || 0);

        addUp.push({
                ...record,
            SalesCashAmount,
            SalesCCardAmount,
            SalesChequeAmount,
            SalesBankAmount,
            Expenses,
            Total:SalesCashAmount+SalesCCardAmount+SalesChequeAmount+SalesBankAmount,
    });
    });

        return addUp[addUp.length - 1];

    });



        for (var i = 0; i < monthDataSet.length; i++) {
            drawRow(monthDataSet[i]);
        }


        for (var i = 0; i < data.procash.length; i++) {
            posCash+=parseFloat(data.procash[i].CashAmount);
            posCredit+=parseFloat(data.cash[i].CreditAmount);
            posCard +=parseFloat(data.cash[i].CardAmount);
        }

        for (var i = 0; i < data.bal.length; i++) {
            cuspayment=parseFloat(data.bal[i].CUSTOMER_PAYMENT);
            cashSale=parseFloat(data.bal[i].CASH_SALES);
            $("#expIn").html(accounting.formatMoney(data.bal[i].EX_IN));
            $("#expOut").html(accounting.formatMoney(data.bal[i].EX_OUT));
            $("#salaryadvance").html(accounting.formatMoney(data.bal[i].SALARY));
            $("#startBal").html(accounting.formatMoney(data.bal[i].START_FLOT));
            $("#cashjob").html(accounting.formatMoney((cashSale+cuspayment)));
            $("#cardjob").html(accounting.formatMoney(data.bal[i].CARD_SALES));
            $("#orderadvancejob").html(accounting.formatMoney(data.bal[i].ORDER_ADVANCE_SALES));
            $("#creditjob").html(accounting.formatMoney(data.bal[i].CREDIT_SALES));
            $("#advancejob").html(accounting.formatMoney(data.bal[i].ADVANCE_PAYMENT));
            $("#chequejob").html(accounting.formatMoney(data.bal[i].CHEQUE_SALES));
            $("#bankjob").html(accounting.formatMoney(data.bal[i].BANK_SALES));
            $("#returnjob").html(accounting.formatMoney(data.bal[i].RETURN_AMOUNT));
            $("#totalcashOut").html(accounting.formatMoney(data.bal[i].CASH_OUT));
            $("#totalcashIn").html(accounting.formatMoney(data.bal[i].CASH_IN));
            $("#suppayment").html(accounting.formatMoney(data.bal[i].SUPPLIER_PAYMENT));


            endBalance=parseFloat(data.bal[i].BALANCE_AMOUNT)+parseFloat(data.startbal);
            $("#balance").html(accounting.formatMoney(endBalance));
            endFloat=parseFloat(data.lastbal);
            $("#dif").html(accounting.formatMoney(endBalance-endFloat));

            totalCash+=parseFloat(data.bal[i].CASH_SALES);
            jobCredit+=parseFloat(data.bal[i].CREDIT_SALES);
            posCard +=parseFloat(data.bal[i].CARD_SALES);
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

        for (var i = 0; i < data.cash.length; i++) {
            totalCash+=parseFloat(data.cash[i].JobInvPayAmount);
            jobCredit+=parseFloat(data.cash[i].JobCreditAmount);
            jobCard +=parseFloat(data.cash[i].JobCardAmount);
        }

        for (var i = 0; i < data.salary.length; i++) {
            totalsalaryAdvance+=parseFloat(data.salary[i].CashAmount);
        }

        for (var i = 0; i < data.suppay.length; i++) {
            totalSupPay+=parseFloat(data.suppay[i].CashPay);
        }

        for (var i = 0; i < data.advance.length; i++) {
            jobadvance+=parseFloat(data.advance[i].CashPay);
            jobadvancecard+=parseFloat(data.advance[i].CardPay);
        }

        for (var i = 0; i < data.cuspay.length; i++) {
            cuspayment+=parseFloat(data.cuspay[i].CashPay);
            cuspaymentcard+=parseFloat(data.cuspay[i].CardPay);
        }



        endBalance=0;

        cashinhand =startBalance+totalCash+posCash-totalCashOut+totalCashIn;
        totalNetSale = totalSale + prevjobSale+prevposSale;

    }

    function drawRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.SalesNetAmount);

        row.append($("<td>" + rowData.sdDate + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.SalesCashAmount) + "</td>"));
        row.append($("<td class='card' align='right'>" + accounting.formatMoney(rowData.SalesCCardAmount) + "</td>"));
        row.append($("<td class='cheque' align='right'>" + accounting.formatMoney(rowData.SalesChequeAmount) + "</td>"));
        row.append($("<td class='bank' align='right'>" + accounting.formatMoney(rowData.SalesBankAmount) + "</td>"));
        row.append($("<td class='oderadvance' align='right'>" + accounting.formatMoney(rowData.Total) + "</td>"));
        row.append($("<td class='advance' align='right'>" + accounting.formatMoney(rowData.Expenses) + "</td>"));
        row.append($("<td class='credit' align='right'>" + accounting.formatMoney(rowData.Total - rowData.Expenses) + "</td>"));

    }


    function drawRowOut(rowData) {
        var row = $("<tr/>");
        $("#saletable2").append(row);

        if(rowData.Mode=='Out'){

            totalCashOut+=parseFloat(rowData.CashAmount);
            row.append($("<td align='right'></td>"));
            row.append($("<td align='left'>" + rowData.TransactionName + " - " + rowData.RepName + " - " + rowData.Remark + "</td>"));
            row.append($("<td class='nbtamount2' align='right'>" + accounting.formatMoney(0) + "</td>"));
            row.append($("<td class='profit2' align='right'>" + accounting.formatMoney(rowData.CashAmount) + "</td>"));
            row.append($("<td align='right'></td>"));
        }else if(rowData.Mode=='In'){
            totalCashIn+=parseFloat(rowData.CashAmount);
            row.append($("<td align='right'></td>"));
            row.append($("<td align='left'>" + rowData.TransactionName + " - " + rowData.RepName + " - " + rowData.Remark+ "</td>"));
            row.append($("<td class='nbtamount2' align='right'>" + accounting.formatMoney(rowData.CashAmount) + "</td>"));
            row.append($("<td class='profit2' align='right'>" + accounting.formatMoney(0) + "</td>"));
            row.append($("<td align='right'></td>"));
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