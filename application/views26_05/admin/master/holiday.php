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
                        <b><span class="alert alert-success pull-left" id="lastProduct"></span></b>
                        <button onclick="addp()" class="btn btn-flat btn-primary pull-right">Add Holiday</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box" id="catDiv">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="producttbl">
                            <thead>
                            <tr>
                                <td>Code</td>
                                <td>Name</td>
                                <td>Date</td>
                                <td>Remark</td>
                                <td>###</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($holiday as $trns) { ?>
                                <tr>
                                    <td><?php echo $trns->id; ?></td>
                                    <td><?php echo $trns->name; ?></td>
                                    <td><?php echo $trns->date; ?></td>
                                    <td><?php echo $trns->remark; ?></td>
                                    <td>
                                        <a  class="btn btn-xs btn-primary" href="#" onclick="editp(<?php echo $trns->id; ?>)" >Edit</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--add department modal-->
    <div id="productmodal" class="modal fade bs-add-category-modal-lg"  role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-sm" style="width: 30%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var producttbl = $('#producttbl').dataTable();
    });
    function addp() {
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_add_holiday/', function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
    function editp(id) {
        console.log(id);
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_edit_holiday/', {id: id}, function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
</script>
