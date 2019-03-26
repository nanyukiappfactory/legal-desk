<?php
		
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-sm">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="'.site_url().'administration/users/personnel.personnel_type_id/'.$order_method.'/'.$page.'">Type</a></th>
						<th><a href="'.site_url().'administration/users/personnel_onames/'.$order_method.'/'.$page.'">Other names</a></th>
						<th><a href="'.site_url().'administration/users/personnel_fname/'.$order_method.'/'.$page.'">First name</a></th>
						<th><a href="'.site_url().'administration/users/personnel_phone/'.$order_method.'/'.$page.'">Phone</a></th>
						<th><a href="'.site_url().'administration/users/personnel_status/'.$order_method.'/'.$page.'">Status</a></th>
						<th colspan="5">Actions</th>
					</tr>
				</thead>
				  <tbody>
				  
			';
			
			//get all administrators
			$administrators = $this->site_model->get_active_users();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$personnel_id = $row->personnel_id;
				$personnel_fname = $row->personnel_fname;
				$personnel_onames = $row->personnel_onames;
				$personnel_phone = $row->personnel_phone;
				$personnel_status = $row->personnel_status;
				$personnel_type_name = $row->personnel_type_name;
				$personnel_name = $personnel_fname.' '.$personnel_onames;
				
				//create deactivated status display
				if($personnel_status == 0)
				{
					$status = '<span class="label label-default">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'administration/activate-user/'.$personnel_id.'" onclick="return confirm(\'Do you want to activate '.$personnel_name.'?\');" title="Activate '.$personnel_name.'"><i class="fa fa-thumbs-up"></i>Activate</a>';
				}
				//create activated status display
				else if($personnel_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'administration/deactivate-user/'.$personnel_id.'" onclick="return confirm(\'Do you want to deactivate '.$personnel_name.'?\');" title="Deactivate '.$personnel_name.'"><i class="fa fa-thumbs-down"></i>Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$personnel_type_name.'</td>
						<td>'.$personnel_onames.'</td>
						<td>'.$personnel_fname.'</td>
						<td>'.$personnel_phone.'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'administration/reset-password/'.$personnel_id.'" class="btn btn-sm btn-warning" onclick="return confirm(\'Reset password for '.$personnel_fname.'?\');">Reset Password</a></td>
						<td><a href="'.site_url().'administration/edit-user/'.$personnel_id.'" class="btn btn-sm btn-success" title="Edit '.$personnel_name.'"><i class="fa fa-pencil"></i>Edit Personnel</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'administration/delete-user/'.$personnel_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$personnel_name.'?\');" title="Delete '.$personnel_name.'"><i class="fa fa-trash"> Delete</i></a></td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no personnel";
		}
?>
<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-heading">
			<h2 class="panel-title">Search personnel</h2>
		</div>

		<div class="panel-body">
		
			<?php
            echo form_open("hr/personnel/search_personnel", array("class" => "form-horizontal"));
            ?>
            <div class="row">
                
                <div class="col-md-6">
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">First name: </label>
                        
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="personnel_fname" placeholder="First name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Other names: </label>
                        
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="personnel_onames" placeholder="Other names">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Personnel Phone: </label>
                        
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="personnel_phone" placeholder="Personnel phone">
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4">
                        	<div class="center-align">
                            	<button type="submit" class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            echo form_close();
            ?>
    	</div>
    </div>
</div>

<div class="panel panel-default card-view">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			<?php
			$search = $this->session->userdata('personnel_search_title2');
			
			if(!empty($search))
			{
				echo '<h6>Filtered by: '.$search.'</h6>';
				echo '<a href="'.site_url().'hr/personnel/close_search" class="btn btn-sm btn-info pull-right">Close search</a>';
			}
			?>
			<div class="row mb-20">
				
				<a href="<?php echo site_url();?>administration/add-user" class="btn btn-sm btn-info pull-right">Add Personnel</a>
			</div>
			<div class="table-responsive">
				
				<?php echo $result;?>
		
			</div>
		</div>
		<div class="panel-footer">
			<?php if(isset($links)){echo $links;}?>
		</div>
	</div>
</div>