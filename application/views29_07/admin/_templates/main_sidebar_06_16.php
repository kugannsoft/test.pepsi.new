<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <?php if ($admin_prefs['user_panel'] == true): ?>
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo base_url($avatar_dir . '/m_001.png'); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $user_login['firstname'] . $user_login['lastname']; ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo lang('menu_online'); ?></a>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($admin_prefs['sidebar_form'] == true): ?>
            <!-- Search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control"
                           placeholder="<?php echo lang('menu_search'); ?>...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                                    class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>

        <?php endif; ?>
        <!-- Sidebar menu -->
        <ul class="sidebar-menu">
            <li class="header text-uppercase"><?php echo lang('menu_main_navigation'); ?></li>
            <?php if (in_array("M1", $blockView) || $blockView == null) { ?>
                <li class="<?= active_link_controller('dashboard') ?>">
                    <a href="<?php echo site_url('admin/dashboard'); ?>">
                        <i class="fa fa-dashboard"></i> <span><?php echo lang('menu_dashboard'); ?></span>
                    </a>
                </li>
            <?php } ?>
            <!-- <li class="<?= active_link_controller('pos') ?>">
                <a href="<?php echo site_url('admin/pos'); ?>">
                    <i class="fa fa-cart-plus"></i> <span><?php echo lang('menu_pos'); ?></span>
                </a>
            </li> -->
           <!-- <li class="<?= active_link_controller('Imei') ?>">
                <a href="<?php echo site_url('admin/imei/imei_check'); ?>">
                    <i class="fa fa-code"></i> <span>IMEI Checker</span>
                </a>
            </li>  -->
            <?php if (in_array("M2", $blockView) || $blockView == null) { ?>
                <li class="treeview <?= active_link_controller('customer') ?>">
                    <a href="#">
                        <i class="fa fa-user"></i><span>Customer</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (in_array("SM21", $blockView) || $blockView == null) { ?>
                            <?php if (!in_array('addcustomer', $block_function)) { ?>
                                <li class="<?= active_link_function('addcustomer') ?>">
                                    <a href="<?php echo site_url('admin/customer/addcustomer'); ?>">All Customers</a>
                                </li>
                            <?php }
                        } ?>

                        <?php if (in_array("SM24", $blockView) || $blockView == null) { ?>
                            <?php if (!in_array('outstandingcustomer', $block_function)) { ?>
                                <li class="<?= active_link_function('outstandingcustomer') ?>">
                                    <a href="<?php echo site_url('admin/customer/outstandingcustomer'); ?>">All
                                        Outstanding
                                        Customers</a>
                                </li>
                            <?php }
                        } ?>

                        <?php if (in_array("SM22", $blockView) || $blockView == null) { ?>
                            <?php if (!in_array('view_vehicles', $block_function)) { ?>
                                <!--<li class="<?= active_link_function('view_vehicles') ?>">-->
                                <!--    <a href="<?php echo site_url('admin/customer/view_vehicles'); ?>">All Vehicles</a>-->
                                <!--</li>-->
                            <?php }
                        } ?>
                        <?php if (in_array("SM23", $blockView) || $blockView == null) { ?>
                            <?php if (!in_array('customersync', $block_function)) { ?>
                                <!--<li class="<?= active_link_function('customersync') ?>">-->
                                <!--    <a href="<?php echo site_url('admin/customer/customersync'); ?>">Customer-->
                                <!--        Synchronization</a>-->
                                <!--</li>-->
                            <?php }
                        } ?>
                        <?php if (in_array("SM23", $blockView) || $blockView == null) { ?>
                            <?php if (!in_array('customersyncNew', $block_function)) { ?>
                                <!--<li class="<?= active_link_function('customersyncNew') ?>">-->
                                <!--    <a href="<?php echo site_url('admin/customer/customersyncNew'); ?>">Synchronized Customer</a>-->
                                <!--</li>-->
                            <?php }
                        } ?>
                        <!-- <li><a href=""><?php print_r($block_function); ?>h</a></li> -->

                    </ul>
                </li>
            <?php } ?>
                     <?php if (in_array("M11", $blockView) || $blockView == null) { ?>
                <!--<li class="treeview <?= active_link_controller('Customerorder') ?>">-->
                <!--    <a href="#">-->
                <!--        <i class="fa fa-instagram"></i>-->
                <!--        <span>Customer Order</span>-->
                <!--        <i class="fa fa-angle-left pull-right"></i>-->
                <!--    </a>-->

                <!--    <ul class="treeview-menu">-->
                <!--        <li class="<?= active_link_function('addpo') ?>"><a-->
                <!--                    href="<?php echo site_url('admin/Customerorder/addCustomerOrder'); ?>">Add Customer Order</a></li>-->
                <!--        <li class="<?= active_link_function('all_po') ?>"><a-->
                <!--                    href="<?php echo site_url('admin/Customerorder/allCustomerOrder'); ?>">All Customer Order</a></li>-->
                <!--    </ul>-->
                <!--</li>-->
            <?php } ?>
            <?php if (in_array("M3", $blockView) || $blockView == null) { ?>
<!--                <li class="treeview --><?//= active_link_controller('job') ?><!--">-->
<!--                <li class="--><?//= active_link_controller('customer') ?><!--">-->
<!--                    <a href="--><?php //echo site_url('admin/customer/customerAccount'); ?><!--">-->
<!--                        <i class="fa fa-book">-->
<!--                        </i> <span>Account</span>-->
<!--                    </a>-->
<!--                </li>-->

                <!-- <li class="<?= active_link_controller('Job') ?>">
                    <a href="<?php echo site_url('admin/job/view_job'); ?>">
                        <i class="fa fa-book">
                        </i> <span>All Job Cards</span>
                    </a>
                </li> -->

                <!-- <a href="#">
                    <i class="fa fa-book"></i><span>
                        <a href="<?php echo site_url('admin/job/view_job'); ?>">All Job Cards</a>a></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a> -->
<!--                <ul class="treeview-menu">-->
<!--                    --><?php //if (!in_array('view_job', $block_function)) { ?>
<!--                        <li class="--><?//= active_link_function('view_job') ?><!--">-->
<!--                            <a href="--><?php //echo site_url('admin/job/view_job'); ?><!--">All Jobs</a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--                    --><?php //if (!in_array('cancel_job', $block_function)) { ?>
<!--                        <li class="--><?//= active_link_function('cancel_job') ?><!--">-->
<!--                            <a href="--><?php //echo site_url('admin/job/cancel_job/'); ?><!--">Cancel Job</a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--                </ul>-->
                </li>
                <?php
            } ?>

            <?php if (in_array("M5", $blockView) || $blockView == null) { ?>
                <li class="treeview <?= active_link_controller('estimate') ?>">

                    <!-- <a href="<?php echo site_url('admin/job/allCostSheet'); ?>">
                        <i class="fa fa-tags">
                        </i> <span>Issue Note</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a> -->

                    <ul class="treeview-menu">
                        <?php if (in_array("SM51", $blockAdd) || $blockAdd == null) { ?>
                            <li class="">
                                <a href="<?php echo site_url('admin/Salesinvoice/addIssueNote'); ?>">Add Issue Note</a>
                            </li>
                        <?php } ?>
                        <?php if (in_array("SM52", $blockView) || $blockView == null) { ?>
                            <li class="">
                                <a href="<?php echo site_url('admin/Salesinvoice/allIssueNote'); ?>">All Issue Note</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <!-- <li class="treeview <?= active_link_controller('Pos') ?>">
                <a href="#">
                    <i class="fa fa-book"></i><span>Pos Invoice</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="">
                        <a href="<?php echo site_url('admin/pos'); ?>">Add Pos Invoice</a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url('admin/pos/all_pos_invoice'); ?>">All Pos Invoice</a>
                    </li>
                </ul>
            </li> -->
            <?php if (in_array("M4", $blockView) || $blockView == null) { ?>
                <!--<li class="treeview <?= active_link_controller('Salesinvoice') ?>">-->
                    <!--<a href="#">-->
                    <!--    <i class="fa fa-book"></i><span>Easy Payment</span>-->
                    <!--    <i class="fa fa-angle-left pull-right"></i>-->
                    <!--</a>-->
                    <ul class="treeview-menu">
                        <!--<li class="<?= active_link_controller('customer') ?>">-->
                        <!--    <a href="<?php echo site_url('admin/customer/customerAccount'); ?>">-->
                        <!--        <i class="fa fa-book">-->
                        <!--        </i> <span>Account</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <!-- <li class="<?= active_link_controller('easyPayment') ?>">-->
                        <!--    <a href="<?php echo site_url('admin/EasyPayment/allAccount'); ?>">-->
                        <!--        <i class="fa fa-book">-->
                        <!--        </i> <span>All Account</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <?php
                        if (in_array("SM43", $blockAdd) || $blockAdd == null) { ?>
                            <!--<li class="<?= active_link_function('easyPayment') ?>">
                                <a href="<?php echo site_url('admin/EasyPayment/easyPayment'); ?>"><i class="fa fa-book">
                                    </i>Easy Payment Invoice</a>
                            </li>
                            
                            <li class="<?= active_link_function('easyPayment') ?>">
                                <a href="<?php echo site_url('admin/EasyPayment/allEasyPayment'); ?>"><i class="fa fa-book">
                                    </i>All Easy Invoice</a>
                            </li>-->
                        <?php }
                      ?>
                        <?php
                        if (in_array("SM43", $blockAdd) || $blockAdd == null) { ?>
                            <!--<li class="<?= active_link_function('easyPayment') ?>">-->
                            <!--    <a href="<?php echo site_url('admin/EasyPayment/easyPaymentSettlement'); ?>"><i class="fa fa-book">-->
                            <!--        </i>Easy Payment Settlement</a>-->
                            <!--</li>-->
                            
                            <!-- <li class="<?= active_link_function('easyPayment') ?>">-->
                            <!--    <a href="<?php echo site_url('admin/EasyPayment/allEasySettlement'); ?>"><i class="fa fa-book">-->
                            <!--        </i>All Settlement Receipt</a>-->
                            <!--</li>-->
                            
                            <!-- <li class="<?= active_link_function('easyPayment') ?>">-->
                            <!--    <a href="<?php echo site_url('admin/EasyPayment/easyPaymentCancel'); ?>"><i class="fa fa-book">-->
                            <!--        </i>Easy Payment Cancel</a>-->
                            <!--</li>-->
                        <?php }
                        ?>
                    </ul>
                <!--</li>-->
            <?php } ?>
            <?php if (in_array("M4", $blockView) || $blockView == null) { ?>
                <li class="treeview <?= active_link_controller('Salesinvoice') ?>">
                    <a href="#">
                        <i class="fa fa-book"></i><span>Invoice</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (in_array("SM41", $blockAdd) || $blockAdd == null) {
                            if (!in_array('addSalesInvoice', $block_function)) { ?>
                                <li class="<?= active_link_function('addSalesInvoice') ?>">
                                    <a href="<?php echo site_url('admin/Salesinvoice/addSalesInvoice'); ?>">Add Sales
                                        Invoice</a>
                                </li>
                            <?php }
                        }
                        if (in_array("SM42", $blockView) || $blockView == null) {
                            if (!in_array('all_pre_orders', $block_function)) { ?>
                                <li class="<?= active_link_function('all_pre_orders') ?>">
                                    <a href="<?php echo site_url('admin/Salesinvoice/all_pre_orders'); ?>">All Pre Orders</a>
                                </li>
                            <?php }
                        }
                        if (in_array("SM42", $blockView) || $blockView == null) {
                            if (!in_array('all_sales_invoice', $block_function)) { ?>
                                <li class="<?= active_link_function('all_sales_invoice') ?>">
                                    <a href="<?php echo site_url('admin/Salesinvoice/all_sales_invoice'); ?>">All Sales
                                        Invoice</a>
                                </li>
                            <?php }
                        }
                        if (in_array("SM43", $blockAdd) || $blockAdd == null) { ?>
                            <!-- <li class="<?= active_link_function('job_invoice') ?>">
                                <a href="<?php echo site_url('admin/Salesinvoice/job_invoice'); ?>">Add Job Invoice</a>
                            </li> -->
                        <?php }
                        if (in_array("SM44", $blockView) || $blockView == null) {
                            ?>
<!--                            <li class="--><?//= active_link_function('all_temp_invoices') ?><!--">-->
<!--                                <a href="--><?php //echo site_url('admin/AllSalesinvoice/all_temp_invoices'); ?><!--">All Job-->
<!--                                    Temporary-->
<!--                                    Invoice</a>-->
<!--                            </li>-->
                        <?php }
                        if (in_array("SM45", $blockView) || $blockView == null) { ?>
                            <!-- <li class="<?= active_link_function('index') ?>">
                                <a href="<?php echo site_url('admin/AllSalesinvoice'); ?>">All Job Invoice</a>
                            </li> -->
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if (in_array("M5", $blockView) || $blockView == null) { ?>
                <li class="treeview <?= active_link_controller('estimate') ?>">

                    <!--<a href="<?php echo site_url('admin/job/all_estimate'); ?>">-->
                    <!--    <i class="fa fa-tags">-->
                    <!--    </i> <span>All Estimate</span>-->
                    <!--    <i class="fa fa-angle-left pull-right"></i>-->
                    <!--</a>-->

                   <!-- <a href="#">
                         <i class="fa fa-tags"></i><span>Estimate</span>
                         <i class="fa fa-angle-left pull-right"></i>
                     </a>
                    <ul class="treeview-menu">
                        <?php if (in_array("SM51", $blockAdd) || $blockAdd == null) { ?>
                            <li class="">
                                <a href="<?php echo site_url('admin/job/estimate_job'); ?>">Add Estimate</a>
                            </li>
                        <?php } ?>
                        <?php if (in_array("SM52", $blockView) || $blockView == null) { ?>
                            <li class="">
                                <a href="<?php echo site_url('admin/job/all_estimate'); ?>">All Estimates</a>
                            </li>
                        <?php } ?>
                    </ul> -->
                </li>
            <?php } ?>
            <?php if (in_array("M6", $blockView) || $blockView == null) { ?>
                <li class="treeview <?= active_link_controller('product') ?>">
                    <a href="#">
                        <i class="fa fa-product-hunt"></i>
                        <span><?php echo lang('menu_product'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?= active_link_function('index') ?>"><a
                                    href="<?php echo site_url('admin/product/'); ?>"><?php echo lang('menu_product'); ?></a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if (empty($_SESSION['location']) || $_SESSION['location'] == 1) { ?>
            <?php if (in_array("M7", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('master') ?>">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span><?php echo lang('menu_master'); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('master') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Product</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (!in_array('category', $block_function)) { ?>
                                <li class="<?= active_link_function('category') ?>"><a
                                            href="<?php echo site_url('admin/master/category'); ?>"><?php echo lang('menu_category'); ?></a>
                                </li>
                            <?php } ?>
                            <?php if (!in_array('product_brand', $block_function)) { ?>
                                <li class="<?= active_link_function('product_brand') ?>"><a
                                            href="<?php echo site_url('admin/master/product_brand'); ?>">Prodcut
                                        Brand</a></li>
                            <?php } ?>
                            <?php if (!in_array('product_quality', $block_function)) { ?>
                                <li class="<?= active_link_function('product_quality') ?>"><a
                                            href="<?php echo site_url('admin/master/product_quality'); ?>">Prodcut
                                        Quality</a></li>
                            <?php } ?>
                            <?php if (!in_array('store_rack', $block_function)) { ?>
                                <li class="<?= active_link_function('store_rack') ?>"><a
                                            href="<?php echo site_url('admin/master/store_rack'); ?>">Store Rack</a>
                                </li>
                            <?php }
                            if (!in_array('store_location', $block_function)) { ?>
                                <li class="<?= active_link_function('store_location') ?>"><a
                                            href="<?php echo site_url('admin/master/store_location'); ?>">Store
                                        Locations</a></li>
                            <?php } ?>

                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('master') ?>">
                        <!-- <a href="#"><i class="fa fa-gratipay"></i><span>Job</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a> -->
                        <ul class="treeview-menu">
                            <?php if (!in_array('job_section', $block_function)) { ?>
                                <li class="<?= active_link_function('job_section') ?>"><a
                                            href="<?php echo site_url('admin/master/job_section'); ?>">Job Type</a></li>
                            <?php } ?>
                            <li class="<?= active_link_function('job_type_header') ?>"><a
                                        href="<?php echo site_url('admin/master/job_type_header'); ?>">Work Type
                                    Category</a></li>

                            <?php if (!in_array('job_type', $block_function)) { ?>
                                <li class="<?= active_link_function('job_type') ?>"><a
                                            href="<?php echo site_url('admin/master/job_type'); ?>">Work Type</a></li>
                            <?php } ?>
                            <?php if (!in_array('jobinv_description', $block_function)) { ?>
                                <li class="<?= active_link_function('jobinv_description') ?>"><a
                                            href="<?php echo site_url('admin/master/jobinv_description'); ?>">Work Type
                                        Description</a></li>
                            <?php } ?>
                            <?php if (!in_array('jobcard_description', $block_function)) { ?>
                                <li class="<?= active_link_function('jobcard_description') ?>"><a
                                            href="<?php echo site_url('admin/master/jobcard_description'); ?>">Customer
                                        Request Notes</a></li>
                            <?php }
                            if (!in_array('jobcard_category', $block_function)) { ?>
                                <!-- <li class="<?= active_link_function('jobcard_category') ?>"><a href="<?php echo site_url('admin/master/jobcard_category'); ?>">Job Category</a></li> -->
                            <?php } ?>

                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('master') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>General</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
<!--                            <li class="--><?php //= active_link_function('mercedes_model_codes') ?><!--"><a-->
<!--                                        href="--><?php //echo site_url('admin/master/mercedes_model_codes'); ?><!--">Models-->
<!--                                    Codes</a></li>-->

                            <?php if (!in_array('vcategory', $block_function)) { ?>
                                <!-- <li class="<?= active_link_function('vcategory') ?>"><a href="<?php echo site_url('admin/master/vcategory'); ?>">Vehicle Make & Models</a></li> -->
                            <?php } ?>
                            <?php if (!in_array('view_inscompany', $block_function)) { ?>
<!--                                <li class="--><?php //= active_link_function('view_inscompany') ?><!--"><a-->
<!--                                            href="--><?php //echo site_url('admin/master/view_inscompany'); ?><!--">Third Party-->
<!--                                        Companies</a></li>-->
                            <?php } ?>
<!--                            <li class="--><?php //= active_link_function('invoice_condition') ?><!--"><a-->
<!--                                        href="--><?php //echo site_url('admin/master/invoice_condition'); ?><!--">Terms &-->
<!--                                    Conditions</a></li>-->


                            <?php if (!in_array('trans_type', $block_function)) { ?>
                                <li class="<?= active_link_function('trans_type') ?>"><a
                                            href="<?php echo site_url('admin/master/trans_type'); ?>">Transaction
                                        type</a></li>
                            <?php } ?>

                            <li class="<?= active_link_function('index') ?>">
                                <a href="<?php echo site_url('admin/supplier'); ?>">Supplier</a>
                            </li>

                            <li class="<?= active_link_function('bank_account') ?>">
                                <a href="<?php echo site_url('admin/master/bank_account'); ?>">Accounts</a>
                            </li>


                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('master') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Employee</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (!in_array('emp_type', $block_function)) { ?>
                                <li class="<?= active_link_function('emp_type') ?>">
                                    <a href="<?php echo site_url('admin/master/emp_type'); ?>">Employee Type</a>
                                </li>
                            <?php } ?>
                            <?php if (!in_array('index', $block_function)) { ?>
                                <li class="<?= active_link_function('employee') ?>">
                                    <a href="<?php echo site_url('admin/sales/index'); ?>">Employee</a>
                                </li>
                            <?php } ?>


                        </ul>
                    </li>
                </ul>
                <!-- create new customer option -->
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('master') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Customer</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (!in_array('customer_routes', $block_function)) { ?>
                                <li class="<?= active_link_function('customer_routes') ?>">
                                    <a href="<?php echo site_url('admin/master/customer_routes'); ?>">Customer Routes</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <!--<li class="<?= active_link_controller('master') ?>">-->
                    <!--    <a href="#"><i class="fa fa-gratipay"></i><span>Easy Payment</span>-->
                    <!--        <i class="fa fa-angle-left pull-right"></i>-->
                    <!--    </a>-->
                        <!--<ul class="treeview-menu">-->
                        <!--    <?php if (!in_array('manageInterest', $block_function)) { ?>-->
                        <!--        <li class="<?= active_link_function('manageInterest') ?>">-->
                        <!--            <a href="<?php echo site_url('admin/master/manageInterest'); ?>">Manage Interest</a>-->
                        <!--        </li>-->
                        <!--    <?php } ?>-->

                        <!--    <?php if (!in_array('holiday', $block_function)) { ?>-->
                        <!--        <li class="<?= active_link_function('holiday') ?>">-->
                        <!--            <a href="<?php echo site_url('admin/master/holiday'); ?>">Holiday Schedule</a>-->
                        <!--        </li>-->
                        <!--    <?php } ?>-->

                        <!--    <?php if (!in_array('extraCharges', $block_function)) { ?>-->
                        <!--        <li class="<?= active_link_function('extraCharges') ?>">-->
                        <!--            <a href="<?php echo site_url('admin/master/extraCharges'); ?>">Extra Charges</a>-->
                        <!--        </li>-->
                        <!--    <?php } ?>-->
                        <!--</ul>-->
                    <!--</li>-->
                </ul>
                <!--<ul class="treeview-menu">
                    <li class="<?= active_link_function('index') ?>"><a href="<?php echo site_url('admin/master/'); ?>"><?php echo lang('menu_master'); ?></a></li>
                </ul>-->
                <!-- <ul class="treeview-menu">
                    <?php if (!in_array('category', $block_function)) { ?>
                    <li class="<?= active_link_function('category') ?>"><a href="<?php echo site_url('admin/master/category'); ?>"><?php echo lang('menu_category'); ?></a></li>
                    <?php }
                if (!in_array('trans_type', $block_function)) { ?>
                    <li class="<?= active_link_function('trans_type') ?>"><a href="<?php echo site_url('admin/master/trans_type'); ?>">Transaction type</a></li>
                    <?php }
                if (!in_array('vcategory', $block_function)) { ?>
                    <li class="<?= active_link_function('vcategory') ?>"><a href="<?php echo site_url('admin/master/vcategory'); ?>">Vehicle Make & Models</a></li>
                    <?php }
                if (!in_array('view_inscompany', $block_function)) { ?>
                    <li class="<?= active_link_function('view_inscompany') ?>"><a href="<?php echo site_url('admin/master/view_inscompany'); ?>">Third Party Companies</a></li>
                    <?php }
                if (!in_array('jobcard_category', $block_function)) { ?>
                    <li class="<?= active_link_function('jobcard_category') ?>"><a href="<?php echo site_url('admin/master/jobcard_category'); ?>">Job Category</a></li>
                    <?php }
                if (!in_array('jobcard_description', $block_function)) { ?>
                    <li class="<?= active_link_function('jobcard_description') ?>"><a href="<?php echo site_url('admin/master/jobcard_description'); ?>">Job Card Description</a></li>
                    <?php }
                if (!in_array('jobinv_description', $block_function)) { ?>
                    <li class="<?= active_link_function('jobinv_description') ?>"><a href="<?php echo site_url('admin/master/jobinv_description'); ?>">Work Type Description</a></li>
                    <?php }
                if (!in_array('job_type', $block_function)) { ?>
                    <li class="<?= active_link_function('job_type') ?>"><a href="<?php echo site_url('admin/master/job_type'); ?>">Work Type</a></li>
                    <?php }
                if (!in_array('job_section', $block_function)) { ?>
                    <li class="<?= active_link_function('job_section') ?>"><a href="<?php echo site_url('admin/master/job_section'); ?>">Job Section</a></li>
                    <?php } ?>
                    <?php if (!in_array('emp_type', $block_function)) { ?>
                    <li class="<?= active_link_function('emp_type') ?>">
                        <a href="<?php echo site_url('admin/master/emp_type'); ?>">Employee Type</a>
                    </li>
                    <?php }
                if (!in_array('index', $block_function)) { ?>
                    <li class="<?= active_link_function('index') ?>">
                        <a href="<?php echo site_url('admin/sales/'); ?>">Employee</a>
                    </li>
                    <?php }
                if (!in_array('index', $block_function)) { ?>
                    <li class="<?= active_link_function('index') ?>">
                        <a href="<?php echo site_url('admin/supplier'); ?>">Supplier</a>
                    </li>
                    <?php }
                if (!in_array('bank_account', $block_function)) { ?>
                    <li class="<?= active_link_function('bank_account') ?>">
                        <a href="<?php echo site_url('admin/master/bank_account'); ?>">Accounts</a>
                    </li>
                    <?php } ?>
                </ul> -->
            </li>
            <?php } 
            } ?>
            <?php if (in_array("M8", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('report') ?>">
                <a href="#">
                    <i class="fa fa-gratipay"></i><span>Reporting</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <a href="<?php echo site_url('admin/customer/customerreport'); ?>">
                            <i class="fa fa-gratipay"></i><span>All Customers</span>
                        </a>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <!-- <a href="#"><i class="fa fa-gratipay"></i><span>Issue Note</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a> -->
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('issueNoteByDate') ?>">
                                <a href="<?php echo site_url('admin/report/issueNoteByDate'); ?>">Issue Note By Date</a>
                            </li>
                            <li class="<?= active_link_function('issueNoteByDate') ?>">
                                <a href="<?php echo site_url('admin/report/issueNoteByJob'); ?>">Issue Note By Job</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <!-- <a href="#"><i class="fa fa-gratipay"></i><span>Job Sale</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a> -->
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('jobsalesbydate') ?>">
                                <a href="<?php echo site_url('admin/report/jobsalesbydate'); ?>">Date wise Job sale</a>
                            </li>
                            <li class="<?= active_link_function('jobsalesumbydate') ?>">
                                <a href="<?php echo site_url('admin/report/jobsalesumbydate'); ?>">Job Invoice
                                    summery</a>
                            </li>
                            <li class="<?= active_link_function('jobpaymentbyinvoice') ?>">
                                <a href="<?php echo site_url('admin/report/jobpaymentbyinvoice'); ?>">Job Payment
                                    summery</a>
                            </li>
                            <li class="<?= active_link_function('jobsalesbyservice') ?>">
                                <a href="<?php echo site_url('admin/report/jobsalesbyservice'); ?>">Service wise Job
                                    sale</a>
                            </li>
                            <li class="<?= active_link_function('jobsalesbyproduct') ?>">
                                <a href="<?php echo site_url('admin/report/jobsalesbyproduct'); ?>">Product wise Job
                                    sale</a>
                            </li>
                        <!--    <li class="<?= active_link_function('vehiclesummery') ?>">-->
                        <!--        <a href="<?php echo site_url('admin/report/vehiclesummery'); ?>">Vehicle wise Job-->
                        <!--            summary</a>-->
                        <!--    </li>-->
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Pos Sale</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('salesbydate') ?>">
                                <a href="<?php echo site_url('admin/report/salesbydate'); ?>">Date wise sale</a>
                            </li>
                                 <li class="<?= active_link_function('directsalesbyproduct') ?>">
                                                                <a href="<?php echo site_url('admin/report/directsalesbyproduct'); ?>">Product wise sale</a>
                                                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                        <li class="<?= active_link_controller('report') ?>">
                            <!-- <a href="#"><i class="fa fa-gratipay"></i><span>Customer Order</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a> -->
<!--                            <ul class="treeview-menu">-->
<!--                                <li class="--><?php //= active_link_function('salesbydate') ?><!--">-->
<!--                                    <a href="--><?php //echo site_url('admin/report/orderbydate'); ?><!--">Date wise order</a>-->
<!--                                </li>-->
<!--                            </ul>-->
                        </li>
                    </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>GRN</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('grnreport') ?>">
                                <a href="<?php echo site_url('admin/report/grnreport'); ?>">Goods Recevied Note</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Stock</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('productreport') ?>">
                                <a href="<?php echo site_url('admin/report/productreport'); ?>">Product Stock</a>
                            </li>
                            <li class="<?= active_link_function('lowstockreport') ?>">
                                <a href="<?php echo site_url('admin/report/lowstockreport'); ?>">Minimum Stock</a>
                            </li>
<!--                            <li class="--><?//= active_link_function('pricereport') ?><!--">-->
<!--                                <a href="--><?php //echo site_url('admin/report/pricereport'); ?><!--">Price Stock</a>-->
<!--                            </li>-->
<!--                            <li class="--><?php //= active_link_function('serialstock') ?><!--">-->
<!--                                <a href="--><?php //echo site_url('admin/report/serialstock'); ?><!--">Product Serial Stock</a>-->
<!--                            </li>-->
<!--                            <li class="--><?//= active_link_function('dailyfinalreport') ?><!--">-->
<!--                                <a href="--><?php //echo site_url('admin/report/dailyfinalreport'); ?><!--">Daily Final Stock</a>-->
<!--                            </li>-->
                        </ul>
                    </li>
                </ul>
                <!--<ul class="treeview-menu">-->
                <!--    <li class="<?= active_link_controller('report') ?>">-->
                <!--        <a href="#"><i class="fa fa-gratipay"></i><span>Transfer</span>-->
                <!--            <i class="fa fa-angle-left pull-right"></i>-->
                <!--        </a>-->
                <!--        <ul class="treeview-menu">-->
                <!--            <li class="<?= active_link_function('trasferreport') ?>">-->
                <!--                <a href="<?php echo site_url('admin/report/trasferreport'); ?>">Stock Transfer</a>-->
                <!--            </li>-->
                <!--        </ul>-->
                <!--    </li>-->
                <!--</ul>-->
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Cash</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('cashinout') ?>">
                                <a href="<?php echo site_url('admin/report/cashinout'); ?>">Cash In out</a>
                            </li>
                            <li class="<?= active_link_function('cashfloat') ?>">
                                <a href="<?php echo site_url('admin/report/cashfloat'); ?>">Expenses Earning</a>
                            </li>
<!--                            <li class="--><?php //= active_link_function('dailybalancedetail') ?><!--">-->
<!--                                <a href="--><?php //echo site_url('admin/report/dailybalancedetail'); ?><!--">Daily Cash-->
<!--                                    Float</a>-->
<!--                            </li>-->
                            <li class="<?= active_link_function('dailycashturnover') ?>">
                                    <a href="<?php echo site_url('admin/report/dailycashturnover'); ?>">Cash
                                        Turn Over</a>
                                </li>
                                 <li class="<?= active_link_function('dailycashturnoversummary') ?>">
                                    <a href="<?php echo site_url('admin/report/dailycashturnoversummary'); ?>">Cash
                                        Turn Over Summery</a>
                                </li>
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Payments</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('customerpayment') ?>">
                                <a href="<?php echo site_url('admin/report/customerpayment'); ?>">Customer Payments</a>
                            </li>
                            <li class="<?= active_link_function('supplierpayment') ?>">
                                <a href="<?php echo site_url('admin/report/supplierpayment'); ?>">Supplier Payments</a>
                            </li>
                            <!--<li class="<?= active_link_function('easybydate') ?>">-->
                            <!--        <a href="<?php echo site_url('admin/report/easybydate'); ?>">Easy Payments</a>-->
                            <!--    </li>-->
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_controller('report') ?>">
                        <a href="#"><i class="fa fa-gratipay"></i><span>Credit</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= active_link_function('customercredit') ?>">
                                <a href="<?php echo site_url('admin/report/customercredit'); ?>">Customer Outstanding
                                    Detail</a>
                            </li>
                            <li class="<?= active_link_function('customercredit') ?>">
                                <a href="<?php echo site_url('admin/report/customercreditsummary'); ?>">Customer
                                    Outstanding Summary</a>
                            </li>
                            <!-- <li class="">
                                <a href="#">Supplier Payments</a>
                            </li> -->
                        </ul>
                    </li>
                </ul>
                <ul class="treeview-menu">
<!--                    <li class="--><?php //= active_link_controller('report') ?><!--">-->
<!--                        <a href="#"><i class="fa fa-gratipay"></i><span>Commission</span>-->
<!--                            <i class="fa fa-angle-left pull-right"></i>-->
<!--                        </a>-->
<!--                        <ul class="treeview-menu">-->
<!--                            <li class="--><?php //= active_link_function('customercommission') ?><!--">-->
<!--                                <a href="--><?php //echo site_url('admin/report/customercommission'); ?><!--">Customer wise-->
<!--                                    Commission</a>-->
<!--                            </li>-->
                            <!-- <li class="">
                                <a href="#">Supplier Payments</a>
                            </li> -->
<!--                        </ul>-->
<!--                    </li>-->
                </ul>
                <ul class="treeview-menu">
                        <li class="<?= active_link_controller('report') ?>">
                            <a href="#"><i class="fa fa-gratipay"></i><span>Monthly Report</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('monthwiseincomereport') ?>">
                                    <a href="<?php echo site_url('admin/report/monthwiseincomereport'); ?>">Monthly Transaction Report</a>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('loadingreport') ?>">
                                    <a href="<?php echo site_url('admin/report/loadingreport'); ?>">Loading Report</a>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('routewisereport') ?>">
                                    <a href="<?php echo site_url('admin/report/routewisereport'); ?>">Route Wise Report</a>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('routewiseoutstandingreport') ?>">
                                    <a href="<?php echo site_url('admin/report/routewiseoutstandingreport'); ?>">Route Wise Outstanding Report</a>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('saleswisereport') ?>">
                                    <a href="<?php echo site_url('admin/report/saleswisereport'); ?>">Total Sales Report</a>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('returnreport') ?>">
                                    <a href="<?php echo site_url('admin/report/returnreport'); ?>">Return Report</a>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('receivedproductreport') ?>">
                                    <a href="<?php echo site_url('admin/report/receivedproductreport'); ?>">Received Product Report</a>
                                </li>
                            </ul>
                        </li>
                        
                </ul>
                    <ul class="treeview-menu">
                    <!--    <li class="<?= active_link_controller('report') ?>">-->
                    <!--        <a href="#"><i class="fa fa-gratipay"></i><span>Easy</span>-->
                    <!--            <i class="fa fa-angle-left pull-right"></i>-->
                    <!--        </a>-->
                    <!--        <ul class="treeview-menu">-->
                    <!--            <li class="<?= active_link_function('easySummeryByDate') ?>">-->
                    <!--                <a href="<?php echo site_url('admin/report/easySummeryByDate'); ?>">Payment Summery By Date</a>-->
                    <!--            </li>-->
                    <!--        </ul>-->
                    <!--    </li>-->
                    </ul>
            </li>
            <?php } ?>
            <?php if (empty($_SESSION['location']) || $_SESSION['location'] == 1) { ?>
            <?php if (in_array("M9", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('grn') ?>">
                <a href="#">
                    <i class="fa fa-support"></i>
                    <span>Good Received Note</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li class="<?= active_link_function('addgrn') ?>"><a
                                href="<?php echo site_url('admin/grn/addgrn'); ?>">Add GRN</a></li>
                    <li class="<?= active_link_function('all_grn') ?>"><a
                                href="<?php echo site_url('admin/grn/all_grn'); ?>">All GRN</a></li>
                    <li class="<?= active_link_function('cancel_grn') ?>"><a
                                href="<?php echo site_url('admin/grn/cancel_grn'); ?>">Cancel GRN</a></li>
                    <li class="<?= active_link_function('stockAdjustment') ?>"><a
                                href="<?php echo site_url('admin/grn/stockAdjustment'); ?>">Stock Adjustment</a></li>
                    <li class="<?= active_link_function('barcodeprint') ?>"><a
                                href="<?php echo site_url('admin/grn/barcodeprint'); ?>">Barcode Print</a></li>
                </ul>
            </li>
            <?php } 
            } ?>
            <?php if (in_array("M10", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('payment') ?>">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Payment</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li class="<?= active_link_function('cus_payment') ?>"><a
                                href="<?php echo site_url('admin/payment/cus_payment'); ?>">Customer Payment</a></li>
                    <li class="<?= active_link_function('cancel_cus_payment') ?>"><a
                                href="<?php echo site_url('admin/payment/cancel_cus_payment'); ?>">Cancel Customer
                            Payment</a></li>
                    <li class="<?= active_link_function('sup_payment') ?>"><a
                                href="<?php echo site_url('admin/payment/sup_payment'); ?>">Supplier Payment</a></li>
                    <li class="<?= active_link_function('cancel_sup_payment') ?>"><a
                                href="<?php echo site_url('admin/payment/cancel_sup_payment'); ?>">Cancel Supplier
                            Payment</a></li>
                    <!--<li class="<?= active_link_function('payment') ?>"><a href="<?php echo site_url('admin/payment/cancel_cus_payment'); ?>">Barcode Print</a></li>-->
                </ul>
            </li>
            <?php } ?>
            <?php if (empty($_SESSION['location']) || $_SESSION['location'] == 1) { ?>
            <?php if (in_array("M11", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('purchase') ?>">
                <a href="#">
                    <i class="fa fa-instagram"></i>
                    <span>Purchase</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <!--<li class="<?= active_link_function('addpo') ?>"><a-->
                    <!--            href="<?php echo site_url('admin//purchase/addpo'); ?>">Add Purchase Order</a></li>-->
                    <!--<li class="<?= active_link_function('all_po') ?>"><a-->
                    <!--            href="<?php echo site_url('admin/purchase/all_po'); ?>">All PO</a></li>-->
                    <li class="<?= active_link_function('addprn') ?>">
                            <a href="<?php echo site_url('admin/purchase/addprn'); ?>">Add Purchase Return</a>
                        </li>
                    <li class="<?= active_link_function('all_prn') ?>">
                        <a href="<?php echo site_url('admin/purchase/all_prn'); ?>">All Purchase Return</a>
                    </li>
                </ul>
            </li>
            <?php } 
            } ?>
            <?php if (in_array("M12", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('mrn') ?>">
                <!-- <a href="#">
                    <i class="fa fa-instagram"></i>
                    <span>Parts Request</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a> -->

                <ul class="treeview-menu">
                    <li class="<?= active_link_function('add_mrn') ?>"><a
                                href="<?php echo site_url('admin/mrn/add_mrn'); ?>">Add Part Request</a></li>
                    <li class="<?= active_link_function('issue_mrn') ?>"><a
                                href="<?php echo site_url('admin/mrn/issue_mrn'); ?>">Issue Parts</a></li>
                    <li class="<?= active_link_function('all_mrns') ?>"><a
                                href="<?php echo site_url('admin/mrn/all_mrns'); ?>">All Parts Requests</a></li>
                </ul>
            </li>
            <?php } ?>
            <?php if (in_array("M13", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('invoice') ?>">
                <a href="#">
                    <i class="fa fa-instagram"></i>
                    <span>Invoice - Return/ Cancel</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <?php if (in_array("SM131", $blockView) || $blockView == null) { ?>
                        <li class="<?= active_link_function('return_invoice') ?>"><a
                                    href="<?php echo site_url('admin/invoice/return_invoice'); ?>">Return Invoice</a>
                        </li>
                    <?php } ?>
                    <?php if (in_array("SM132", $blockView) || $blockView == null) { ?>
                        <li class="<?= active_link_function('all_returns') ?>"><a
                                    href="<?php echo site_url('admin/invoice/all_returns'); ?>">All Return Invoice</a>
                        </li>
                    <?php } ?>
                    <?php if (in_array("SM133", $blockView) || $blockView == null) { ?>
                        <li class="<?= active_link_function('cancel_invoice') ?>"><a
                                    href="<?php echo site_url('admin/invoice/cancel_invoice'); ?>">Cancel Pos
                                Invoice</a>
                        </li>
                    <?php } ?>
                    <?php if (in_array("SM134", $blockView) || $blockView == null) { ?>
                        <li class="<?= active_link_function('index') ?>"><a
                                    href="<?php echo site_url('admin/invoice/index'); ?>">Reprint Pos Invoice</a></li>
                    <?php } ?>
                    <?php if (in_array("SM134", $blockView) || $blockView == null) { ?>
                        <li class="<?= active_link_function('received_invoice') ?>"><a
                                    href="<?php echo site_url('admin/invoice/received_invoice'); ?>">Received Product Count</a></li>
                    <?php } ?>
                    <?php if (in_array("SM134", $blockView) || $blockView == null) { ?>
                        <li class="<?= active_link_function('received_invoice') ?>"><a
                                    href="<?php echo site_url('admin/invoice/all_received_invoice'); ?>">All Received Product Count Details</a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <!-- <li class="treeview <?= active_link_controller('transer') ?>">
                <a href="#">
                    <i class="fa fa-tags"></i>
                    <span>Stock Transfer</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li class="<?= active_link_function('transer') ?>"><a href="<?php echo site_url('admin/transer/stock_out'); ?>">Stock transfer out</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_function('transer') ?>"><a href="<?php echo site_url('admin/transer/stock_in'); ?>">Stock transfer in</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_function('transer') ?>"><a href="<?php echo site_url('admin/transer/cancel_transer'); ?>">Cancel Transfer</a></li>
                </ul>
            </li> -->
            <?php if (in_array("M15", $blockView) || $blockView == null) { ?>
            <li class="treeview <?= active_link_controller('cash') ?>">
                <a href="#">
                    <i class="fa fa-tags"></i>
                    <span>Cash Float</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <!--<li class="<?= active_link_function('cash_float') ?>"><a-->
                    <!--            href="<?php echo site_url('admin/cash/cash_float'); ?>">Cash Float</a></li>-->
                </ul>
                <ul class="treeview-menu">
                    <li class="<?= active_link_function('cash_float_balance') ?>"><a
                                href="<?php echo site_url('admin/cash/cash_float_balance'); ?>">Cash Float Balance</a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <!-- <li class="<?= active_link_function('dailyupdatetock') ?>" >
                <a href="<?php echo site_url('admin/daily_update/dailyupdatetock'); ?>">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>Update Daily Stock</span>
                </a>
            </li>  -->
       
            <?php if (empty($_SESSION['role']) || $_SESSION['role'] == 1) { ?>
                <li class="header text-uppercase"><?php echo lang('menu_administration'); ?></li>
                
                 <li class="<?= active_link_controller('setPermission') ?>">
                    <a href="<?php echo site_url('admin/setPermission/role'); ?>">
                        <i class="fa fa-user-secret"></i> <span>User Roles</span>
                    </a>
                </li>
                
                <li class="<?= active_link_controller('users') ?>">
                    <a href="<?php echo site_url('admin/users'); ?>">
                        <i class="fa fa-user"></i> <span><?php echo lang('menu_users'); ?></span>
                    </a>
                </li>
                <!--                <li class="--><? //= active_link_controller('groups') ?><!--">-->
                <!--                    <a href="--><?php //echo site_url('admin/groups'); ?><!--">-->
                <!--                        <i class="fa fa-shield"></i> <span>--><?php //echo lang('menu_security_groups'); ?><!--</span>-->
                <!--                    </a>-->
                <!--                </li>-->
                <li class="<?= active_link_controller('setPermission') ?>">
                    <a href="<?php echo site_url('admin/setPermission'); ?>">
                        <i class="fa fa-user-secret"></i> <span>Set Permission</span>
                    </a>
                </li>
            <?php } ?>
            <!--  <li class="<?= active_link_controller('groups') ?>">
                            <a href="<?php echo site_url('admin/groups'); ?>">
                                <i class="fa fa-shield"></i> <span><?php echo lang('menu_security_groups'); ?></span>
                            </a>
                        </li>
                        <li class="treeview <?= active_link_controller('prefs') ?>">
                            <a href="#">
                                <i class="fa fa-cogs"></i>
                                <span><?php echo lang('menu_preferences'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= active_link_function('interfaces') ?>"><a href="<?php echo site_url('admin/prefs/interfaces/admin'); ?>"><?php echo lang('menu_interfaces'); ?></a></li>
                            </ul>
                        </li>
                        <li class="<?= active_link_controller('files') ?>">
                            <a href="<?php echo site_url('admin/files'); ?>">
                                <i class="fa fa-file"></i> <span><?php echo lang('menu_files'); ?></span>
                            </a>
                        </li>
                        <li class="<?= active_link_controller('database') ?>">
                            <a href="<?php echo site_url('admin/database'); ?>">
                                <i class="fa fa-database"></i> <span><?php echo lang('menu_database_utility'); ?></span>
                            </a>
                        </li>-->


        </ul>
    </section>
</aside>
