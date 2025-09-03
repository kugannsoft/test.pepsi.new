<form id="addproductform">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <!-- <center><h4>Spare Parts</h4></center> -->
    </div>
    <div class="row">
            <div class="col-md-12">
                <div class="box" id="catDiv">
                    <div class="box-body table-responsive">
                    <center><p id="alert"></p></center>
                        <table class="table table-bordered" id="producttbl">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Unit Price (Rs)</th>
                                    <th>Total (Rs)</th>
                                    <!-- <th>####</th> -->
                                    <th>####</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_data">
                            <?php foreach ($spareParts as $row) { ?>

                                <tr>
                                <input type="hidden" id="spare_part_id" name="spare_part_id" value="<?php echo $row->spare_part_id ; ?>">
                                <td><?php echo $row->spare_part_id ; ?></td>
                                <td><?php echo $row->spare_part_desc ; ?></td>
                                <td><?php echo $row->qty ; ?></td>
                                <td><?php echo $row->unit_price ; ?></td>
                                <td><?php echo $row->total_amount ; ?></td>
                                <!-- <td><a  row_id="<?php echo $row->id ; ?>" class='edt btn btn-xs btn-primary' name="edit" id="edit">Edit</a></td> -->
                                <td><a row_id="<?php echo $row->id ; ?>" class='del btn btn-xs btn-primary' id="delete" name="delete">Delete</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                </div>
                

            </div>

        </div>
    </div>
</form>

<script type="text/javascript">
 $("#producttbl tbody tr").on('click', '.del', function() {

        var id = $(this).attr('row_id');
        $.ajax({
            url: "<?php echo base_url('admin/master/deleteSpareParts/') ?>",
            type: 'POST',
            data: {id: id},
            success: function(data) {
                var resultData = JSON.parse(data);
                var feedback = resultData['fb'];
                if(feedback == true){

                    $.notify("Spare Parts Successfuly Deleted..", "success");
                           }
            }
        });
    });
  
</script>
