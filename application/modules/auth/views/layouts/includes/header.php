<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<title><?php echo $title; ?></title>

<!-- Bootstrap core CSS -->
<link href="<?php echo base_url(); ?>assets/vendor/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<?php if(isset($login)){?>
    <link href="<?php echo base_url(); ?>assets/themes/custom/signin.css" rel="stylesheet">
<?php }
else{?>
    <link href="<?php echo base_url(); ?>assets/themes/custom/styles.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/custom/dashboard.css" rel="stylesheet">
<?php } ?>

