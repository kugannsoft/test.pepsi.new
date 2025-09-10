<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="content-wrapper">
        <section class="content-header">
            <?php echo $pagetitle; ?>
            <?php echo $breadcrumb; ?>
        </section>
        <!-- Main content -->
        <section class="content invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
<!--                        <i class="fa "></i> --><?php //echo company_name ?><!-- Rental Schedule-->
<!--                        <small class="pull-right">--><?php //echo date("Y-m-d H:i:s"); //$invoice['AccNo']; ?><!--</small>-->
                    </h2>

                </div><!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <style>
                    #tbl_summery{
                        border-collapse:collapse;
                        width:100%;
                    }

                    #tbl_summery tr {
                        padding-bottom: 5px;
                    }

                    #payHistory td,  #payHistory th{
                        font-size: 13px;
                    }
                </style>
                <table id="tbl_summery">
                    <tr>
<!--                        <td>Account No</td><td>:</td><td>--><?php //echo $invoice_data->AccNo; ?><!--</td><td>&nbsp;</td><td>Customer Name</td><td>:</td><td>--><?php //echo $invoice_data->CusName; ?><!--</td>-->
                    </tr>
                    <tr>
<!--                        <td>Loan Amount</td><td>:</td><td>--><?php //echo $invoice_data->TotalAmount; ?><!--</td><td>&nbsp;</td><td>Total Interest</td><td>:</td><td>--><?php //echo $invoice_data->Interest; ?><!--</td>-->
                    </tr>
                </table>
                <hr>
            </div><!-- /.row -->
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped" id="payHistory">
                        <thead>
                        <th class="text-left">Receipt No</th>
                        <th class="text-right">Paid Date</th>
                        <th class="text-right">Invoice Date</th>
                        <th class="text-right">Paid Ins.</th>
                        <th class="text-right">Paid Amount</th>
                        </thead>
                        <tbody>
                        <?php
                        $total_paid = 0;
                        $total_rd = 0;
                        $i = 1;
                            ?>

                            <?php
                            foreach ($invoice_data as $invoiceData) {
                                $total_rd+=$invoiceData->TotalPayment;
                                ?>
                                <tr>
                                    <td  style="text-align: left;"><?php echo $invoiceData->PaymentId; ?></td>
                                    <td  style="text-align: right;"><?php echo $invoiceData->PayDate; ?></td>
                                    <td  style="text-align: right;"><?php echo $invoiceData->InvDate; ?></td>
                                    <td  style="text-align: right;"><?php echo $invoiceData->PayDate; ?></td>
                                    <td  style="text-align: right;"><?php echo $invoiceData->PayAmount; ?></td>
<!--                                    <td  style="text-align: right;">--><?php //echo $invoiceData->PayDate; ?><!--</td>-->
<!--                                    <td  style="text-align: right;">--><?php //echo $invoiceData->PayDate; ?><!--</td>                                   -->
                                </tr>
                            <?php } ?>
                            <?php
                            $i++;
                        ?>
                        </tbody>
                        <tfoot>
                        <th></th>
                        <th ></th>
                        <th class="text-right"></th>
                        <th class="text-right"><?php // echo $product->currencyFormat($total_cap);  ?></th>
                        <th class="text-right"><?php echo $total_rd;  ?></th>
                        </tfoot>
                    </table>
<!--                    <table>-->
<!--                        <tr><td>Total Paid Amount</td><td>&nbsp;</td><td class="text-right"><b>--><?php //echo $total_paid; ?><!--</b></td></tr>-->
<!--                        <tr><td>Total Paid Rental Default</td><td>&nbsp;</td><td class="text-right"><b>--><?php //echo $total_rd; ?><!--</b></td></tr>-->
<!--                        <tr><td>Total Due Amount</td><td>&nbsp;</td><td class="text-right"><b>--><?php //echo $total_rd; ?><!--</b></td></tr>-->
<!--                    </table>-->
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <a href="" onclick="window.print()"  class="btn btn-success" style="text-align: right"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
        </section>
    </div>
<!-- ./wrapper -->
