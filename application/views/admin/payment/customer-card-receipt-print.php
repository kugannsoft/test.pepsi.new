<div class="row"  id="printArea2" align="center" style='margin:5px;'>
    <!-- company header -->
     <?php $this->load->view('admin/_templates/company_header.php',true); ?>
    <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">
        <!-- <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
            <td colspan="9" style="height: 100px">&nbsp;</td>
        </tr> -->
      <!--    <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:650px;"></td>
    </tr> -->
        <tr style="text-align:left;">
            <td style="width:200px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:20px;">&nbsp;</td>
            <td  style="width:380px;">&nbsp;</td>
            <td  style="width:290px;">&nbsp;</td>
            <td style="width:20px;">&nbsp;</td>
            <td style="width:320px;">&nbsp;</td>
            <td style="width:170px;">&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!-- <td>&nbsp;</td>-->
            <td >&nbsp;</td> 
            <td colspan="2" style='font-size: 20px;text-align: center;'><b>Customer Copy</b></td>
            <td>DATE</td>
            <td>:</td>
            <td id="rcpdate"></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>RECEIPT NO</td>
            <td>:</td>
            <td id="rcpreceiptno"></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Received with thanks a sum of Rupees</td>
            <td>:</td>
            <td colspan="4"  id="rcpamountword">ONLY</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">Reason for payment </td>
            <td>:</td>
            <td colspan="4"  id="rcpreason"></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3">In Cash / Cheque from</td>
            <td>:</td>
            <td colspan="4" id="rcpcusname"></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td>:</td>
            <td colspan="4" id="rcpcusaddress" rowspan="3"></td>
            <td>&nbsp;</td>
        </tr>
         <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="3"></td>
            <td></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>
            <td id="rcpinvno"></td>
            <td colspan="2"  ></td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Vehicle No</td>
            <td>:</td>
            <td colspan="2" id="rcpvno"></td>
            <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>
            <td id="rcpcuscode"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Amount</td>
            <td>:</td>
            <td colspan="2" id="rcpamount">Rs.</td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Cheque No</td>
            <td>:</td>
            <td colspan="2" id="rcpchequeno"></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Bank</td>
            <td>:</td>
            <td colspan="2" id="rcpbank"></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>
            <td>&nbsp;</td>
        </tr>
        <tr style="text-align:left;">
            <td>Date</td>
            <td>:</td>
            <td colspan="2"  id="rcpchequedate"></td>
            <td></td>
            <!-- <td>&nbsp;</td> -->
            <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <!-- <td>&nbsp;</td> -->
        </tr>
        <tr style="text-align:left;">
            <td>Payment Type</td>
            <td>:</td>
            <td colspan="2"  id="rcppaytype"></td>
            <td></td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <!--<br> -->
    <!--<hr> <br> -->
    <?php //$this->load->view('admin/_templates/company_header.php',true); ?>
    <!--<table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;" border="0">-->
        <?php //foreach ($company as $com) {  ?>
        
        <!--  <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:650px;"></td>
    </tr> -->
    <!--    <tr style="text-align:left;">-->
    <!--        <td style="width:200px;">&nbsp;</td>-->
    <!--        <td  style="width:20px;">&nbsp;</td>-->
    <!--        <td  style="width:380px;">&nbsp;</td>-->
    <!--        <td  style="width:20px;">&nbsp;</td>-->
    <!--        <td  style="width:380px;">&nbsp;</td>-->
    <!--        <td  style="width:290px;">&nbsp;</td>-->
    <!--        <td style="width:20px;">&nbsp;</td>-->
    <!--        <td style="width:300px;">&nbsp;</td>-->
    <!--        <td style="width:190px;">&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
            <!-- <td>&nbsp;</td>-->
    <!--        <td >&nbsp;</td> -->
    <!--        <td colspan="2" style='font-size: 20px;text-align: center;'><b>Office Copy</b></td>-->
    <!--        <td>DATE</td>-->
    <!--        <td>:</td>-->
    <!--        <td id="rcpdate1"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>RECEIPT NO</td>-->
    <!--        <td>:</td>-->
    <!--        <td id="rcpreceiptno1"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3">Received with thanks a sum of Rupees</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4"  id="rcpamountword1">ONLY</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td></td>-->
    <!--        <td colspan="4">&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3">Reason for payment </td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4"  id="rcpreason1"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3">In Cash / Cheque from</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4" id="rcpcusname1"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="4" id="rcpcusaddress1" rowspan="3"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--     <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="3"></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td colspan="5">Being Partial / Full payment in settlement of invoice No</td>-->
    <!--        <td id="rcpinvno1"></td>-->
    <!--        <td colspan="2"  ></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Vehicle No</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="rcpvno1"></td>-->
    <!--        <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>-->
    <!--        <td  id="rcpcuscode1"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Amount</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="rcpamount1">Rs.</td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Cheque No</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="rcpchequeno1"></td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Bank</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2" id="rcpbank1"></td>-->
    <!--        <td></td>-->
    <!--        <td></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td style="border-top: 1px dashed #000;text-align: center;">Cashier</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Date</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2"  id="rcpchequedate1"></td>-->
    <!--        <td></td>-->
            <!-- <td>&nbsp;</td> -->
    <!--        <td colspan="4"  style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
            <!-- <td>&nbsp;</td> -->
    <!--    </tr>-->
    <!--    <tr style="text-align:left;">-->
    <!--        <td>Payment Type</td>-->
    <!--        <td>:</td>-->
    <!--        <td colspan="2"  id="rcppaytype1"></td>-->
    <!--        <td></td>-->
    <!--        <td colspan="2"></td>-->
    <!--        <td>&nbsp;</td>-->
    <!--        <td>&nbsp;</td>-->
    <!--    </tr>-->
    <!--</table>-->
    
<!--</div> -->