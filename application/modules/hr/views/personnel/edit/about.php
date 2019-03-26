<?php
//personnel data
$row = $personnel->row();

$personnel_onames = $row->personnel_onames;
$personnel_fname = $row->personnel_fname;
$personnel_phone = $row->personnel_phone;
$personnel_type_id2 = $row->personnel_type_id;

//repopulate data if validation errors occur
$validation_error = validation_errors();
				
if(!empty($validation_error))
{
	$personnel_onames = set_value('personnel_onames');
	$personnel_fname = set_value('personnel_fname');
	$personnel_phone = set_value('personnel_phone');
	$personnel_type_id2 = set_value('personnel_type_id');
}
?>
<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-heading">
            <h2 class="panel-title">About <?php echo $personnel_onames.' '.$personnel_fname;?></h2>
        </div>
		<div class="panel-body">
            
            <?php echo form_open(''.site_url().'administration/edit-user-about/'.$personnel_id.'', array("class" => "form-horizontal", "role" => "form"));?>
            
            <div class="row">
                
                <div class="col-md-6">
                    
                    <div class="form-group">
                        <label class="col-lg-5 control-label">Type: </label>
                        
                        <div class="col-lg-7">
                            <select class="form-control" name="personnel_type_id">
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
                        <label class="col-lg-5 control-label">Other Names: </label>
                        
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="personnel_onames" placeholder="Other Names" value="<?php echo $personnel_onames;?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-5 control-label">First Name: </label>
                        
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="personnel_fname" placeholder="First Name" value="<?php echo $personnel_fname;?>">
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-lg-5 control-label">Phone: </label>
                        
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="personnel_phone" placeholder="Phone" value="<?php echo $personnel_phone;?>">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-12">
                            <div class="form-actions center-align">
                                <button class="submit btn btn-primary" type="submit">
                                    Edit personnel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>