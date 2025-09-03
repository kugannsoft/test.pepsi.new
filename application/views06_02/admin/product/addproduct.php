<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
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
        <div class="row">
            <div class="box col-lg-12" id="catDiv">
                <div class="col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="productCode" class="control-label">Product Code <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="productCode" id="productCode" placeholder="Enter product Code">
                                </div>
                                <div class="form-group">
                                    <label for="product" class="control-label">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="product" id="product" placeholder="Enter product name">
                                </div>
                                <div class="form-group">
                                    <label for="remark" class="control-label">Appear name</label>
                                    <input class="form-control" name="appearname"  id="appearname" placeholder="Enter appear name"/>
                                </div>
                                <div class="productmaparea">
                                    <h5 class="pull-right">Product mapping</h5><br/>
                                    <div class="form-group">
                                        <label for="cateogry" class="control-label">Department <span class="required">*</span></label>
                                        <select class="form-control"  required="required" name="department" id="department">
                                            <option value="0">-Select a department-</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_category" class="control-label">Sub Department <span class="required">*</span></label>
                                        <select  class="form-control" name="sub_department"  required="required" id="sub_department">
                                            <option value="0">-Select a sub department-</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="category" class="control-label">Category  <span class="required">*</span></label>
                                        <select class="form-control" name="category" required="required" id="category">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="subcategory" class="control-label">Sub Category  <span class="required">*</span></label>
                                        <select class="form-control" name="sub_category" required="required" id="sub_category">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier" class="control-label">Supplier <span class="required">*</span></label>
                                    <select class="form-control"  required="required" name="supplier" id="supplier">
                                        <option value="0">-Select a Supplier-</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_image" class="control-label">Image <span class="required">*</span></label>
                                    <input type="file" class="form-control" name="product_image" id="product_image" placeholder="Enter product name">
                                </div>
                                 <div class="form-group">
                                    <label for="product_image" class="control-label">Is Active</label>
                                    <input class="prd_icheck" type="checkbox" name="active"> 
                                </div>
                                
                                <br/><br/>
                                <div class="productmaparea">
                                    <div class="form-group">
                                        <label for="pricelevel" class="control-label">Price level <span class="required">*</span></label>
                                        <select class="form-control"  required="required" name="pricelevel" id="pricelevel">
                                            <option value="0">-Select a Price level-</option>
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

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--extra potions for a product-->
                                <div class="row">
                                    <div class="col-sm-6">                                             
                                        <div class="form-group">
                                            <label for="barcode" class="control-label">Bar code  <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="barcode" id="barcode"/>
                                        </div>
                                    </div>
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
                                    <div class="col-sm-6">                                             
                                        <div class="form-group">
                                            <label for="costprice" class="control-label">Is Warranty  <span class="required">*</span></label>
                                            <input class="prd_icheck" type="checkbox" name="iswarranty" id="iswarranty" value="checked">
                                            <input type="number" disabled="true" class="form-control" name="warranty" id="warranty" placeholder="months"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--add department modal-->
        <div id="customermodal" class="modal fade bs-add-category-modal-lg" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- load data -->
                </div>
            </div>
        </div>
    </section>
</div>

