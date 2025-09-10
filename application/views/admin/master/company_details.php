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
                        <button onclick="addc()" class="btn btn-flat btn-primary pull-right">Add Company Details</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="customertbl">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name One </td>
                                    <td>Name Two</td>
                                    <td>Register No</td>
                                    <td>Address Line 01</td>
                                    <td>Address Line 02</td>
                                    <td>Address Line 03</td>
                                    <td>Mobile No</td>
                                    <td>Landline No</td>
                                    <td>Fax</td>
                                    <td>Email 01</td>
                                    <td>Email 02</td>
                                    <td>IsActive</td>
                                    <td>Advisor Name</td>
                                    <td>Advisor Contact</td>
                                    <td>VAT</td>
                                    <td>NBT</td>
                                    <td>NBT Ratio</td>
                                    <td>###</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transType as $trns) { ?>
                                <tr>
                                    <td><?php echo $trns->CompanyID; ?></td>
                                    <td><?php echo $trns->CompanyName; ?></td>
                                    <td><?php echo $trns->CompanyName2; ?></td>
                                    <td><?php echo $trns->RegNo; ?></td>
                                    <td><?php echo $trns->AddressLine01 ; ?></td>
                                    <td><?php echo $trns->AddressLine02 ; ?></td>
                                    <td><?php echo $trns->AddressLine03 ; ?></td>
                                    <td><?php echo $trns->MobileNo; ?></td>
                                    <td><?php echo $trns->LanLineNo; ?></td>
                                    <td><?php echo $trns->Fax; ?></td>
                                    <td><?php echo $trns->Email01; ?></td>
                                    <td><?php echo $trns->Email02; ?></td>
                                    <td> <?php if( $trns->IsActive==1){ ?>
                                        <span class="label label-xs label-success" >Active</span>
                                    <?php }elseif ( $trns->IsActive==0) { ?>
                                       <span class="label label-xs label-danger" >Inactive</span>
                                    <?php } ?> 
                                    </td>
                                    <td><?php echo $trns->SAdvisorName; ?></td>
                                    <td><?php echo $trns->SAdvisorContact; ?></td>
                                    <td><?php echo $trns->VAT; ?></td>
                                    <td><?php echo $trns->NBT; ?></td>
                                    <td><?php echo $trns->NBT_Ratio; ?></td>
                                    <td><a  class="btn btn-xs btn-primary" href="#" onclick="editc(<?php echo $trns->CompanyID; ?>)" >Edit</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!--add department modal-->
    <div id="productmodal" class="modal fade bs-add-category-modal-lg"  role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" style="width: 80%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function () {

        var producttbl = $('#producttbl').dataTable();
    });
    function addc() {
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_addcompany_details/', function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
    function editc(id) {
        console.log(id);
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_edicompany_details/', {id: id}, function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
</script>