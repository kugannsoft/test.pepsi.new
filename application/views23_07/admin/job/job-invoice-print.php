<div class="row"  id="printArea" align="center" style='margin:5px;'>
<!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>

<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td> Customer Code</td>
        <td> :</td>
        <td id="lblcusCode"> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;"> <b>General Invoice</b></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> Customer Name</td>
        <td> :</td>
        <td id="lblcusName"> &nbsp;</td>
        <td > Date</td>
        <td> :</td>
        <td  id="lblinvDate"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> Address</td>
        <td> :</td>
        <td rowspan="3" id="lblAddress" valign="top"> &nbsp;</td>
        <td> Tel</td>
        <td> :</td>
        <td  id="lbltel"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> </td>
        <td></td>
        <td > Make</td>
        <td> :</td>
        <td  id="lblmake"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td></td>
        <td> Model No</td>
        <td> :</td>
        <td  id="lblmodel"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> Contact Name</td>
        <td>:</td>
        <td  id="lblConName"> &nbsp;</td>
        <td > Estimate No</td>
        <td> :</td>
        <td  id="lblestimateNo"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> V. I. No </td>
        <td>:</td>
        <td  id="lblviNo"> &nbsp;</td>
        <td > Invoice No</td>
        <td> :</td>
        <td id="lblinvoiceNo"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td>Reg No</td>
        <td>:</td>
        <td  id="lblregNo"> &nbsp;</td>
        <td > </td>
        <td> </td>
        <td> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td colspan="6">&nbsp;</td>
    </tr>
</table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
    padding: 13px;
}
</style>
                <table id="tbl_est_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:14px;" border="1">
                    <thead>
                        <tr>
                            <th style='padding: 3px;width:20px;'>Item</th>
                            <th style='padding: 3px;width:300px;'>Description</th>
                            <th style='padding: 3px;width:40px;'>Qty</th>
                            <th style='padding: 3px;width:70px;'>Unit Price</th>
                            <th style='padding: 3px;width:80px;'>Net Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="4" style="text-align:right">Total Amount  </th><th id="lbltotalEsAmount"   style='text-align:right'></th></tr>
                         <tr><th colspan="4" style="text-align:right">Discount  </th><th id="lbltotalDicount"   style='text-align:right'></th></tr>
                          <tr><th colspan="4" style="text-align:right">Advance  </th><th id="lblAdvance"   style='text-align:right'></th></tr>
                        <!-- <tr><th colspan="4" style="text-align:right">VAT Amount  </th><th id="lbltotalVat"   style='text-align:right'></th></tr>
                        <tr><th colspan="4" style="text-align:right">NBT Amount  </th><th id="lbltotalNbt"   style='text-align:right'></th></tr> -->
                        <tr><th colspan="4" style="text-align:right">Net Amount  </th><th id="lbltotalNet"   style='text-align:right'></th></tr>
                        <!-- <tr><th colspan="5"  style="text-align:left">Remark: <span id="lblremark"></span></th></tr> -->
                        <tr>
                            <th colspan="5" style="text-align:left;font-size: 12px;">
                                <!-- <ul>
                                    <li>Please Make 50 % advance payment at the time of estimate/s approval to commence repairs.</li>
                                    <li>If any defects / areas needing attention is found after dismantling or during the repair process, we reserve the right
to submit a supplementary estimate for your approval.</li>
                                    <li>Service charges are valid for 90 days from the date of issue.</li>
                                    <li>We will not be responsible for quality of job for any work carried out using non genuine or used parts.</li>
                                    <li>Delivery subject to availability of parts & man power.</li>
                                    <li>Replaced parts should be collected at the time of delivery or within 01 week from the date of invoice. We will not be
responsible for any replaced parts thereafter.</li>
                                    <li>All payments related to the repairs are required to be settled in full prior to the delivery of the vehicle.</li>
                                    <li>Any deductions made by insurer according to the policy conditions on your insurance policy, we will not deducted
from our final invoice.</li>
                                </ul> -->
                            </th>
                        </tr></tfoot>
                </table><br>
                <div id="foot" style="border: 1px #000 solid;width:697px;padding: 5px;">
                        <table style="border-collapse:collapse;width:683px;padding:2px;" border="0">
                          <tbody>
                            <tr><td colspan="4" style='text-align:center'>I Certify that there are no
valubles in the bike.</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td style="border-top:1px dashed #000;text-align: center;width:200px;">Name</td><td>&nbsp;</td><td>&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:200px;">Customer Authorisation</td></tr>
                            
</tbody>
</table>
</div>
                <!-- <table style="border-collapse:collapse;width:700px;padding:5px;" border="0">
                        <tr><th colspan="5" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</th></tr>
                        <tr><th colspan="5" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</th></tr>
                        <tr><th colspan="4" style="text-align:right;border-left:1px #000 solid;border-bottom:1px #000 solid;width:400px;">&nbsp;</th><th style="border-top:1px dashed #000;border-bottom:1px #000 solid;border-right:1px #000 solid;">Signature</th></tr>
                    </table> -->
            </div>