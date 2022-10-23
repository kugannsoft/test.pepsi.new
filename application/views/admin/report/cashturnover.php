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
<!--                        <b>Balance</b> : <span id='startBal' style='font-weight:bold;font-size:20px;'></span>-->
                        <table id="saletable" class="table table-bordered">
                            <thead>
                            <tr>
                                <td>Date</td>
                                <td>Invoice No</td>
                                <td>Customer No</td>
                                <td>Job Description</td>
<!--                                <td>Amount</td>-->
                                <td>Cash</td>
<!--                                <td>Card</td>-->
<!--                                <td>Cheque</td>-->
<!--                                <td>Bank</td>-->
<!--                                <td>Oder Advance</td>-->
<!--                                <td>Advance</td>-->
<!--                                <td>Credit</td>-->

                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
<!--                                <th id="totalpsale" style="text-align: right;color: #00aaf1;"></th>-->
                                <th id="totalpcash" style="text-align: right;color: #00aaf1;"></th>
<!--                                <th id="totalpcard" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalpcheque" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalpbank" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalorderadvance" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalpadvance" style="text-align: right;color: #00aaf1;"></th>-->
<!--                                <th id="totalpcredit" style="text-align: right;color: #00aaf1;"></th></tr>-->
                            </tfoot>
                        </table>
                        <table id="saletablex" class="table table-bordered">
                            <thead>
                            <tr>
                                <td style="width:20px;"></td>
                                <td style="width:150px;"></td>
                                <td style="width:50px;"></td>
                                <td style="width:100px;"></td>
                                <td style="width:100px;"></td>
                            </tr>
                            </thead>
                            <tbody>
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>No of New Customers </td>-->
<!--                                <td></td>-->
<!--                                <td id="noofnewcus" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>No of Existing Customers  </td>-->
<!--                                <td></td>-->
<!--                                <td id="noofrepcus" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>No Of New Jobs</td>-->
<!--                                <td></td>-->
<!--                                <td id="noofnewjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>No of Complete Jobs </td>-->
<!--                                <td></td>-->
<!--                                <td id="noofcomjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>No of Pending Jobs</td>-->
<!--                                <td></td>-->
<!--                                <td id="noofpendingjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>No of Over Due Jobs </td>-->
<!--                                <td></td>-->
<!--                                <td id="noofoverjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr><td colspan="5">&nbsp;</td></tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Start Cash Float  </td>-->
<!--                                <td></td>-->
<!--                                <td id="startfloat" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr><td colspan="5">Complete Jobs Payment Summary</td></tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Cash Jobs  *</td>-->
<!--                                <td></td>-->
<!--                                <td id="cashjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Card Jobs  </td>-->
<!--                                <td></td>-->
<!--                                <td id="cardjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Order Advanced Jobs  </td>-->
<!--                                <td></td>-->
<!--                                <td id="orderadvancejob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Advanced Jobs  </td>-->
<!--                                <td></td>-->
<!--                                <td id="advancejob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Credit Jobs </td>-->
<!--                                <td></td>-->
<!--                                <td id="creditjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Cheque Jobs </td>-->
<!--                                <td></td>-->
<!--                                <td id="chequejob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Bank Jobs </td>-->
<!--                                <td></td>-->
<!--                                <td id="bankjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Return Jobs *</td>-->
<!--                                <td></td>-->
<!--                                <td id="returnjob" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
                            <!-- <tr>
                                <td></td>
                                <td>Customer Payment (Cash) </td>
                                <td></td>
                                <td id="customerpay" class="text-right"></td>
                                <td></td>
                            </tr>  -->
