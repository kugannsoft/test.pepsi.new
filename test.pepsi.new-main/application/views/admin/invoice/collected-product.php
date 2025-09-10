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
                <div class="box box-success container-fluid">
                    <div class="row" style="background: #D0D0D0;"><br>
                        <style>
                            .form-group {margin-bottom: 5px;}
                        </style>
                        <div class="col-md-4">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="customer" class="col-sm-4 control-label">Received No <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" tabindex="1" class="form-control" readonly  value="<?php echo $inv->InvoiceNo; ?>" name="grn_no" id="grn_no" placeholder="auto gen">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnDate" class="col-sm-4 control-label">Received Date <span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" required name="invDate" id="invDate" value="<?php echo $inv->ReceivedDate; ?>" placeholder="">

                                        <!-- Hidden fields are okay -->
                                        <input type="hidden" name="location" id="invlocation" value="<?php echo $_SESSION['location']; ?>">
                                        <input type="hidden" name="invUser" id="invUser" value="<?php echo $_SESSION['user_id']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="grnremark"class="col-sm-4 control-label">Received Remark<span class="required">*</span></label>
                                    <div class="col-sm-7">
                                        <input name="grnremark"  tabindex="2" id="grnremark" class="form-control" value="<?php echo $inv->ReceivedRemark; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
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
                                </div>
<!--                                --><?php //if (!$isEditMode) { ?>
<!--                                <div class="form-group">-->
<!--                                    <label class="col-sm-4 control-label">Routes </label>-->
<!--                                    <div class="col-sm-7">-->
<!--                                        <select class="form-control" name="route" id="route">-->
<!--                                            <option value="0">-Select-</option>-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                --><?php //} ?>

<!--                                --><?php //if ($isEditMode) { ?>
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
<!--                                --><?php //} ?>
                            </form>
                        </div>
                        <div  class="col-md-5">
                            <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="supplier" class="col-sm-4 control-label">Customer<span class="required">*</span></label>
<!--                                    <div class="col-sm-7">-->
<!--                                        <div class="input-group">-->
<!--                                          <!-- <input type="text" tabindex="1" class="form-control" required="required"  name="customer" id="customer" placeholder="Customer" value="--><?php //echo $customer; ?><!--"> -->-->
<!--                                            <select class="form-control" required="required" name="customer" id="customer" placeholder="customer name">-->
<!--                                                <option value="0">-Select a customer-</option>-->
<!--                                            </select>-->
<!--                                         -->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    --><?php //} ?>
<!--                                    --><?php //if ($isEditMode) { ?>
                                        <div class="col-sm-7">
                                        <div class="input-group">
<!--                                           <input type="text" tabindex="1" class="form-control" required="required"  name="customer" id="customer" placeholder="Customer" >-->
                                            <select class="form-control" required="required" name="customer" id="customer" placeholder="customer name">

                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer->CusCode ?>"><?= $customer->CusName ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        </div>
                                    </div>
<!--                                    --><?php //} ?>
                                </div>
                             
                                <div class="form-group">
                                    <label for="additional" class="col-sm-4 control-label">
                                    <!-- Non Return Invoice -->
                                    </label>
                                    <div class="col-sm-7" >
                                        <input type="checkbox" tabindex="6" name="nonInv" value="1" id="nonInv" class="prd_icheck" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <div class="row">
                        <hr>
                        <div class="col-md-5">
                            <div class="box-body">
                                <form class="form-horizontal" id="formProduct">
                                    <span id="location"></span>
                                    <span id="lbl_batch_no"></span>
                                    <label id="errProduct"></label>
                                    <div class="form-group">
                                        <div>
                                            <label for="itemCode" class="col-sm-4 control-label"><span class="required"></span></label>
                                            <div class="col-sm-8"><span id="productName" style="font-size: 10px;"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="lbl_refCode">
                                            <label for="itemCode" class="col-sm-4 control-label">Product Code <span class="required"></span></label>
                                            <div class="col-sm-6 input-group">
                                                <input type="text" tabindex="9" name="itemCode" id="itemCode" class="form-control">
                                                <input type="hidden" name="productName" id="productName" class="form-control" >
                                                <input type="hidden" name="totalQty" id="totalQty" class="form-control" >
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div id="productLable" >
                                        <div class="form-group">
                                            <label for="product" class="col-sm-4 control-label">Qty <span class="required">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="number" tabindex="10"  min="0" step="1" class="form-control" required="required"  name="qty" id="qty" placeholder="Enter Qty"  value="0">
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
                        <div class="col-md-7">
                            <h5 class="text-center"><b>Return Item List</b></h5>
                            <div class="table-responsives">
                                <table id="tbl_item" class="table table-bordered table-striped table-responsives">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <span id="errData"></span>
                                <button  tabindex="19" id="saveItems" class="btn btn-success">Save</button>&nbsp;<button  tabindex="21" id="resetItems" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>



        $('#invDate').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true
        });



    $('.prd_icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '50%'
    });

    $('#customer').select2({
    placeholder: "Select a customer",
    allowClear: true,
    minimumInputLength:1,
    width: '100%'
});
</script>

<script>
    
        const items = <?php echo json_encode($this->data['items']); ?>;

        
            let tbody = $('#tbl_item tbody');
            items.forEach((item, index) => {
                let row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.ProductCode}</td>
                        <td>${item.ProductName}</td>
                        <td>${item.Quantity}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-row" data-id="${item.id}">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-row" data-id="${item.id}">Delete</button>
                        </td>
                    </tr>`;
                tbody.append(row);
            });

            $('#tbl_item').on('click', '.delete-row', function () {
                $(this).closest('tr').remove(); 
                alert(`Row with ID ${$(this).data('id')} deleted.`);
            });

            $('#tbl_item').on('click', '.edit-row', function () {
                
            const rowId = $(this).data('id');
            const item = items.find(i => i.id == rowId); 

            if (item) {
                $('#itemCode').val(item.ProductCode);
                $('#productName').val(item.ProductName);
                $('#qty').val(item.Quantity); 
                $('#editRowId').val(rowId);
            } else {
                alert('Item not found!');
            }
        });
    </script>