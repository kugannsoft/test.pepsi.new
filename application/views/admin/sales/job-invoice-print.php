<div class="row"  id="printArea" align="center" style='margin:5px;'>
<!-- load comapny common header -->
    <?php //$this->load->view('admin/_templates/company_header.php',true); ?>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: times, Helvetica, sans-serif;" border="0">
 <!-- <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
            </tr>  -->
            <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="height: 50px;">
               <!--  <b><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?> &nbsp;&nbsp;  <?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo  $company['MobileNo'] ?></b>-->
                </td> 
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: center;"><span id="invType" style="font-size: 20px;position: relative;left:100px"><b><span id="lblinvoiceType"></span><br>INVOICE</b></span></td><td colspan="3" style="">&nbsp;</td></tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td><td style="text-align: right;">VAT NO : 1040587877000&nbsp;&nbsp;&nbsp;</td><td colspan="3" style="">&nbsp;</td></tr>
            <tr style="text-align:left;font-size:12px;">
                <td colspan="3">&nbsp;</td>
                <td colspan="3" rowspan="8">
                    <table style="text-align:left;font-size:11px;">
                        <tr style="text-align:left;">
                            <td style='width: 70px;'> Date</td>
                            <td style='width: 10px;'> :</td>
                            <td  id="lblinvDate"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Invoice No</td>
                            <td> :</td>
                            <td  id="lblinvoiceNo"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Reg No</td>
                            <td> :</td>
                            <td id="lblregNo"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Job No</td>
                            <td> :</td>
                            <td id="lbljobNo"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Mileage</td>
                            <td> :</td>
                            <td id="lblodo"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Chassis No</td>
                            <td> :</td>
                            <td  id="lblviNo"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td > Make</td>
                            <td> :</td>
                            <td id="lblmake"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td> Model</td>
                            <td> :</td>
                            <td id="lblmodel"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="text-align:left;font-size:12px;">
                <td colspan="3" rowspan="7">
                    <TABLE  style="text-align:left;font-size:12px;margin-left: 5px;">
                        <tr style="text-align:left;">
                            <td colspan="3"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td colspan="3"><span id="lblcusCode"></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Contanct Name <span id="lblConName"></span></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"></td>
                        </tr>
                        <tr style="text-align:left;">
                            <td id="lblcusName" colspan="3"></td>
                        </tr>
                        <tr style="text-align:left;">
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;">
                          <td> Tel  : </td>
                          <td id="lbltel" colspan="2"></td>
                        </tr>
                    </TABLE>
                </td>
            </tr>
            <tr style="text-align:left;font-size:12px;">
              <td colspan="6">&nbsp;</td>
            </tr>
            <?php //$noofjob=0;$refno=0; ?>
        </table><br>
                      <table id="tbl_est_data" style="border-collapse:collapse;width:690px;padding:5px;font-size:13px;" border="1"> 
                          <tbody>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-size: 10px;font-weight: normal;text-align: left;'>Any Inquiries please contact service manager</th>
                              <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>SUB TOTAL &nbsp;&nbsp;</th>
                              <th style="border-right: 1px solid #fff;border-top: 1px solid #000;">Rs.</th>
                              <th id="lbltotalEsAmount" style='text-align:right;border-top: 1px solid #000;'><?php //echo number_format($invHed->JobTotalAmount,2);?></th>
                            </tr>
                             
                            <tr id="rowDis">
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'>DISCOUNT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="lbltotalDicount" style='text-align:right'><?php //echo number_format($invHed->JobTotalDiscount,2);?></th>
                            </tr>
                             
                            <tr id="rowAdvance">
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> ADVANCE &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="lblAdvance" style='text-align:right'><?php //echo number_format($invHed->JobAdvance,2);?></th>
                            </tr>
                            <tr>
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;font-weight: normal;text-align: left;'>Estimate No : <span id="lblestimateNo"></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REF No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No Of Job : <span id="lblnoofjob"></span></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> VAT  &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="lbltotalVat" style='text-align:right'></th>
                            </tr>
                                
                            <tr  id="rowNbt">
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; '></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> NBT &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="lbltotalNbt" style='text-align:right'><?php //echo number_format($invHed->JobNbtAmount,2);?></th>
                                </tr>
                              
                            <tr >
                                <th colspan="4" style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid; font-weight: normal;text-align: left;'>Type Of Job : <span id="lblTypeOfJob"></span></th>
                                <th style='text-align:right;border-left:1px #fff solid;border-bottom:1px #fff solid;'> TOTAL &nbsp;&nbsp;</th>
                                <th style="border-right: 1px solid #fff;">Rs.</th>
                                <th id="lbltotalNet" style='text-align:right'><?php //echo number_format($invHed->JobNetAmount-$invHed->JobAdvance,2) ?></th>
                            </tr>

                          </tfoot>
                      </table>
                      <br/>
                      <table style="border-collapse:collapse;width:683px;padding:2px; bottom: 20px" border="0">
                          <tbody>
                             <tr><td colspan="7">&nbsp;</td></tr>
                             <tr><td colspan="7">&nbsp;</td></tr>  
                             <tr><td colspan="7">&nbsp;</td></tr>
                            <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td colspan="2" style="border-top:1px dashed #000;text-align: center;font-size: 10px;">Signature Of Purchaser</td><td>&nbsp;</td></tr>
                            <tr><td style="border-top:1px dashed #000;text-align: center;width:100px;">Check by</td><td style="width: 10px;">&nbsp;</td><td style="border-top:1px dashed #000;text-align: center;width:100px;">Prepared By</td><td style="width: 10px;">&nbsp;</td><td colspan="2" style="font-size: 11px;">I am satisfied with service / goods I received</td><td style="width:200px;"></td></tr>
                            <tr><td style="text-align: left;width:100px;"><b>Remarks</b></td><td colspan="6">&nbsp;</td></tr>
                            <tr><td colspan="7"  style="border:1px solid #000;height: 30px;">&nbsp;</td></tr>
                            <tr><td style="font-size: 11px;"><?php echo date('d-m-Y');?></td><td colspan="5"  style="">&nbsp;</td><td style="font-size: 11px;text-align: right;">Page 1 of 1</td></tr>
                                         
                        </tbody>
                        </table>
            </div>