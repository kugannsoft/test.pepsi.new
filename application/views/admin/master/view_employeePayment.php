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
					<a href="<?php echo base_url('admin/Master/employee_payment'); ?>" class="btn btn-flat btn-primary pull-right">Employee Payment</a>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="box" id="catDiv">
					<div class="box-body table-responsive" style="margin-left:150px; ">
						<table class="table table-bordered" id="producttbl">
							<thead>
								<tr>
									<td>Employee ID</td>
									<td>Job Code</td>
									<td>Invoice No</td>
									<td>Amount (Rs)</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($salepersonpayment as $value) { ?>
									<tr>
										<td><?php echo $value->empNo; ?></td>
										<td><?php echo $value->jobCode; ?></td>
										<td><?php echo $value->jobinvNo; ?></td>
										<td><?php echo $value->amount; ?></td>
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

