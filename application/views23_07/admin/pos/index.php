<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    .content-header{
        padding: 0px;
    }
    .content{
        padding-bottom: 0px;
    }
    .btnlg{line-height: 2.5;font-size: 21px;}
    .box{
       margin: 0;
    }
    
    .table>tfoot>tr>td{
        padding:6px;
    }

    .btnlg {
        line-height: 1.5;
        font-size: 21px;
    }
 
</style>
<div class="content-wrapper">
    <section class="content-header">
        <?php //echo $pagetitle; ?>
        <?php //echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="box collapse cart-options" id="collapseExample">
            <div class="box-header">Filter Categories</div>
            <div class="box-body categories_dom_wrapper">
            </div>
            <div class="box-footer">
                <button class="btn btn-primary close-item-options pull-right">Hide options</button>
            </div>
        </div>   
        <div class="row gui-row-tag">
            <div class="meta-row col-lg-12 col-md-12">
                <div class="box box-primary direct-chat direct-chat-primary" id="product-list-wrapper" style="visibility: visible;">
                    <div class="box-header with-border">
                        <form action="" method="post" id="search-item-form">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-large btn-primary btn-lg">Search</button>
                                </span>
                                <input type="text" autofocus id="search_product" name="item_sku_barcode" placeholder="Barcode, Serial Number, Product name or code ..." class="form-control input-lg">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-success btn-lg" id="SHGrid" bound="true"><i class="fa fa-plus-circle"></i> Show/Hide Grid</button>
                                    <!--<a class="btn btn-default"  data-target="#modelInvoice"  data-toggle="modal" alt="Note" ><i class="fa fa-pencil"></i> Note</a>-->
                                </span>
                            </div>
                        </form>
                    </div>
                    <div id="suggestPanel" class="box-body" style="visibility: visible;">
                        <span id="errGrid"></span>
                        <div class="direct-chat-messages item-list-container nscroll" style="padding: 0px; height: 200px;">
                            <div class="row" id="filter-list" style="padding-left:0px;padding-right:0px;margin-left:0px;margin-right:0px;">

                            </div>
                        </div>
                    </div>
                    <div class="overlay" id="product-list-splash" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
            <div class="meta-row col-lg-12 col-md-12">
                <div class="box box-primary direct-chat direct-chat-primary" id="cart-details-wrapper" style="visibility: visible;">
                    <div class="box-header with-border" id="cart-header">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-3">
                             <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"> Price Level</span>
                                <div class="input-group">

                                    <!--<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="Walkin Customer">-->
                                    <select class="form-control" id="prLevel">
                                        <?php foreach ($plv as $pl) { ?>
                                            <option value="<?php echo $pl->PL_No; ?>" <?php if ($pl->PL_No == 1) {
                                            echo 'selected';
                                        }
                                            ?>><?php echo $pl->PriceLevel; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div> 
                            </div>
                            <div class="col-md-2">
                                    <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"> Date</span>
                                  <div class="input-group"><input type="text" name="invDate" id="invDate">
                                  <input type="hidden" name="vatRate" id="vatRate" value="<?php echo $company['VAT']; ?>">
                                <input type="hidden" name="nbtRate" id="nbtRate" value="<?php echo $company['NBT']; ?>">
                                <input type="hidden" name="nbtRatioRate" id="nbtRatioRate" value="<?php echo $company['NBT_Ratio']; ?>">
                                </div>
                                </div></div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"> Hold Invoice</span>
                                  <div class="input-group"><input type="text" name="invoiceNo" id="invoiceNo"></div>
                                </div></div>
                                <div class="col-md-4">
                               <div class="input-group">
                            <!--<span class="input-group-addon">Please choose a customer</span>-->
                            <select name="customer_id" id="customer_id"  class="selectpicker form-control" >
                                
                                <?php foreach ($customers as $cus) { ?>
                                    <option value="<?php echo $cus->CusCode; ?>"><?php echo $cus->CusName; ?></option>
                                <?php } ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary cart-add-customer" id="addCustomer" ><i class="fa fa-user"></i> Add a customer</button>
                            </span>
                        </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-3">
                             <div class="input-group">
                                <span class="input-group-addon" id="basic-addon3"> Invoice Type</span>
                                <div class="input-group">

                                    <!--<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="Walkin Customer">-->
                                    <select name="invoiceType" required="required"  id="invoiceType" class="form-control">
                                    <!-- <option value="">Select a Invoice type</option> -->
                                    <option value="1">General Invoice</option>
                                    <option value="2">Tax Invoice</option>
                                </select>
                                </div>
                            </div> 
                            </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <span> Total Invoice VAT/NBT</span>
                                      <!-- <div class="input-group"><input type="text" name="invDate" id="invDate"></div> -->
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1" style="line-height: 9px;"> VAT</span>
                                        <div class="input-group">
                                        <input class="prd_icheck" type="checkbox" name="isTotalVat"  id="isTotalVat" value='1'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1" style="line-height: 9px;"> NBT</span>
                                        <div class="input-group">
                                         <input class="prd_icheck" type="checkbox" name="isTotalNbt" id="isTotalNbt" value='1'> 
                                <input class="" type="hidden" name="totalNbtRatio" id="totalNbtRatio" value='1'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                        
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <label for="ismultiprice" class="control-label">
                                            <input  class="prd_icheck"  type="checkbox" name="disablePrint" id="disablePrint" value="1">
                                            Disable Print
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                    <style>
                        #cart-item-table-header td{font-size:15px;}#cart-table-body td,#cart-details td{font-size:20px;}
                    </style>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="col-md-9">
                        <table class="table" id="cart-item-table-header" >
                            <thead>
                                <tr class="active">
                                    <td width="10" class="text-left">#</td>
                                    <td width="50" class="text-left"></td>
                                    <td width="210" class="text-left">Items</td>
                                    <td width="130" class="text-right">Unit Price</td>
                                    <td width="145" class="text-right">Quantity</td>
                                    <td width="145" class="text-right">Free quantity</td>
                                    <td width="145" class="text-right">Discount</td>
                                    <td width="115" class="text-right">Total Price</td>
                                    <td width="50" class="text-right"></td>
                                </tr>
                            </thead>
                        </table>
                        <div class="direct-chat-messages nscroll" id="cart-table-body" style="padding: 0px; height: 303px;">
                            <table class="table table-hover table-striped" style="margin-bottom:0;">                
                                <tbody><tr id="cart-table-notice"><td colspan="4">Please add an item</td></tr></tbody>
                            </table>
                        </div>
                        <table class="table" id="cart-details">
                            <tfoot>
                                <tr class="active">
                                    <td width="230" class="text-left" style="font-size:15px;">No Of Items - <span id="itemCount">0</span></td>
                                    
                                    <td width="130" class="text-right"></td>
                                    <td width="130" class="text-right">
                                                            </td>
                                    <td width="110" class="text-right"><span> </span></td>
                                </tr>
                                <!-- <tr class="active">
                                    <td colspan="2" width="380" class="text-right cart-discount-notice-area" ><span id="errPrint" class="pull-left"></span></td>
                                    <td width="130" class="text-right">Discount</td>
                                    <td width="110" class="text-right"><span id="cart-discount">LKR 0.00 </span></td>
                                </tr>
                                <tr class="active" >
                                    <td colspan="2" width="380" class="text-right cart-discount-notice-area" ><span id="errPrint" class="pull-left"></span></td>
                                    <td width="130" class="text-right" style="font-size:16px;">VAT</td>
                                    <td width="110" class="text-right" style="font-size:18px;"><span id="cart-vat">LKR 0.00 </span></td>
                                </tr>
                                <tr class="active" style="font-size:10px;">
                                    <td colspan="2" width="380" class="text-right cart-discount-notice-area" ><span id="errPrint" class="pull-left"></span></td>
                                    <td width="130" class="text-right" style="font-size:16px;">NBT</td>
                                    <td width="110" class="text-right" style="font-size:18px;"><span id="cart-nbt">LKR 0.00 </span></td>
                                </tr>
                                <tr class="success">
                                    <td width="230" class="text-right">
                                    </td>
                                    <td width="130" class="text-right"></td>
                                    <td width="130" class="text-right"><strong>Net Payable</strong></td>
                                    <td width="110" class="text-right"><strong><span id="cart-topay"></span></strong></td>
                                </tr> -->
                            </tfoot>
                        </table>
                        </div>
                        <div class="col-md-3">
                        <div class="row">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Total</td>
                                        <td>:</td>
                                        <td id="cart-value">LKR 0.00 </td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>:</td>
                                        <td id="cart-discount">LKR 0.00 </td>
                                    </tr>
                                    <tr>
                                        <td>Vat</td>
                                        <td>:</td>
                                        <td id="cart-vat">LKR 0.00 </td>
                                    </tr>
                                    <tr>
                                        <td>Nbt</td>
                                        <td>:</td>
                                        <td id="cart-nbt">LKR 0.00 </td>
                                    </tr>
                                    <tr>
                                        <td>Net Payable</td>
                                        <td>:</td>
                                        <td id="cart-topay" style="font-size: 25px;color: #3c8dbc">LKR 0.00 </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                             <form class="form-horizontal" >
                             <div class="col-sm-6" >
                                 <div class="form-group" role="group">
                                    <button data-target="#modelPayment" type="button"  data-toggle="modal" class="btn btn-primary btn-lg btnlg" id="cart-pay-button" style="margin-bottom:0px;width: 90%;">
                                        <i class="fa fa-money"></i>
                                        Payment            
                                    </button>
                                </div>
                             </div>
                             <div class="col-sm-6" >
                                 <div class="form-group" >
                                    <button type="button"  class="btn btn-info btn-lg btnlg" id="printInvoice" style="margin-bottom:0px;width: 90%;">
                                        <i class="fa fa-print"></i>
                                        Print            
                                    </button>
                                </div>
                             </div>
                             <!-- <div class="col-sm-12" >
                                 <div class="form-group" role="group">
                                    <button data-target="#modelPayment" type="button"  data-toggle="modal" class="btn btn-primary btn-lg btnlg" id="cart-pay-button" style="margin-bottom:0px;width: 90%;">
                                        <i class="fa fa-money"></i>
                                        Payment            
                                    </button>
                                </div>
                             </div> -->
                             <div class="col-sm-12" >
                                 <div class="form-group" role="group">
                                    <button type="button"  class="btn btn-warning btn-lg btnlg" id="savePrint" style="margin-bottom:0px;width: 95%;">
                                        <i class="fa fa-print"></i>
                                        Without Payment            
                                    </button>
                                </div>
                             </div>
                             <div class="col-sm-6" >
                                 <div class="form-group" role="group">
                                    <button data-target="#modelTotalDis" type="button"  data-toggle="modal" class="btn btn-success btn-lg btnlg" id="cart-discount-button" style="margin-bottom:0px;width: 90%;">
                                        <i class="fa fa-gift"></i>
                                        Discount            
                                    </button>
                                </div>
                             </div>
                             <div class="col-sm-6" >
                                 <div class="form-group" role="group">
                                <button type="button" class="btn btn-danger btn-lg btnlg" id="cart-return-to-order" style="margin-bottom:0px;width: 90%;"> <!-- btn-app  -->
                                    <i class="fa fa-remove"></i>
                                    Cancel          
                                </button>
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                <input type="hidden" name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                <input type="hidden" name="invfname" id="invfname" value="<?php echo $_SESSION['fname'] ?>">
                                <input type="hidden" name="a5print" id="a5print" value="<?php echo $company['A5Print'] ?>">
                                <input type="hidden" value="1" name="action" id="action">
                            </div>
                             </div>
                               <!--  <div class="form-group" >
                                        <label for="ismultiprice" class="control-label">
                                            <input  class="prd_icheck"  type="checkbox" name="disablePrint" id="disablePrint" value="1">
                                            Disable Print
                                        </label>
                                    </div> -->
                        <!-- <div class="form-group" >
                            <button type="button"  class="btn btn-warning btn-lg btnlg" id="savePrint" style="margin-bottom:0px;width: 90%;">
                                <i class="fa fa-print"></i>
                                Without Payment            
                            </button>
                        </div>
                             
                             
                            <div class="form-group" role="group">
                                <button data-target="#modelTotalDis" type="button"  data-toggle="modal" class="btn btn-success btn-lg btnlg" id="cart-discount-button" style="margin-bottom:0px;width: 90%;">
                                    <i class="fa fa-gift"></i>
                                    Discount			
                                </button>
                            </div>
                            <div class="form-group" role="group">
                                <button type="button" class="btn btn-danger btn-lg btnlg" id="cart-return-to-order" style="margin-bottom:0px;width: 90%;"> 
                                    <i class="fa fa-remove"></i>
                                    Cancel			
                                </button>
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                <input type="hidden" name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                <input type="hidden" name="invfname" id="invfname" value="<?php echo $_SESSION['fname'] ?>">
                                <input type="hidden" name="a5print" id="a5print" value="<?php echo $company['A5Print'] ?>">
                                <input type="hidden" value="1" name="action" id="action">
                            </div> -->
                             </form>
                             </div>
                        </div>
</div>
                    </div>
                    <!-- /.box-header -->
<!--                    <div class="box-body">
                        <table class="table" id="cart-item-table-header" >
                            <thead>
                                <tr class="active">
                                    <td width="50" class="text-left">#</td>
                                    <td width="50" class="text-left"></td>
                                    <td width="210" class="text-left">Items</td>
                                    <td width="130" class="text-right">Unit Price</td>
                                    <td width="145" class="text-right">Quantity</td>
                                    <td width="145" class="text-right">Free quantity</td>
                                    <td width="145" class="text-right">Discount</td>
                                    <td width="115" class="text-right">Total Price</td>
                                    <td width="50" class="text-right"></td>
                                </tr>
                            </thead>
                        </table>
                        <div class="direct-chat-messages nscroll" id="cart-table-body" style="padding: 0px; height: 193px;">
                            <table class="table table-hover table-striped" style="margin-bottom:0;">                
                                <tbody><tr id="cart-table-notice"><td colspan="4">Please add an item</td></tr></tbody>
                            </table>
                        </div>
                        <table class="table" id="cart-details">
                            <tfoot>
                                <tr class="active">
                                    <td width="230" class="text-left" style="font-size:15px;">No Of Items - <span id="itemCount">0</span></td>
                                    
                                    <td width="130" class="text-right"></td>
                                    <td width="130" class="text-right">
                                        Total:                    </td>
                                    <td width="110" class="text-right"><span id="cart-value">LKR 0.00 </span></td>
                                </tr>
                                <tr class="active">
                                    <td colspan="2" width="380" class="text-right cart-discount-notice-area" ><span id="errPrint" class="pull-left"></span></td>
                                    <td width="130" class="text-right">Discount</td>
                                    <td width="110" class="text-right"><span id="cart-discount">LKR 0.00 </span></td>
                                </tr>
                                <tr class="success">
                                    <td width="230" class="text-right">
                                         <div class="input-group pull-left">
                                        <label for="ismultiprice" class="control-label">
                                            <input  class="prd_icheck"  type="checkbox" name="disablePrint" id="disablePrint" value="1">
                                            Disable Print
                                        </label>
                                    </div>
                                    </td>
                                    <td width="130" class="text-right"></td>
                                    <td width="130" class="text-right"><strong>Net Payable</strong></td>
                                    <td width="110" class="text-right"><strong><span id="cart-topay">LKR 0.00 </span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                     /.box-body 
                    <div class="box-footer" id="cart-panel">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button"  class="btn btn-warning btn-lg" id="savePrint" style="margin-bottom:0px;">
                                    <i class="fa fa-money"></i>
                                    Print            
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button data-target="#modelPayment" type="button"  data-toggle="modal" class="btn btn-primary btn-lg" id="cart-pay-button" style="margin-bottom:0px;">
                                    <i class="fa fa-money"></i>
                                    Payment            
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button data-target="#modelTotalDis" type="button"  data-toggle="modal" class="btn btn-success btn-lg" id="cart-discount-button" style="margin-bottom:0px;">
                                    <i class="fa fa-gift"></i>
                                    Discount			
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-danger btn-lg" id="cart-return-to-order" style="margin-bottom:0px;">  btn-app  
                                    <i class="fa fa-remove"></i>
                                    Cancel			
                                </button>
                                <input type="hidden" name="location" id="location" value="<?php echo $_SESSION['location'] ?>">
                                <input type="hidden" name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                <input type="hidden" name="invfname" id="invfname" value="<?php echo $_SESSION['fname'] ?>">
                            </div>

                        </div>
                    </div>-->
                    <span id="lastInv" class="pull-left"> Last Invoice - </span>
                    <!-- /.box-footer--> 
                </div>

            </div>

        </div>
    </section>
    <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="cusModal">
                <!-- load data -->
            </div>
        </div>
    </div>

    <!--product modal-->
    <div class="modal fade bs-bill-modal-lg" id="modelBilling" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <!--<form role="form" id="addDep" data-parsley-validate>-->
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Add products</h4>
                        <span id="top"></span>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-6 col-sm-12">
                                    <label id="errProduct"></label>
                                    <div class="form-group">
                                        <label for="mLProCode" class="col-sm-4 control-label">Product Code</label>
                                        <div class="col-sm-6"><span id="mLProCode"></span><input type="hidden" required="required" disabled class="form-control input-lg" name="mProCode" id="mProCode" >
                                            <input type="hidden" required="required" disabled class="form-control" name="mWarrnty" id="mWarrnty" >
                                        </div> <br>
                                    </div>
                                    <div class="form-group">
                                        <label for="mProName" class="col-sm-4 control-label">Product Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" required="required" disabled class="form-control input-lg" name="mProName" id="mProName">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Selling Price</label>
                                        <div class="col-sm-6"><input type="number" onfocus="this.select();"  required="required" min="1" step="1" class="form-control input-lg"  name="mSellPrice" id="mSellPrice" placeholder="Enter selling price">
                                            <input type="hidden" required="required" class="form-control" name="mCostPrice" id="mCostPrice" ></div> <br>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Unit Or Case</label>
                                        <div class="col-sm-6">
                                            <select required="required" class="form-control input-lg" name="mUnit" id="mUnit">
                                                <option value="Unit">Unit</option>
                                                <option value="Case">Case</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Quantity</label>
                                        <div class='col-sm-6 '><input type='number' name='mQty' onfocus="this.select();"  id="mQty" min="1" value='1' class='form-control input-lg' aria-describedby='sizing-addon3'></div>
                                        <input type="hidden" required="required" class="form-control" name="mUpc" id="mUpc">
                                    </div>
                                    <div class="form-group" id="dv_FreeQty">
                                        <label class="col-sm-4 control-label">Free Quantity</label>
                                        <div class="col-sm-6"><input type="text" required="required" class="form-control input-lg" name="mFreeQty" id="mFreeQty" value="0" placeholder="Free Qty">
                                        <input type="hidden"  name="mIsFree" id="mIsFree" onfocus="this.select();"  value="0" ></div>
                                    </div>
                                    <div class="form-group"  id="dv_SN">
                                        <label class="col-sm-4 control-label">Serial Number</label>
                                        <div class="col-sm-6"><input type="text" required="required" class="form-control input-lg" name="mSerial" id="mSerial" placeholder="Serial Number">
                                            <input type="hidden" required="required" class="form-control input-lg" name="isSerial" id="isSerial" placeholder="Serial Number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Sale Ref</label>
                                        <div class="col-sm-6"><select name="mRef" id="mRef"  class="form-control input-lg" >
                                                <option value="0">Select a sale ref</option>
                                                <?php foreach ($salePerson as $sp) { ?>
                                                    <option value="<?php echo $sp->RepID; ?>"><?php echo $sp->RepName; ?></option>
<?php } ?>
                                            </select></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <h4 class="text-center">Apply Product Wise Discount <span class="discount_type">: <span class="label label-warning">Cash</span></span></h4>
                                        <div class="input-group">
                                            <span class="input-group-btn"><button class="btn btn-primary btn-lg percentage_discount " disType="1" val="1" type="button">Percentage</button></span>
                                            <input type="number" name="discount_value" id="proWiseDiscount" class="form-control input-lg" min="0" onfocus="this.select();"  value="0" step="5" placeholder="Define the amount or percentage here...">
                                            <span class="input-group-btn"><button class="btn btn-warning flat_discount btn-lg active" disType="1"  val="2" type="button">Cash</button></span>
                                        </div>
                                    </div>
                                    <div  class="form-group">
                                        <input class="prd_icheck" type="checkbox" name="isProVat"  id="isProVat" value="1"> VAT
                                    </div>
                                    <div  class="form-group">
                                        <input class="prd_icheck" type="checkbox" name="isProNbt" id="isProNbt" value='1'> NBT
                                        <input class="" type="hidden" name="proNbtRatio" id="proNbtRatio" value='1'>
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="addProduct" class="btn btn-primary btn-lg">Add Product</button>
                    </div>

                </div>
            <!--</form>-->
        </div>
    </div>

    <!--total discount-->
    <div class="modal fade bs-bill-modal-lg" id="modelTotalDis" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Total Items Discount</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h4 class="text-center">Apply Total Items Discount By <span class="discount_type">: <span class="label label-warning">Cash</span></span></h4>
                                        <div class="input-group">
                                            <span class="input-group-btn"><button class="btn btn-primary btn-lg percentage_discount " disType="2" val="1" type="button">Percentage</button></span>
                                            <input type="number" name="discount_value" id="totalAmountDiscount" class="form-control input-lg" min="0" value="0"  onfocus="this.select();" step="5"  placeholder="Define the amount or percentage here...">
                                            <span class="input-group-btn"><button class="btn btn-warning flat_discount btn-lg active" disType="2"  val="2" type="button">Cash</button></span>
                                        </div></div>
                                    <label id="errTotalDis"></label>
                                </div><div class="col-md-3"></div>
                            </form>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-lg pull-left" id="clearTotalDiscount" type="button">Remove Total Items Discount</button>
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="addDiscount" class="btn btn-success btn-lg">Add Discount</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--payment model-->
    <div class="modal fade bs-payment-modal-lg" id="modelPayment" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Payment Details <span id="errPayment"></span></h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-4">

                                    <!--<div class="form-group">-->
                                        <!--<h4 class="text-center">Payment Type : <span class="discount_type">: <span class="label label-primary">percentage</span></span></h4>-->
                                    <div class="input-group">
                                        <span class="input-group-addon label-success">Cash Amount</span>
                                        <input type="number" onfocus="this.select();" name="cash_amount" id="cash_amount" min='0' value="0"  step="50"  class="form-control input-lg" placeholder="cash amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card Amount</span>
                                        <input type="number" disabled name="card_amount" id="card_amount" min='0' value="0"  class="form-control input-lg" placeholder="card amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Cheque Amount</span>
                                        <input type="number" name="cheque_amount" id="cheque_amount" min='0' value="0"  class="form-control input-lg" placeholder="Cheque amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Credit Amount</span>
                                        <input type="number" onfocus="this.select();" name="credit_amount" id="credit_amount" min='0'  value="0"  step="50"  class="form-control input-lg" placeholder="credit amount">
                                    </div>
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Cash</td><td>:</td><td  id='mcash'  class='text-right'>0.00</td></tr>
                                            <tr><td>Card</td><td>:</td><td  id='mcard'  class='text-right'>0.00</td></tr>
                                            <tr><td>Cheque</td><td>:</td><td  id='mcheque'  class='text-right'>0.00</td></tr>
                                            <tr><td>Credit</td><td>:</td><td  id='mcredit'  class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table>
                                    <!--</div>-->
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">Card type</span>
                                        <select name="card_type" id="card_type" class="form-control input-lg">
                                            <option value="0">Select a type</option>
                                            <option value="1">Visa</option>
                                            <option value="2">Master</option>
                                            <option value="3">Amex</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Reference</span>
                                        <input type="text" name="card_ref" id="card_ref"   class="form-control input-lg" placeholder="Reference">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Amount</span>
                                        <input type="number" name="ccard_amount" id="ccard_amount" min='0'  step="50"  value="0" onfocus="this.select();"  class="form-control input-lg" placeholder="card amount">
                                        <span class="input-group-btn"><button class="btn btn-primary btn-lg" id='addCard' type="button">Add</button></span>
                                    </div>
                                    <h4>Card details</h4>
                                    <label id="errCard"></label>
                                    <table class="table table-hover" id='tblCard'>
                                        <thead>
                                            <tr><th>Type</th><th>Ref</th><th>Amount</th><th></th></tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr><td>Total</td><td>:</td><td  id='mtotal'  class='text-right'>0.00</td></tr>
                                            <tr><td>Discount</td><td>:</td><td  id='mdiscount'  class='text-right'>0.00</td></tr>
                                            <tr><td>VAT</td><td>:</td><td  id='mvat'  class='text-right'>0.00</td></tr>
                                            <tr><td>NBT</td><td>:</td><td  id='mnbt'  class='text-right'>0.00</td></tr>
                                            <tr><td>Net Payable</td><td>:</td><td  id='mnetpay'  class='text-right'>0.00</td></tr>
                                            <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div> 
                        <div class="row">
                            <div class="col-md-12"><div id='chequeData'><hr><h4>Cheque Details</h4>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank" class="control-label">Bank <span class="required">*</span></label>
                                    <select class="form-control"   name="bank" id="bank">
                                    <option value="">Select a Bank</option>
                                    <?php foreach($bank as $banks){?>
                                        <option value="<?php echo $banks->BankCode; ?>"><?php echo $banks->BankName; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeNo" class="control-label">Cheque No <span class="required">*</span></label>
                                    <input type="text" class="form-control"   name="chequeNo" id="chequeNo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeReciveDate" class="control-label">Cheque Received date <span class="required">*</span></label>
                                    <input type="text" class="form-control"   name="chequeReciveDate" id="chequeReciveDate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeDate" class="control-label">Date of Cheque<span class="required">*</span></label>
                                    <input type="text" class="form-control"   name="chequeDate" id="chequeDate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chequeReference" class="control-label">Cheque Reference<span class="required"></span></label>
                                    <textarea  class="form-control" name="chequeReference" id="chequeReference">

                                    </textarea>
                                </div>
                            </div>
                        </div></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <button type="button" id="saveInvoice" class="btn btn-success btn-lg">Confirm Payment</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!--invoice print-->
    <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content"><div class="modal-body" >
                        <div class="row"  id="printArea" align="center" style='margin:5px;'>
                             <?php $this->load->view('admin/_templates/company_header.php',true); ?>
                            <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:120px;">&nbsp;</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:200px;">&nbsp;</td>
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;">&nbsp;</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;">&nbsp;</td>
                                </tr>
                                <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:120px;vertical-align:top;padding-left: 5px;text-align: left;font-size: 10px" colspan="3" rowspan="4"><br><span id="lblCusName"></span><br><span id="lblAddress"></span></td>
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;">&nbsp;</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;">&nbsp;</td>
                                </tr> 
                                <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;">&nbsp;</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;">&nbsp;</td>
                                </tr>
                                <tr style="text-align:center;font-size:12px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;">&nbsp;</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;">&nbsp;</td>
                                </tr>
                                <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;">&nbsp;</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;">&nbsp;</td>
                                </tr>
                                <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:120px;">PAGE</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:200px;" id="lblPage">1</td>
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;text-align:left;">DATE</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;" id="lblInvDate">&nbsp;</td>
                                </tr>
                                <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:120px;">OUR REFERENCE</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:200px;" id="lblOurRef">&nbsp;</td>
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;text-align:left;">INVOICE NO</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;" id="lblInvNo">&nbsp;</td>
                                </tr>
                                <tr style="text-align:left;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
                                    <td style="width:120px;">CUSTOMER CODE</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:200px;" id="lblCusCode">&nbsp;</td>
                                    <td style="width:10px;">&nbsp;</td>
                                    <td style="width:120px;text-align:left;">YOUR REFERENCE</td>
                                    <td style="width:5px;">&nbsp;</td>
                                    <td style="width:250px;" id="lblYourRef">&nbsp;</td>
                                </tr>
                            </table>
                            <style>#tblData td{padding: 2px;}</style>
                            <table id="tblData"  style="border-collapse:collapse;width:700px;font-size:10px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
                                <thead>
                                    <tr style="text-align:center;border:#000 solid 1px;">
                                        <td style="text-align:center;border:#000 solid 1px;">ITEM CODE</td>
                                        <td style="text-align:center;border:#000 solid 1px;">PART NO.</td>
                                        <td style="text-align:center;border:#000 solid 1px;">PART NAME</td>
                                        <td style="text-align:center;border:#000 solid 1px;"> QTY</td>
                                        <td style="text-align:center;border:#000 solid 1px;">RATE</td>
                                        <td style="text-align:center;border:#000 solid 1px;">TOTAL AMOUNT</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;">Sub Total</td>
                                    <!--<td></td>-->
                                        <td style="text-align:right"  id="invTotal">0.00</td>
                                    </tr>
                                    <tr id="discountRow">
                                        <td colspan="5" style="text-align: right;"> Discount</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invTotalDis">0.00</td>
                                    </tr>
                                    <tr  id="nbtAmountRow">
                                        <td colspan="5"  style="text-align: right;">NBT</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invNbt">0.00</td>
                                    </tr>
                                    <tr  id="vatAmountRow">
                                        <td colspan="5"  style="text-align: right;">VAT</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invVat">0.00</td>
                                    </tr>
                                    <tr  id="netAmountRow">
                                        <td colspan="5"  style="text-align: right;">Total Amount</td>
                                        <!--<td></td>-->
                                        <td style="text-align:right"  id="invNet">0.00</td>
                                    </tr>
                                   <!--  <tr  id="cusPayRow">
                                        <td colspan="5"  style="text-align: right;">Customer Pay</td>
                                        <td style="text-align:right"  id="invCusPay">0.00</td>
                                    </tr>
                                    <tr  id="balanceRow">
                                        <td colspan="5" id="crdLabel" style="text-align: right;">Balance Amount</td>
                                        <td style="text-align:right"  id="invBalance">0.00</td>
                                    </tr> -->
                                </tfoot>
                            </table>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                        <!-- <button type="button" id="printInvoice" class="btn btn-primary btn-lg">Print</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<style>
    .shop-items:hover{
        background-color: #00ca6d;
        color: #fff;
    }
    
   #search_product_keyboard,#card_ref_keyboard {
        font-size: 25px;
        white-space: nowrap;
    overflow-x: auto;
background: rgba(43, 43, 43, 0.7);
width:100%;
    }
    
    #mSellPrice_keyboard,#mQty_keyboard,#proWiseDiscount_keyboard,#totalAmountDiscount_keyboard,#cash_amount_keyboard,#credit_amount_keyboard,#ccard_amount_keyboard {
        font-size: 25px;
        white-space: nowrap;
    overflow-x: auto;
/*background: rgba(43, 43, 43, 0.7);*/
/*width:100%;*/
    }
</style>
<script type="text/javascript">
$('#invDate,#chequeReciveDate,#chequeDate').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });
    $('#invDate').datepicker().datepicker("setDate", new Date());
    
    
	
// $('#search_product')
// 	.keyboard({ layout: 'qwerty',autoAccept : true,usePreview: false,
//     position: {
//         of: $(window), 
//         my: 'center bottom',
//         at: 'center bottom',
//         at2: 'center bottom' 
//     }})
// 	.autocomplete({
// 		source: "product/get_products"
// 	})
	
// 	.addAutocomplete({
// 		position : {
// 			of : $(window),       
// 			my : 'center center', 
// 			at : 'center center',  
// 			collision: 'flip'
// 		}
// 	}).addTyping();
                
</script>