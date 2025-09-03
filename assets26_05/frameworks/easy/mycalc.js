
//---------------------------
function CalcPayment(LoanAmt, Rate, Months)
// Rate = monthly rate; already divided by 12 giving a monthly rate
{
    var Pmt = 0;

    if (Months == 0)
    {
        Pmt = 0;
    }
    else
    if (Rate == 0)
    {
//		Pmt = NumRnd(LoanAmt / Months + 0.0049, 2);
        Pmt = Math.ceil(LoanAmt / Months * 100) / 100;
    }
    else
    {
//		Pmt = NumRnd(LoanAmt * (Rate / (1.0 - Math.pow(1.0 + Rate, -Months))) + 0.0049, 2);
        Pmt = Math.ceil(LoanAmt * (Rate / (1.0 - Math.pow(1.0 + Rate, -Months))) * 100) / 100;
    }

    return Pmt;
}

function CalcLoanAmount(Pmt, Rate, Months)
// Rate = monthly rate; already divided by 12 giving a monthly rate
{
    var LoanAmt = 0;

    if (Months == 0)
    {
        LoanAmt = 0;
    }
    else
    if (Rate == 0)
    {
        LoanAmt = NumRnd(Pmt * Months + 0.0049, 2);
    }
    else
    {
        LoanAmt = NumRnd(Pmt * ((1.0 - Math.pow(1.0 + Rate, -Months)) / Rate) + 0.0049, 2);
    }

    return (LoanAmt);
}
// Payment = LoanAmt * (Rate/12 / (1 - (1 + Rate/12)^-Months)
function CalcRate(LoanAmt, Payment, Months)
// determine Rate numerically by initial guess and refinement
{
    var Rate = 0;
    var TryRate;
    var Pmt;
    var cDec = 2;
    var Inc;

    if (LoanAmt != 0)
    {
        //first guess at the rate - average interest over length of the loan
        Rate = (Payment * Months - LoanAmt) / LoanAmt / Months * 12;
        if (Rate > 0)
        {
            Pmt = 0;

            while (Math.abs(Payment - Pmt) > 0.001)
            {
                Inc = Math.pow(10, -cDec);
                TryRate = Rate;
                Pmt = CalcPayment(LoanAmt, TryRate / 12, Months);
                while (Pmt < Payment)
                {
                    Rate = TryRate;
                    TryRate += Inc;
                    Pmt = CalcPayment(LoanAmt, TryRate / 12, Months);
                }
                cDec++;
            }
            Rate = TryRate;
        }
    }

    return Rate;
}

// NumMonths = -(LN(1 - (LoanAmt / Payment) * Rate)) / LN(1 + Rate))
function CalcTerm(Payment, LoanAmt, Rate)
// Rate = monthly rate
{
    var Term = 0;

    if (Payment != 0)
    {
        Term = NumRnd(-(Math.log(1 - (LoanAmt / Payment) * Rate) / Math.log(1 + Rate)), 0);
    }

    return Term;
}


// --------------------------