<!--                            <tr><td colspan="5">&nbsp;</td></tr>-->
<!--                            <tr><td colspan="5">Payment Summary</td></tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Supplier Payments  </td>-->
<!--                                <td></td>-->
<!--                                <td id="suppayment" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr><td colspan="5">&nbsp;</td></tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Employee Advance Payments  </td>-->
<!--                                <td></td>-->
<!--                                <td id="salaryadvance" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Cash Out * </td>-->
<!--                                <td></td>-->
<!--                                <td id="totalcashOut" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Cash In * </td>-->
<!--                                <td></td>-->
<!--                                <td id="totalcashIn" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Expenses  *</td>-->
<!--                                <td></td>-->
<!--                                <td id="expOut" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Earning * </td>-->
<!--                                <td></td>-->
<!--                                <td id="expIn" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr><td colspan="5">-->
<!--                                    <table id="saletable2" class="table table-bordered">-->
<!--                                        <thead>-->
<!--                                        <tr>-->
<!--                                            <td style="width:20px;"></td>-->
<!--                                            <td style="width:150px;"></td>-->
<!--                                            <td style="width:50px;"> In</td>-->
<!--                                            <td style="width:100px;"> Out</td>-->
<!--                                            <td style="width:100px;"></td>-->
<!--                                        </tr>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        </tbody>-->
<!--                                    </table>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Day End Cash Float </td>-->
<!--                                <td></td>-->
<!--                                <td id="endFlaot" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Cash Balance </td>-->
<!--                                <td></td>-->
<!--                                <td id="balance" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Diffrence </td>-->
<!--                                <td></td>-->
<!--                                <td id="dif" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->
<!--                            <tr><td colspan="5">&nbsp;</td></tr>-->
<!--                            <tr>-->
<!--                                <td></td>-->
<!--                                <td>Operated Cashier</td>-->
<!--                                <td></td>-->
<!--                                <td id="cashier" class="text-right"></td>-->
<!--                                <td></td>-->
<!--                            </tr>-->

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
            url: "loadreportturnover",
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
        for (var i = 0; i < data.pro.length; i++) {
            drawRow(data.pro[i]);
        }

        for (var i = 0; i < data.product.length; i++) {
            drawProductRow(data.product[i]);
        }

        for (var i = 0; i < data.part.length; i++) {
            drawPartRow(data.part[i]);
        }

        for (var i = 0; i < data.easy.length; i++) {
            drawEasyRow(data.easy[i]);
        }

        for (var i = 0; i < data.easycuspay.length; i++) {
            drawEasyCusPayRow(data.easycuspay[i]);
        }

        for (var i = 0; i < data.cusodercuspay.length; i++) {
            drawCusodercuspayCusPayRow(data.cusodercuspay[i]);
        }

        for (var i = 0; i < data.cuspay.length; i++) {
            drawCusPayRow(data.cuspay[i]);
        }

        for (var i = 0; i < data.advance.length; i++) {
            drawJobAdvanceRow(data.advance[i]);
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

        for (var i = 0; i < data.expearn.length; i++) {

            if(data.expearn[i].IsExpenses==1){
                totalExpOut+=parseFloat(data.expearn[i].FlotAmount);
            }else if(data.expearn[i].IsExpenses==0){
                totalExpIn+=parseFloat(data.expearn[i].FlotAmount);
            }
        }

        endBalance=0;

        cashinhand =startBalance+totalCash+posCash-totalCashOut+totalCashIn;
        totalNetSale = totalSale + prevjobSale+prevposSale;




    }

    function drawRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.JobNetAmount);

        row.append($("<td>" + rowData.JobInvDate + "</td>"));
        row.append($("<td>" + rowData.JobInvNo + "</td>"));
        row.append($("<td>" + rowData.JRegNo + "</td>"));
        row.append($("<td  align='left'>" + rowData.JobDescription + "</td>"));
        row.append($("<td class='net' align='right'>" + accounting.formatMoney(rowData.JobNetAmount) + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.JobCashAmount) + "</td>"));
        row.append($("<td class='card' align='right'>" + accounting.formatMoney(rowData.JobCardAmount) + "</td>"));
        row.append($("<td class='cheque' align='right'>" + accounting.formatMoney(rowData.JobChequeAmount) + "</td>"));
        row.append($("<td class='bank' align='right'>" + accounting.formatMoney(rowData.JobBankAmount) + "</td>"));
        row.append($("<td class='oderadvance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='' align='right'>" + accounting.formatMoney(rowData.JobAdvance) + "</td>"));
        row.append($("<td class='credit' align='right'>" + accounting.formatMoney(rowData.JobCreditAmount) + "</td>"));
    }

    function drawJobAdvanceRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.NetAmount);

        row.append($("<td>" + rowData.PayDate + "</td>"));
        row.append($("<td>" + rowData.CusPayNo + "</td>"));
        row.append($("<td>" + rowData.CusCode + "</td>"));
        row.append($("<td  align='left'>" + rowData.CusName + " - Job Advance </td>"));
        row.append($("<td class='net' align='right'>" + accounting.formatMoney(rowData.TotalPayment) + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.CashPay) + "</td>"));
        row.append($("<td class='card' align='right'>" + accounting.formatMoney(rowData.CardPay) + "</td>"));
        row.append($("<td class='cheque' align='right'>" + accounting.formatMoney(rowData.ChequePay) + "</td>"));
        row.append($("<td class='oderadvance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='advance' align='right'>" + accounting.formatMoney(rowData.TotalPayment) + "</td>"));
        row.append($("<td class='credit' align='right'>" + accounting.formatMoney(0) + "</td>"));
    }

    function drawCusPayRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.NetAmount);

        row.append($("<td>" + rowData.PayDate + "</td>"));
        row.append($("<td>" + rowData.CusPayNo + "</td>"));
        row.append($("<td>" + rowData.CusCode + "</td>"));
        row.append($("<td  align='left'>" + rowData.CusName + " - Customer Payment</td>"));
        row.append($("<td class='net' align='right'>" + accounting.formatMoney(rowData.TotalPayment) + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.CashPay) + "</td>"));
        row.append($("<td class='card' align='right'>" + accounting.formatMoney(rowData.CardPay) + "</td>"));
        row.append($("<td class='cheque' align='right'>" + accounting.formatMoney(rowData.ChequePay) + "</td>"));
        row.append($("<td class='bank' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='oderadvance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='advance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='credit' align='right'>" + accounting.formatMoney(0) + "</td>"));
    }

    function drawEasyCusPayRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.TotalPayment);

        row.append($("<td>" + rowData.PayDate + "</td>"));
        row.append($("<td>" + rowData.PaymentId + "</td>"));
        row.append($("<td>" + rowData.CusCode + "</td>"));
        row.append($("<td  align='left'>" + rowData.CusName + " - Customer Easy Payment</td>"));
        if (rowData.PaymentType == 1){
            row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.PayAmount) + "</td>"));
        } else {
            row.append($("<td class='cash' align='right'>" + accounting.formatMoney(0) + "</td>"));
        }

    }

    function drawCusodercuspayCusPayRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.PayAmount);

        row.append($("<td>" + rowData.payDate + "</td>"));
        row.append($("<td>" + rowData.Rcp_No + "</td>"));
        row.append($("<td> </td>"));
        row.append($("<td  align='left'>" + rowData.CusName + " - Customer Order Payment - " + rowData.PO_No + "</td>"));
        if (rowData.PayType == 1){
            row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.PayAmount) + "</td>"));
        } else {
            row.append($("<td class='cash' align='right'>" + accounting.formatMoney(0) + "</td>"));
        }

    }

    function drawProductRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.NetAmount);

        row.append($("<td>" + rowData.InvDate + "</td>"));
        row.append($("<td>" + rowData.InvNo + "</td>"));
        row.append($("<td>" + rowData.InvProductCode + "</td>"));
        row.append($("<td align='left'>" + rowData.AppearName + "</td>"));
        row.append($("<td class='net' align='right'>" + accounting.formatMoney(rowData.NetAmount) + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.InvCashAmount) + "</td>"));
        row.append($("<td class='card' align='right'>" + accounting.formatMoney(rowData.InvCCardAmount) + "</td>"));
        row.append($("<td class='cheque' align='right'>" + accounting.formatMoney(rowData.InvChequeAmount) + "</td>"));
        row.append($("<td class='oderadvance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='advance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='credit' align='right'>" + accounting.formatMoney(rowData.InvCreditAmount) + "</td>"));
    }

    function drawPartRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.SalesNetAmount);

        row.append($("<td>" + rowData.InvDate + "</td>"));
        row.append($("<td>" + rowData.SalesInvNo + "</td>"));
        row.append($("<td>" + rowData.SalesVehicle + "</td>"));
        row.append($("<td align='left'>" + rowData.AppearName + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.SalesCashAmount) + "</td>"));

    }

    function drawEasyRow(rowData) {

        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.DueAmount);

        row.append($("<td>" + rowData.InvDate + "</td>"));
        row.append($("<td>" + rowData.InvNo + "</td>"));
        row.append($("<td></td>"));
        row.append($("<td align='left'>" + rowData.AppearName + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(rowData.DownPayment) + "</td>"));

    }

    function drawCOderRow(rowData) {
        var row = $("<tr/>");
        $("#saletable").append(row);
        totalSale+=parseFloat(rowData.PO_NetAmount);

        row.append($("<td>" + rowData.InvDate + "</td>"));
        row.append($("<td>" + rowData.PO_No + "</td>"));
        row.append($("<td></td>"));
        row.append($("<td align='left'>" + rowData.AppearName + "</td>"));
        row.append($("<td class='net' align='right'>" + accounting.formatMoney(rowData.PO_NetAmount) + "</td>"));
        row.append($("<td class='cash' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='card' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='cheque' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='cheque' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='oderadvance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='advance' align='right'>" + accounting.formatMoney(0) + "</td>"));
        row.append($("<td class='credit' align='right'>" + accounting.formatMoney(rowData.PO_NetAmount) + "</td>"));
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