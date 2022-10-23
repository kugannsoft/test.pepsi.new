<div class="row"  id="printArea" align="center" style='margin:0px 5px 0px 5px;'>
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
    <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>  
    <table style="border-collapse:collapse;width:700px;margin:0px 5px 0px 5px;font-family: times,Arial, Helvetica, sans-serif;" border="0">
        
        <tr style="text-align:left;font-size:12px;">
            <td style="border-top: #000 solid 1px;border-left: #000 solid 1px;padding-left:5px;width:100px;"> Code</td>
            <td style="border-top: #000 solid 1px;width:5px;"> :</td>
            <td colspan="4" style="border-top: #000 solid 1px;border-right: #000 solid 1px;width:300px;"><span id="lblcusCode"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align:left;font-size:15px;padding-top: 5px;width:250px;" colspan="3" > <b><span id="lblesttype"></span> ESTIMATE</b></td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td style="border-left: #000 solid 1px;padding: 0px 5px;" valign="top">Customer Name</td>
            <td> :</td>
            <td rowspan="3" colspan="4" valign="top" style="border-right: #000 solid 1px;border-bottom: #000 solid 1px;font-size:10px;"  id="lblcusName"></td>
            <td>&nbsp;</td>
            <td colspan="3" rowspan="5" style="padding-left:20px;">
            <table style="font-size: 12px">
            <tbody>
                    <tr>
                        <td>Date</td><td>:</td><td  id="lblinvDate"></td>
                    </tr>
                    <tr>
                        <td>Tele</td><td>:</td><td  id="lbltel"></td>
                    </tr>
                     <tr>
                        <td>Make</td><td>:</td><td  id="lblmake"></td>
                    </tr>
                     <tr>
                        <td>Model </td><td>:</td><td id="lblmodel"></td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td style="border-left: #000 solid 1px;padding:0px 5px">Address</td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td style="border-left: #000 solid 1px;border-bottom: #000 solid 1px;"> </td>
            <td  style="border-bottom: #000 solid 1px;"></td>
            <td >&nbsp;</td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td colspan="2"> Insurance Company</td>
            <!-- <td> :</td> -->
            <td colspan="4" id="lblInsCompany"> &nbsp;:&nbsp; &nbsp;&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
    padding: 0px;
    font-size: 10px;
}
</style>
    <table id="tbl_est_data" style="font-family:times;border-collapse:collapse;width:700px;padding:5px;font-size:11px;" border="1">
        <thead>
            <tr>
                <td colspan="2"  style="font-size:12px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-weight: none;font-size:12px;">Contact Name</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblConName" style="width:200px;font-weight: none;font-size:11px;"></span>
                </td>
                <td colspan="3"  style="width:300px;font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;font-weight: bold;">Estimate No&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: bold;" id="lblestimateNo"></span></td>
            </tr>
            <tr>
                <td colspan="2"  style="font-size:12px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-weight: bold;font-size:13px;">V. I. No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblviNo" style="width:200px;font-weight: none"></span>
                </td>
                <td colspan="3" style="font-size:12px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">Supplementary No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblsupNo"></span></td>
            </tr>
             <!-- <tr><td style="height:10px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;" colspan="5"></td></tr> -->
            <tr>
                <td colspan="2"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-size: 13px;">Reg: No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblregNo" style="width:200px;font-size: 13px;"></span>
                </td>
                <td colspan="3" style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none"></span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblmodelno"></span></td>
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
            <tr id="is_rowTotal"><td colspan="4" style="text-align:right;padding: 2px;">SUB TOTAL</td><td id="is_total" style="text-align:right;padding: 2px;">&nbsp;</td><td style="text-align:right;padding: 2px;">&nbsp;</td></tr>
            <tr id="is_rowVat"><td colspan="4" style="text-align:right;padding: 2px;">VAT 15 %</td><td id="is_vat" style="text-align:right;padding: 2px;">&nbsp;</td><td style="text-align:right;padding: 2px;">&nbsp;</td></tr>
            <tr id="is_rowNbt"><td colspan="4" style="text-align:right;padding: 2px;">NBT</td><td id="is_nbt" style="text-align:right;padding: 2px;">&nbsp;</td><td style="text-align:right;padding: 2px;">&nbsp;</td></tr>
            <tr id="is_rowNet"><td colspan="4" style="text-align:right;padding: 2px;font-weight:bold;">Estimate Amount</td><td id="is_net" style="text-align:right;padding: 2px;font-weight:bold;">&nbsp;</td><td style="text-align:right;padding: 2px;">&nbsp;</td></tr>
        </tfoot>
        </table>
        <table id="tbl_footer" style="font-family:times;border-collapse:collapse;width:700px;padding:5px;font-size:13px;" border="1">
            <!-- <tr><th colspan="4" style="text-align:right;padding: 5px">Estimate Amount  </th><th style='text-align:right;padding: 5px' id='lbltotalEsAmount'></th></tr> -->
            <tr><th colspan="5"  style="text-align:left;padding:2px 5px;">Remark: <span id="lblremark"></span><br>
            <table border="1" style="margin-left:10px;margin-bottom: 3px;">
                <tr>
                    <td style="padding: 5px 3px;font-weight: none">GP - GENUINE PARTS</td><td style="padding:  5px 3px;font-weight: none">NON - NONGENUINE PARTS</td><td style="padding:  5px 3px;font-weight: none">UP - USED PARTS</td>
                </tr>
            </table>
            </th></tr>
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
            </tr>
    </table>
    <table style="border-collapse:collapse;width:700px;padding:5px;" border="0">
            <tr><td colspan="7" style="text-align:left;border-left:1px #000 solid;border-top:1px #000 solid;border-right:1px #000 solid;padding-left: 3px;">
            <!-- COMPUTER BASE SIKKENS 2K COLOUR MIXING AND BAKE BOOTH PAINTING -->
            </td></tr>
            <!-- <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr> -->
            <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr>
            <tr><td colspan="7" style="text-align:left;border-left:1px #000 solid;border-right:1px #000 solid;font-size: 10px;padding-left: 3px;"></td></tr>
            <tr>
                <td style="width: 180px;font-size: 10px;border-left:1px #000 solid;padding-left: 3px;">VAT would be added to net invoice value</td>
                <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Name & Signature ( Customer)</td>
                <td style="width: 15px">&nbsp;</td>
                <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Name & Signature ( Assesor)</td>
                <td style="width: 15px">&nbsp;</td>
                <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Signature. </td>
                <td style="width: 15px;border-right:1px #000 solid;">&nbsp;</td>
            </tr>
            <tr><td colspan="6" style="text-align:right;border-left:1px #000 solid;border-bottom:1px #000 solid;width:400px;">&nbsp;</td><td style="border-bottom:1px #000 solid;border-right:1px #000 solid;"></td></tr>
        </table>
</div>