<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <h4>Edit</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="productCode" class="control-label">Product Code <span class="required">*</span></label>
                            <input type="text" class="form-control" required="required"  name="productCode" id="productCode" value="<?php echo $product->ProductCode; ?>" readonly placeholder="Auto Generate" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product" class="control-label">Part No <span class="required">*</span></label>
                            <input type="text" class="form-control" value="<?php echo $product->Cus_PrdCode; ?>" required="required"  name="part_no" id="part_no" placeholder="Enter Part No">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="product" class="control-label">Mercedes Part No <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $product->OrgPartNo; ?>"  name="orgpart_no" id="orgpart_no" placeholder="Enter Mercedes Part No">
                </div>
                <div class="form-group">
                    <label for="product" class="control-label">Name <span class="required">*</span></label>
                    <input type="text" class="form-control" required="required" value="<?php echo $product->Prd_Description ?>"  name="productname" id="product" placeholder="Enter product name">
                </div>
                <div class="form-group">
                    <label for="remark" class="control-label">Appear name</label>
                    <input class="form-control" name="appearname"  id="appearname" value="<?php echo $product->Prd_AppearName ?>" placeholder="Enter appear name"/>
                </div>
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="productCode" class="control-label">Product Brand <span class="required">*</span></label>
                            <select class="form-control"  required="required" name="brand" id="brand">
                                <option value="0">-Select a brand-</option>
                                <?php foreach ($brand AS $dep) { ?>
                                <option <?php echo ($dep->BrandID == $product->Prd_Brand) ? 'SELECTED' : '' ?> value="<?php echo $dep->BrandID ?>"><?php echo $dep->BrandName ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product" class="control-label">Product Quality <span class="required">*</span></label>
                            <select class="form-control"  required="required" name="quality" id="quality">
                                <option value="0">-Select a quality-</option>
                                <?php foreach ($quality AS $dep) { ?>
                                <option <?php echo ($dep->QualityID == $product->Prd_Quality) ? 'SELECTED' : '' ?> value="<?php echo $dep->QualityID ?>"><?php echo $dep->QualityName ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div> -->
                <div class="productmaparea">
                    <h5 class="pull-right">Product mapping</h5><br/>
                    <div class="form-group">
                        <span id="errTop"></span>
                        <label for="cateogry" class="control-label">Department <span class="required">*</span></label>
                        <div class="input-group">
                            <select class="form-control"  required="required" name="department" id="department">
                                <option value="0">-Select a department-</option>
                                <?php foreach ($alldepartment AS $dep) { ?>
                                    <option <?php echo ($dep->DepCode == $product->DepCode) ? 'SELECTED' : '' ?> value="<?php echo $dep->DepCode ?>"><?php echo $dep->Description ?></option>
                                <?php } ?>
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-warning" id="addDep"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-primary" id="editDep"><i class="fa fa-pencil-square-o"></i></button>
                                <button class="btn btn-danger" id="delDep"><i class="fa fa-close"></i></button>
                            </span>
                        </div>
                        <div class="input-group" id="panel_dep1">
                            <input type="text" class="form-control pull-right" name="dep1" id="dep1">
                            <span class="input-group-btn"><button class="btn btn-primary" id="saveDep1">Add</button></span>
                        </div>
                        <div class="input-group" id="edpanel_dep1">
                            <input type="text" class="form-control pull-right" name="edep1" id="edep1">
                            <span class="input-group-btn"><button class="btn btn-primary" id="editDep1">Update</button></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sub_category" class="control-label">Sub Department <span class="required">*</span></label>
                        <div class="input-group"><select  class="form-control" name="sub_department"  required="required" id="sub_department">
                                <option value="0">-Select a sub department-</option>
                                <?php foreach ($allsubdepartment AS $subdep) { ?>
                                    <option <?php echo ($subdep->SubDepCode == $product->SubDepCode) ? 'SELECTED' : '' ?> value="<?php echo $subdep->SubDepCode ?>"><?php echo $subdep->Description ?></option>
                                <?php } ?>
                            </select>
                            <div class="input-group-btn">
                                <button class="btn btn-warning" id="addSubDep"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-primary" id="editSubDep"><i class="fa fa-pencil-square-o"></i></button>
                                <button class="btn btn-danger" id="delSubDep"><i class="fa fa-close"></i></button>
                            </div>
                        </div>
                        <div class="input-group" id="panel_dep2">
                            <input type="text" class="form-control pull-right" name="dep2" id="dep2">
                            <span class="input-group-btn"><button class="btn btn-primary" id="saveDep2">Add</button></span>
                        </div>
                        <div class="input-group" id="edpanel_dep2">
                            <input type="text" class="form-control pull-right" name="edep2" id="edep2">
                            <span class="input-group-btn"><button class="btn btn-primary" id="editDep2">Update</button></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="control-label">Category  <span class="required">*</span></label>
                        <div class="input-group"><select class="form-control" name="category" id="category">
                                <option value="0">-Select a Category-</option>
                                <?php foreach ($allcatogery AS $cat) { ?>
                                    <option <?php echo ($cat->CategoryCode == $product->CategoryCode) ? 'SELECTED' : '' ?> value="<?php echo $cat->CategoryCode ?>"><?php echo $cat->Description ?></option>
                                <?php } ?>
                            </select>
                            <div class="input-group-btn">
                                <button class="btn btn-warning"  id="addCat"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-primary" id="editCat"><i class="fa fa-pencil-square-o"></i></button>
                                <button class="btn btn-danger" id="delCat"><i class="fa fa-close"></i></button>
                            </div>
                        </div>
                        <div class="input-group" id="panel_dep3">
                            <input type="text" class="form-control pull-right" name="dep3" id="dep3">
                            <span class="input-group-btn"><button class="btn btn-primary" id="saveDep3">Add</button></span>
                        </div>
                        <div class="input-group" id="edpanel_dep3">
                            <input type="text" class="form-control pull-right" name="edep3" id="edep3">
                            <span class="input-group-btn"><button class="btn btn-primary" id="editDep3">Update</button></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subcategory" class="control-label">Sub Category  <span class="required">*</span></label>
                        <div class="input-group"><select class="form-control" name="sub_category" id="sub_category">
                                <option value="0">-Select a sub Category-</option>
                                <?php foreach ($allsubcategory AS $subcat) { ?>
                                    <option <?php echo ($subcat->SubCategoryCode == $product->SubCategoryCode) ? 'SELECTED' : '' ?> value="<?php echo $subcat->SubCategoryCode ?>"><?php echo $subcat->Description ?>
                                        
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="input-group-btn">
                                <button class="btn btn-warning"  id="addSubCat"> <i class="fa fa-plus"></i></button>
                                <button class="btn btn-primary" id="editSubCat"><i class="fa fa-pencil-square-o"></i></button>
                                <button class="btn btn-danger" id="delSubCat"><i class="fa fa-close"></i></button>
                            </div>
                        </div>
                        <div class="input-group" id="panel_dep4">
                            <input type="text" class="form-control pull-right" name="dep4" id="dep4">
                            <span class="input-group-btn"><button class="btn btn-primary" id="saveDep4">Add</button></span>
                        </div>
                        <div class="input-group" id="edpanel_dep4">
                            <input type="text" class="form-control pull-right" name="edep4" id="edep4">
                            <span class="input-group-btn"><button class="btn btn-primary" id="editDep4">Update</button></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="supplier" class="control-label">Supplier <span class="required">*</span></label>
                    <select class="form-control"  required="required" name="supplier" id="supplier">
                        <option value="0">-Select a Supplier-</option>
                        <?php foreach ($allsuppliers AS $sup) { ?>
                            <option <?php echo ($sup->SupCode == $product->Prd_Supplier) ? 'SELECTED' : '' ?> value="<?php echo $sup->SupCode ?>"><?php echo $sup->SupName ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reorderlevel" class="control-label">Re Order Level<span class="required">*</span></label>
                            <input type="text" class="form-control" required="required" value="<?php echo $product->Prd_ROL; ?>"  name="reorderlevel" id="reorderlevel">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reorderqty" class="control-label">Re Order Qty<span class="required">*</span></label>
                            <input type="text" class="form-control" required="required" value="<?php echo $product->Prd_ROQ; ?>" name="reorderqty" id="reorderqty">
                        </div>
                    </div>
                </div>
                <div class="form-group" style="display:none">
                    <label for="product_image" class="control-label">Image <span class="required">*</span></label>
                    <input type="file" class="form-control" name="product_image" id="product_image" placeholder="Enter product name" />
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="isactive" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="isactive" value="1" <?php echo ($product->Prd_IsActive == 1) ? 'checked' : '' ?>> 
                                Is Active
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="isopenprice" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="isopenprice" value="1" <?php echo ($product->IsOpenPrice == 1) ? 'checked' : '' ?>> 
                                Is Open Price
                            </label>
                        </div>
                        <!-- <div class="form-group">
                            <label for="ispromotion" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="ispromotion" value="1" <?php echo ($product->IsPromotions == 1) ? 'checked' : '' ?>> 
                                Is Promotion
                            </label>
                        </div> -->
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ismultiprice" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="ismultiprice" value="1"  <?php echo ($product->IsMultiPrice == 1) ? 'checked' : '' ?>> 
                                Is Multi Price
                            </label>
                        </div>
                        <!-- <div class="form-group">
                            <label for="isserialno" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="isserialno" value="1" <?php echo ($product->IsSerial == 1) ? 'checked' : '' ?>> 
                                Is Serial No
                            </label>
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="israwmaterial" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="israwmaterial" value="1" <?php echo ($product->IsRawMaterial == 1) ? 'checked' : '' ?>> 
                                Is Raw Mtr
                            </label>
                        </div> -->
                    </div>
                    <div class="col-md-4">
                        <!-- <div class="form-group">
                            <label for="isfraction" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="isfraction" value="1" <?php echo ($product->IsFraction == 1) ? 'checked' : '' ?>> 
                                Is Fraction
                            </label>
                        </div> -->
                        <div class="form-group">
                            <label for="isfreeissue" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="isfreeissue" value="1" <?php echo ($product->IsFreeIssue == 1) ? 'checked' : '' ?>> 
                                Is Free Issue
                            </label>
                        </div>
                        <!-- <div class="form-group">
                            <label for="isfreeissue" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="isvat" value="1" <?php echo ($product->IsTax == 1) ? 'checked' : '' ?>> 
                                Is VAT
                            </label>
                        </div> -->
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="isfraction" class="control-label">
                                <input class="prd_icheck" type="checkbox" name="isnbt" id="isnbt" value="1" <?php echo ($product->IsNbt == 1) ? 'checked' : '' ?>> 
                                Is NBT
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" id="nbtratioDiv">
                            <label for="isfreeissue" class="control-label">
                                    NBT Ratio
                            </label>
                            <input class="form-control input-sm" type="text" id="nbtratio" name="nbtratio" value="<?php echo ($product->NbtRatio); ?>"> 
                        </div>
                    </div>
                    <div class="col-md-4"> </div>
                </div> -->
                <div class="row">
                    <div class="col-md-6">
<!--                        <div class="form-group">-->
<!--                            <label>Warranty</label>-->
<!--                            <div class="input-group">-->
<!--                                <div class="input-group-addon">-->
<!--                                    <input class="prd_icheck" type="checkbox" name="iswarranty" id="iswarranty" value="1" --><?php //echo ($product->IsWarranty == 1) ? 'checked' : '' ?><!--
<!--                                </div>-->
<!--                                <input type="text" class="form-control" name="warranty" id="warranty" value="--><?php //echo $product->WarrantyPeriod; ?><!--">-->
<!--                                <div class="input-group-addon">M</div>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="form-group">
                            <label>Profit Margin Percentage</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <input class="prd_icheck" type="checkbox" name="isprofitmargin" id="isprofitmargin" value="1" > 
                                </div>
                                <input type="text" class="form-control" name="profitmarginpercentage" id="profitmarginpercentage" value="">
                                <div class="input-group-addon">%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Discount Limit</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <input class="prd_icheck" type="checkbox" name="isdiscountlimit" id="isdiscountlimit" value="1" <?php echo ($product->IsDiscount == 1) ? 'checked' : '' ?>> 
                                </div>
                                <input type="text" class="form-control pull-right" name="discountlimit" id="discountlimit" value="<?php echo $product->DiscountLimit; ?>">
                                <div class="input-group-addon">%</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="barcode" class="control-label">Bar code  <span class="required">*</span></label>
                            <input type="text" class="form-control" name="barcode" id="barcode" value="<?php echo $product->BarCode; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unitpercase" class="control-label">Unit Per Case<span class="required">*</span></label>
                            <input type="text" class="form-control" required="required"  name="unitpercase" id="unitpercase" value="<?php echo $product->Prd_UPC; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unitpermeasure" class="control-label">Unit Per Messure<span class="required">*</span></label>
                            <select class="form-control" required="required"  name="unitpermeasure" id="unitpermeasure">
                                <option value="">--Select--</option>
                                <?php foreach ($measure AS $unit) { ?>
                                    <option <?php echo ($product->Prd_UOM == $unit->UOM_No) ? 'SELECTED' : '' ?> value="<?php echo $unit->UOM_No ?>"><?php echo $unit->UOM_Name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pricelevelarea">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="costprice" class="control-label">Cost Price<span class="required">*</span></label>
                                <?php if (in_array("SM135", $blockView) || $blockView == null) { ?>
                                <input type="text" class="form-control"  name="costprice" id="costprice" value="<?php echo $product->Prd_CostPrice; ?>">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="setaprice" class="control-label">Set a Price<span class="required">*</span></label>
                                <input type="text" class="form-control"  name="setaprice" id="setaprice" value="<?php echo $product->Prd_SetAPrice; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pricelevel" class="control-label">Price level <span class="required">*</span></label>
                        <select class="form-control"  required="required" name="pricelevel" id="pricelevel">
                            <option value="0">-Select a Price level-</option>
                            <?php foreach ($ploption AS $pl) { ?>
                                <option value="<?php echo $pl->PL_No ?>" val2="<?php echo $pl->PriceLevel ?>" ><?php echo $pl->PriceLevel ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="priceleveltbl">
                        <table class='table table-bordered' id='pltbl'>
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Price level</td>
                                    <td>Price </td>
                                    <td>#</td>
                                </tr>
                            </thead>
                            <tbody id="pltbldata">
                            <script>var item = [];</script>
                            <?php foreach ($productpl AS $pldata) { ?>
                                <tr>
                                    <td><?php echo $pldata->PL_No ?></td>
                                    <td><?php echo $pldata->PriceLevel ?></td>
                                    <td><input type="number" step="any" class="form-control" name="pl[<?php echo $pldata->PL_No ?>]" value="<?php echo $pldata->ProductPrice ?>"/></td>
                                    <td><span value="<?php echo $pldata->PL_No ?>" class="btn btn-danger delete">x</span></td>
                                </tr>
                                <script> item.push(<?php echo $pldata->PL_No ?>);</script>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php // print_r($productpl); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="proDate" class="control-label"> <span class="required">*</span></label>
                    <input type="hidden" class="form-control" name="proDate" id="proDate" value="<?php echo $product->Prd_Date; ?>"/>
                </div>
                <div class="row" style="background-color:#fff">
<!--                    <h4>Store Location</h4><hr>-->
                    <div class="row">
<!--                    <div class="col-md-4">-->
<!--                        <div class="form-group">-->
<!--                            <label for="productCode" class="control-label">Location<span class="required">*</span></label>-->
<!--                            <select class="form-control"  required="required" name="location" id="location">-->
<!--                                <option value="0">-Select a location-</option>-->
<!--                                --><?php //foreach ($location AS $sup) { ?>
<!--                                    <option value="--><?php //echo $sup->location_id ?><!--">--><?php //echo $sup->location ?><!--</option>-->
<!--                                --><?php //} ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="col-md-4" style="padding-left:0px;">
<!--                        <div class="form-group">-->
<!--                            <label for="productCode" class="control-label">Rack No<span class="required">*</span></label>-->
<!--                            <select class="form-control" name="rack" id="rack">-->
<!--                                <option value="0">-Select a rack-</option>-->
<!--                                --><?php //foreach ($racks AS $sup) { ?>
<!--                                    <option value="--><?php //echo $sup->rack_id ?><!--">--><?php //echo $sup->rack_no ?><!--</option>-->
<!--                                --><?php //} ?>
<!--                            </select>-->
<!--                        </div>-->
                    </div>
                    <div class="col-md-4" style="padding-left:0px;">
<!--                        <div class="form-group">-->
<!--                            <label for="productCode" class="control-label">Bin No <span class="required">*</span></label><br>-->
<!--                            <div class="input-group">-->
<!--                            <select class="form-control" name="bin" id="bin">-->
<!--                                <option value="0">-Select a bin-</option>-->
<!--                            </select>-->
<!--                            <span class="input-group-btn"><button class="btn btn-primary" id="addLoc">Add</button></span>-->
<!--                        </div></div>-->
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="loc_arr" id="loc_arr">
                        <input type="hidden" name="rack_arr" id="rack_arr">
                        <input type="hidden" name="bin_arr" id="bin_arr">
                        <input type="hidden" name="loc_array" id="loc_array">
                        <input type="hidden" name="rack_array" id="rack_array">
                        <input type="hidden" name="bin_array" id="bin_array">
                        <table class="table" id="store_location">
<!--                            <thead>-->
<!--                                <tr>-->
<!--                                    <th>Location</th>-->
<!--                                    <th>Rack No</th>-->
<!--                                    <th>Bin No</th>-->
<!--                                    <th>#</th>-->
<!--                                </tr>-->
<!--                            </thead>-->
                            <tbody>
                            <script>var loc_array = [];var rack_array = [];var bin_array = [];</script>
                            <?php foreach ($productloc AS $pldata) { ?>
                                <tr>
                                    <td><?php echo $pldata->location ?></td>
                                    <td><?php echo $pldata->rack_no ?></td>
                                    <td><?php echo $pldata->bin_no ?></td>
                                    <td><span loc='<?php echo $pldata->ProLocation ?>' bin='<?php echo $pldata->ProBin ?>' rack='<?php echo $pldata->ProRack ?>' class='btn btn-xs btn-danger remove'>x</span></td>
                                </tr>
                                <script>
                                    loc_array.push(<?php echo $pldata->ProLocation ?>);
                                    rack_array.push(<?php echo $pldata->ProRack ?>);
                                    bin_array.push(<?php echo $pldata->ProBin ?>);
                                        $("#loc_arr").val(loc_array);
                                        $("#rack_arr").val(rack_array);
                                        $("#bin_arr").val(bin_array);
                                        $("#loc_array").val(JSON.stringify(loc_array));
                                        $("#rack_array").val(JSON.stringify(rack_array));
                                        $("#bin_array").val(JSON.stringify(bin_array));
                                </script>
                            <?php } ?>
                        </tbody>
                        </table>

                    </div>
                </div>
                </div>
                
                <!--extra potions for a product-->
                <!--                    <div class="row">
                                        <div class="col-sm-6">                                             
                                            <div class="form-group">
                                                <label for="costcodeprice" class="control-label">Cost Code Price  <span class="required">*</span></label>
                                                <input type="number" class="form-control" name="costcodeprice" id="costcodeprice"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">                                             
                                            <div class="form-group">
                                                <label for="costprice" class="control-label">Cost Price  <span class="required">*</span></label>
                                                <input type="number" class="form-control" name="costprice" id="costprice"/>
                                            </div>
                                        </div>
                                    </div>-->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success btn-flat" type="submit">Save Product</button>
    </div>
</form>

<script>

    var s_dep = <?php echo $product->DepCode; ?>;
    var s_subdep = <?php echo $product->SubDepCode; ?>;
    var s_cat = <?php echo $product->CategoryCode; ?>;
    var s_subcat = <?php echo $product->SubCategoryCode; ?>;
    
    var isNbt = $("input[name='isnbt']:checked").val();
        if(isNbt){
            $("#nbtratio").prop('disabled',false);
        }else{
            $("#nbtratio").prop('disabled',true);
        }
    $("input[name='isnbt']").on('ifChanged', function(event){
        isNbt = $("input[name='isnbt']:checked").val();
        if(isNbt){
            $("#nbtratio").prop('disabled',false);
        }else{
            $("#nbtratio").prop('disabled',true);
        }
    });
    
    $("#panel_dep1").hide();
    $("#panel_dep2").hide();
    $("#panel_dep3").hide();
    $("#panel_dep4").hide();
    
    $("#edpanel_dep1").hide();
    $("#edpanel_dep2").hide();
    $("#edpanel_dep3").hide();
    $("#edpanel_dep4").hide();
    
    $('#addDep').click(function(e) {
        $("#panel_dep1").show();
        $("#edpanel_dep1").hide();
        $("#dep1").focus();
        e.preventDefault();
    });
    $('#addSubDep').click(function(e) {
        $("#panel_dep2").show();
        $("#edpanel_dep2").hide();
        $("#dep2").focus();
        e.preventDefault();
    });
    $('#addCat').click(function(e) {
        $("#panel_dep3").show();
        $("#edpanel_dep3").hide();
        $("#dep3").focus();
        e.preventDefault();
    });
    $('#addSubCat').click(function(e) {
        $("#panel_dep4").show();
        $("#edpanel_dep4").hide();
        $("#dep4").focus();
        e.preventDefault();
    });
    
    $('#editDep').click(function(e) {
        $("#edpanel_dep1").show();
        $("#panel_dep1").hide();
        $("#edep1").val($("#department option:selected").html());
        $("#edep1").focus();
        e.preventDefault();
    });
    $('#editSubDep').click(function(e) {
        $("#edpanel_dep2").show();
        $("#panel_dep2").hide();
        $("#edep2").val($("#sub_department option:selected").html());
        $("#edep2").focus();
        e.preventDefault();
    });
    $('#editCat').click(function(e) {
        $("#edpanel_dep3").show();
        $("#panel_dep3").hide();
        $("#edep3").val($("#category option:selected").html());
        $("#edep3").focus();
        e.preventDefault();
    });
    $('#editSubCat').click(function(e) {
        $("#edpanel_dep4").show();
        $("#panel_dep4").hide();
        $("#edep4").val($("#sub_category option:selected").html());
        $("#edep4").focus();
        e.preventDefault();
    });
    
    
    s_dep = $("#department option:selected").val();
    s_subdep = $("#sub_department option:selected").val();
    s_cat = $("#category option:selected").val();


    $('#proDate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    $('#department').select2({
        placeholder: "Select a Department",
        allowClear: true
    });
    $('#sub_department').select2({
        placeholder: "Select a Sub Department",
        allowClear: true
    });
    $('#category').select2({
        placeholder: "Select a Category",
        allowClear: true
    });
    $('#sub_category').select2({
        placeholder: "Select a Sub Category",
        allowClear: true
    });

    $('#department').change(function() {
        s_dep = $("#department option:selected").val();
        if(s_dep!='' || s_dep!=0){$("#delDep").attr('disabled',false);}else{$("#delDep").attr('disabled',true);}
        $(".select2-selection__rendered").attr('title', '');
        $("#addSubDep,#saveDep2,#editDep").attr('disabled',false);
        $("#addCat,#saveDep3,#editCat,#editSubDep").attr('disabled',true);
        $("#addSubCat,#saveDep4,#editSubCat").attr('disabled',true);
        $.ajax({
            url: "<?php echo base_url('admin/product/loadsubdepartment/') ?>",
            type: 'POST',
            data: {dep: $(this).val()},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#sub_department').empty().append("<option value=''>--select--</option>");

                $.each(resp, function(k, v) {
                    $('<option>').val(v.SubDepCode).text(v.Description).appendTo('#sub_department');
                });
            }
        });
    });
    $('#sub_department').change(function() {
        s_subdep = $("#sub_department option:selected").val();
        if(s_subdep!='' || s_subdep!=0){$("#delSubDep").attr('disabled',false);}else{$("#delSubDep").attr('disabled',true);}
        $("#addCat,#saveDep3,#editSubDep").attr('disabled',false);
        $("#addSubCat,#saveDep4,#editSubCat,#editCat").attr('disabled',true);
        $(".select2-selection__rendered").attr('title', '');
        $.ajax({
            url: "<?php echo base_url('admin/product/loadcategory/') ?>",
            type: 'POST',
            data: {subdep: $(this).val(), dep: s_dep},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#category').empty().append("<option value=''>--select--</option>");
                $.each(resp, function(k, v) {

                    $('<option>').val(v.CategoryCode).text(v.Description).appendTo('#category');
                });
            }
        });
    });
    $('#category').change(function() {
        s_cat = $("#category option:selected").val();
        if(s_cat!='' || s_cat!=0){$("#delCat").attr('disabled',false);}else{$("#delCat").attr('disabled',true);}
    $("#addSubCat,#saveDep4,#editCat").attr('disabled',false);
    $("#editSubCat").attr('disabled',true);
        $(".select2-selection__rendered").attr('title', '');
        $.ajax({
            url: "<?php echo base_url('admin/product/loadsubcategory/') ?>",
            type: 'POST',
            data: {cat: $(this).val(), subdep: s_subdep, dep: s_dep},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#sub_category').empty().append("<option value=''>--select--</option>");
                $.each(resp, function(k, v) {

                    $('<option>').val(v.SubCategoryCode).text(v.Description).appendTo('#sub_category');
                });
            }
        });
    });
    
    $('#sub_category').change(function() {
    $("#editSubCat").attr('disabled',false);
    s_subcat = $("#sub_category option:selected").val();
    if(s_subcat!='' || s_subcat!=0){$("#delSubCat").attr('disabled',false);}else{$("#delSubCat").attr('disabled',true);}
    });
    
    $('#addproductform').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('admin/product/update_product/') ?>",
            type: "POST",
            data: $(this).serializeArray(),
            success: function(data) {
                if (data == 'success') {
                    $('#productmodal').modal('hide');
                }
            }
        });
    });


    $('body').on('change', '#pricelevel', function() {
        var i = $(this).val();
        if (i > 0 && item.indexOf(i) == -1) {
            $('#pltbldata').append("<tr><td>" + i + "</td><td>" + $('#pricelevel option:selected').attr('val2') + "</td><td><input type='number' step='any' class='form-control' name='pl[" + i + "]'></td><td><span value='" + i + "' class='btn btn-danger delete'>x</span></td></tr>");
            item.push(i);
        }
        $(this).val('0');
    });
    $('#pltbldata').on('click', '.delete', function() {
        console.log($(this).attr('value') + 'deleted');
        item.splice(item.indexOf($(this).attr('value')), 1);
        $(this).closest('tr').remove();
    });
    $('#warranty').keyup(function() {
        if ($(this).val() != '' && $(this).val() != 0 && !isNaN($(this).val())) {
            $('#iswarranty').iCheck('check');
        } else {
            $('#iswarranty').iCheck('uncheck');
        }
    });
    $('#discountlimit').keyup(function() {
        if ($(this).val() != '' && $(this).val() != 0 && !isNaN($(this).val())) {
            $('#isdiscountlimit').iCheck('check');
        } else {
            $('#isdiscountlimit').iCheck('uncheck');
        }
    });
    $('#profitmarginpercentage').keyup(function() {
        if ($(this).val() != '' && $(this).val() != 0 && !isNaN($(this).val())) {
            $('#isprofitmargin').iCheck('check');
        } else {
            $('#isprofitmargin').iCheck('uncheck');
        }

    });


    $("#productname").keyup(function() {
        var word = $(this).val();

        var capword = word.toUpperCase();
        $("#productname").val(capword);
        $("#appearname").val(capword);
    });

    $(".select2-selection__rendered").attr('title', '');
    
    $('#delDep').click(function(e) {
        var r = confirm('Do you want to delete this department?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: {edepartment:s_dep,level:1},
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#department").find("[value='" + s_dep + "']").remove();
                            }

                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
        e.preventDefault();
    });
    $('#delSubDep').click(function(e) {
        var r = confirm('Do you want to delete this sub department?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: {esubdepartment:s_subdep,level:2},
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#sub_department").find("[value='" + s_subdep + "']").remove();
                            }

                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
        e.preventDefault();
    });
    $('#delCat').click(function(e) {
        var r = confirm('Do you want to delete this category?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: {ecategory:s_cat,level:3},
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#category").find("[value='" + s_cat + "']").remove();
                            }

                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
        e.preventDefault();
    });
    $('#delSubCat').click(function(e) {
        var r = confirm('Do you want to delete this sub category?');
            if (r === true) {

                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/deleteDep",
                    data: {esubcategory:s_subcat,level:4},
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];
                        var lvl = resultData['level'];

                        if (feedback != false) {
                            if (feedback == 2) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has sub category.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 3) {
                                $("#errProduct1").show();
                                $('html, body').animate({scrollTop: $('#errTop').offset().top}, 'slow');
                                $("#errProduct1").html('Can not delete this. This sub category has linked with product.').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
                                return false;
                            } else if (feedback == 1) {
                                $("#sub_category").find("[value='" + s_subcat + "']").remove();
                            }

                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            } else {

            }
        e.preventDefault();
    });
    
    $('#saveDep1').click(function(e) {
        var department = $("#dep1").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addDep",
                data: {department:department},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['DepCode'];
                    var dec = resultData['Description'];

                    if (feedback == true) {
                        $("#department").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#dep1").val('');
                        $("#panel_dep1").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });
    $('#saveDep2').click(function(e) {
    var subdepartment = $("#dep2").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addSubDep",
                data: {department1:s_dep,subdepartment:subdepartment},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['SubDepCode'];
                    var dec = resultData['Description'];

                    if (feedback == true) {
                        $("#sub_department").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#dep2").val('');
                        $("#panel_dep2").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });
    $('#saveDep3').click(function(e) {
        var category = $("#dep3").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addCat",
                data: {department2:s_dep,subdepartment1:s_subdep,category:category},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['CategoryCode'];
                    var dec = resultData['Description'];

                    if (feedback == true) {
                        $("#category").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#dep3").val('');
                        $("#panel_dep3").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });
    $('#saveDep4').click(function(e) {
    var subcategory = $("#dep4").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/addSubCat",
                data: {department3:s_dep,subdepartment2:s_subdep,category1:s_cat,subcategory:subcategory},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['SubCategoryCode'];
                    var dec = resultData['Description'];

                    if (feedback == true) {
                        $("#sub_category").append("<option value='"+val+"'>"+dec+"</option>");
                        $("#dep4").val('');
                        $("#panel_dep4").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });
    
    $('#editDep1').click(function(e) {
        var department = $("#edep1").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/editDep",
                data: {level:1,edepartment:s_dep,edesc:department},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['DepCode'];
                    var dec = resultData['Description'];
                    var code1 = resultData['code'];

                    if (feedback == true) {
                        $("#department option[value='" + code1 + "']").remove();
                        $("#department").append("<option value='"+code1+"'>"+dec+"</option>");
                        $("#department").val(code1);
                        $("#edep1").val('');
                        $("#edpanel_dep1").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });
    $('#editDep2').click(function(e) {
    var subdepartment = $("#edep2").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/editDep",
                data: {level:2,edepartment:s_dep,esubdepartment:s_subdep,edesc:subdepartment},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['SubDepCode'];
                    var dec = resultData['Description'];
                    var code2 = resultData['code'];

                    if (feedback == true) {
                        $("#sub_department option[value='" + code2 + "']").remove();
                        $("#sub_department").append("<option value='"+code2+"'>"+dec+"</option>");
                        $("#sub_department").val(code2);
                        $("#edep2").val('');
                        $("#edpanel_dep2").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });
    $('#editDep3').click(function(e) {
        var category = $("#edep3").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/editDep",
                data: {level:3,edepartment:s_dep,esubdepartment:s_subdep,ecategory:s_cat,edesc:category},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['CategoryCode'];
                    var dec = resultData['Description'];
                    var code3 = resultData['code'];

                    if (feedback == true) {
                        $("#category option[value='" + code3 + "']").remove();
                        $("#category").append("<option value='"+code3+"'>"+dec+"</option>");
                        $("#category").val(code3);
                        $("#edep3").val('');
                        $("#edpanel_dep3").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });

    $('#editDep4').click(function(e) {
    var subcategory = $("#edep4").val();
        $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + "admin/master/editDep",
                data: {level:4,edepartment:s_dep,esubdepartment:s_subdep,ecategory:s_cat,esubcategory:s_subcat,edesc:subcategory},
                success: function (json) {
                    var resultData = JSON.parse(json);
                    var feedback = resultData['fb'];
                    var val = resultData['SubCategoryCode'];
                    var dec = resultData['Description'];
                    var code4 = resultData['code'];

                    if (feedback == true) {
                        $("#sub_category option[value='" + code4 + "']").remove();
                        $("#sub_category").append("<option value='"+code4+"'>"+dec+"</option>");
                        $("#sub_category").val(code4);
                        $("#edep4").val('');
                        $("#edpanel_dep4").hide();
                     }
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        e.preventDefault();
    });

 var loc =$("#location option:selected").val();
    $('#location').change(function() {
         loc = $("#location option:selected").val();
        $('#bin,#rack').empty().append("<option value=''>--select--</option>");
        $.ajax({
            url: "<?php echo base_url('admin/product/loadracks/') ?>",
            type: 'POST',
            data: {loc: $(this).val()},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#bin,#rack').empty().append("<option value=''>--select--</option>");

                $.each(resp, function(k, v) {
                    $('<option>').val(v.rack_id).text(v.rack_no).appendTo('#rack');
                });
            }
        });
    });

    $('#rack').change(function() {
        var rack = $("#rack option:selected").val();
        $('#bin').empty().append("<option value=''>--select--</option>");
        $.ajax({
            url: "<?php echo base_url('admin/product/loadbins/') ?>",
            type: 'POST',
            data: {dep: $(this).val()},
            success: function(resp) {
                resp = JSON.parse(resp);
                $('#bin').empty().append("<option value=''>--select--</option>");

                $.each(resp, function(k, v) {
                    $('<option>').val(v.store_id).text(v.bin_no).appendTo('#bin');
                });
            }
        });
    });

    var loc_array  = [];
    var rack_array = [];
    var bin_array  = [];

    var locnew = $("#loc_arr").val();
        var racknew = $("#rack_arr").val();
        var binnew = $("#bin_arr").val();
        if(locnew!=''){
           loc_array = locnew.split(",");
        }
        if(racknew!=''){
           rack_array = racknew.split(",");
        }
        if(binnew!=''){
           bin_array = binnew.split(",");
        }


    $("#addLoc").click(function(e){
       
        
        
        var loc_name  = $("#location option:selected").html();
        var rack_name = $("#rack option:selected").html();
        var rack_id   = $("#rack option:selected").val();
        var bin_name  = $("#bin option:selected").html();
        var bin_id    = $("#bin option:selected").val();
        var loc_id    = $("#location option:selected").val();

        if(location==''){
            $.notify("Please select a location.", "warning");
            return false;
        }else if(rack_id==''){
             $.notify("Please select a rack no.", "warning");
            return false;
        }else if(bin_id==''){
            $.notify("Please select a bin no.", "warning");
            return false;
        }else{
            var locArrIndex = $.inArray(loc_id, loc_array);
            if (locArrIndex < 0) {
                loc_array.push(loc_id);
                rack_array.push(rack_id);
                bin_array.push(bin_id);
                $('#store_location tbody').append("<tr location='"+loc_id+"' rack_id='"+rack_id+"' bin_id='"+bin_id+"'><td>"+loc_name+"</td><td>"+rack_name+"</td><td>"+bin_name+"</td><td><span loc='" + loc_id + "' bin='" + bin_id + "' rack='" + rack_id + "' class='btn btn-xs btn-danger remove'>x</span></td></tr>");
                $("#rack").val('');
                $("#bin").val('');
                $("#loc_array").val(JSON.stringify(loc_array));
                $("#rack_array").val(JSON.stringify(rack_array));
                $("#bin_array").val(JSON.stringify(bin_array));

            }else{
                $.notify("Location already exists.", "warning");
                return false;
            }
        }
        e.preventDefault();
    });

    $('#store_location').on('click', '.remove', function() {
        loc_array.splice(loc_array.indexOf($(this).attr('loc')), 1);
        rack_array.splice(rack_array.indexOf($(this).attr('rack')), 1);
        bin_array.splice(bin_array.indexOf($(this).attr('bin')), 1);
        $(this).closest('tr').remove();
        $("#loc_array").val(JSON.stringify(loc_array));
        $("#rack_array").val(JSON.stringify(rack_array));
        $("#bin_array").val(JSON.stringify(bin_array));
    });
</script>