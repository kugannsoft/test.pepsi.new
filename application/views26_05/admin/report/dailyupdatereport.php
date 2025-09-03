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
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-info">
                                    Last Updated By <?php echo $summery->user; ?> @ <?php echo $summery->lastupdate; ?> 
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <form id="sform" method="POST" action="">
                                <div class="col-md-2">
                                    <input type="text" name="stockdate" id="stockdate" class="form-control" placeholder="select date" />
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" id="btnsubmit" class="btn btn-success btn-flat">update Stock</button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br/>
                                <br/>
                                <?php if (isset($result) && $result == 1): ?>
                                <p class="alert alert-success">sucessfully updated stock data to date <?php echo $date; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
</div>
<script>
    $('#stockdate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        startDate: "<?php echo $lastupdate ?>",
        endDate: "<?php echo $nextdate ?>"
    });
</script>