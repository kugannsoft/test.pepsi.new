<div class="row"  id="printArea" align="center" style='margin:5px;'>
    <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>  

    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td></td>
        <td> </td>
        <td > &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;font-weight: bold;" ><span id="lblInvType"></span> </td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td colspan="2">Bill to :</td>
<td> &nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2"> &nbsp;</td>    
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td colspan="2" rowspan="4" style="font-size:14px;border: #000 solid 1px;padding:10px;">
            <span id="lblcusName"></span><br>
            <span id="lbladdress1"></span>
            <!-- <span id="lbladdress2"></span><br> -->
        </td>
        <td> &nbsp;</td>
        <td>Invoice No</td>
        <td>:</td>
        <td colspan="2" id="lblPoNo"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td>Invoice Date</td>
        <td>:</td>
        <td colspan="2" id="lblinvDate"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td>Remark</td>
        <td>:</td>
        <td colspan="2" style="border-bottom:1px dashed #000;"> &nbsp;</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
    <td> &nbsp;</td>
        <td colspan="4" style="border-bottom:1px dashed #000;"> &nbsp;</td>

    </tr>
    <tr style="text-align:right;font-size:13px;">
        <td colspan="2" ></td><td colspan="5" style="text-align: right;padding-top: 13px;" id="vatno">VAT Reg. No : <?php echo $company['Email02'] ?></td>
    </tr>
</table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
    padding: 13px;
}

</style><br>
<table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
    <thead id="taxHead">
        <tr>
            <th style='padding: 3px;width:30px;'>Qty</th>
            <th style='padding: 3px;width:250px;'>Description</th>
            <!-- <th style='padding: 3px;'></th> -->
            <th style='padding: 3px;width:60px;'>Warranty</th>
            <th style='padding: 3px;width:80px;'>Unit Price</th>
            <th style='padding: 3px;width:80px;'>Total Price</th>
        </tr>
    </thead>
    <thead  id="invHead">
        <tr>
            <th style='padding: 3px;width:30px;'>Qty</th>
            <th style='padding: 3px;width:250px;'>Description</th>
            <!-- <th style='padding: 3px;'></th> -->
            <th style='padding: 3px;width:60px;'>Warranty</th>
            <th style='padding: 3px;width:80px;'>Unit Price</th>
            <th style='padding: 3px;width:80px;'>Total Price</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr id="rowTotal"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">Total Amount </th><th id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowDiscount"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">Discount  </th><th id="lbltotalDiscount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowVat" ><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">VAT Amount  </th><th id="lbltotalVatAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowNbt"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">NBT Amount  </th><th id="lbltotalNbtAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowNet"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th  style="text-align:right;padding: 3px;">Net Amount  </th><th id="lbltotalPONetAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowAdvance"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th  style="text-align:right;padding: 3px;">Advance Amount  </th><th id="lbltotalPOAdvanceAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowCash"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">Cash Amount  </th><th id="lbltotalCashAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowCredit"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">Credit Amount  </th><th id="lbltotalCreditAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowCheque"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">Cheque Amount  </th><th id="lbltotalChequeAmount"   style='text-align:right;padding: 3px;'></th></tr>
        <tr id="rowCard"><th colspan="3" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right;padding: 3px;">Card Amount  </th><th id="lbltotalCardAmount"   style='text-align:right;padding: 3px;'></th></tr>
        </tfoot>
</table>
<table style="width:700px;" border="0">
        <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
        <tr><td colspan="5" style="text-align:left;">Thank You For Your Business</td></tr>
        <tr><td colspan="5" style="text-align:left;font-size:9px;"><i>This Invoice Should be Provide for Warranty all Cheques Should be Drawn in Favour Of</i></td></tr>
        <tr><td colspan="5" style="text-align:left;font-size:9px;"><i>"HK Computer Solutions (Pvt) Ltd."</i></td></tr>
         <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
          <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
           <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr> <tr>
            <td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td>
            <td style="">&nbsp;</td>
            <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
            <td style="">&nbsp;</td>
           <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:100px;text-align: center">Prepared By</td>
            <td style="">&nbsp;</td>
            <td style="width:200px;text-align: center">Approved By</td>
            <td style="">&nbsp;</td>
            <td style="width:200px;text-align: center">Customer Signature</td>            
        </tr>
    </table>
</div>