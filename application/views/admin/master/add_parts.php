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
						 <a href="<?php echo base_url('admin/Master/loadmodal_addjob_parts'); ?>" class="btn btn-flat btn-primary pull-right">Add Spare Parts</a>
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
									<td>ID</td>
									<td>Job type</td>
									<td>Description</td>
									<td>####</td>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($transType as $trns) { ?>
								<tr>
									<td><?php echo $trns->id; ?></td>
									<td><?php echo $trns->jobtype_name; ?></td>
									<td><?php echo $trns->JobDescription; ?></td>
									<td><a  class="btn btn-xs btn-primary" href="#" onclick="view(<?php echo $trns->description; ?>)" >View</a></td>
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
		<div class="modal-dialog modal-lg" style="width: 50%;">
			<div class="modal-content">
				<!-- load data -->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function (){
		var producttbl = $('#producttbl').dataTable();
	});
	function view(id) {
		console.log(id);
		$('.modal-content').load('<?php echo base_url() ?>admin/master/view_spare_parts/', {id: id}, function (result) {
			$('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
		});
	}
</script>
