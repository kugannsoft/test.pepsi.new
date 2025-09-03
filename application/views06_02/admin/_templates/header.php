<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="<?php echo $charset; ?>">
        <title><?php echo $title; ?></title>
        <?php if ($mobile === FALSE): ?>
            <!--[if IE 8]>
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <![endif]-->
        <?php else: ?>
            <meta name="HandheldFriendly" content="true">
        <?php endif; ?>
        <?php if ($mobile == TRUE && $mobile_ie == TRUE): ?>
            <meta http-equiv="cleartype" content="on">
        <?php endif; ?>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex, nofollow">
        <?php if ($mobile == TRUE && $ios == TRUE): ?>
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-status-bar-style" content="black">
            <meta name="apple-mobile-web-app-title" content="<?php echo $title; ?>">
        <?php endif; ?>
        <?php if ($mobile == TRUE && $android == TRUE): ?>
            <meta name="mobile-web-app-capable" content="yes">
        <?php endif; ?>
        <link rel="icon" href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAqElEQVRYR+2WYQ6AIAiF8W7cq7oXd6v5I2eYAw2nbfivYq+vtwcUgB1EPPNbRBR4Tby2qivErYRvaEnPAdyB5AAi7gCwvSUeAA4iis/TkcKl1csBHu3HQXg7KgBUegVA7UW9AJKeA6znQKULoDcDkt46bahdHtZ1Por/54B2xmuz0uwA3wFfd0Y3gDTjhzvgANMdkGb8yAyY/ro1d4H2y7R1DuAOTHfgAn2CtjCe07uwAAAAAElFTkSuQmCC">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,700italic">
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/bootstrap/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/bootstrap/css/bootstrap-switch.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/font-awesome/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/ionicons/css/ionicons.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/adminlte/css/adminlte.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/adminlte/css/skins/skin-blue.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/Datatables/dataTables.bootstrap.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck/css/blue.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/custom.css'); ?>">
        <?php if ($mobile === FALSE && $admin_prefs['transition_page'] == TRUE): ?>
            <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/animsition/animsition.min.css'); ?>">
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
            <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.css'); ?>">
        <?php endif; ?>
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/domprojects/css/dp.min.css'); ?>">
        <?php if ($mobile === FALSE): ?>
            <!--[if lt IE 9]>
                <script src="<?php echo base_url($plugins_dir . '/html5shiv/html5shiv.min.js'); ?>"></script>
                <script src="<?php echo base_url($plugins_dir . '/respond/respond.min.js'); ?>"></script>
            <![endif]-->
        <?php endif; ?>
        <script>
            const baseUrl = "<?php echo base_url('admin') ?>";
            console.log(baseUrl);
        </script>
        <script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/slimscroll/slimscroll.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/Datatables/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/Datatables/dataTables.bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/icheck/js/icheck.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/pace/pace.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/notify.min.js'); ?>"></script>
        <?php if ($mobile == TRUE): ?>
            <script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
        <?php endif; ?>
        <?php if ($admin_prefs['transition_page'] == TRUE): ?>
            <script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
            <script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
            <script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
        <?php endif; ?>
        
        <?php if ($this->router->fetch_class() == 'pos'): ?>
            <!--point of sale js-->
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jquery/jquery-ui-timepicker.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/pos/pos.js'); ?>"></script>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <link rel="stylesheet" href="<?php echo base_url('assets/plugins/keyboard/css/keyboard.css'); ?>">
            <script src="<?php echo base_url($plugins_dir . '/keyboard/js/jquery.keyboard.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/keyboard/js/jquery.keyboard.extension-autocomplete.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/keyboard/js/jquery.keyboard.extension-typing.js'); ?>"></script>
        <?php endif; ?>
        
        <?php if($this->router->fetch_class() == 'EasyPayment'): ?>
            <script src="<?php echo base_url('assets/frameworks/easy/mycalc.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/easy/pay_cal.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jquery/jquery-ui-timepicker.js'); ?>"></script>

        <?php if ($this->router->fetch_method() == 'easyPaymentSettlement'): ?>
            <script src="<?php echo base_url('assets/frameworks/easy/easy_payment.js'); ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() == 'easyPayment'): ?>
            <script src="<?php echo base_url('assets/frameworks/easy/invoice.js'); ?>"></script>
        <?php endif; ?>
        <?php endif; ?>

        <?php if($this->router->fetch_class() == 'Salesinvoice'): ?>

            <?php if ($this->router->fetch_method() == 'index'): ?>
            <script type="text/javascript" src="https://unpkg.com/vue"></script>
            <!-- <script src="<?php echo base_url('assets/plugins/vue.min.js'); ?>"></script> -->
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <?php endif; ?>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            
            <?php if ($this->router->fetch_method() == 'job_invoice'): ?>
            <script>$(document).ready(function() { $('body').addClass('sidebar-collapse'); });</script>
            <script src="<?php echo base_url('assets/frameworks/job/job_invoice1.9.js'); ?>"></script>
            
            <?php endif; ?>
            <script src="<?php echo base_url('assets/frameworks/jquery/jquery-ui-timepicker.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() == 'addSalesInvoice'): ?>
            <script>$(document).ready(function() { $('body').addClass('sidebar-collapse'); });</script>
            <script src="<?php echo base_url('assets/frameworks/job/add_sales_invoice1.6.js'); ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_method() == 'addIssueNote'): ?>
            <script>$(document).ready(function() { $('body').addClass('sidebar-collapse'); });</script>
            <script src="<?php echo base_url('assets/frameworks/job/add_issue_note.js'); ?>"></script>
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'job'): ?>
            <!--job js-->
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/notify.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jquery/jquery-ui-timepicker.js'); ?>"></script>
            
            <link rel="stylesheet" href="<?php echo base_url('assets/plugins/facebox/facebox.css'); ?>">
            <script src="<?php echo base_url($plugins_dir . '/facebox/facebox.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'index'): ?>
            <script>$(document).ready(function() { $('body').addClass('sidebar-collapse'); });</script>
            <script src="<?php echo base_url('assets/frameworks/job/job1.3.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'edit_job'): ?>
            <script>$(document).ready(function() { $('body').addClass('sidebar-collapse'); });</script>
            <script src="<?php echo base_url('assets/frameworks/job/job_edit1.2.js'); ?>"></script>
            <?php endif; ?>
             <?php if ($this->router->fetch_method() == 'cancel_job'): ?>
            <script src="<?php echo base_url('assets/frameworks/job/job_cancel.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'view_job'): ?>
            <script src="<?php echo base_url('assets/frameworks/job/base64.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'estimate_job'): ?>
            <script>$(document).ready(function() { $('body').addClass('sidebar-collapse'); });</script>
            <script src="<?php echo base_url('assets/frameworks/job/job_estimate1.4.js'); ?>"></script>
            <?php endif; ?>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/keyboard/css/keyboard.css'); ?>">
            <script src="<?php echo base_url($plugins_dir . '/keyboard/js/jquery.keyboard.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/keyboard/js/jquery.keyboard.extension-autocomplete.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/keyboard/js/jquery.keyboard.extension-typing.js'); ?>"></script> -->
        <?php endif; ?>

        <?php if ($this->router->fetch_class() == 'product'): ?>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
        <?php endif; ?>

        <?php if ($this->router->fetch_class() == 'customer'): ?>
        <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
        <?php endif; ?>

         <?php if ($this->router->fetch_class() == 'permission'): ?>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
        <?php endif; ?>
        
        
        <?php if ($this->router->fetch_class() == 'grn'): ?>
            <!--grn js-->
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'addgrn'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/grn.js'); ?>"></script>
            <?php endif; ?>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script>$(document).ready(function() {
                    $('body').addClass('sidebar-collapse');
                });</script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'cancel_grn'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/grn_cancel.js'); ?>"></script>
            <?php endif; ?> <?php if ($this->router->fetch_method() == 'barcodeprint'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/barcode.js'); ?>"></script>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'mrn'): ?>
            <!--grn js-->
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'add_mrn'): ?>
                <script src="<?php echo base_url('assets/frameworks/job/add_mrn.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'issue_mrn'): ?>
                <script src="<?php echo base_url('assets/frameworks/job/issue_mrn.js'); ?>"></script>
            <?php endif; ?>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script>$(document).ready(function() {
                    $('body').addClass('sidebar-collapse');
                });</script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'cancel_grn'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/grn_cancel.js'); ?>"></script>
            <?php endif; ?> <?php if ($this->router->fetch_method() == 'barcodeprint'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/barcode.js'); ?>"></script>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'purchase'): ?>
            <!--grn js-->
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script>$(document).ready(function() {
                    $('body').addClass('sidebar-collapse');
                });</script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'addpo'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/po1.1.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'cancel_po'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/po_cancel.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'addprn'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/prnote.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'cancel_prn'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/prn_cancel.js'); ?>"></script>
            <?php endif; ?>
    <?php endif; ?>
      <?php if ($this->router->fetch_class() == 'Customerorder'): ?>
            <!--grn js-->
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
        <?php if ($this->router->fetch_method() == 'addCustomerOrder'): ?>
            <script src="<?php echo base_url('assets/frameworks/cusoder/cus_order.js'); ?>"></script>
            <script>$(document).ready(function() {
                    $('body').addClass('sidebar-collapse');
                });</script>
        <?php endif; ?>
<!--        --><?php //if ($this->router->fetch_method() == 'addPayment'): ?>
<!--            <script src="--><?php //echo base_url('assets/frameworks/cusoder/cus_order.js'); ?><!--"></script>-->
<!--        --><?php //endif; ?>
        <?php if ($this->router->fetch_method() == 'cancel_po'): ?>
            <script src="<?php echo base_url('assets/frameworks/cusoder/cus_order_cancel.js'); ?>"></script>
        <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'transer'): ?>
            <!--transer-->
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'stock_out'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/trans_out.js'); ?>"></script>
            <?php endif; ?>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script>$(document).ready(function() {
                    $('body').addClass('sidebar-collapse');
                });</script>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'stock_in'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/trans_in.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'cancel_transer'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/trans_cancel.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'barcodeprint'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/barcode.js'); ?>"></script>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ($this->router->fetch_class() == 'payment'): ?>
