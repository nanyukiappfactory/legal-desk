
<?php echo form_open($this->uri->uri_string(), array("class" => "form-signin"));?>
	<img class="mb-4" src="<?php echo base_url();?>assets/images/lock1.png" alt="" width="72" height="72">
	<h1 class="h3 mb-3 font-weight-normal"><?php echo  $title;?></h1>
	<label for="user_email" class="sr-only">Email address</label>
	<input type="user_email" id="user_email" name="user_email" class="form-control" placeholder="Email address" required autofocus>
	<label for="user_password" class="sr-only">Password</label>
	<input type="password" id="user_password"  name="user_password" class="form-control" placeholder="Password" required>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
<?php echo form_close();