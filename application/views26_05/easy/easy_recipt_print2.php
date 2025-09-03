<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <div class="box-header" style="background: #b4f3c8">
        <div class="col-sm-4"><span><b><?php echo $pagetitle; ?></b></span>

        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-1"></div>
                <?php if (in_array("SM162", $blockView) || $blockView == null) { ?>
                    <div class="col-sm-2">
                        <button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print
                        </button>
                    </div>
                <?php } ?>
             </div>
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
    </div>
<section class="content">
    <div class="row" id="printArea" align="center" style='margin:5px;'>
        <!-- company header -->
        <?php $this->load->view('admin/_templates/company_header.php', true); ?>
        <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;"
               border="0">
            <!-- <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                <td colspan="9" style="height: 100px">&nbsp;</td>
            </tr> -->
            <!--    <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:650px;"></td>
    </tr> -->
            <tr style="text-align:left;">
                <td style="width:200px;">&nbsp;</td>
                <td style="width:20px;">&nbsp;</td>
                <td style="width:380px;">&nbsp;</td>
                <td style="width:20px;">&nbsp;</td>
                <td style="width:380px;">&nbsp;</td>
                <td style="width:290px;">&nbsp;</td>
                <td style="width:20px;">&nbsp;</td>
                <td style="width:320px;">&nbsp;</td>
                <td style="width:170px;">&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <!-- <td>&nbsp;</td>-->
                <td>&nbsp;</td>
                <td colspan="2" style='font-size: 20px;text-align: center;'><b>Customer Copy</b></td>
                <td>DATE</td>
                <td>:</td>
                <td id="rcpdate"><?php echo $receipt_hed->PayDate?></td>
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
                <td id="rcpreceiptno"><?php echo $receipt_hed->PaymentId?></td>
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
                <td colspan="4" id="rcpamountword"><?php echo $pay_amount_word?></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3"></td>
                <td></td>
                <td colspan="4">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3">Reason for payment</td>
                <td>:</td>
                <td colspan="4" id="rcpreason"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3">In Cash / Cheque from</td>
                <td>:</td>
                <td colspan="4" id="rcpcusname"><?php echo $receipt_hed->DisplayName?></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3"></td>
                <td>:</td>
                <td colspan="4" id="rcpcusaddress" rowspan="3"><?php echo $receipt_hed->Address01?></td>
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
                <td id="rcpinvno"><?php echo $receipt_hed->InvNo?></td>
                <td colspan="2"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>Account No</td>
                <td>:</td>
                <td colspan="2" id="rcpvno"><?php echo $receipt_hed->AccNo?></td>
                <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>
                <td id="rcpcuscode"><?php echo $receipt_hed->CusCode?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>Amount</td>
                <td>:</td>
                <td colspan="2" id="rcpamount">Rs.<?php echo $receipt_hed->TotalPayment?></td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>Cheque No</td>
                <td>:</td>
                <td colspan="2" id="rcpchequeno"><?php echo $receipt_hed->ChequeNo?></td>
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
                <td colspan="2" id="rcpchequedate"><?php echo $receipt_hed->ChequeDate?></td>
                <td></td>
                <!-- <td>&nbsp;</td> -->
                <td colspan="4" style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <!-- <td>&nbsp;</td> -->
            </tr>
            <tr style="text-align:left;">
                <td>Payment Type</td>
                <td>:</td>
                <td colspan="2" id="rcppaytype"><?php echo $receipt_hed->payType?> Payment</td>
                <td></td>
                <td colspan="2"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br>
        <hr>
        <br>
        <?php $this->load->view('admin/_templates/company_header.php', true); ?>
        <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;font-size:12px;"
               border="0">
            <?php //foreach ($company as $com) {  ?>

            <!--  <td colspan="9"  style="padding:5px;text-align: center;"><img src="<?php echo base_url($avatar_dir . '/sml.jpg'); ?>" style="width:650px;"></td>
    </tr> -->
            <tr style="text-align:left;">
                <td style="width:200px;">&nbsp;</td>
                <td style="width:20px;">&nbsp;</td>
                <td style="width:380px;">&nbsp;</td>
                <td style="width:20px;">&nbsp;</td>
                <td style="width:380px;">&nbsp;</td>
                <td style="width:290px;">&nbsp;</td>
                <td style="width:20px;">&nbsp;</td>
                <td style="width:300px;">&nbsp;</td>
                <td style="width:190px;">&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <!-- <td>&nbsp;</td>-->
                <td>&nbsp;</td>
                <td colspan="2" style='font-size: 20px;text-align: center;'><b>Customer Copy</b></td>
                <td>DATE</td>
                <td>:</td>
                <td id="rcpdate"><?php echo $receipt_hed->PayDate?></td>
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
                <td id="rcpreceiptno"><?php echo $receipt_hed->PaymentId?></td>
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
                <td colspan="4" id="rcpamountword"><?php echo $pay_amount_word?></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3"></td>
                <td></td>
                <td colspan="4">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3">Reason for payment</td>
                <td>:</td>
                <td colspan="4" id="rcpreason"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3">In Cash / Cheque from</td>
                <td>:</td>
                <td colspan="4" id="rcpcusname"><?php echo $receipt_hed->DisplayName?></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td colspan="3"></td>
                <td>:</td>
                <td colspan="4" id="rcpcusaddress" rowspan="3"><?php echo $receipt_hed->Address01?></td>
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
                <td id="rcpinvno"><?php echo $receipt_hed->InvNo?></td>
                <td colspan="2"></td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>Account No</td>
                <td>:</td>
                <td colspan="2" id="rcpvno"><?php echo $receipt_hed->AccNo?></td>
                <td style="text-align: right;">Code&nbsp;&nbsp;&nbsp;:</td>
                <td id="rcpcuscode"><?php echo $receipt_hed->CusCode?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>Amount</td>
                <td>:</td>
                <td colspan="2" id="rcpamount">Rs.<?php echo $receipt_hed->TotalPayment?></td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr style="text-align:left;">
                <td>Cheque No</td>
                <td>:</td>
                <td colspan="2" id="rcpchequeno"><?php echo $receipt_hed->ChequeNo?></td>
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
                <td colspan="2" id="rcpchequedate"><?php echo $receipt_hed->ChequeDate?></td>
                <td></td>
                <!-- <td>&nbsp;</td> -->
                <td colspan="4" style="text-align: right;"> ( Subject to realization of remittance )&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <!-- <td>&nbsp;</td> -->
            </tr>
            <tr style="text-align:left;">
                <td>Payment Type</td>
                <td>:</td>
                <td colspan="2" id="rcppaytype"><?php echo $receipt_hed->payType?> Payment</td>
                <td></td>
                <td colspan="2"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

    </div>
</section>
</div>

<script type="text/javascript">

    $("#btnPrint").click(function(){
        $('#printArea').focus().print();
    });

</script>