// function paytbl(tLoanAmt, tRate, tMonths, extra, instalment) {
//     tRate = tRate / 100;
//     var addPrinipal = 0;
//     var calPayment = 0;
//     var loan_prin = 0;
//     var total_int = 0;
//     var total_pay = 0;
//     var total_prin = 0;
//     var total_bal = 0;
//     var yr_total_int = 0;
//     var yr_total_pay = 0;
//     var yr_total_prin = 0;
//     var yr_total_bal = 0;
//
//     var monthAr = [];
//     var monPayAr = [];
//     var pricAr = [];
//     var intAr = [];
//     var balAr = [];
//      monthAr.length = 0; monPayAr.length = 0; pricAr.length = 0; intAr.length = 0; balAr.length = 0;
// //    var ex =0;
// //    addPrinipal = parseFloat(extra/tMonths).toFixed(2);;
// //    alert(addPrinipal);
//
//    // var lm * (tRate) = $("#termInterst").val();
//    var totalInterest = tLoanAmt * (tRate) * tMonths;
//      tLoanAmt += totalInterest;
//
//     $("#tbl_payment_schedule tbody").empty();
//     $("#tbl_payment_schedule").append("<tr><td></td><td></td><td></td><td></td><td></td><td>" + accounting.formatMoney(tLoanAmt) + "</td><tr>");
//     var y = 1;
//     // calPayment = CalcPayment(tLoanAmt, tRate / 12, tMonths);
//     // console.log('calpayment',calPayment);
//     for (var i = 0; i < instalment; i++) {
//         var p, lm, interest, principal, balance;
//
//         // if (i == 0) {
//             lm=tLoanAmt;
// //             alert(lm);
// //         } else {
// //            alert(lm);
// //             lm= lm;
// //         }
//
//             interest = (totalInterest / tMonths).toFixed(2);
//             loan_prin = parseFloat(( lm - totalInterest) / instalment).toFixed(2);
//
//             if (i === (instalment - 1)) {
//                 loan_prin = loan_prin - ((loan_prin * instalment) - (tLoanAmt - totalInterest));
//             }
//
//             // interest = (lm * (tRate) / 12).toFixed(2);
//             // loan_prin = parseFloat(calPayment).toFixed(2) - parseFloat(interest).toFixed(2);
//             if (lm < loan_prin) {
//                 loan_prin = lm;
//                 addPrinipal = 0;
//             }
//             if (lm < loan_prin + addPrinipal) {
// //                loan_prin = lm;
//                 addPrinipal = parseFloat(lm) - parseFloat(loan_prin);
//                // addPrinipal = Number(lm - loan_prin).toFixed(2);
//         console.log('loan_prin',loan_prin);
//             }
//
//             p = parseFloat(interest) + parseFloat(loan_prin) + parseFloat(addPrinipal);
//             // lm = (lm - parseFloat(loan_prin)) + parseFloat(addPrinipal);
//         var  previousAmount = tLoanAmt;
//         if (!!balAr[i-1]){
//             previousAmount = balAr[i-1];
//         }
//             lm = previousAmount - p;
//
// //        loan_prin = (p - interest).toFixed(2);
//         total_int += parseFloat(interest);
//         total_pay += parseFloat(p);
//         total_prin += parseFloat(loan_prin);
//         total_bal += parseFloat(lm);
//         yr_total_int += parseFloat(interest);
//         yr_total_pay += parseFloat(p);
//         yr_total_prin += parseFloat(loan_prin);
//         yr_total_bal += parseFloat(lm);
//         var m = i + 1;
//
//         monthAr.push(m);
//         monPayAr.push(p);
//         pricAr.push(loan_prin);
//         intAr.push(interest);
//         balAr.push(lm);
//
//         $("#tbl_payment_schedule").append("<tr><td>" + m + "</td><td>" + accounting.formatMoney(p) + "</td><td>" + accounting.formatMoney(loan_prin) + "</td><td>" + accounting.formatMoney(interest) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");
//
//         if (m % 12 == 0) {
//             $("#tbl_payment_schedule").append("<tr class='yr_row' ><td> Year " + y + "</td><td>" + accounting.formatMoney(yr_total_pay) + "</td><td>" + accounting.formatMoney(yr_total_prin) + "</td><td>" + accounting.formatMoney(yr_total_int) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");
//             $("#tbl_payment_schedule").append("<tr><td colspan='6'></td><tr>");
//             y++;
//             yr_total_int = 0;
//             yr_total_pay = 0;
//             yr_total_prin = 0;
//             yr_total_bal = 0;
//         }
//         $("#tps_tot_bal").html(accounting.formatMoney(0));
//         $("#tps_tot_pay").html(accounting.formatMoney(total_pay));
//         $("#tps_tot_prin").html(accounting.formatMoney(total_prin));
//         $("#tps_tot_int").html(accounting.formatMoney(total_int));
//
//         $("#monthAr").val(JSON.stringify(monthAr));
//         $("#monPayAr").val(JSON.stringify(monPayAr));
//         $("#pricAr").val(JSON.stringify(pricAr));
//         $("#intAr").val(JSON.stringify(intAr));
//         $("#balAr").val(JSON.stringify(balAr));
//
//     }
// }

