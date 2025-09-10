
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <center><h4>Edit Spare Part Description</h4></center>
        <hr style="border-width: 3px; border-color: #63abd8;">
        </div>

    </div>
    <div class="modal-body" style="margin-left: 150px;">
        <div class="row">
            <div class="col-md-8">
                <form id="editSpareParts">
                <div class="form-group">
                    <label for="productCode" class="control-label">Spare Parts<span class="required"></span></label>
                    <?php foreach ($result as $trns) { ?>
                    <input type="text" name="sparePart" id="sparePart" class="form-control"  value="<?php echo $trns->spare_part_desc?>" placeholder="Enter Quantity" requered disabled>
                
                </div>                
               <div class="form-group">
                    <label for="qty" class="control-label">Quantity of Spare Part</label>
                    <input type="number" name="qty" id="qty" class="form-control" placeholder="Enter Quantity " required="true" value="<?php echo $trns->qty?>">
                </div>
                <div class="form-group">
                    <label for="qty" class="control-label">Free Issue</label>&nbsp &nbsp
                     <?php if($trns->free_issue=='1'){ ?>
                    <input  type="checkbox" name="freeIssue" id="freeIssue" value="1" checked="true"> 
                    <?php }else{ ?>
                    <input  type="checkbox" name="freeIssue" id="freeIssue" value="1" >
                    <?php } ?>
                </div>
              
                <input type="hidden" name="sp_id" id="sp_id" value="<?php echo $trns->id; ?>">                  
                <input type="hidden" name="unitPrice" id="unitPrice" value="<?php echo $trns->unit_price; ?>">
                  <?php } ?>
                  <div class="form-group">
                <center>
                <button class="btn btn-s btn-primary" id="add" type="submit">Save</button>
                </center>
                </div>
                  </form>
            </div>
        </div>
    </div>  
<script type="text/javascript">
     $("#editSpareParts").submit(function(e) {
         $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/editSpareparts",
                    data: $("#editSpareParts").serialize(),
                    success: function(json) {
                    }
                      
                });
            
        });
</script>
