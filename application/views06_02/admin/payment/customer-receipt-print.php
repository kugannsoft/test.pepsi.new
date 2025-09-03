<div class="row"  id="printArea" align="center" style='margin:5px;'>
    <!-- company header -->
     <?php $this->load->view('admin/_templates/company_header_mini.php',true); ?>

    <table style="border-collapse:collapse;width:290px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
        <?php //foreach ($company as $com) {  ?>
        
        <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
            <td colspan="4">Customer Receipt</td>
        </tr>
        <tr style="text-align:center;">
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td colspan="2">Payment Number</td>
            <td>:</td>
            <td id="invNumber"></td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td colspan="2">Payment Date</td>
            <td>:</td>
            <td id="invoiceDate"></td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td colspan="2">Customer Name</td>
            <td>:</td>
            <td id="cusname"></td>
        </tr>
        <!-- <tr style="text-align:left;font-size:13px;">
            <td colspan="2">Outstanding Balance</td>
            <td>:</td>
            <td id="outstand"></td>
        </tr> -->
    </table>
    <style>#tblData td{padding: 2px;}</style>
    <table id="tblData"  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
        <thead>
            <tr style="text-align:center;border:#000 solid 1px;">
                <td style="text-align:center;border:#000 solid 1px;">Cheque Date</td>
                <td style="text-align:center;border:#000 solid 1px;"> Cheque No</td>
                <td style="text-align:center;border:#000 solid 1px;">Bank Name</td>
                <td style="text-align:center;border:#000 solid 1px;">T. Amount</td>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot style='border:#000 solid 1px;'>
            <tr >
                <td colspan="3" style="text-align: right;">Total Payment Amount</td>
            <!--<td></td>-->
                <td style="text-align:right"  id="invTotal">0.00</td>
            </tr>
        </tfoot>
    </table>
    <table  style="border-collapse:collapse;width:290px;font-size:14px;margin:5px 5px 30px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">
        <tr style="text-align:center;font-size:15px;">
            <td colspan="4"><b>Thank You Come Again</b></td>
        </tr>
        <tr style="text-align:center">
            <td colspan="4">&nbsp;</td>
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
</div> 