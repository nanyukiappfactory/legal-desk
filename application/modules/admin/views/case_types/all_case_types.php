<?php
/**
 * Created by PhpStorm.
 * User: ivy
 * Date: 2/22/19
 * Time: 10:25 PM
 */


		$result = '';

		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;

			$result .=
			'
			<table class="table table-bordered table-striped table-sm display pb-30">
				<thead>
					<tr>
						<th>#</th>
						<th>Icon</th>
						<th><a href="'.site_url().'administration/case_types/case_type_name/'.$order_method.'/'.$page.'">Case Type name</a></th>
						<th><a href="'.site_url().'administration/case_types/case_type_parent/'.$order_method.'/'.$page.'">Case Type Parent</a></th>
						<th><a href="'.site_url().'administration/case_types/created/'.$order_method.'/'.$page.'">Date Created</a></th>
						<th><a href="'.site_url().'administration/case_types/last_modified/'.$order_method.'/'.$page.'">Last modified</a></th>
						<th><a href="'.site_url().'administration/case_types/case_type_description/'.$order_method.'/'.$page.'">Case Type Description</a></th>
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
				$case_type_id = $row->case_type_id;
				$case_type_name = $row->case_type_name;
				$parent = $row->case_type_parent;
				$case_type_description = $row->case_type_description;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;


				$case_type_parent = '-';

				//Case Type parent
				foreach($all_case_types->result() as $row2)
				{
					$case_type_id2 = $row2->case_type_id;

					if($parent == $case_type_id2)
					{
						$case_type_parent = $row2->case_type_name;
						break;
					}
				}

				//creators & editors
				if($admins != NULL)
				{
					foreach($admins as $adm)
					{
						$personnel_id = $adm->personnel_id;

						if($personnel_id == $created_by)
						{
							$created_by = $adm->personnel_fname;
						}

						if($personnel_id == $modified_by)
						{
							$modified_by = $adm->personnel_fname;
						}
					}
				}

				else
				{
				}
				$count++;
				$result .=
				'
					<tr>
						<td>'.$count.'</td>
						<td><i class="fa fa-file fa-2x"></i></td>
						<td>'.$case_type_name.'</td>
						<td>'.$case_type_parent.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$case_type_description.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$case_type_id.'" class="btn btn-primary btn-sm" data-toggle="modal" title="Expand '.$case_type_name.'"><i class="fa fa-plus"></i></a>
							
							<!-- Modal -->
							<div id="user'.$case_type_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$case_type_name.'</h4>
										</div>
										
										<div class="modal-body">
											<table class="table table-stripped table-sm table-hover">
												<tr>
													<th>Case Type Name</th>
													<td>'.$case_type_name.'</td>
												</tr>
												<tr>
													<th>Case Type parent</th>
													<td>'.$case_type_parent.'</td>
												</tr>
												<tr>
													<th>Case Type Description</th>
													<td>'.$case_type_description.'</td>
												</tr>
												<tr>
													<th>Date created</th>
													<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
												</tr>
												<tr>
													<th>Created by</th>
													<td>'.$created_by.'</td>
												</tr>
												<tr>
													<th>Date modified</th>
													<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
												</tr>
												<tr>
													<th>Modified by</th>
													<td>'.$modified_by.'</td>
												</tr>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											<a href="'.site_url().'administration/edit-case_type/'.$case_type_id.'" class="btn btn-sm btn-success" title="Edit '.$case_type_name.'"><i class="fa fa-pencil"></i></a>
											'.$button.'
											<a href="'.site_url().'administration/delete-case_type/'.$case_type_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$case_type_name.'?\');" title="Delete '.$case_type_name.'"><i class="fa fa-trash"></i></a>
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td><a href="'.site_url().'administration/edit-case_type/'.$case_type_id.'" class="btn btn-sm btn-success" title="Edit '.$case_type_name.'"><i class="fa fa-pencil"></i></a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'administration/delete-case_type/'.$case_type_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$case_type_name.'?\');" title="Delete '.$case_type_name.'"><i class="fa fa-trash"></i></a></td>
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
			$result .= "There are no Case Type";
		}
?>

				<div class="panel panel-default card-view">
					<div class="panel-wrapper collapse in">
						<div class="panel-body">

							<div class="row" style="margin-bottom:20px;">
								<div class="col-lg-12">
									<a href="<?php echo site_url();?>administration/add-case_type" class="btn btn-warning pull-right">Add Case Type</a>
								</div>
							</div>
							<div class="table-wrap">
								<div class="table-responsive">

									<?php echo $result;?>

                                </div>
							</div>

							<div class="pull-right">
                            	<?php if(isset($links)){echo $links;}?>
							</div>
						</div>
					</div>
				</div>