<!--payment-->
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jquery/jquery-ui-timepicker.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/daterangepicker/moment.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
             <link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css'); ?>">
            <?php if ($this->router->fetch_method() == 'job_payment'): ?>
                <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'view_customer'): ?>
                <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'cus_payment'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/cus_payment1.5.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'cancel_cus_payment'): ?>
                <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
                <script src="<?php echo base_url('assets/frameworks/pos/cus_pay_cancel.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'sup_payment'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/sup_payment.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'cancel_sup_payment'): ?>
                <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
                <script src="<?php echo base_url('assets/frameworks/pos/sup_pay_cancel.js'); ?>"></script>
            <?php endif; ?>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script>$(document).ready(function() {
                    $('body').addClass('sidebar-collapse');
                });</script>
          <!--   <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script> -->
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'cancel_payment'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/grn_cancel.js'); ?>"></script>
            <?php endif; ?> <?php if ($this->router->fetch_method() == 'barcodeprint'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/barcode.js'); ?>"></script>
            <?php endif; ?>
        <?php endif; ?>
        <!--invoice-->
        <?php if ($this->router->fetch_class() == 'invoice'): ?>
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'cancel_invoice'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/invoice.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'index'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/invoice.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'return_invoice'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/return_invoice1.1.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'received_invoice'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/received_invoice.1.js'); ?>"></script>
            <?php endif; ?>
            <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap-switch.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
        <?php endif; ?>

        <?php if ($this->router->fetch_class() == 'customer'): ?>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
        <?php endif; ?>

        <!--report-->
        <?php if ($this->router->fetch_class() == 'report'): ?>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/tablefreez/jquery.freezeheader.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/daterangepicker/moment.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
             <link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css'); ?>">
        <?php endif; ?>
        <!--stock-->
        <?php if ($this->router->fetch_class() == 'stock'): ?>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/tablefreez/jquery.freezeheader.js'); ?>"></script>
        <?php endif; ?>
        <!--cash-->
        <?php if ($this->router->fetch_class() == 'cash'): ?>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
            <script src="<?php echo base_url('assets/frameworks/jQuery.print.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'cash_float'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/cash_ex.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'cash_float_balance'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/cash_bal1.1.js'); ?>"></script>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->router->fetch_class() == 'daily_update'): ?>
            <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
        <?php endif; ?>
        <!--imei -->
        <?php if ($this->router->fetch_class() == 'imei'): ?>
            <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/account/accounting.min.js'); ?>"></script>
            <?php if ($this->router->fetch_method() == 'clear_serial_stock'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/serial_clear.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'clear_product_stock'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/product_clear.js'); ?>"></script>
                <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'clear_bulk_stock'): ?>
                <script src="<?php echo base_url('assets/frameworks/jqueryui/jquery-ui.js'); ?>"></script>
                <script src="<?php echo base_url('assets/frameworks/pos/bulk_product_clear.js'); ?>"></script>
                <script src="<?php echo base_url($plugins_dir . '/select2/js/select2.min.js'); ?>"></script>
            <?php endif; ?>
            <?php if ($this->router->fetch_method() == 'imei_check'): ?>
                <script src="<?php echo base_url('assets/frameworks/pos/imei_checker.js'); ?>"></script>
                <script src="<?php echo base_url('assets/frameworks/pos/imei.js'); ?>"></script>
            <?php endif; ?>
        <?php endif; ?>
        <script src="<?php echo base_url($frameworks_dir . '/adminlte/js/adminlte.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/domprojects/js/dp.min.js'); ?>"></script>
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini nscroll">
        <?php if ($mobile === FALSE && $admin_prefs['transition_page'] == TRUE): ?>
            <div class="wrapper animsition">
            <?php else: ?>
                <div class="wrapper">
                <?php endif; ?>
                <script>$(document).ajaxStart(function() {
                Pace.restart();
            });</script> 