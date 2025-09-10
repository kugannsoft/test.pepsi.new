<div class="row"  id="printArea2" align="center" style='margin:0px 5px 0px 5px;'>

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

    <?php //$this->load->view('admin/_templates/company_header.php',true); ?>  

    <table style="border-collapse:collapse;width:700px;margin:0px 5px 0px 5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                        <tr style="text-align:left;font-size:12px;">
                            <td style="padding-left:5px;width:100px;"> Code</td>
                            <td style=";width:5px;"> :</td>
                            <td colspan="4" style="width:300px;"><span id="lblcusCodelb"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td style="border-right: #fff solid 1px;border-top: #fff solid 1px;">&nbsp;</td>
                            <td style="text-align:left;font-size:15px;padding-top:2px;width:200px;border-top: #fff solid 1px;" colspan="3" ><span id="lblesttypelb"></span> ESTIMATE</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="padding: 0px 5px;" valign="top">Customer Name</td>
                            <td> :</td>
                            <td rowspan="3" colspan="4" valign="top" style="font-size:10px;"  id="lblcusNamelb"></td>
                            <td>&nbsp;</td>
                            <td colspan="3" rowspan="3" style="padding-left:20px;">
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
                            <td >&nbsp;</td>
                            <td  ></td>
                            <td >&nbsp;</td>
                        </tr>
                        
                    </table>
<style type="text/css" media="screen">
    #tbl_est_data_lb tbody tr td{
    padding: 0px;
    font-size: 10px;
}
</style>
                <table id="tbl_est_data_lb" style="border-collapse:collapse;width:700px;padding:5px;font-size:11px;" border="0">
                    <thead>
                        
                        <tr>
                            <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                                <span style="width:200px;font-weight: none">Insurance Company</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblInsCompany" style="width:200px;font-weight: none;font-size:11px;"></span>
                            </td>
                            <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;"></td>
                        </tr>
                        <tr>
                            <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                                <span style="width:200px;font-weight: none">Contact Name</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblConNamelb" style="width:200px;font-weight: none;font-size:11px;"></span>
                            </td>
                            <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;font-weight:bold;">Estimate No&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: bold" id="lblestimateNolb"></span></td>
                        </tr>
                        <tr>
                            <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                                <span style="width:200px;font-weight: none">V. I. No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblviNolb" style="width:200px;font-weight: none"></span>
                            </td>
                            <td colspan="3" style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">Supplementary No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblsupNolb"></span></td>
                        </tr>
                         <!-- <tr><td style="height:10px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;" colspan="6"></td></tr> -->
                        <tr>
                            <td colspan="3"  style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;">
                                <span style="width:200px;font-weight: none">Reg: No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none">:</span>&nbsp;&nbsp;&nbsp;&nbsp;<span  id="lblregNolb" style="width:200px;font-weight: none;font-size:13px;"></span>
                            </td>
                            <td colspan="3" style="font-size:13px;border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:20px;font-weight: none"></span>&nbsp;&nbsp;&nbsp;<span style="width:200px;font-weight: none" id="lblmodelnolb"></span></td>
                        </tr>
                        <tr><td style="border-top: 1px solid #fff;border-left:1px solid #fff;border-right :1px solid #fff;" colspan="6">&nbsp;</td></tr>
                        <tr>
                            <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 20px;'>ITEM</td>
                            <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 360px;'>DESCRIPTION</td>
                            <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 20px;'></td>
                            <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 30px;'>QTY</td>
                            <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 70px;'>UNIT PRICE</td>
                            <td style='font-size:11px;padding: 1px;font-weight: none;text-align:center;width: 80px;'>QUOTED AMOUNT</td>
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
                <table style="border-collapse:collapse;width:700px;padding-top:10px;font-size:11px;" border="0">
                    <tr id="rowSubTotallb">
                        <td colspan="6" style="text-align:right;padding: 1px;">Sub Total  </td><td style='text-align:right;padding: 1px;width: 95px;border:0.5px solid #000;' id="lbltotalEsSubAmountlb">&nbsp;</td>
                    </tr>
                    <tr id="rowNbtlb">
                        <td colspan="6" style="text-align:right;padding: 1px;">NBT  </td><td style='text-align:right;padding: 1px;width: 95px;border:0.5px solid #000;' id="lbltotalEsNbtAmountlb">&nbsp;</td>
                    </tr>
                    <tr id="rowVatlb">
                        <td colspan="6" style="text-align:right;padding:1px;">VAT  </td><td style='text-align:right;padding: 1px;width: 95px;border:0.5px solid #000;' id="lbltotalEsVatAmountlb">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right;padding: 1px;">Estimate Amount  </td><td style='text-align:right;padding: 1px;width: 95px;font-weight:bold;border:0.5px solid #000;' id="lbltotalEsAmountlb">&nbsp;</td>
                    </tr>
                    <tr>
                        <td  colspan="7"  style="text-align:left;">Remark: <span id="lblremarklb"></span></td>
                    </tr>
                </table>
                <div id="footer2">
                    <div  class="pageNum2"></div>
                </div>
            </div>