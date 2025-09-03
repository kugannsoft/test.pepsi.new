<div class="row"  id="printArea" align="center" style='margin:0px 5px 0px 5px;'>
<style>
.borderdot{
    border-bottom: 1px dashed #000;
}
.bordertopbottom{
    border-bottom: 1px solid #000;
    border-top: 1px solid #000;
}

/*@page:right{ 
  @bottom-left {
    margin: 10pt 0 30pt 0;
    border-top: .25pt solid #666;
    content: "My book";
    font-size: 9pt;
    color: #333;
  }
}*/
/*#foot{page-break-after: always;}*/
/*#foot2{page-break-after: always;}*/
</style>
    <!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>  
    <table style="border-collapse:collapse;width:700px;margin:0px 5px 0px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">
        
        <!-- <tr style="text-align:left;font-size:15px;">
            <td style="padding-left:5px;font-size:12px;"> Date  </td>
            <td> :</td>
            <td colspan="4" style="text-align:left;font-size:12px;"></td>
            <td>&nbsp;</td>
            <td > <b>JOB NO</b></td>
            <td > :</td>
            <td><b><?php //echo $estHed->JobCardNo?></b></td>
        </tr> -->
       <!--  <tr><td colspan="10" style="text-align: center;font-size:12px;font-weight:bold;"><i>R e c o v e r y S e r v i c e Tel No : 071-5181818</i></td></tr>
        <tr><td colspan="10" style="text-align: center;font-size:12px;">&nbsp;</td></tr> -->
        <tr style="text-align:left;font-size:12px;">
            <td style="border-top: #000 solid 1px;border-left: #000 solid 1px;padding-left:5px;width:100px;"> Code</td>
            <td style="border-top: #000 solid 1px;width:5px;"> :</td>
            <td colspan="4" style="border-top: #000 solid 1px;border-right: #000 solid 1px;width:300px;"><span id="lblcusCode"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-right: #fff solid 1px;border-top: #fff solid 1px;">&nbsp;</td>
            <td style="text-align:left;font-size:15px;padding-top:2px;width:200px;border-top: #fff solid 1px;" colspan="3" ><b><span id="lblesttype"></span> ESTIMATE</b></td>
        </tr>
        <tr style="text-align:left;font-size:12px;">
            <td style="border-left: #000 solid 1px;padding: 0px 5px;" valign="top">Customer Name</td>
            <td> :</td>
            <td rowspan="3" colspan="4" valign="top" style="border-right: #000 solid 1px;border-bottom: #000 solid 1px;font-size:10px;"  id="lblcusName"></td>
            <td>&nbsp;</td>
            <td colspan="3" rowspan="3" style="padding-left:20px;">
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
            <td style="border-left: #000 solid 1px;border-bottom: #000 solid 1px;">&nbsp;</td>
            <td  style="border-bottom: #000 solid 1px;"></td>
            <td >&nbsp;</td>
        </tr>
        <!-- <tr style="text-align:left;font-size:12px;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td  colspan="4">&nbsp;</td>
        </tr> -->
    </table>
