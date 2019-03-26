<?php
//personnel data
$row = $personnel->row();

// var_dump($row) or die();
$personnel_onames = $row->personnel_onames;
$personnel_fname = $row->personnel_fname;
$personnel_phone = $row->personnel_phone;
$personnel_type_id = $row->personnel_type_id;


//echo $gender_id;
//repopulate data if validation errors occur
$validation_error = validation_errors();
				
if(!empty($validation_error))
{
	$personnel_onames =set_value('personnel_onames');
	$personnel_fname =set_value('personnel_fname');
	$personnel_phone =set_value('personnel_phone');
	$personnel_type_id = set_value('personnel_type_id');
}
?>

<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-6">
					<h2 class="panel-title"><?php echo $personnel_fname.' '.$personnel_onames;?> Details</h2>
					<i class="fa fa-phone"></i>
					<span id="mobile_phone"><?php echo $personnel_phone;?></span>
				</div>
				<div class="col-md-6">
					<a href="<?php echo site_url();?>administration/users" class="btn btn-sm btn-info pull-right">Back to personnel</a>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div class="tabs">
						<ul class="nav nav-tabs nav-justified">
							<li class="active">
								<a class="text-center" data-toggle="tab" href="#general"><i class="fa fa-user"></i> General details</a>
							</li>
							<li>
								<a class="text-center" data-toggle="tab" href="#account"><i class="fa fa-lock"></i> Account details</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="general">
								<?php echo $this->load->view('edit/about', '', TRUE);?>
							</div>
							<div class="tab-pane" id="account">
								<?php echo $this->load->view('edit/account', '', TRUE);?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>