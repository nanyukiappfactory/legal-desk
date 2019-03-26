<?php
//personnel data
$personnel_onames = set_value('personnel_onames');
$personnel_fname = set_value('personnel_fname');
$personnel_phone = set_value('personnel_phone');
$personnel_type_id2 = set_value('personnel_type_id');
$personnel_password = set_value('personnel_password');
?>         

<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
            <div class="row" style="margin-bottom:20px;">
                <div class="col-lg-12">
                    <a href="<?php echo site_url();?>administration/users" class="btn btn-info pull-right">Back to personnel</a>
                </div>
            </div>
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-lg-5 control-label">Type: </label>
                            
                            <div class="col-lg-7">
                                <select class="form-control" name="personnel_type_id">
                                    <option value="">---Select Type---</option>
                                    <?php
                                        if($personnel_types->num_rows() > 0)
                                        {
                                            $status = $personnel_types->result();
                                            
                                            foreach($status as $res)
                                            {
                                                $personnel_type_id = $res->personnel_type_id;
                                                $personnel_type_name = $res->personnel_type_name;
                                                
                                                if($personnel_type_id == $personnel_type_id2)
                                                {
                                                    echo '<option value="'.$personnel_type_id.'" selected>'.$personnel_type_name.'</option>';
                                                }
                                                
                                                else
                                                {
                                                    echo '<option value="'.$personnel_type_id.'">'.$personnel_type_name.'</option>';
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-5 control-label">First Name: </label>
                            
                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="personnel_fname" placeholder="First Name" value="<?php echo $personnel_fname;?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-5 control-label">Other Names: </label>
                            
                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="personnel_onames" placeholder="Other Names" value="<?php echo $personnel_onames;?>">
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <label class="col-lg-5 control-label">Password: </label>
                            
                            <div class="col-lg-7">
                                <input type="password" class="form-control" name="personnel_password" placeholder="Password" value="<?php echo $personnel_password;?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-5 control-label">Phone: </label>
                            
                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="personnel_phone" placeholder="Phone" value="<?php echo $personnel_phone;?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-4 col-md-offset-5">
                        <button class="submit btn btn-primary" type="submit">
                            Add personnel
                        </button>
                    </div>
                </div>
                
            <?php echo form_close();?>
        </div>
    </div>
</div>