<?php
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$facebook = $contacts['facebook'];
		$twitter = $contacts['twitter'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$phone = $contacts['phone'];
	}
?>
<!-- JavaScript -->
	
    <!-- jQuery -->
    <script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
	<!-- Data table JavaScript -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/jszip/dist/jszip.min.js"></script>
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/pdfmake/build/pdfmake.min.js"></script>
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/pdfmake/build/vfs_fonts.js"></script>
	
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	
	<!-- Slimscroll JavaScript -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/dist/js/jquery.slimscroll.js"></script>

	<!-- Select2 JavaScript -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
		
	<!-- Moment JavaScript -->
	<script type="text/javascript" src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/moment/min/moment-with-locales.min.js"></script>
		
	<!-- Bootstrap Daterangepicker JavaScript -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Switchery JavaScript -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	
	<!-- Fancy Dropdown JS -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/dist/js/dropdown-bootstrap-extended.js"></script>
	
	<!-- Init JavaScript -->
	<script src="<?php echo $this->site_model->get_resources_location();?>dd/dist/js/init.js"></script>
	<!-- Custom JS -->
	<script src="<?php echo $this->site_model->get_resources_location();?>custom/js/admin.js"></script>