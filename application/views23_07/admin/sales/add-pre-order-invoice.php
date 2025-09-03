<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">

        <style type="text/css">
            .icheckbox_square-blue, .iradio_square-blue{
                background-color: #fff;
            }
        </style>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success container-fluid">
                    <div class="row" style="background: #5fbfba;"><br>
                        <style>
                            .form-group {margin-bottom: 5px;}
                        </style>
                        <div class="col-md-4">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="customer" class="col-sm-4 control-label">Invoice No <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" value="<?php echo $inv; ?>"  name="grn_no" id="grn_no" placeholder="Auto Generate">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnDate" class="col-sm-4 control-label">Invoice Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" disabled class="form-control" required="required"  name="grnDate" id="grnDate" placeholder="">
                                        <input type="hidden" class="form-control" required="required"  name="location" id="invlocation" value="<?php echo $_SESSION['location'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">
                                        <input type="hidden" class="form-control" required="required"  name="maxSerial" id="maxSerial" >
                                        <input type="hidden" name="vatRate" id="vatRate" value="<?php echo $company['VAT']; ?>">
                                        <input type="hidden" name="nbtRate" id="nbtRate" value="<?php echo $company['NBT']; ?>">
                                        <input type="hidden" name="nbtRatioRate" id="nbtRatioRate" value="<?php echo $company['NBT_Ratio']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Price Level</label>
                                    <div class="col-sm-7">
                                        <select tabindex="7" class="form-control" id="priceLevel">
                                            <?php foreach ($plv as $pl) { ?>
                                                <option value="<?php echo $pl->PL_No; ?>" <?php if ($pl->PL_No == 1) {echo 'selected';}?>><?php echo $pl->PriceLevel; ?></option>
                                            <?php } ?></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">CO Number </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="po_number" class="form-control" id="po_number" placeholder="Customer Order" value="<?php echo $customerOder;?>">
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="additional" class="col-sm-4 control-label">Sales Person</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" required="required"  name="newsalesperson" id="newsalesperson" placeholder="sales person">
                                        <option value="">-Select a sales person-</option>
                                        <?php foreach ($salesperson as $trns) { ?>
                                            <option value="<?php echo $trns->RepID; ?>"
                                                    <?php echo ($trns->RepID == $selectedSalespersonID) ? 'selected' : ''; ?>>
                                                <?php echo $trns->RepName; ?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div> -->

                                <!-- <?php if (!$isEditMode) { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Routes </label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="route" id="route">
                                            <option value="0">-Select-</option>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if ($isEditMode) { ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Routes</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="route" id="route">
                                                <option value="0">-Select-</option>
                                                <?php foreach ($routes as $route) { ?>
                                                     <option value="<?php echo $route->id; ?>"
                                                            <?php echo (isset($selectedRoute) && $route->id == $selectedRoute) ? 'selected' : ''; ?>>
                                                        <?php echo $route->name;  ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?> -->

                                <div class="form-group">
                                    <!--                                    <label for="additional" class="col-sm-4 control-label">Insurance</label>-->
                                    <div class="col-sm-7">
                                        <input type="hidden" name="insCompany" id="insCompany">
                                        <!--                                        <select class="form-control" required="required"  name="insCompany" id="insCompany" >-->
                                        <!--                                        <option value="">-Select an insurance company-</option>-->
                                        <!--                                       --><?php //foreach ($vehicle_company as $trns) { ?>
                                        <!--                                <option value="--><?php //echo $trns->VComId; ?><!--" >--><?php //echo $trns->VComName; ?><!--</option>-->
                                        <!--                                --><?php //} ?>
                                        <!--                                        </select>-->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div  class="col-md-5">
                            <row class="form-horizontal" >
                                <div class="form-group">
                                    <label for="supplier" class="col-sm-4 control-label">Customer<span class="required">*</span></label>

                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <input type="text" tabindex="1" class="form-control" required="required"  name="customer" id="customer" placeholder="Customer" value="<?php echo $customer; ?>">

                                            <span class="input-group-btn">
                                            <button data-target="#customermodal"  id="addNewCustomer" class="btn btn-flat btn-primary pull-right" title="New Customer"><i class="fa fa-user-plus"></i></button>
                                          </span>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <span id="cusName1"></span><br>
                                        <span id="cusPhone"></span>
                                        <br>
                                        <span id="cusAddress"></span>
                                        <input type="hidden" tabindex="5" name="invoicenumber" id="invoicenumber" class="form-control" />
                                        <input type="hidden" tabindex="5" name="vididateCreditLimit" id="vididateCreditLimit" class="form-control" />
                                        <input type="hidden" tabindex="6"  min="0" step="200" name="additional" value="0" id="additional" class="form-control" />
                                        <input type="hidden" tabindex="5" name="discountLimit" id="discountLimit" class="form-control" />
                                    </div>
                                    <div class="col-sm-4">
                                        Credit Limit : <span id="creditLimit"></span><br>
                                        Outstanding : <span id="cusOutstand"></span> <br>
                                        Available Limit : <span id="availableCreditLimit"></span>
                                    </div>
                                    <div class="col-sm-4">
                                        Salesperson : <span id="newsalesperson"></span><br>
                                        Route : <span id="route"></span> <br>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <!--                                    <label for="invoicenumber" class="col-sm-4 control-label">Total Inv. VAT/NBT</label>-->
                                    <label for="invoicenumber" class="col-sm-4 control-label">Referral No</label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="8" class="form-control"  name="refferNo" id="refferNo"  placeholder="Referral No" value="">
                                        <input class="prd_icheck" type="hidden" name="isTotalVat"  id="isTotalVat" value='1'>
                                        <input class="prd_icheck" type="hidden" name="isTotalNbt" id="isTotalNbt" value='1'>
                                        <input class="" type="hidden" name="totalNbtRatio" id="totalNbtRatio" value='1'>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="col-sm-4 control-label">Invoice Type</label>
                                    <div class="col-sm-7">
                                        <select tabindex="7" class="form-control" id="invType">
                                            <option value="1">General Invoice</option>
                                            <option value="2">Tax Invoice</option>
                                            <option value="3">Credit Invoice</option>
                                        </select>
                                    </div>
                                </div>  -->
                                <!-- <div class="form-group">
                                    <div class="col-sm-4"><input type="text" tabindex="8" class="form-control" required="required"  name="shippingLabel" id="shippingLabel"  placeholder="Shipping" value="Shipping"></div>
                                    <div class="col-sm-7">
                                     <input type="number" step="50" tabindex="8" onfocus="this.select();"  class="form-control" required="required"  name="shipping" id="shipping" placeholder="Shipping charges" value="0">
                                     <input type="hidden" tabindex="1" class="form-control" required="required"  name="soNo" id="soNo" placeholder="Transport charges">
                                        <select style="display: none;" tabindex="3" disabled class="form-control" id="location">
                                            <?php foreach ($location as $loc) { ?>
                                        <option value="<?php echo $loc->location_id; ?>" <?php if ($loc->location_id == $_SESSION['location']) {echo 'selected';}?>><?php echo $loc->location; ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div> -->
                                <!--
                               <div class="form-group">
                                        <label class="col-sm-4 control-label">Price Level</label>
                                        <div class="col-sm-6">
                                            <select tabindex="7" class="form-control" id="priceLevel">
                                             <?php foreach ($plv as $pl) { ?>
                                            <option value="<?php echo $pl->PL_No; ?>" <?php if ($pl->PL_No == 1) {echo 'selected';}?>><?php echo $pl->PriceLevel; ?></option>
                                            <?php } ?></select>
                                        </div>
                                    </div>
                                    -->
                            </row>
                            <!--                            </form>-->
                        </div>
                        <div  class="col-md-3">
                            <div class="row">
                                <div  class="col-md-9">
                                    <div class="input-group">
                                        <!--                                        <select class="form-control" required="required"  name="regNo" id="regNo" placeholder="Vehicle Number">-->
                                        <!--                                            <option>-Select a vehicle-</option>-->
                                        <!--                                        </select>-->
                                        <!-- <input type="text" tabindex="1" class="form-control" required="required"  name="regNo" id="regNo" placeholder="Vehicle Number" value=""> -->
                                        <!--                                          <span class="input-group-btn">-->
                                        <!--                                            <button data-target="#vehiclemodal"  id="addNewVehicle" class="btn btn-flat btn-success pull-right" title="New Vehicle"><i class="fa fa-car"></i></button>-->
                                        <!--                                          </span>-->
                                    </div><!-- /input-group -->
                                    <div class="form-group">

                                    </div>
                                    <!--                                    <table style="font-size: 9px;">-->
                                    <!--                                    <tr>-->
                                    <!--                                        <td>Register no</td>-->
                                    <!--                                        <td>:</td>-->
                                    <!--                                        <td class="text-right"><span id="registerNo"></span></td>-->
                                    <!--                                    </tr>-->
                                    <!--                                    <tr>-->
                                    <!--                                        <td>Model</td>-->
                                    <!--                                        <td>:</td>-->
                                    <!--                                        <td class="text-right"><span id="modelno"></span></td>-->
                                    <!--                                    </tr>-->
                                    <!--                                    <tr>-->
                                    <!--                                        <td>VIN Number</td>-->
                                    <!--                                        <td>:</td>-->
                                    <!--                                        <td class="text-right"><span id="vinno"></span></td>-->
                                    <!--                                    </tr>-->
                                    <!--                                </table>-->
                                </div>
                                <div  class="col-md-3">
                                </div>

                            </div>
                            <div class="row">
                                <table style="font-size: 18px;text-align:right;">
                                    <tr>
                                        <td>Total  Amount</td>
                                        <td>:</td>
                                        <td class="text-right"><span id="totalgrn">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount</td>
                                        <td>:</td>
                                        <td class="text-right"><span id="grndiscount">0.00</span></td>
                                    </tr>
                                    <!--                                    <tr>-->
                                    <!--                                        <td>VAT Amount</td>-->
                                    <!--                                        <td>:</td>-->
                                    <!--                                        <td class="text-right"><span id="totalVat">0.00</span></td>-->
                                    <!--                                    </tr>-->
                                    <!--                                    <tr>-->
                                    <!--                                        <td>NBT Amount</td>-->
                                    <!--                                        <td>:</td>-->
                                    <!--                                        <td class="text-right"><span id="totalNbt">0.00</span></td>-->
                                    <!--                                    </tr>-->
                                    <tr>
                                        <td>Shipping</td>
                                        <td>:</td>
                                        <td class="text-right"><span id="shippingcharges">0.00</span></td>
                                    </tr>
                                    <tr style="color: green;">
                                        <td><b>Net Amount</b></td>
                                        <td>:</td>
                                        <td class="text-right"><span  id="netgrnamount">0.00</span></td>
                                    </tr>
                                </table>

                            </div>
                            <!-- <h4><b>Invoice Details</b></h4> -->

                        </div><span id="lastInvoice" class="pull-right"></span>
                    </div>
                    <div class="row">
                        <hr>
                        <div class="col-md-4">
                            <div class="box-body">
                                <form class="form-horizontal" id="formProduct">
                                    <span id="lbl_batch_no"></span>
                                    <label id="errProduct"></label>
                                    <div class="form-group">
                                        <div>
                                            <label for="itemCode" class="col-sm-4 control-label"><span class="required"></span></label>
                                            <div class="col-sm-8"><span id="productName" style="font-size: 10px;"></span>&nbsp;
                                                <span id="productStock" style="font-size: 10px;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <span id="productName"></span> -->
                                    <!-- <div class="form-group">
                                        <label class="col-sm-4 control-label">Supplier Item</label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" tabindex="8" class="prd_icheck" name="suppliercheck" value="1"/>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <div>
                                            <label for="itemCode" class="col-sm-4 control-label"><span class="required"></span></label>
                                            <div class="col-sm-8"><span id="productName" style="font-size: 10px;"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
<!--                                        <div>-->
<!--                                            <input class="prd_icheck" type="checkbox" name="isProNbt" id="isProNbt" value="1" checked> Is Return-->
<!--                                            <input type="hidden" name="IsReturn" id="IsReturn" value="1">-->
<!--                                        </div>-->



                                        <div id="lbl_refCode">


                                            <label for="itemCode" class="col-sm-4 control-label">Product <span class="required"></span></label>
                                            <div class="col-sm-8 input-group">
                                                <!-- <span id="productName"></span> -->
                                                <input type="text" tabindex="9" name="itemCode" id="itemCode" class="form-control" onfocus="this.select();" >
                                                <!--                                                <select class="form-control"  name="itemCode" id="itemCode">
                                                                                                </select>-->

                                                <span class="input-group-btn">
                                                    <button class="btn btn-warning" id="addpro"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="lotPriceLable" >
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Loan Type</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" disabled id="loanType">
                                                    <!--<option value="">-Select-</option>-->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Loan Amount</label>
                                            <div class="col-sm-6">
                                                <input type="number" step="10000" id="lotPrice" value="0" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="productLable" >
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Unit Or Case</label>
                                            <div class="col-sm-4">
                                                <select required="required" tabindex="9" class="form-control" name="mUnit" id="mUnit">
                                                    <option value="UNIT">Unit</option>
                                                    <option value="CASE">Case</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4"><span id="proStock"></span></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product" class="col-sm-4 control-label">Qty <span class="required">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="number" tabindex="10"  min="0" step="1" class="form-control" required="required"  name="qty" id="qty" placeholder="Enter Qty"  value="0" onfocus="this.select();" >
                                            </div>
                                            <div class="col-sm-2"><span id="upm"></span></div>
                                            <!-- <input class="prd_icheck" type="checkbox" name="isProVat"  id="isProVat" value="1"> VAT -->
                                        </div>

<!--                                        <div class="form-group">-->
<!--                                            <label for="product" class="col-sm-4 control-label">Return Qty </label>-->
<!--                                            <div class="col-sm-4">-->
<!--                                                <input type="number" tabindex="10"  min="0" step="1" class="form-control" required="required"  name="returnqty" id="returnqty" placeholder="Enter Return Qty"  value="0" onfocus="this.select();" >-->
<!--                                            </div>-->
<!--                                            <div class="col-sm-2"><span id="upm"></span></div>-->
                                            <!-- <input class="prd_icheck" type="checkbox" name="isProVat"  id="isProVat" value="1"> VAT -->
<!--                                        </div>-->

<!--                                        <div class="form-group">-->
<!--                                            <label class="col-sm-4 control-label">Return Type</label>-->
<!--                                            <div class="col-sm-4">-->
<!--                                                <select required="required" tabindex="9" class="form-control" name="returntype" id="returntype">-->
<!--                                                    <option value="UNIT">Damage</option>-->
<!--                                                    <option value="CASE">Expired</option>-->
<!--                                                </select>-->
<!--                                            </div>-->
<!--                                            <div class="col-sm-4"><span id="proStock"></span></div>-->
<!--                                        </div>-->
                                        <div class="form-group" id="dv_FreeQty">
                                            <label for="product" class="col-sm-4 control-label">Free Qty <span class="required"></span></label>
                                            <div class="col-sm-4">
                                                <input type="number" tabindex="11"  min="0" step="1" class="form-control" required="required"  name="freeqty" id="freeqty" placeholder="Enter Qty"  value="0" onfocus="this.select();" >
                                            </div>
                                            <div class="col-sm-2"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product" class="col-sm-4 control-label">
                                                <!-- Unit Cost -->
                                                <span class="required"></span></label>
                                            <div class="col-sm-4">
                                                <input type="hidden" tabindex="12"  min="0" step="1" class="form-control" required="required"  name="unitcost" id="unitcost" placeholder="Enter Qty"  value="0" onfocus="this.select();" >
                                            </div>
                                            <div class="col-sm-2"></div>
                                            <!-- <input class="prd_icheck" type="checkbox" name="isProNbt" id="isProNbt" value='1'> NBT -->
                                            <input class="" type="hidden" name="proNbtRatio" id="proNbtRatio" value='1'>
                                        </div>
                                        <div class="form-group">
                                            <label for="sellingPrice" class="col-sm-4 control-label">Selling Price <span class="required">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="number"  tabindex="13"  min="0" step="1" class="form-control" required="required"  name="sellingPrice" id="sellingPrice" placeholder="Enter Selling Price" onfocus="this.select();" >

                                                <input type="hidden" disabled class="form-control" required="required"  name="prdName" id="prdName" placeholder="Enter product Code">
                                                <input type="hidden" class="form-control" required="required"  name="batchCode" id="batchCode">
                                                <input type="hidden" class="form-control" required="required"  name="upc" id="upc">
                                                <input type="hidden" class="form-control" required="required"  name="isSerial" id="isSerial">
                                                <input type="hidden" class="form-control" required="required"  name="orgSellPrice" id="orgSellPrice">
                                            </div>
                                            <!-- <div class="col-sm-1"><input class="prd_icheck" type="checkbox" name="isZero" id="isZero" value='1'></div> -->
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label for="sellingPrice" class="col-sm-4 control-label">VAT Selling Price <span class="required"></span></label>
                                            <div class="col-sm-5">

                                                <input type="text" class="form-control" required="required"  name="proVatPrice" id="proVatPrice" >
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                        <div class="form-group" id="dv_SN">
                                            <label for="product" class="col-sm-4 control-label">Serial No <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" tabindex="14" class="form-control" required="required"  name="serialNo" id="serialNo" placeholder="Enter Serial No"  value="" onfocus="this.select();" >
                                                <input type="hidden" tabindex="14" class="form-control" required="required"  name="serialQty" id="serialQty"  value="0">
                                                <input type="hidden" tabindex="14" class="form-control" name="serialNoCheck" id="serialNoCheck">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="salesperson" id="salesperson" value="0">
                                            <!--                                    <label for="supplier" class="col-sm-4 control-label">Sales Person<span class="required">*</span></label>-->
                                            <!--                                    <div class="col-sm-7">-->
                                            <!--                                        <select class="form-control" tabindex="14" required="required"  name="salesperson" id="salesperson" placeholder="sales person">-->
                                            <!--                                        <option value="">-Select a sales person-</option>-->
                                            <!--                                       --><?php //foreach ($salesperson as $trns) { ?>
                                            <!--                                <option value="--><?php //echo $trns->RepID; ?><!--" >--><?php //echo $trns->RepName; ?><!--</option>-->
                                            <!--                                --><?php //} ?>
                                            <!--                                        </select>-->
                                            <!--                                    </div>-->
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="additional" class="col-sm-4 control-label">Warranty Period</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" required="required"  name="warrantytype" id="warrantytype" placeholder="">
                                                    <option value="">-Select a Warranty Period-</option>
                                                    <?php foreach ($warrantytype as $trns) { ?>
                                                        <option value="<?php echo $trns->id; ?>" ><?php echo $trns->type; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="product" class="col-sm-7 control-label">Product Wise Discount<span class="required">*</span></label>
                                            <div class="col-sm-3"><input tabindex="15" type="radio" checked required="required" class="prd_icheck"  name="discount_type" id="productWise" value="1"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product" class="col-sm-7 control-label">Total Item Wise Discount<span class="required">*</span></label>
                                            <div class="col-sm-3"><input tabindex="15"  type="radio" required="required" class="prd_icheck"  name="discount_type" id="totalItemWise" value="2"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="buyAmount" class="col-sm-4 control-label">Discount %<span class="required"></span></label>
                                            <div class="col-sm-5 input-group">
                                                <span class="input-group-addon"><input tabindex="16"  type="radio" class="prd_icheck" name="discount" checked value="1"></span>
                                                <input type="number" min="0"  tabindex="16"  step="5" pattern="[0-9]*" class="form-control" required="required"  name="disPercent" id="disPercent" placeholder="Enter Discount Percentage" value="0" onfocus="this.select();" >
                                            </div>
                                            <div class="col-sm-7">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="totalNet" class="col-sm-4 control-label">Dis. Amount <span class="required"></span></label>
                                            <div class="col-sm-5 input-group">
                                                <span class="input-group-addon"><input tabindex="17"  type="radio" class="prd_icheck" name="discount" value="2"></span>
                                                <input type="number" tabindex="17"  min="0" step="50" pattern="[0-9]*" class="form-control" required="required"  name="disAmount" id="disAmount" placeholder="Enter discount amount" value="0">
                                                <input type="hidden" min="0" step="50" pattern="[0-9]*" class="form-control" required="required"  name="totalWithOutDiscount" id="totalWithOutDiscount" placeholder="Enter sold amount" value="0" onfocus="this.select();" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="rank" class="col-sm-4 control-label">&nbsp;</label>
                                        <button tabindex="18"  type="button" id="addItem" class="btn btn-primary ">Add Item</button>
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-center"><b>Invoice Item List</b></h5>

                            <div class="table-responsives">
                                <table id="tbl_item" class="table table-bordered table-striped table-responsives">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Product</th>
                                        <th>Unit/case</th>
                                        <th>Quantity</th>
                                        <th>Free Qty</th>
                                        <th>Price</th>
                                        <th>Discount (%)</th>
                                        <th>Total Amount</th>
                                        <th>Return type</th>
                                        <th>Return Qty</th>
                                        <!-- <th>warranty</th> -->
                                        <!--<th>Sale person</th>-->
                                        <th>##</th>
                                        <th>##</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                                <div  class="form-group">
                                    <label> Remarks</label>
                                    <textarea class="form-control" name="remark" id="remark" ></textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <span id="errData"></span>
                                <!--  &nbsp;<input  tabindex="20"  type="hidden" name="dwnFile" id="dwnFile" value="<?php echo base_url().'admin/grn/barcode.txt'?>">&nbsp;
                                <a class="btn btn-warning"  tabindex="20"  id="dwnLink" href="<?php echo base_url("admin/grn/downloadBarCode")?>">Download Barcode</a>&nbsp; -->
                                <button data-target="#modelPayment" type="button"  data-toggle="modal" class="btn btn-primary" id="cart-pay-button">
                                    <i class="fa fa-money"></i>
                                    Save
                                </button>&nbsp;

                                <!-- <button id="loadBarCode" class="btn btn-info">Barcode Generate</button>&nbsp; -->
                                <!--    <button  tabindex="19" id="saveItems" class="btn btn-success">Save</button>&nbsp;--><button id="btnPrint" link="#" class="btn btn-primary">Print</button>&nbsp;
                                <button  tabindex="21" id="resetItems" class="btn btn-danger">Reset</button>&nbsp;
                                <input type="hidden" name="action" id="action" value="<?php echo $action; ?>">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- customer modal -->
    <div id="customermodal" class="modal fade bs-addcustomer-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" style="width: 95%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>
    <!-- customer modal -->
    <div id="vehiclemodal" class="modal fade bs-addcustomer-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" style="width: 95%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>
    <!--invoice print-->
    <div class="modal fade bs-print-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"><div class="modal-body" >
                    <?php //invoice print
                    $this->load->view('admin/sales/view-sales-pre-orders.php',true); ?>
                </div></div>
        </div>
    </div>
    <!--payment model-->
    <div class="modal fade bs-addpayment-modal-lg" id="modelPayment" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <form role="form" id="addDep" data-parsley-validate method="post" action="#">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
                        <h4 class="modal-title" id="myModalLabel2">Payment Details<span id="errPayment"></span></h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="col-md-4">
                                    <b><span id="casAmount" ></span></b>

                                    <!--<div class="form-group">-->
                                    <!--<h4 class="text-center">Payment Type : <span class="discount_type">: <span class="label label-primary">percentage</span></span></h4>-->
                                    <div class="input-group">
                                        <span class="input-group-addon label-success">Cash Amount</span>
                                        <input type="number" name="cash_amount" id="cash_amount" min='0' value="0"  step="50"  class="form-control" placeholder="cash amount" onfocus="this.select();" >
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card Amount</span>
                                        <input type="number" disabled name="card_amount" id="card_amount" min='0' value="0"  class="form-control" placeholder="card amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Return Amount</span>
                                        <input type="number" disabled name="return_amount" id="return_amount" min='0' value="0"  class="form-control" placeholder="Return Amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Advance Amount</span>
                                        <input type="number" disabled name="advance_amount" id="advance_amount" min='0' value="0"  class="form-control" placeholder="Advance Amount">
                                        <input type="hidden"  name="before_advance_amount" id="before_advance_amount" value="0" class="form-control">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Bank Amount</span>
                                        <input type="number" name="bank_amount" id="bank_amount" min='0' value="0"  class="form-control" placeholder="Bank Amount">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">Cheque Amount</span>
                                        <input type="number" name="cheque_amount" id="cheque_amount" min='0' value="0"  class="form-control" placeholder="cheque amount" onfocus="this.select();" >
                                    </div><br>
                                    <!-- <div class="input-group">
                                        <span class="input-group-addon">Credit Amount</span>
                                        <input type="number" name="credit_amount" id="credit_amount" min='0'  value="0"  step="50"  class="form-control" placeholder="credit amount">
                                    </div> -->
                                    <div class="input-group" id="creditSection">
                                        <span class="input-group-addon">Credit Amount</span>
                                        <input type="number" name="credit_amount" id="credit_amount" min='0'  value="0"  step="50"  class="form-control" placeholder="credit amount" onfocus="this.select();" >
                                        <div class="input-group-btn">
                                            <button class="btn btn-warning" id="addCredit"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr><td>Cash</td><td>:</td><td  id='mcash'  class='text-right'>0.00</td></tr>
                                        <tr><td>Card</td><td>:</td><td  id='mcard'  class='text-right'>0.00</td></tr>
                                        <tr><td>Advance</td><td>:</td><td  id='madvance'  class='text-right'>0.00</td></tr>
                                        <tr><td>Return</td><td>:</td><td  id='mareturn'  class='text-right'>0.00</td></tr>
                                        <tr><td>Bank</td><td>:</td><td  id='mbank'  class='text-right'>0.00</td></tr>
                                        <tr><td>Cheque</td><td>:</td><td  id='mcheque'  class='text-right'>0.00</td></tr>
                                        <tr><td>Credit</td><td>:</td><td  id='mcredit'  class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table>
                                    <!--</div>-->
                                </div>
                                <div class="col-md-4">
                                    <b><span id="advanceAmountTotal" ></span></b>
                                    <div class="form-group">
                                        <span class="label">Advance Payment</span>
                                        <input type="text" name="advance_payment_no" id="advance_payment_no"   class="form-control" placeholder="Advace Payment No">
                                    </div>
                                    <div class="form-group" style="display:;">
                                        <span class="label">Return Payment</span>
                                        <input type="text" name="return_payment_no" id="return_payment_no"   class="form-control" placeholder="Return Payment No">
                                    </div><hr>
                                    <div class="input-group">
                                        <span class="input-group-addon">Card type</span>
                                        <select name="card_type" id="card_type" class="form-control">
                                            <option value="0">Select a type</option>
                                            <option value="1">Visa</option>
                                            <option value="2">Master</option>
                                            <option value="3">Amex</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Reference</span>
                                        <input type="text" name="card_ref" id="card_ref"   class="form-control" placeholder="Reference">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Amount</span>
                                        <input type="number" name="ccard_amount" id="ccard_amount" min='0'  step="50"  value="0"  class="form-control" placeholder="card amount">
                                        <span class="input-group-btn"><button class="btn btn-primary" id='addCard' type="button">Add</button></span>
                                    </div>
                                    <h4>Card details</h4>
                                    <label id="errCard"></label>
                                    <table class="table table-hover" id='tblCard'>
                                        <thead>
                                        <tr><th>Type</th><th>Ref</th><th>Amount</th><th></th></tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div id='bankData'><hr>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="bank" class="control-label">Bank Account<span class="required">*</span></label>
                                                <select class="form-control" required="required"  name="bank_acc" id="bank_acc">
                                                    <option value="">Select a Bank Account</option>
                                                    <?php foreach($bank_acc as $banks){?>
                                                        <option value="<?php echo $banks->acc_id; ?>"><?php echo $banks->acc_name." / ".$banks->acc_no." - ".$banks->BankName; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr><td>Total</td><td>:</td><td  id='mtotal'  class='text-right'>0.00</td></tr>
                                        <tr><td>VAT</td><td>:</td><td  id='mvat'  class='text-right'>0.00</td></tr>
                                        <tr><td>NBT</td><td>:</td><td  id='mnbt'  class='text-right'>0.00</td></tr>
                                        <tr><td>Discount</td><td>:</td><td  id='mdiscount'  class='text-right'>0.00</td></tr>
                                        <tr><td id="">Shipping</td><td>:</td><td  id='mshipping'  class='text-right'>0.00</td></tr>
                                        <tr><td>Net Payable</td><td>:</td><td  id='mnetpay'  class='text-right'>0.00</td></tr>
                                        <tr><td id='changeLable'>Change/Refund</td><td>:</td><td id='mchange' class='text-right'>0.00</td></tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <input type="hidden" name="mchange1" id="mchange1">
                                        <div class="col-md-11">
                                            <div class="input-group">
                                                <span class="input-group-addon">Comission</span>
                                                <input type="text" name="com_amount" id="com_amount"  class="form-control" placeholder="Commission Amount" onfocus="this.select();" >
                                            </div>  <br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Pay to</span>
                                                <input type="text" name="compayto" id="compayto"  class="form-control" placeholder="Commission Pay to" onfocus="this.select();" >
                                                <input type="hidden" name="compaytoid" id="compaytoid"  class="form-control" placeholder="Commission Pay to" onfocus="this.select();" >
                                            </div><br>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="input-group">If item receiver different from customer</div>
                                            <div class="input-group">
                                                <span class="input-group-addon">Name</span>
                                                <input type="text" name="receiver_name" id="receiver_name"  class="form-control" placeholder="Receiver Name" onfocus="this.select();" >
                                            </div>  <br>
                                            <div class="input-group">
                                                <span class="input-group-addon">NIC</span>
                                                <input type="text" name="receiver_nic" id="receiver_nic"  class="form-control" placeholder="Receiver Nic" onfocus="this.select();" minlength="10" maxlength="12" >
                                            </div><br>

                                        </div>
                                    </div>
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
                        <button type="button" id="saveItems" class="btn btn-success btn-lg">Confirm Payment</button>
                    </div>

                </div>
            </form>
        </div>
    </div>


</div>
<script>


    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });
    $("#supplier").select2({
        minimumInputLength: 1
    });



    // $('#newsalesperson').on('change', function() {
    //     var salespersonID = $(this).val();
    //     if (salespersonID != "0") {

    //         $.ajax({
    //             url: "<?php echo base_url(); ?>" + "admin/customer/findemploeeroute",
    //             method: 'POST',
    //             data: { salespersonID: salespersonID },
    //             dataType: 'json',
    //             success: function(response) {

    //                 $('#route').empty();
    //                 $('#route').append('<option value="0">-Select-</option>');

    //                 $.each(response, function(index, routeID) {
    //                 console.log(routeID);
    //                 $('#route').append('<option value="'+ routeID.route_id +'">'+ routeID.route_name +'</option>');
    //             });
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error fetching routes:', error);
    //             }
    //         });
    //     } else {
    //         $('#route').empty();
    //         $('#route').append('<option value="0">-Select-</option>');
    //     }
    // });





    // $('#route').on('change', function() {
    //     var routeID = $(this).val();
    //     if (routeID != "0") {

    //         $.ajax({
    //             url: "<?php echo base_url(); ?>" + "admin/sales/findroutecustomer",
    //             method: 'POST',
    //             data: { routeID: routeID },
    //             dataType: 'json',
    //             success: function(response) {

    //                 $('#customer').empty();
    //                 $('#customer').append('<option value="0">-Select-</option>');

    //                 $.each(response, function(index, customers) {
    //                 console.log(customers);
    //                 $('#customer').append('<option value="'+ customers.CusCode +'">'+ customers.CusName +'</option>');
    //             });
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error fetching customer:', error);
    //             }
    //         });
    //     } else {
    //         $('#customer').empty();
    //         $('#customer').append('<option value="0">-Select-</option>');
    //     }
    // });


        var baseUrl = "<?= base_url(); ?>";
        var customerCode = "C123"; // test customer code

        $.ajax({
        type: "POST",
        url: baseUrl + "admin/Payment/getCustomersDataById",
        data: { cusCode: customerCode },
        success: function(response) {
        console.log("Success:", response);
    },
        error: function(xhr) {
        console.error("404 Error", xhr.responseText);
    }
    });

    $.ajax({
        url: "admin/Salesinvoice/loadreturnproductjson",
        data: { /* your data */ },
        success: function (res) {
            // your existing product loading code...


            $("#isProNbt").prop("checked", true);
            $("#IsReturn").val("1");
        }
    });




</script>

<script type="text/javascript">
    //    $('#customer').select2({
    //         placeholder: "Select a customer",
    //         allowClear: true,
    //         minimumInputLength:1,
    //         width: '100%'
    //    });
</script>
<!-- <style type="text/css">
    ul.ui-autocomplete {
    z-index: 1100;
} -->
</style>