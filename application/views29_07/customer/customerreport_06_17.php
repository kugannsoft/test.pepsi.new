
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
    #gridarea {
        display: flex;
        overflow:scroll;
        background: rgba(136, 153, 119, 0.23);
        height: 400px;
        padding: 2px;
    }

    #tbl_est_data tbody tr td{
        padding: 13px;
    }

    .editrowClass {
      background-color: #f1b9b9;
    }

    .fullpad div {
      padding-left: 0px;
      padding-right: 0px;
    }
</style>
<div class="content-wrapper" id="app">
        <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="col-sm-2"><button type="button" id="btnPrint" class="btn btn-primary btn-sm btn-block">Print</button></div>
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
                                    <td>Name</td>
                                    <td>Phone</td>
                                    <td>Address</td>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="customermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content">
            <!-- load data -->
        </div>
    </div>
</div>
        
<script type="text/javascript">


var customertbl = $('#customertbl').dataTable({
            "processing": true,
            "serverSide": true,
            "bPaginate": false,
            "order": [[0, "asc"]],
            "language": {
                "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
            },
            "ajax": {
                "url": "allCustreport",
                "type": "POST"
            },
            "columns":
                    [
                        {"data": "CusName","searchable": true},
                        {"data": "MobileNo"},
                        {"data": "Address01"},
                      
                        
                    ]
    });


var inv =$("#inv").val();

$("#btnPrint").click(function(){
$('#customertbl').focus().print();
});

</script>