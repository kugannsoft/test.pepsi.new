<!--invoice print-->
<div class="row"  id="printArea" align="center" style='margin:5px;'>
    <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>  

    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
        <tr style="text-align:left;font-size:13px;">
            <td> PRN No</td>
            <td> :</td>
            <td id="lblgrnno"></td>
            <td colspan="3" style="text-align:center;font-size:20px;"> <b>Purchase Return Note</b></td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td> Date</td>
            <td> :</td>
            <td id="lblinvDate"></td>
            <td colspan="3" style="text-align:center;font-size:20px;"></td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td> Supplier</td>
            <td> :</td>
            <td id="lblcusName" colspan="4"></td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td> Address</td>
            <td> :</td>
            <td rowspan="2" id="lblAddress" valign="top"></td>
            <td class="text-right"> Invoice No</td>
            <td>: </td>
            <td  id="lblinvNo"></td>
        </tr>
        <tr style="text-align:left;font-size:13px;">
            <td> </td>
            <td></td>
            <td class="text-right">Addtional Charges </td>
            <td> :</td>
            <td  id="lblAddCharge"></td>
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
        <table id="tbl_est_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
            <thead>
                
                <tr>
                    <th style='padding: 3px;'>#</th>
                    <th style='padding: 3px;'>Code</th>
                    <th style='padding: 3px;'>Description</th>
                    <th style='padding: 3px;'>Qty</th>
                    <th style='padding: 3px;'>Cost Price</th>
                    <th style='padding: 3px;'>Unit Price</th>
                    <th style='padding: 3px;'>Total</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr><th colspan="5" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Total Amount  </th><th id="lbltotalAmount"   style='text-align:right'></th></tr>
                <tr id="rowDis"><th colspan="5" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">Discount  </th><th id="lbltotalDis"   style='text-align:right'></th></tr>
                <tr id="rowVat"><th colspan="5" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">VAT  </th><th id="lbltotalVat"   style='text-align:right'></th></tr>
                <tr id="rowNbt"><th colspan="5" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right">NBT  </th><th id="lbltotalNbt"   style='text-align:right'></th></tr>
                
                <tr id="rowNet"><th colspan="5" style="border-left: 1px #fff solid;border-bottom: 1px #fff solid;"></th><th style="text-align:right"> Net Amount  </th><th id="lbltotalNet"   style='text-align:right'></th></tr>
                
                </tfoot>
        </table>
        <table style="width:700px;" border="0">
                <tr><td colspan="5" style="text-align:left;">&nbsp;</td></tr>
                <tr>
                    <td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                <tr><td colspan="5" style="text-align:right;">&nbsp;</td></tr>
                <tr><td style="border-bottom:1px dashed #000;width:100px" >&nbsp;</td><td style="">&nbsp;</td>
                    <td style="border-bottom:0px dashed #000;width:200px">&nbsp;</td>
                    <td style="">&nbsp;</td>
                   <td style="border-bottom:1px dashed #000;width:200px">&nbsp;</td>
               </tr>
               <tr>
                    <td style="width:100px;text-align: center">Approved By</td>
                    <td style="">&nbsp;</td>
                    <td style="width:200px;text-align: center"></td>
                    <td style="">&nbsp;</td>
                    <td style="width:200px;text-align: center">Signature</td>
                </tr>
            </table>
    </div>