<style type="text/css" media="screen">
    #tbl_est_data tbody tr td{
    padding: 0px;
    font-size: 10px;
}
</style>
    <table id="tbl_est_data" style="border-collapse:collapse;width:700px;padding:5px;font-size:11px;" border="1">
        <thead>
            <tr>
                <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-weight: none">Contact Name</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblConName" style="width:200px;font-weight: none;font-size:11px;"></span>
                </td>
                <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">Estimate No&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblestimateNo"></span></td>
            </tr>
            <tr>
                <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-weight: none">V. I. No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblviNo" style="width:200px;font-weight: none"></span>
                </td>
                <td colspan="3" style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">Supplementary No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblsupNo"></span></td>
            </tr>
             <!-- <tr><td style="height:10px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;" colspan="6"></td></tr> -->
            <tr>
                <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                    <span style="width:200px;font-weight: none">Reg: No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblregNo" style="width:200px;font-weight: none;font-size:13px;"></span>
                </td>
                <td colspan="3" style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none"></span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblmodelno"></span></td>
            </tr>
            <!-- <tr><td style="border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;" colspan="6">&nbsp;</td></tr> -->
            <tr>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 20px;border: 1px solid #000;'>ITEM</td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 360px;border: 1px solid #000;'>DESCRIPTION</td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 20px;border: 1px solid #000;'></td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 30px;border: 1px solid #000;'>QTY</td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 70px;border: 1px solid #000;'>UNIT PRICE</td>
                <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 80px;border: 1px solid #000;'>QUOTED AMOUNT</td>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <!-- <tr><td colspan="6" style="text-align:right;padding: 5px">&nbsp;</td></tr> -->
            <!-- <tr>
                <td colspan="5" style="text-align:right;padding: 5px;border-bottom: 1px #fff solid;border-top: 1px #000 solid;">Estimate Amount  </td><td style='text-align:right;padding: 5px;border-top: 1px #000 solid;' id="lbltotalEsAmount">&nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="6"  style="text-align:left">Remark: <span id="lblremark"></span><br><br>
                </td>
            </tr> -->
        </tfoot>
    </table>
    <table style="border-collapse:collapse;width:700px;padding:5px;font-size:11px;" border="0">
        <tr id="rowSubTotal">
            <td colspan="6" style="text-align:right;padding: 1px;border-bottom: 1px #fff solid;border-top: 1px #000 solid;border-left:1px #000 solid;">Sub Total  </td><td style='text-align:right;padding: 1px;border:1px #000 solid;width: 95px;' id="lbltotalEsSubAmount">&nbsp;
            </td>
        </tr>
        <tr id="rowNbt">
            <td colspan="6" style="text-align:right;padding: 1px;border-bottom: 1px #fff solid;border-top: 1px #000 solid;border-left:1px #000 solid;">NBT  </td><td style='text-align:right;padding: 1px;border:1px #000 solid;width: 95px;' id="lbltotalEsNbtAmount">&nbsp;
            </td>
        </tr>
        <tr id="rowVat">
            <td colspan="6" style="text-align:right;padding:1px;border-bottom: 1px #fff solid;border-top: 1px #000 solid;border-left:1px #000 solid;">VAT  </td><td style='text-align:right;padding: 1px;border:1px #000 solid;width: 95px;' id="lbltotalEsVatAmount">&nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right;padding: 1px;border-bottom: 1px #fff solid;border-top: 1px #000 solid;border-left:1px #000 solid;">Estimate Amount  </td><td style='text-align:right;padding: 1px;border:1px #000 solid;width: 95px;font-weight:bold;' id="lbltotalEsAmount">&nbsp;
            </td>
        </tr>
        <tr>
            <td  colspan="7"  style="text-align:left;border-left:1px #000 solid;border-bottom:1px #000 solid;border-right:1px #000 solid;">Remark: <span id="lblremark"></span>
            </td>
        </tr>
    </table>
    <table style="border-collapse:collapse;width:700px;" border="0" id="foot">
        <tr>
            <td colspan="7" style="text-align:center;font-size: 12px;text-align:left;border-left:1px #000 solid;border-bottom:1px #000 solid;border-right:1px #000 solid;padding-left: 3px;">
                <table border="1" style="margin-left:10px;margin:5px;width:500px;" align="center">
                    <tr>
                        <td style="padding: 5px 3px;font-weight: none">GP - GENUINE PARTS</td>
                        <td style="padding: 5px 3px;font-weight: none">NON - NONGENUINE PARTS</td>
                        <td style="padding: 5px 3px;font-weight: none">UP - USED PARTS</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align:left;font-size: 12px;text-align:left;border-left:1px #000 solid;border-top:1px #000 solid;border-right:1px #000 solid;border-bottom:1px #000 solid;padding-left: 3px;">
                <!-- <ul>
                    <li>Please Make 50 % advance payment at the time of estimate/s approval to commence repairs.</li>
                    <li>If any defects / areas needing attention is found after dismantling or during the repair process, we reserve the right to submit a supplementary estimate for your approval.</li>
                    <li>Service charges are valid for 90 days from the date of issue.</li>
                    <li>We will not be responsible for quality of job for any work carried out using non genuine or used parts.</li>
                    <li>Delivery subject to availability of parts & man power.</li>
                    <li>Replaced parts should be collected at the time of delivery or within 01 week from the date of invoice. We will not be responsible for any replaced parts thereafter.</li>
                    <li>All payments related to the repairs are required to be settled in full prior to the delivery of the vehicle.</li>
                    <li>Any deductions made by insurer according to the policy conditions on your insurance policy, we will not deducted from our final invoice.
                    </li>
                </ul> -->
            </td>
        </tr>
        </table>
        <table style="border-collapse:collapse;width:700px;padding:5px;" border="0">
        <!-- <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-top:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr> -->
        <tr><td colspan="7" style="text-align:left;border-left:1px #000 solid;border-right:1px #000 solid;padding: 3px;">
        <!-- COMPUTER BASE SIKKENS 2K COLOUR MIXING AND BAKE BOOTH PAINTING -->
        </td></tr>
        <!-- <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr> -->
        <!-- <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr> -->
        <tr><td colspan="7" style="text-align:right;border-left:1px #000 solid;border-right:1px #000 solid;">&nbsp;</td></tr>
        <tr><td colspan="7" style="text-align:left;border-left:1px #000 solid;border-right:1px #000 solid;font-size: 10px;padding-left: 3px;"></td></tr>
        <tr>
            <td style="width: 180px;font-size: 10px;border-left:1px #000 solid;padding-left: 3px;">VAT would be added to net invoice value</td>
            <td style="width: 120px;font-size: 11px;text-align: center;"></td>
            <td style="width: 15px">&nbsp;</td>
            <td style="width: 120px;font-size: 11px;text-align: center;border-top: 1px dashed #000;">Signature.</td>
            <td style="width: 15px">&nbsp;</td>
            <td style="width: 120px;font-size: 11px;text-align: center;"></td>
            <td style="width: 15px;border-right:1px #000 solid;">&nbsp;</td>
        </tr>
        <tr><td colspan="6" style="text-align:right;border-left:1px #000 solid;border-bottom:1px #000 solid;width:400px;">&nbsp;</td><td style="border-bottom:1px #000 solid;border-right:1px #000 solid;"></td></tr>
        </table>
        <div id="footer">
            <div  class="pageNum"></div>
        </div>
</div>