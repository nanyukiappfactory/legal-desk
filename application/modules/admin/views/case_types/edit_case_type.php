<?php
/**
 * Created by PhpStorm.
 * User: ivy
 * Date: 2/22/19
 * Time: 10:25 PM
 */?>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title"><?php echo $title;?></h2>
    </header>
    <div class="panel-body">
        <div class="row" style="margin-bottom:20px;">
            <div class="col-lg-12">
                <a href="<?php echo site_url();?>administration/case_types" class="btn btn-info pull-right">Back to Case Types</a>
            </div>
        </div>
        <!-- Adding Errors -->
        <?php
        if(isset($error)){
            echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
        }

        //the case type details
        $case_type_id = $case_type[0]->case_type_id;
        $case_type_name = $case_type[0]->case_type_name;
        $case_type_parent = $case_type[0]->case_type_parent;
        $case_type_description = $case_type[0]->case_type_description;

        $validation_errors = validation_errors();

        if(!empty($validation_errors))
        {
            $case_type_name = set_value('case_type_name');
            $case_type_parent = set_value('case_type_parent');
            $case_type_description = set_value('case_type_description');

            echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
        }

        ?>

        <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
        <!-- Case Type Name -->
        <div class="form-group">
            <label class="col-lg-4 control-label">Case Type Name</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="case_type_name" placeholder="Case Type Name" value="<?php echo $case_type_name;?>" >
            </div>
        </div>
        <!-- Case Type Parent -->
        <div class="form-group">
            <label class="col-lg-4 control-label">Case Type Parent</label>
            <div class="col-lg-4">
                <select name="case_type_parent" class="form-control" >
                    <?php
                    echo '<option value="0">No Case Type Parent</option>';
                    if($all_case_types->num_rows() > 0)
                    {
                        $result = $all_case_types->result();

                        foreach($result as $res)
                        {
                            if($res->case_type_id == $case_type_parent)
                            {
                                echo '<option value="'.$res->case_type_id.'" selected>'.$res->case_type_name.'</option>';
                            }
                            else
                            {
                                echo '<option value="'.$res->case_type_id.'">'.$res->case_type_name.'</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Case Type Description -->
        <div class="form-group">
            <label class="col-lg-4 control-label">Case Type Description</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="case_type_description" placeholder="Case Type Description" value="<?php echo $case_type_description;?>" >
            </div>
        </div>

        <div class="form-actions center-align">
            <button class="submit btn btn-primary" type="submit">
                Edit Case Type
            </button>
        </div>
        <br />
        <?php echo form_close();?>
    </div>
</section>
