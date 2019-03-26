
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo $contacts['company_name'];?> | <?php echo $title;?></title>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
	<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
	<!-- Data table CSS -->
	<link href="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
	
	<!-- select2 CSS -->
	<link href="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>
		
	<!-- Bootstrap Daterangepicker CSS -->
	<link href="<?php echo $this->site_model->get_resources_location();?>dd/vendors/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
	
	<!-- Custom CSS -->
    <link href="<?php echo $this->site_model->get_resources_location();?>dd/dist/css/style.css" rel="stylesheet" type="text/css">
    
	<!-- Font Awesome -->
	<link href="<?php echo $this->site_model->get_resources_location();?>fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	
	<!-- Custom -->
	<link rel="stylesheet" href="<?php echo $this->site_model->get_resources_location();?>custom/css/admin.css">