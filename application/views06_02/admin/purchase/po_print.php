<div class="row"  id="printArea" align="center" style='margin:5px;'>
    <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>  
                        
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
    <tr style="text-align:left;font-size:13px;">
        <td> Delevery Date</td>
        <td> :</td>
        <td id="lblinvDate"> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" style="text-align:center;font-size:20px;"> <b>Purchase Order</b></td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> PO No</td>
        <td> :</td>
        <td id="lblPoNo"> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3">Ship to :</td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td> Vendor</td>
        <td></td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="3" rowspan="3" style="font-size:14px;border: #000 solid 1px;padding:10px;">
            <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?><br>
            <?php echo $company['AddressLine01'] ?><br><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?><br>
            Contact Us - <?php echo $company['LanLineNo'] ?>
        </td>
    </tr>
    <tr style="text-align:left;font-size:13px;">
        <td  id="lblSupplier" colspan="3"  style="font-size:14px;border: #000 solid 1px;padding:5px;"> Vendor</td>
        <td> &nbsp;</td>
        <td ></td>
    </tr>
</table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
    padding: 13px;
}
</style><br>
    <table id="tbl_po_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
        <thead>
            <tr>
                <th style='padding: 3px;'>#</th>
                <th style='padding: 3px;'>Description</th>
                <!-- <th style='padding: 3px;'></th> -->
                <th style='padding: 3px;'>Qty</th>
                <th style='padding: 3px;'>Unit</th>
                <th style='padding: 3px;'>Unit Price</th>
                <th style='padding: 3px;'>Total Price</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr><th colspan="5" style="text-align:right;padding: 3px;">Total Amount </th><th id="lbltotalPOAmount"   style='text-align:right;padding: 3px;'></th></tr>
            <tr id="rowDiscount"><th colspan="5" style="text-align:right;padding: 3px;">Discount  </th><th id="lbltotalDiscount"   style='text-align:right;padding: 3px;'></th></tr>
            <tr id="rowVat" ><th colspan="5" style="text-align:right;padding: 3px;">VAT Amount  </th><th id="lbltotalVatAmount"   style='text-align:right;padding: 3px;'></th></tr>
            <tr id="rowNbt"><th colspan="5" style="text-align:right;padding: 3px;">NBT Amount  </th><th id="lbltotalNbtAmount"   style='text-align:right;padding: 3px;'></th></tr>
            <tr id="rowNet"><th colspan="5" style="text-align:right;padding: 3px;">Net Amount  </th><th id="lbltotalPONetAmount"   style='text-align:right;padding: 3px;'></th></tr>
            
            </tfoot>
    </table>
    <table style="width:700px;" border="0">
            <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
            <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
            <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
            <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
             <tr>
                <td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td>
                <td style="">&nbsp;</td>
                <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
                <td style="">&nbsp;</td>
                <td style="">&nbsp;</td>
            </tr>
            <tr>
                <td style="width:100px;text-align: center">Prepared By</td>
                <td style="">&nbsp;</td>
                <td style="width:200px;text-align: center">Authorised Signature</td>
                <td style="">&nbsp;</td>
                <td style="">&nbsp;</td>
            </tr>
        </table>
</div>