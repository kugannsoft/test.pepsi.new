<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-large btn-primary" type="button">Search</button>
                            </span>
                            <input id="search_product" class="form-control ui-autocomplete-input" type="text" placeholder="Search Product" autofocus="" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box" id="catDiv">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="grnno" class="control-label">Grn No<span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="grnno" id="grnno" readonly />
                                </div>
                                <div class="form-group">
                                    <label for="product" class="control-label">Name<span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="product" id="product" placeholder="Enter product name">
                                </div>
                                <div class="form-group">
                                    <label for="remark" class="control-label">Appear name</label>
                                    <input class="form-control" name="appearname"  id="appearname" placeholder="Enter appear name"/>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--add department modal-->
        <div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- load data -->
                </div>
            </div>
        </div>
    </section>
</div>

