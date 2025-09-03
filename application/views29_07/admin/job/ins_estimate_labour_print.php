<div class="row"  id="printArea2" align="center" style='margin:0px 5px 0px 5px;'>
<style>
.borderdot{
    border-bottom: 1px dashed #000;
}

.bordertopbottom{
    border-bottom: 1px solid #000;
    border-top: 1px solid #000;
}
/*#tbl_footer{page-break-after: always;}*/
/*p { page-break-after: always; }*/
</style>
    <table style="border-collapse:collapse;width:700px;margin:0px 5px 0px 5px;font-family: times,Arial, Helvetica, sans-serif;" border="0">
        
        <tr style="text-align:left;font-size:12px;">
            <td style="padding-left:5px;width:100px;"> Code</td>
            <td style="width:5px;"> :</td>
            <td colspan="4" style="width:300px;"><span id="lblcusCodelb"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align:left;font-size:15px;padding-top: 5px;width:250px;" colspan="3" > <b><span id="lblesttypelb"></span> ESTIMATE</b></td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td style="padding: 0px 5px;" valign="top">Customer Name</td>
            <td> :</td>
            <td rowspan="3" colspan="4" valign="top" style="font-size:10px;"  id="lblcusNamelb"></td>
            <td>&nbsp;</td>
            <td colspan="3" rowspan="5" style="padding-left:20px;">
            <table style="font-size: 12px">
            <tbody>
                    <tr>
                        <td>Date</td><td>:</td><td  id="lblinvDatelb"></td>
                    </tr>
                    <tr>
                        <td>Tele</td><td>:</td><td  id="lbltellb"></td>
                    </tr>
                     <tr>
                        <td>Make</td><td>:</td><td  id="lblmakelb"></td>
                    </tr>
                     <tr>
                        <td>Model </td><td>:</td><td id="lblmodellb"></td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td style="padding:0px 5px">Address</td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td > </td>
            <td ></td>
            <td >&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td colspan="2"> Insurance Company</td>
            <!-- <td> :</td> -->
            <td colspan="4" id="lblInsCompanylb"> &nbsp;:&nbsp; &nbsp;&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
    padding: 0px;
    font-size: 10px;
}
</style>
    <table id="tbl_est_data_lb" style="font-family:times;border-collapse:collapse;width:700px;padding:5px;font-size:11px;" border="0">
        <thead>
            <tr>
                <td colspan="2"  style="font-size:12px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-weight: none;font-size:12px;">Contact Name</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblConNamelb" style="width:200px;font-weight: none;font-size:11px;"></span>
                </td>
                <td colspan="3"  style="width:300px;font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;font-weight: bold;">Estimate No&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: bold;" id="lblestimateNolb"></span></td>
            </tr>
            <tr>
                <td colspan="2"  style="font-size:12px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-weight: bold;font-size:13px;">V. I. No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblviNolb" style="width:200px;font-weight: none"></span>
                </td>
                <td colspan="3" style="font-size:12px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">Supplementary No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblsupNolb"></span></td>
            </tr>
             <!-- <tr><td style="height:10px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;" colspan="5"></td></tr> -->
            <tr>
                <td colspan="2"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-size: 13px;">Reg: No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblregNolb" style="width:200px;font-size: 13px;"></span>
                </td>
                <td colspan="3" style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none"></span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblmodelnolb"></span></td>
            </tr>
            <!-- <tr><td style="border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;" colspan="5">&nbsp;</td></tr> -->
            <tr>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 20px'>ITEM</td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 360px'>DESCRIPTION</td>
                <th style='font-size:11px;padding: 1px;text-align:center;width:20px;'></th>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 30px'>QTY</td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 70px'>NETT QUOTED AMOUNT</td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 80px'>AMENDED AMOUNT</td>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr id="is_rowTotal"><td colspan="4" style="text-align:right;padding: 2px;border-top:1px solid #fff;">SUB TOTAL</td><td id="is_total" style="text-align:right;padding: 2px;border:1px solid #000;">&nbsp;</td><td style="text-align:right;padding: 2px;border-top:1px solid #fff;">&nbsp;</td></tr>
            <tr id="is_rowVat"><td colspan="4" style="text-align:right;padding: 2px;">VAT 15 %</td><td id="is_vat" style="text-align:right;padding: 2px;border:1px solid #000;">&nbsp;</td><td style="text-align:right;padding: 2px;">&nbsp;</td></tr>
            <tr id="is_rowNbt"><td colspan="4" style="text-align:right;padding: 2px;">NBT</td><td id="is_nbt" style="text-align:right;padding: 2px;border:1px solid #000;">&nbsp;</td><td style="text-align:right;padding: 2px;">&nbsp;</td></tr>
            <tr id="is_rowNet"><td colspan="4" style="text-align:right;padding: 2px;font-weight:bold;">Estimate Amount</td><td id="is_net" style="text-align:right;padding: 2px;font-weight:bold;border:1px solid #000;">&nbsp;</td><td style="text-align:right;padding: 2px;">&nbsp;</td></tr>
        </tfoot>
        </table>
        
</div>