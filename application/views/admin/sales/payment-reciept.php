<div class="row"  id="printArea" align="center" style='margin:5px;'>
    <!-- company header -->
     <?php $this->load->view('admin/_templates/company_header_mini.php',true); ?>

    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="1">
        <?php //foreach ($company as $com) {  ?>
        
        <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
            <td colspan="9" style="height: 100px">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><b>Office Copy</b></td>
            <td>DATE</td>
            <td>:</td>
            <td id="lbldate">2018-02-23</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>RECEIPT NO</td>
            <td>&nbsp;</td>
            <td id="lblreceiptno">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Received with thanks a sum of Rupees</td>
            <td>:</td>
            <td colspan="4"  id="lblamountword">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Reason for payment </td>
            <td>:</td>
            <td colspan="4"  id="lblreason">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">In Cash / Cheque from</td>
            <td>:</td>
            <td colspan="4" id="lblcusname">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>
            <td></td>
            <td colspan="2"  id="lblinvno">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Vehicle No</td>
            <td>:</td>
            <td colspan="2" id="lblvno"></td>
            <td>Code&nbsp;&nbsp;&nbsp;:</td>
            <td>181</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Amount</td>
            <td>:</td>
            <td colspan="2" id="lblamount"></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Cheque No</td>
            <td>:</td>
            <td colspan="2" id="lblchequeno"></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Bank</td>
            <td>:</td>
            <td colspan="2" id="lblbank"></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>Cashier</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Date</td>
            <td>:</td>
            <td colspan="2"  id="lblchequedate"></td>
            <td></td>
            <!-- <td>&nbsp;</td> -->
            <td colspan="3"> ( Subject to realization of remittance )</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Payment Type</td>
            <td>:</td>
            <td colspan="2"  id="lblpaytype"></td>
            <td></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <!-- <tr style="text-align:left;font-size:13px;">
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
        </tr> -->
        <!-- <tr style="text-align:left;font-size:13px;">
            <td colspan="2">Outstanding Balance</td>
            <td>:</td>
            <td id="outstand"></td>
        </tr> -->
    </table>
    <style>#tblData td{padding: 2px;}</style>
    
</div> 