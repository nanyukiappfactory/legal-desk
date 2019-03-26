<?php 
	
	if(!isset($contacts))
	{
		$contacts = $this->site_model->get_contacts();
	}
	$data['contacts'] = $contacts; 

	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$email2 = $contacts['email'];
		$logo = $contacts['logo'];
		$mission = $contacts['mission'];
		$vision = $contacts['vision'];
		$company_name = $contacts['company_name'];
		
		$phone = $contacts['phone'];
		
		if(!empty($facebook))
		{
			$facebook = '<li class="facebook"><a href="'.$facebook.'" target="_blank" title="Facebook">Facebook</a></li>';
		}
		
	}
	else
	{
		$email = '';
		$facebook = '';
		$twitter = '';
		$linkedin = '';
		$logo = '';
		$company_name = '';
		$mission = '';
		$vision = '';
		$google = '';
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->load->view('admin/layout/includes/header', $data, TRUE); ?>
</head>

<body>
	<input type="hidden" id="base_url" value="<?php echo site_url();?>">
	<!--Preloader-->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!--/Preloader-->
    <div class="wrapper theme-1-active pimary-color-red">

        <!-- header navigation -->
        <?php echo $this->load->view('admin/layout/includes/top_navigation', $data, TRUE); ?>
        <!-- end of header navigation -->

        <?php echo $this->load->view('admin/layout/includes/sidebar', $data, TRUE); ?>

		<!-- Main Content -->
		<div class="page-wrapper">
			<div class="container-fluid">
				
				<!-- Title -->
				<div class="row heading-bg">
					<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
					  <h6 class="txt-dark"><?php echo $title;?></h6>
					</div>
					<!-- Breadcrumb -->
					<div class="col-lg-8 col-sm-7 col-md-7 col-xs-12">
					  <ol class="breadcrumb">
						<?php echo $this->site_model->get_breadcrumbs();?>
					  </ol>
					</div>
					<!-- /Breadcrumb -->
					<div class="clearfix"></div>
					<?php
						$success = $this->session->userdata('success_message');

						if(!empty($success))
						{
							echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
							$this->session->unset_userdata('success_message');
						}
						
						$error = $this->session->userdata('error_message');
						
						if(!empty($error))
						{
							echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
							$this->session->unset_userdata('error_message');
						}
					?>
				</div>
				<!-- /Title -->

				<?php echo $content;?>
				
				
			</div>
			
			<!-- Footer -->
			<footer class="footer container-fluid pl-30 pr-30">
				<div class="row">
					<div class="col-sm-12">
						<p><?php echo date("Y")?> &copy; <?php echo $company_name;?>. Pampered by Nanyuki AppFactory</p>
					</div>
				</div>
			</footer>
			<!-- /Footer -->
			
		</div>
		<!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
	<?php echo $this->load->view('admin/layout/includes/footer', $data, TRUE); ?>
	
</body>

</html>