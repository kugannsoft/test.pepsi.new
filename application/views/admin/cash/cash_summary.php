<table style="border-collapse:collapse;width:700px;margin:5px;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;" border="0">
    <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
        <td rowspan="3">
            &nbsp;
        </td>
        <td colspan="5" style="font-size:20px;font-family: Arial, Helvetica, sans-serif;text-align: left;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b>
        </td>
    </tr> 
    <tr style="text-align:left;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
        <td colspan="5"><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?></td>
    </tr>
    <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;">
        <td colspan="6">&nbsp;</td>
    </tr>
    <tr style="text-align:right;font-size:14px;">
        <td colspan="6">Report Generated time : <?php echo date("Y-m-d H:i:s"); ?></td>
    </tr>
</table>
<h4>Daily Sale Summary <?php echo $date; ?></h4>
<table  style=" border-collapse:collapse;font-size:13px;" border="1">
        <thead>
            <tr>
                <td>Date</td>
                <td>Invoice No</td>
                <td>Vehicle No</td>
                <td>Job Description</td>
                <td>Amount</td>
                <td>Cash</td>
                <td>Card</td>
                <td>Cheque</td>
                <td>Bank</td>
                <td>Advance</td>
                <td>Credit</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            $tamount=0;$tcash=0;$tcard=0;$tcheque=0;$tadvance=0;$tcredit=0;
            foreach ($pro as $dtl) { 
                $tamount+=$dtl->JobNetAmount;
                $tcash+=$dtl->JobCashAmount;
                $tcard+=$dtl->JobCardAmount;
                $tcheque+=$dtl->JobChequeAmount;
                $tbank+=$dtl->JobBankAmount;
                $tadvance+=$dtl->JobAdvance;
                $tcredit+=$dtl->JobCreditAmount;
             ?>
                <tr>
                    <td><?php echo $dtl->JobInvDate; ?></td>
                    <td><?php echo $dtl->JobInvNo; ?></td>
                    <td><?php echo $dtl->JRegNo; ?></td>
                    <td  align='left'><?php echo $dtl->JobDescription; ?></td>
                    <td class='net' align='right'><?php echo number_format($dtl->JobNetAmount,2); ?></td>
                    <td class='cash' align='right'><?php echo number_format($dtl->JobCashAmount,2); ?></td>
                    <td class='card' align='right'><?php echo number_format($dtl->JobCardAmount,2); ?></td>
                    <td class='cheque' align='right'><?php echo number_format($dtl->JobChequeAmount,2); ?></td>
                    <td class='bank' align='right'><?php echo number_format($dtl->JobBankAmount,2); ?></td>
                    <td class='' align='right'><?php echo number_format($dtl->JobAdvance,2); ?></td>
                    <td class='credit' align='right'><?php echo number_format($dtl->JobCreditAmount,2); ?></td>
                </tr>
            <?php } ?>
            <?php 
           // $tamount=0;$tcash=0;$tcard=0;$tcheque=0;$tadvance=0;$tcredit=0;
            foreach ($part as $dtl) { 
                $tamount+=$dtl->NetAmount;
                $tcash+=$dtl->SalesCashAmount;
                $tcard+=$dtl->SalesCCardAmount;
                $tcheque+=$dtl->SalesChequeAmount;
                $tbank+=$dtl->SalesBankAmount;
                $tadvance+=$dtl->SalesAdvancePayment;
                $tcredit+=$dtl->SalesCreditAmount;
             ?>
                <tr>
                    <td><?php echo $dtl->InvDate; ?></td>
                    <td><?php echo $dtl->SalesInvNo; ?></td>
                    <td><?php echo $dtl->SalesVehicle; ?></td>
                    <td  align='left'><?php echo $dtl->AppearName; ?></td>
                    <td class='net' align='right'><?php echo number_format($dtl->NetAmount,2); ?></td>
                    <td class='cash' align='right'><?php echo number_format($dtl->SalesCashAmount,2); ?></td>
                    <td class='card' align='right'><?php echo number_format($dtl->SalesCCardAmount,2); ?></td>
                    <td class='cheque' align='right'><?php echo number_format($dtl->SalesChequeAmount,2); ?></td>
                    <td class='bank' align='right'><?php echo number_format($dtl->SalesBankAmount,2); ?></td>
                    <td class='' align='right'><?php echo number_format($dtl->SalesAdvancePayment,2); ?></td>
                    <td class='credit' align='right'><?php echo number_format($dtl->SalesCreditAmount,2); ?></td>
                </tr>
            <?php } ?>
            <?php foreach ($product as $dtl) { 
                $tamount+=$dtl->NetAmount;
                $tcash+=$dtl->InvCashAmount;
                $tcard+=$dtl->InvCCardAmount;
                $tcheque+=$dtl->InvChequeAmount;
                // $tbank+=$dtl->SalesBankAmount;
                // $tadvance+=$dtl->JobAdvance;
                $tcredit+=$dtl->InvCreditAmount; ?>
                <tr>
                    <td><?php echo $dtl->InvDate; ?></td>
                    <td><?php echo $dtl->InvNo; ?></td>
                    <td><?php echo $dtl->InvProductCode; ?></td>
                    <td  align='left'><?php echo $dtl->AppearName; ?></td>
                    <td class='net' align='right'><?php echo number_format($dtl->NetAmount,2); ?></td>
                    <td class='cash' align='right'><?php echo number_format($dtl->InvCashAmount,2); ?></td>
                    <td class='card' align='right'><?php echo number_format($dtl->InvCCardAmount,2); ?></td>
                    <td class='cheque' align='right'><?php echo number_format($dtl->InvChequeAmount,2); ?></td>
                    <td class='bank' align='right'><?php echo number_format(0,2); ?></td>
                    <td class='' align='right'><?php echo number_format(0,2); ?></td>
                    <td class='credit' align='right'><?php echo number_format($dtl->InvCreditAmount,2); ?></td>
                </tr>
            <?php } ?>
            <?php foreach ($cuspay as $dtl) {  
                $tamount+=$dtl->TotalPayment;
                $tcash+=$dtl->CashPay;
                $tcard+=$dtl->CardPay;
                $tcheque+=$dtl->ChequePay;
                // $tadvance+=$dtl->JobAdvance;
                // $tcredit+=$dtl->JobCreditAmount;
                ?>
                <tr>
                    <td><?php echo $dtl->PayDate; ?></td>
                    <td><?php echo $dtl->CusPayNo; ?></td>
                    <td><?php echo $dtl->CusCode; ?></td>
                    <td  align='left'><?php echo $dtl->CusName; ?> - Customer Payment</td>
                    <td class='net' align='right'><?php echo number_format($dtl->TotalPayment,2); ?></td>
                    <td class='cash' align='right'><?php echo number_format($dtl->CashPay,2); ?></td>
                    <td class='card' align='right'><?php echo number_format($dtl->CardPay,2); ?></td>
                    <td class='cheque' align='right'><?php echo number_format($dtl->ChequePay,2); ?></td>
                    <td class='bank' align='right'><?php echo number_format(0,2); ?></td>
                    <td class='' align='right'><?php echo number_format(0,2); ?></td>
                    <td class='credit' align='right'><?php echo number_format(0,2); ?></td>
                </tr>
            <?php } ?>
            <?php foreach ($advance as $dtl) {  
                $tamount+=$dtl->TotalPayment;
                $tcash+=$dtl->CashPay;
                $tcard+=$dtl->CardPay;
                $tcheque+=$dtl->ChequePay;
                $tadvance+=$dtl->TotalPayment;
                // $tcredit+=$dtl->JobCreditAmount;
                ?>
                <tr>
                    <td><?php echo $dtl->PayDate; ?></td>
                    <td><?php echo $dtl->CusPayNo; ?></td>
                    <td><?php echo $dtl->CusCode; ?></td>
                    <td  align='left'><?php echo $dtl->CusName; ?> - Job Advance </td>
                    <td class='net' align='right'><?php echo number_format($dtl->TotalPayment,2); ?></td>
                    <td class='cash' align='right'><?php echo number_format($dtl->CashPay,2); ?></td>
                    <td class='card' align='right'><?php echo number_format($dtl->CardPay,2); ?></td>
                    <td class='cheque' align='right'><?php echo number_format($dtl->ChequePay,2); ?></td>
                    <td class='bank' align='right'><?php echo number_format(0,2); ?></td>
                    <td class='' align='right'><?php echo number_format($dtl->TotalPayment,2); ?></td>
                    <td class='credit' align='right'><?php echo number_format(0,2); ?></td>
                </tr>
            <?php } ?>
            
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th id="totalpsale" style="text-align: right;color: #00aaf1;"><?php echo number_format($tamount,2); ?></th>
                <th id="totalpcash" style="text-align: right;color: #00aaf1;"><?php echo number_format($tcash,2); ?></th>
                <th id="totalpcard" style="text-align: right;color: #00aaf1;"><?php echo number_format($tcard,2); ?></th>
                <th id="totalpcheque" style="text-align: right;color: #00aaf1;"><?php echo number_format($tcheque,2); ?></th>
                <th id="totalpbank" style="text-align: right;color: #00aaf1;"><?php echo number_format($tbank,2); ?></th>
                <th id="totalpadvance" style="text-align: right;color: #00aaf1;"><?php echo number_format($tadvance,2); ?></th>
                <th id="totalpcredit" style="text-align: right;color: #00aaf1;"><?php echo number_format($tcredit,2); ?></th></tr>
        </tfoot>
    </table>
    <h4>Daily Cash Float Summary <?php echo $date; ?></h4>
    <table style=" border-collapse:collapse;font-size:13px;" border="1">
    <thead>
        <tr>
            <td style="width:20px;"></td>
            <td style="width:150px;"></td>
            <td style="width:1px;"></td>
            <td style="width:100px;"></td>
            <td style="width:100px;"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td>No of New Customers </td>
            <td></td>
            <td id="noofnewcus"  style="text-align: right;"><?php echo $newcus; ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>No of Repeat Customers  </td>
            <td></td>
            <td id="noofrepcus"  style="text-align: right;"><?php echo $repcus; ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>No Of New Jobs</td>
            <td></td>
            <td id="noofnewjob" style="text-align: right;"><?php echo $newjobs; ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>No of Complete Jobs </td>
            <td></td>
            <td id="noofcomjob"  style="text-align: right;"><?php echo $completejobs; ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>No of Pending Jobs</td>
            <td></td>
            <td id="noofpendingjob"  style="text-align: right;"><?php echo $pendingjob; ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>No of Over Due Jobs </td>
            <td></td>
            <td id="noofoverjob"  style="text-align: right;"><?php echo $overjob; ?></td>
            <td></td>
        </tr>
        <tr><td colspan="5">&nbsp;</td></tr>
        <tr>
            <td></td>
            <td>Start Cash Float  </td>
            <td></td>
            <td id="startfloat"  style="text-align: right;"><?php echo $startbal; ?></td>
            <td></td>
        </tr> 
        <tr><td colspan="5">Complete Jobs Payment Summary</td></tr>
        <tr>
            <td></td>
            <td>Cash Jobs * </td>
            <td></td>
            <td id="cashjob"  style="text-align: right;"><?php echo number_format($bal->CASH_SALES+$bal->CUSTOMER_PAYMENT,2); ?></td>
            <td></td>
        </tr> 
         
        <tr>
            <td></td>
            <td>Advanced Jobs  </td>
            <td></td>
            <td id="advancejob"  style="text-align: right;"><?php echo number_format($bal->ADVANCE_PAYMENT,2); ?></td>
            <td></td>
        </tr> 
        <tr>
            <td></td>
            <td>Return Jobs *</td>
            <td></td>
            <td id="returnjob"  style="text-align: right;"><?php echo number_format($bal->RETURN_AMOUNT,2); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Card Jobs  </td>
            <td></td>
            <td id="cardjob"  style="text-align: right;"><?php echo number_format($bal->CARD_SALES,2); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit Jobs </td>
            <td></td>
            <td id="creditjob"  style="text-align: right;"><?php echo number_format($bal->CREDIT_SALES,2); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Credit Jobs </td>
            <td></td>
            <td id="creditjob"  style="text-align: right;"><?php echo number_format($bal->CREDIT_SALES,2); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Cheque Jobs </td>
            <td></td>
            <td id="chequejob"  style="text-align: right;"><?php echo number_format($bal->CHEQUE_SALES,2); ?></td>
            <td></td>
        </tr>
        

        <tr>
            <td></td>
            <td>Customer Payment</td>
            <td></td>
            <td id="customerpay"  style="text-align: right;"><?php echo number_format($bal->CUSTOMER_PAYMENT,2); ?></td>
            <td></td>
        </tr> 
        <tr><td colspan="5">&nbsp;</td></tr>
        <tr><td colspan="5">Payment Summary</td></tr>
        <tr>
            <td></td>
            <td>Supplier Payments  </td>
            <td></td>
            <td id="suppayment"  style="text-align: right;"><?php echo number_format($bal->SUPPLIER_PAYMENT,2); ?></td>
            <td></td>
        </tr> 
        <tr><td colspan="5">&nbsp;</td></tr>
        <tr>
            <td></td>
            <td>Employee Advance Payments  </td>
            <td></td>
            <td id="salaryadvance"  style="text-align: right;"><?php echo number_format($bal->SALARY,2); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Cash Out  </td>
            <td></td>
            <td id="totalcashOut"  style="text-align: right;"><?php echo number_format($bal->CASH_OUT,2); ?></td>
            <td></td>
        </tr> 
        <tr>
            <td></td>
            <td>Cash In  </td>
            <td></td>
            <td id="totalcashIn"  style="text-align: right;"><?php echo number_format($bal->CASH_IN,2); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Expenses  </td>
            <td></td>
            <td id="expOut"  style="text-align: right;"><?php echo number_format($bal->EX_OUT,2); ?></td>
            <td></td>
        </tr> 
        <tr>
            <td></td>
            <td>Earning  </td>
            <td></td>
            <td id="expIn"  style="text-align: right;"><?php echo number_format($bal->EX_IN,2); ?></td>
            <td></td>
        </tr>  
        <tr><td colspan="5">
                <table style=" border-collapse:collapse;font-size:13px;" border="1">
                    <thead>
                        <tr>
                            <td style="width:20px;"></td>
                            <td style="width:250px;"></td>
                            <td style="width:50px;"> In</td>
                            <td style="width:50px;"> Out</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($inout as $dtl) { 
                        if($dtl->Mode=='Out'){ ?>
                        <tr>
                            <td></td>
                            <td><?php echo $dtl->TransactionName." - ".$dtl->RepName." - ".$dtl->Remark; ?></td>
                            <td></td>
                            <td style="text-align: right;"><?php echo number_format($dtl->CashAmount,2); ?></td>
                        </tr>
                        <?php }elseif($dtl->Mode=='In'){ ?>
                        <tr>
                            <td></td>
                            <td><?php echo $dtl->TransactionName." - ".$dtl->RepName." - ".$dtl->Remark; ?></td>
                            <td style="text-align: right;"><?php echo number_format($dtl->CashAmount,2); ?></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Day End Cash Float </td>
            <td></td>
            <td id="endFlaot"  style="text-align: right;"><?php echo number_format($lastbal,2); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Cash Balance </td>
            <td></td>
            <td id="balance"  style="text-align: right;"><?php echo number_format($bal->BALANCE_AMOUNT+$startbal,2); ?></td>
            <td></td>
        </tr> 
        <tr>
            <td></td>
            <td>Diffrence </td>
            <td></td>
            <td id="dif"  style="text-align: right;"><?php echo number_format($bal->BALANCE_AMOUNT+$startbal-$lastbal,2); ?></td>
            <td></td>
        </tr>  
        <tr><td colspan="5">&nbsp;</td></tr>
        <tr>
            <td></td>
            <td>Operated Cashier</td>
            <td></td>
            <td id="cashier"  style="text-align: right;"><?php echo $cashier; ?></td>
            <td></td>
        </tr> 
    </tbody>
</table>
<p style="font-size:13px;">This is system generated mail for <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?> by <a href="http://nsoft.lk" target="_blank">nsoft.lk</a>.<br> Please do not reply. <br><b>Thank you for your business</b>.</p>
