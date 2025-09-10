<table style="border-collapse:collapse;width:290px;margin:5px" border="0">
    <tr style="text-align:center;font-size:25px;">
        <td colspan="4"><b> <?php echo $company['CompanyName'] ?></b></td>
    </tr>
    <tr style="text-align:center;font-size:20px;">
        <td colspan="4"><b><?php echo $company['CompanyName2'] ?></b></td>
    </tr>
    <tr style="text-align:center;font-size:15px;">
        <td colspan="4"><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?></td>
    </tr>
    <tr style="text-align:center;font-size:15px;">
        <td colspan="4"><?php echo $company['LanLineNo'] ?></td>
    </tr>
    <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;">
        <td colspan="4">Cash Invoice</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="2">Invoice Number</td>
        <td>:</td>
        <td id="invNumber"></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="2">Invoice Date</td>
        <td>:</td>
        <td id="invoiceDate"></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="2">Cashier</td>
        <td>:</td>
        <td id="invCashier"></td>
    </tr>
</table>
<style>#tblData td{padding: 2px;}</style>
<table id="tblData"  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px;" border="0">
    <thead>
        <tr style="text-align:center;border:#000 solid 1px;">
            <td style="text-align:center;border:#000 solid 1px;">Description</td>
            <td style="text-align:center;border:#000 solid 1px;"> Qty</td>
            <td style="text-align:center;border:#000 solid 1px;">Price</td>
            <td style="text-align:center;border:#000 solid 1px;">T. Amount</td>
        </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot style='border:#000 solid 1px;'>
        <tr >
            <td colspan="3" style="text-align: right;">Total Amount</td>
        <!--<td></td>-->
            <td style="text-align:right"  id="invTotal">0.00</td>
        </tr>
        <tr id="discountRow">
            <td colspan="3" style="text-align: right;">Total Discount</td>
            <!--<td></td>-->
            <td style="text-align:right"  id="invTotalDis">0.00</td>
        </tr>
        <tr  id="netAmountRow">
            <td colspan="3"  style="text-align: right;">Net Amount</td>
            <!--<td></td>-->
            <td style="text-align:right"  id="invNet">0.00</td>
        </tr>
        <tr  id="cusPayRow">
            <td colspan="3"  style="text-align: right;">Customer Pay</td>
            <!--<td></td>-->
            <td style="text-align:right"  id="invCusPay">0.00</td>
        </tr>
        <tr  id="balanceRow">
            <td colspan="3" id="crdLabel" style="text-align: right;">Balance Amount</td>
            <!--<td></td>-->
            <td style="text-align:right"  id="invBalance">0.00</td>
        </tr>
    </tfoot>
</table>
<table  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px 5px 30px 5px;" border="0">

    <tr>
        <td colspan="4" style="text-align:left;font-size:12px;">Number of Item <span id="invNoItem"></span></td>
    </tr>
    <tr style="text-align:center">
        <td colspan="4">Every accessories for 6 month warranty</td>
    </tr>
    <tr style="text-align:center">
        <td colspan="4"><b>Thank You Come Again</b></td>
    </tr>
    <tr style="text-align:center">
        <td colspan="4">Any compliant to sms <?php echo $company['MobileNo'] ?></td>
    </tr>
    <tr style="text-align:center;font-size:12px;">
        <td colspan="4"><i>Software By NSOFT &nbsp;&nbsp;&nbsp;&nbsp;www.nsoft.lk</i></td>
    </tr>
    <tr style="text-align:center">
        <td colspan="4" style="height:30px;">&nbsp;</td>
    </tr>
    <tr style="text-align:center">
        <td colspan="4">-</td>
    </tr>
</table>