//Monthly
function paytbl(tLoanAmt, tRate, tMonths, extra) {
    tRate = tRate / 100;
    var addPrinipal = 0;
    var calPayment = 0;
    var loan_prin = 0;
    var total_int = 0;
    var total_pay = 0;
    var total_prin = 0;
    var total_bal = 0;
    var yr_total_int = 0;
    var yr_total_pay = 0;
    var yr_total_prin = 0;
    var yr_total_bal = 0;

    var monthAr = [];
    var monPayAr = [];
    var pricAr = [];
    var intAr = [];
    var balAr = [];
    monthAr.length = 0; monPayAr.length = 0; pricAr.length = 0; intAr.length = 0; balAr.length = 0;

    var totalInterest = tLoanAmt * (tRate) * tMonths;
    tLoanAmt += totalInterest;

    $("#tbl_payment_schedule tbody").empty();
    $("#tbl_payment_schedule").append("<tr><td></td><td></td><td></td><td></td><td></td><td>" + accounting.formatMoney(tLoanAmt) + "</td><tr>");
    var y = 1;

    for (var i = 0; i < tMonths; i++) {
        var p, lm, interest, principal, balance;

        lm=tLoanAmt;

        interest = (totalInterest / tMonths).toFixed(2);
        loan_prin = parseFloat(( lm - totalInterest) / tMonths).toFixed(2);

        if (i === (tMonths - 1)) {
            loan_prin = loan_prin - ((loan_prin * tMonths) - (tLoanAmt - totalInterest));
        }

        if (lm < loan_prin) {
            loan_prin = lm;
            addPrinipal = 0;
        }
        if (lm < loan_prin + addPrinipal) {
            addPrinipal = parseFloat(lm) - parseFloat(loan_prin);
            console.log('loan_prin',loan_prin);
        }

        p = parseFloat(interest) + parseFloat(loan_prin) + parseFloat(addPrinipal);
        var  previousAmount = tLoanAmt;
        if (!!balAr[i-1]){
            previousAmount = balAr[i-1];
        }
        lm = previousAmount - p;

        total_int += parseFloat(interest);
        total_pay += parseFloat(p);
        total_prin += parseFloat(loan_prin);
        total_bal += parseFloat(lm);
        yr_total_int += parseFloat(interest);
        yr_total_pay += parseFloat(p);
        yr_total_prin += parseFloat(loan_prin);
        yr_total_bal += parseFloat(lm);
        var m = i + 1;

        monthAr.push(m);
        monPayAr.push(p);
        pricAr.push(loan_prin);
        intAr.push(interest);
        balAr.push(lm);

        $("#tbl_payment_schedule").append("<tr><td>" + m + "</td><td>" + accounting.formatMoney(p) + "</td><td>" + accounting.formatMoney(loan_prin) + "</td><td>" + accounting.formatMoney(interest) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");

        if (m % 12 == 0) {
            $("#tbl_payment_schedule").append("<tr class='yr_row' ><td> Year " + y + "</td><td>" + accounting.formatMoney(yr_total_pay) + "</td><td>" + accounting.formatMoney(yr_total_prin) + "</td><td>" + accounting.formatMoney(yr_total_int) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");
            $("#tbl_payment_schedule").append("<tr><td colspan='6'></td><tr>");
            y++;
            yr_total_int = 0;
            yr_total_pay = 0;
            yr_total_prin = 0;
            yr_total_bal = 0;
        }
        $("#tps_tot_bal").html(accounting.formatMoney(0));
        $("#tps_tot_pay").html(accounting.formatMoney(total_pay));
        $("#tps_tot_prin").html(accounting.formatMoney(total_prin));
        $("#tps_tot_int").html(accounting.formatMoney(total_int));

        $("#monthAr").val(JSON.stringify(monthAr));
        $("#monPayAr").val(JSON.stringify(monPayAr));
        $("#pricAr").val(JSON.stringify(pricAr));
        $("#intAr").val(JSON.stringify(intAr));
        $("#balAr").val(JSON.stringify(balAr));

    }
}
//Weekly
function paytblWeekly(tLoanAmt, tRate, tMonths, extra) {
    tRate = tRate / 100;
    var addPrinipal = 0;
    var calPayment = 0;
    var loan_prin = 0;
    var total_int = 0;
    var total_pay = 0;
    var total_prin = 0;
    var total_bal = 0;
    var yr_total_int = 0;
    var yr_total_pay = 0;
    var yr_total_prin = 0;
    var yr_total_bal = 0;

    var monthAr = [];
    var monPayAr = [];
    var pricAr = [];
    var intAr = [];
    var balAr = [];
    monthAr.length = 0; monPayAr.length = 0; pricAr.length = 0; intAr.length = 0; balAr.length = 0;

    var totalInterest = tLoanAmt * (tRate) * tMonths;
    tLoanAmt += totalInterest;

    $("#tbl_payment_schedule tbody").empty();
    $("#tbl_payment_schedule").append("<tr><td></td><td></td><td></td><td></td><td></td><td>" + accounting.formatMoney(tLoanAmt) + "</td><tr>");
    var y = 1;

    var instalment = tMonths * 4;

    for (var i = 0; i < instalment; i++) {
        var p, lm, interest, principal, balance;

        lm=tLoanAmt;

        interest = (totalInterest / instalment).toFixed(2);
        loan_prin = parseFloat(( lm - totalInterest) / instalment).toFixed(2);

        if (i === (instalment - 1)) {
            loan_prin = loan_prin - ((loan_prin * instalment) - (tLoanAmt - totalInterest));
        }

        if (lm < loan_prin) {
            loan_prin = lm;
            addPrinipal = 0;
        }
        if (lm < loan_prin + addPrinipal) {
            addPrinipal = parseFloat(lm) - parseFloat(loan_prin);
            console.log('loan_prin',loan_prin);
        }

        p = parseFloat(interest) + parseFloat(loan_prin) + parseFloat(addPrinipal);
        var  previousAmount = tLoanAmt;
        if (!!balAr[i-1]){
            previousAmount = balAr[i-1];
        }
        lm = previousAmount - p;

        total_int += parseFloat(interest);
        total_pay += parseFloat(p);
        total_prin += parseFloat(loan_prin);
        total_bal += parseFloat(lm);
        yr_total_int += parseFloat(interest);
        yr_total_pay += parseFloat(p);
        yr_total_prin += parseFloat(loan_prin);
        yr_total_bal += parseFloat(lm);
        var m = i + 1;

        monthAr.push(m);
        monPayAr.push(p);
        pricAr.push(loan_prin);
        intAr.push(interest);
        balAr.push(lm);

        $("#tbl_payment_schedule").append("<tr><td>" + m + "</td><td>" + accounting.formatMoney(p) + "</td><td>" + accounting.formatMoney(loan_prin) + "</td><td>" + accounting.formatMoney(interest) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");

        if (m % 48 == 0) {
            $("#tbl_payment_schedule").append("<tr class='yr_row' ><td> Year " + y + "</td><td>" + accounting.formatMoney(yr_total_pay) + "</td><td>" + accounting.formatMoney(yr_total_prin) + "</td><td>" + accounting.formatMoney(yr_total_int) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");
            $("#tbl_payment_schedule").append("<tr><td colspan='6'></td><tr>");
            y++;
            yr_total_int = 0;
            yr_total_pay = 0;
            yr_total_prin = 0;
            yr_total_bal = 0;
        }
        $("#tps_tot_bal").html(accounting.formatMoney(0));
        $("#tps_tot_pay").html(accounting.formatMoney(total_pay));
        $("#tps_tot_prin").html(accounting.formatMoney(total_prin));
        $("#tps_tot_int").html(accounting.formatMoney(total_int));

        $("#monthAr").val(JSON.stringify(monthAr));
        $("#monPayAr").val(JSON.stringify(monPayAr));
        $("#pricAr").val(JSON.stringify(pricAr));
        $("#intAr").val(JSON.stringify(intAr));
        $("#balAr").val(JSON.stringify(balAr));

    }
}
//Daily
function paytblDaily(tLoanAmt, tRate, tMonths, extra) {
    tRate = tRate / 100;
    var addPrinipal = 0;
    var calPayment = 0;
    var loan_prin = 0;
    var total_int = 0;
    var total_pay = 0;
    var total_prin = 0;
    var total_bal = 0;
    var yr_total_int = 0;
    var yr_total_pay = 0;
    var yr_total_prin = 0;
    var yr_total_bal = 0;

    var monthAr = [];
    var monPayAr = [];
    var pricAr = [];
    var intAr = [];
    var balAr = [];
    monthAr.length = 0; monPayAr.length = 0; pricAr.length = 0; intAr.length = 0; balAr.length = 0;

    var totalInterest = tLoanAmt * (tRate) * tMonths;
    tLoanAmt += totalInterest;

    $("#tbl_payment_schedule tbody").empty();
    $("#tbl_payment_schedule").append("<tr><td></td><td></td><td></td><td></td><td></td><td>" + accounting.formatMoney(tLoanAmt) + "</td><tr>");
    var y = 1;

    var instalment = tMonths * 30;

    for (var i = 0; i < instalment; i++) {
        var p, lm, interest, principal, balance;

        lm=tLoanAmt;

        interest = (totalInterest / instalment).toFixed(2);
        loan_prin = parseFloat(( lm - totalInterest) / instalment).toFixed(2);

        if (i === (instalment - 1)) {
            loan_prin = loan_prin - ((loan_prin * instalment) - (tLoanAmt - totalInterest));
        }

        if (lm < loan_prin) {
            loan_prin = lm;
            addPrinipal = 0;
        }
        if (lm < loan_prin + addPrinipal) {
            addPrinipal = parseFloat(lm) - parseFloat(loan_prin);
            console.log('loan_prin',loan_prin);
        }

        p = parseFloat(interest) + parseFloat(loan_prin) + parseFloat(addPrinipal);
        var  previousAmount = tLoanAmt;
        if (!!balAr[i-1]){
            previousAmount = balAr[i-1];
        }
        lm = previousAmount - p;

        total_int += parseFloat(interest);
        total_pay += parseFloat(p);
        total_prin += parseFloat(loan_prin);
        total_bal += parseFloat(lm);
        yr_total_int += parseFloat(interest);
        yr_total_pay += parseFloat(p);
        yr_total_prin += parseFloat(loan_prin);
        yr_total_bal += parseFloat(lm);
        var m = i + 1;

        monthAr.push(m);
        monPayAr.push(p);
        pricAr.push(loan_prin);
        intAr.push(interest);
        balAr.push(lm);

        $("#tbl_payment_schedule").append("<tr><td>" + m + "</td><td>" + accounting.formatMoney(p) + "</td><td>" + accounting.formatMoney(loan_prin) + "</td><td>" + accounting.formatMoney(interest) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");

        if (m % 360 == 0) {
            $("#tbl_payment_schedule").append("<tr class='yr_row' ><td> Year " + y + "</td><td>" + accounting.formatMoney(yr_total_pay) + "</td><td>" + accounting.formatMoney(yr_total_prin) + "</td><td>" + accounting.formatMoney(yr_total_int) + "</td><td>" + accounting.formatMoney(addPrinipal) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");
            $("#tbl_payment_schedule").append("<tr><td colspan='6'></td><tr>");
            y++;
            yr_total_int = 0;
            yr_total_pay = 0;
            yr_total_prin = 0;
            yr_total_bal = 0;
        }
        $("#tps_tot_bal").html(accounting.formatMoney(0));
        $("#tps_tot_pay").html(accounting.formatMoney(total_pay));
        $("#tps_tot_prin").html(accounting.formatMoney(total_prin));
        $("#tps_tot_int").html(accounting.formatMoney(total_int));

        $("#monthAr").val(JSON.stringify(monthAr));
        $("#monPayAr").val(JSON.stringify(monPayAr));
        $("#pricAr").val(JSON.stringify(pricAr));
        $("#intAr").val(JSON.stringify(intAr));
        $("#balAr").val(JSON.stringify(balAr));

    }
}

function paytblForEasyPayment(tLoanAmt, tRate, tMonths, extra, payDate) {
//    var rental_date =6;
    var today =  new Date($("#invDate").val());
    var rental_date = parseFloat($("#excuse_date").val())+1;
    today.setDate(today.getDate() - rental_date);
    
    var paymentDate = new Date(payDate);
     paymentDate.setMonth(paymentDate.getMonth() + 1);
    var newDate ;
    tRate = tRate / 100;
    var addPrinipal = 0;
    var calPayment = 0;
    var loan_prin = 0;
    var total_int = 0;
    var total_pay = 0;
    var total_prin = 0;
    var total_bal = 0;
    var yr_total_int = 0;
    var yr_total_pay = 0;
    var yr_total_prin = 0;
    var yr_total_bal = 0;
    
    var monthAr = [];
    var monPayAr = [];
    var pricAr = [];
    var intAr = [];
    var balAr = [];
     monthAr.length = 0; monPayAr.length = 0; pricAr.length = 0; intAr.length = 0; balAr.length = 0;
     
    $("#tbl_payment_schedule tbody").empty();
//    $("#tbl_payment_schedule").append("<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>" + accounting.formatMoney(tLoanAmt) + "</td><tr>");
    var y = 1;
    var rd = 0;
//    var rdr =0;
    var rdr = parseFloat($("#rental_rate").val());;
    var rdwp = 0;
    var total_rental = 0;
    calPayment = CalcPayment(tLoanAmt, tRate / 12, tMonths);
    for (var i = 0; i < tMonths; i++) {
        var p, lm, interest, principal, balance;
//        newDate = paymentDate.getFullYear()+"-"+(paymentDate.getMonth()+1)+"-"+paymentDate.getDate();
        var days = (paymentDate - today) / (1000 * 60 * 60 * 24);
//        alert(rdwp);
        if(days<0){
            rd = (calPayment+rdwp)*rdr/100;
        }else{
            rd =0;
        }
        
        if (i == 0) {
            lm=tLoanAmt;
        } else {
            lm= lm;
        }
        
         interest = (lm * (tRate) / 12).toFixed(2);
            loan_prin = parseFloat(calPayment).toFixed(2) - parseFloat(interest).toFixed(2);
            if (lm < loan_prin) {
                loan_prin = lm;
                addPrinipal = 0;
            }
            
            if (lm < loan_prin + addPrinipal) {
                addPrinipal = parseFloat(lm) - parseFloat(loan_prin);
            }

            p = parseFloat(interest) + parseFloat(loan_prin) + parseFloat(addPrinipal);
            lm = (lm - parseFloat(loan_prin)) + parseFloat(addPrinipal);
          
        rdwp = p+parseFloat(rd);
        total_rental+= rdwp;
        total_int += parseFloat(interest);
        total_pay += parseFloat(p);
        total_prin += parseFloat(loan_prin);
        total_bal += parseFloat(lm);
        yr_total_int += parseFloat(interest);
        yr_total_pay += parseFloat(p);
        yr_total_prin += parseFloat(loan_prin);
        yr_total_bal += parseFloat(lm);
        var m = i + 1;
        var total_rentals = 0;
        if(paymentDate.getMonth()<today.getMonth() && paymentDate<today){
           total_rentals = 0;
        }else{
           total_rentals = total_rental; 
        }
        
        if(paymentDate.getMonth()==today.getMonth() && paymentDate<today){
           rdwp = total_rental;
        }else{
           rdwp = rdwp; 
        }
        
        monthAr.push(m);
        monPayAr.push(p);
        pricAr.push(loan_prin);
        intAr.push(interest);
        balAr.push(lm);
        
        $("#tbl_payment_schedule").append("<tr><td>" + m + "</td><td>" + getFormattedDate(paymentDate) + "</td><td>" + accounting.formatMoney(p) + "</td><td>" + accounting.formatMoney(p) + "</td><td>" + accounting.formatMoney(rd) + "</td><td >" + accounting.formatMoney(rdwp) + "</td><td class='text-right creditAmount'>" + accounting.formatMoney(rdwp) + "</td><td>" + accounting.formatMoney(total_rentals) + "</td><td>" + accounting.formatMoney(total_rentals) + "</td><td>" + accounting.formatMoney(loan_prin) + "</td><td>" + accounting.formatMoney(interest) + "</td><td>" + accounting.formatMoney(p) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");
        
        if (m % 12 == 0) {
            $("#tbl_payment_schedule").append("<tr class='yr_row' ><td> Year " + y + "</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>" + accounting.formatMoney(yr_total_prin) + "</td><td>" + accounting.formatMoney(yr_total_int) + "</td><td>" + accounting.formatMoney(yr_total_pay) + "</td><td>" + accounting.formatMoney(lm) + "</td><tr>");
            $("#tbl_payment_schedule").append("<tr><td colspan='12'></td><tr>");
            y++;
            yr_total_int = 0;
            yr_total_pay = 0;
            yr_total_prin = 0;
            yr_total_bal = 0;
        }

        paymentDate.setMonth(paymentDate.getMonth() + 1);
        $("#tps_tot_bal").html(accounting.formatMoney(0));
        $("#tps_tot_pay").html(accounting.formatMoney(total_pay));
        $("#tps_tot_prin").html(accounting.formatMoney(total_prin));
        $("#tps_tot_int").html(accounting.formatMoney(total_int));
        
        $("#monthAr").val(JSON.stringify(monthAr));
        $("#monPayAr").val(JSON.stringify(monPayAr));
        $("#pricAr").val(JSON.stringify(pricAr));
        $("#intAr").val(JSON.stringify(intAr));
        $("#balAr").val(JSON.stringify(balAr));
        
    }
}

function getFormattedDate(date) {
  var year = date.getFullYear();
  var month = (1 + date.getMonth()).toString();
  month = month.length > 1 ? month : '0' + month;
  var day = date.getDate().toString();
  day = day.length > 1 ? day : '0' + day;
  return month + '/' + day + '/' + year;
}

function calcTotalInterest(tLoanAmt, tRate, tMonths) {
    // console.log('tamount', tLoanAmt);
    // console.log('rate', tRate);
    // console.log('months', tMonths);
    var tRate2 = tRate / 100;

    var total_int = tRate2 * tLoanAmt * tMonths;

    // var total_int = 0;

    // for (var i = 0; i < tMonths; i++) {
    //     var p, lm, interest;
    //     if (i == 0) {
    //         interest = (tLoanAmt * (tRate) / 12).toFixed(2);
    //         p = CalcPayment(tLoanAmt, tRate / 12, tMonths);
    //         lm = tLoanAmt - (p - interest);
    //     } else {
    //         interest = (lm * (tRate) / 12).toFixed(2);
    //         p = CalcPayment(lm, tRate / 12, (tMonths - i));
    //         lm = (lm - (p - interest)).toFixed(2);
    //     }
    //     total_int += parseFloat(interest);
    // }
    // console.log('total', total_int);
    return (total_int);
}

function calcTotalInterest2(tLoanAmt, tRate, tMonths) {
    tRate = tRate / 100;
    var total_int = 0;
    for (var i = 0; i < tMonths; i++) {
        var p, lm, interest;
        if (i == 0) {
            interest = (tLoanAmt * (tRate) / 12).toFixed(2);
            p = CalcPayment(tLoanAmt, tRate / 12, tMonths);
            lm = tLoanAmt - (p - interest);
        } else {
            interest = (lm * (tRate) / 12).toFixed(2);
            p = CalcPayment(lm, tRate / 12, (tMonths - i));
            lm = (lm - (p - interest)).toFixed(2);
        }
        total_int += parseFloat(interest);
    }
    return (total_int);
}


// numeric functions
function NumRnd(Value, DecDigits)
{
    var Power = Math.pow(10, DecDigits);
    var Num = Math.round(Value * Power) / Power;

    console.log(Num);
}

//if (i == 0) {
//    interest = (tLoanAmt * (tRate) / 12);
////			alert(interest);
//    p = CalcPayment(tLoanAmt, tRate / 12, tMonths);
////                        p = NumRnd(p,2);
//    lm = tLoanAmt - (p - interest);
////                       alert(p+" , "+interest+" , "+lm);
////			console.log(p+" , "+interest+" , "+lm);
//} else {
//    interest = (lm * (tRate) / 12);
//    p = CalcPayment(lm, tRate / 12, (tMonths - i));
////                         p = NumRnd(p,2);
//    lm = (lm - (p - interest));
////			console.log(p+" , "+interest+" , "+lm);
//}