<div class="row"  id="printArea" align="center" style='margin:5px;'>
<!-- load comapny common header -->
    <?php $this->load->view('admin/_templates/company_header.php',true); ?>  
                    
                        <table style="border-collapse:collapse;font-size:12px;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                        
                        <tr style="text-align:left;font-size:15px;">
                            <td style="padding-left:5px;font-size:12px;"> Date  </td>
                            <td> :</td>
                            <td colspan="4" style="text-align:left;font-size:12px;"  id="lbldate"></td>
                            <td>&nbsp;</td>
                            <td > <b>JOB NO</b></td>
                            <td > :</td>
                            <td><b><span  id="lblJobNo"></span></b></td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-top: #000 solid 1px;border-left: #000 solid 1px;padding-left:5px;"> Code</td>
                            <td style="border-top: #000 solid 1px;"> :</td>
                            <td colspan="4" style="border-top: #000 solid 1px;border-right: #000 solid 1px;"><span id="lblcusCode"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Name : <span id="lblcusName"></span></td>
                            <td>&nbsp;</td>
                            <td style="text-align:left;font-size:15px;"> <b>REG NO</b></td>
                            <td > :</td>
                            <td style="text-align:left;font-size:15px;"> <b><span  id="lblregNo"></span></b></td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-left: #000 solid 1px;padding:0px 5px;" valign="top"> Customer Name</td>
                            <td> :</td>
                            <td rowspan="3" colspan="4" valign="top" style="border-right: #000 solid 1px;border-bottom: #000 solid 1px;"><span  id="lblCusName"></span><br><span  id="lblAddress"></span> </td>
                            <td>&nbsp;</td>
                            <td colspan="3" rowspan="6" style="padding-left:20px;">
                            <table style="font-size: 11px">
                            <tbody>
                                    <tr>
                                        <td>No of Job Card</td><td>:</td><td  id="lblnoofjobs">0</td>
                                    </tr>
                                    <tr>
                                        <td>Origin</td><td>:</td><td id="lblcountry"></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Date</td><td>:</td><td  id="lbldelveryDate"></td>
                                    </tr>
                                     <tr>
                                        <td>Delivery Time</td><td>:</td><td id="lbldelveryTime"></td>
                                    </tr>
                                     <tr>
                                        <td>Make</td><td>:</td><td  id="lblmake"></td>
                                    </tr>
                                     <tr>
                                        <td>Model No</td><td>:</td><td  id="lblmodel"></td>
                                    </tr>
                                     <tr>
                                        <td>Odo Meter</td><td>:</td><td id="lblOdo"></td>
                                    </tr>
                                    <tr>
                                        <td>Your Ref</td><td>:</td><td></td>
                                    </tr>
                                    <tr>
                                        <td>Next Service</td><td>:</td><td id="lblNextService"></td>
                                    </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-left: #000 solid 1px;padding:0px 5px;" valign="top">Address </td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td style="border-left: #000 solid 1px;border-bottom: #000 solid 1px;"> </td>
                            <td  style="border-bottom: #000 solid 1px;"></td>
                            <td >&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> Email Address</td>
                            <td> :</td>
                            <td id="lblemail"> </td>
                            <td colspan="3">Payment Type &nbsp;&nbsp; <span id="lblpaymentType"></span></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> S.A.Name</td>
                            <td> :</td>
                            <td  id="lblSAName"></td>
                            <td  colspan="4"> Fuel Type&nbsp; : <span  id="lblFuelType"></span></td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> Tel/ Mob/ Fax No : </td>
                            <td> :</td>
                            <td id="lblpaymentType"></td>
                            <td ></td>
                            <td > </td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="text-align:left;font-size:12px;">
                            <td> V. I. No </td>
                            <td>:</td>
                            <td colspan="4" id="lblviNo"> <?php echo $invVehi->ChassisNo?></td>
                            <td>&nbsp;</td>
                            <td > </td>
                            <td> </td>
                            <td> WAITING</td>
                        </tr>
                        <!-- <tr style="text-align:left;font-size:12px;">
                            <td colspan="10">&nbsp;</td>
                        </tr> -->
                    </table>
                <style type="text/css" media="screen">
                    #tbl_est_data tbody tr td{
                    padding: 13px;
                }
                </style>
                <table style="border-collapse:collapse;width:700px;padding:5px;font-size: 12px;" border="1" id="tbl_jobcard_data">
                    <thead>
                        <tr>
                            <th style='padding: 3px;width:30px;'>No.</th>
                            <th style='padding: 3px;width:540px;text-align: center;'> WORK DESCRIPTION - PERIODIC MAINTAINE </th>
                            <th style='padding: 3px;width:130px;text-align: center;' colspan="2">Estimate Cost</th>
                        </tr>
                        <tr>
                            <th style='padding: 3px;'>&nbsp;</th>
                            <th style='padding: 3px;'>&nbsp;</th>
                            <th style='padding: 3px;width:100px;'>Rs</th>
                            <th style='padding: 3px;width:30px;'>Cts.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="4" style="height:200px;">&nbsp;</td></tr>
                    </tbody>
                    <tfoot>
                        <!-- <tr><th colspan="2" style='text-align:right'>Total Amount  </th><th colspan="2" style='text-align:right' id="totalEsAmount" > </th></tr> -->
                        </tfoot>
                        </table><br>
                        <div id="foot" style='border: 1px #000 solid;width:700px;padding: 5px;' >
                        <table style="border-collapse:collapse;width:683px;padding:2px;font-size: 12px;">
                        <tr>
                            <td rowspan="9" style='padding:5px;padding-right:20px;border:1px solid #000; text-align:left;font-size: 12px;width:450px;'>
                                All things are done to the manufactured recommended standards - any work carried out,
                    outside the standards are based on customer request and No Gurantee will be given on this
                    type of work.<br>
                    After disassembling, if any defect found supplementary estimate would be submitted for
                    your approval.<br>
                    All charges for repairs and materials are payable in full upon completion of work. The
                    company reserves the right to retain to possession of the vehicle until such charges are
                    settled in full.The company disclaims all responsibility whatsoever for loss or damage to
                    vehicle or other property belonging to customers within the vehicle. However the usual
                    precautions are taken by the company against fire, theft.ect. To eliminate the risk of loss or
                    damage, the company kindly requested to remove as far as possible all personal belongs
                    before leaving the vehicle for repairs.<br>
                    I here by authorize the repair work listed above to be done with necessary materials an I
                    grant <?php echo $company['CompanyName'] ?> 's authority to drive the vehicle for purpose of road test.
                    Delivery subject to availability of parts and man power.<br>
                            </td><td style='width: 5px' ></td>
                            <td colspan="2" style='border:1px solid #000;'>&nbsp;</td>
                        </tr>
                        <tr><td colspan="3" style='height: 4px;'>&nbsp;</td></tr>
                        <tr><td></td><td colspan="2" style='border:1px solid #000;text-align: center;'>I Certify that there are no
valubles in the car</td></tr>
                        <tr><td colspan="3" style='height: 4px;'>&nbsp;</td></tr>
                         <tr><td colspan="3" >&nbsp;</td></tr>
                        <tr><td></td><td colspan="2" style='border-top:1px dashed #000;text-align: center;'>Customer Authorisation</td></tr>
                        <tr><td colspan="3" style='height: 4px;'>&nbsp;</td></tr>
                         <!-- <tr><td colspan="3" >&nbsp;</td></tr> -->
                        <tr><td></td><td colspan="2" style='border-top:1px dashed #000;text-align: center;'>Name</td></tr>
                         <tr><td colspan="3" >&nbsp;</td></tr>
                    
                </table></div>
                        
                <table border="1" style="border-collapse:collapse;width:700px;margin-top:4px; ">
                    <tbody>
                        <tr>
                            <td style="width:500px">FURTHER WORK REQUIR</td><td  style="width:200px">Spare Part Card No &nbsp;:&nbsp;<span id="partNo"><?php //echo $jobHed->SparePartJobNo?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div></div>