<div class="row"  id="printArea" align="center" style='margin:5px;'>
                                <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
            <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
            </tr> 
            <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6"><b><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?> &nbsp;&nbsp;  <?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo  $company['MobileNo'] ?></b></td>
            </tr>
            <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Customer Code</td>
                <td> :</td>
                <td id="lblcusCode"> &nbsp;</td>
                <td colspan="3" style="text-align:center;font-size:20px;"> <b>Genaral Invoice</b></td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Customer Name</td>
                <td> :</td>
                <td id="lblcusName"> &nbsp;</td>
                <td > Date</td>
                <td> :</td>
                <td  id="lblinvDate"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Address</td>
                <td> :</td>
                <td rowspan="3" id="lblAddress" valign="top"> &nbsp;</td>
                <td> Tel</td>
                <td> :</td>
                <td  id="lbltel"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> </td>
                <td></td>
                <td > Make</td>
                <td> :</td>
                <td  id="lblmake"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> </td>
                <td> </td>
                <td > Model No</td>
                <td> :</td>
                <td  id="lblmodel"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Contact Name</td>
                <td>:</td>
                <td  id="lblConName"> &nbsp;</td>
                <td > Estimate No</td>
                <td> :</td>
                <td  id="lblestimateNo"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> V. I. No </td>
                <td>:</td>
                <td id="lblviNo"> &nbsp;</td>
                <td>Invoice No</td>
                <td>:</td>
                <td id="lblInvNo"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td>Reg No</td>
                <td>:</td>
                <td  id="lblregNo"> &nbsp;</td>
                <td > </td>
                <td> </td>
                <td> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
                      <table id="tbl_est_data" style="border-collapse:collapse;width:700px;padding:5px;" border="1">
                          <thead>
                              <tr>
                                  <th style='padding: 3px;'>Item</th>
                                  <th style='padding: 3px;'>Description</th>
                                  <th style='padding: 3px;'>ddd</th>
                                  <th style='padding: 3px;'>Qty</th>
                                  <th style='padding: 3px;'>Unit Price</th>
                                  <th style='padding: 3px;'>Net Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                              <tr><th colspan="5" style='text-align:right'>Total Amount &nbsp;&nbsp;</th><th id="totalAmount" style='text-align:right'></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Total Discount &nbsp;&nbsp;</th><th id="totalDiscount" style='text-align:right'></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Advance &nbsp;&nbsp;</th><th id="totalAdvance" style='text-align:right'></th></tr>
                              <tr><th colspan="5" style='text-align:right'>Net Amount &nbsp;&nbsp;</th><th id="netAmount" style='text-align:right'></th></tr>
                              <tr><th colspan="6"></th></tr>
                          </tfoot>
                      </table>
                      <br/>
                      <div id="foot" style="border: 1px #000 solid;width:700px;padding: 5px;page-break-before: always"><table style="border-collapse:collapse;width:683px;padding:2px;"><tbody><tr><td rowspan="9" style="padding:5px;padding-right:20px;border:1px solid #000; text-align:left;font-size: 12px;width:450px;"> All things are done to the manufactured recommended standards - any work carried out,
outside the standards are based on customer request and No Gurantee will be given on this
type of work.<br>After disassembling, if any defect found supplementary estimate would be submitted for
your approval.<br>All charges for repairs and materials are payable in full upon completion of work. The
company reserves the right to retain to possession of the vehicle until such charges are
settled in full.The company disclaims all responsibility whatsoever for loss or damage to
vehicle or other property belonging to customers within the vehicle. However the usual
precautions are taken by the company against fire, theft.ect. To eliminate the risk of loss or
damage, the company kindly requested to remove as far as possible all personal belongs
before leaving the vehicle for repairs.<br>I here by authorize the repair work listed above to be done with necessary materials an I
grant Samarasinghe Motor's authority to drive the vehicle for purpose of road test.
Delivery subject to availability of parts and man power.<br></td><td style="width: 5px"></td><td colspan="2" style="border:1px solid #000;">&nbsp;</td></tr><tr><td colspan="3">&nbsp;</td></tr><tr><td></td><td colspan="2" style="border:1px solid #000;text-align: center;">I Certify that there are no
valubles in the car</td></tr><tr><td colspan="3" style="height: 4px;">&nbsp;</td></tr><tr><td colspan="3">&nbsp;</td></tr><tr><td></td><td colspan="2" style="border-top:1px dashed #000;text-align: center;">Customer Authorisation</td></tr><tr><td colspan="3" style="height: 4px;">&nbsp;</td></tr><tr><td colspan="3">&nbsp;</td></tr><tr><td></td><td colspan="2" style="border-top:1px dashed #000;text-align: center;">Name</td></tr></tbody></table></div>
                    </div>