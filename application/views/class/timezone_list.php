<div class="content-wrapper" style="min-height: 720px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> System Settings        </h1>
    </section>

    <?php
    $this->load->helper('global');
     ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- left column -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-commenting-o"></i> Class Lesson Time</h3>
                    </div>
                    <div class="around10"> </div>
                    <form method="POST" action="<?php echo site_url('classes/timezone_save') ?>">
                        <div class="box-body ">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Level</th>
                                        <th>Lesson Time</th>
                                    </tr></thead>
                                    <tbody>
                                        <?php foreach($timezone as $row) { ?>
                                        <tr>
                                            <td width="40%"><?php echo $row['class']; ?></td>
                                            <td width="15%"><?php echo $row['Section']; ?></td> 
                                            <td width="25%"><?php echo $row['level']; ?></td>
                                            <td width="20%">
                                                <?php
                                                    if($row['is_ampm']=='no')
                                                    {
                                                        ?>
                                                        <input type="hidden" name="class_section_id[<?php echo $row['class_section_id']; ?>]" value="1" />
                                                        <?php
                                                    }
                                                    else
                                                    {

                                                 ?>
                                                    <select style="width:100%" name="class_section_id[<?php echo $row['class_section_id']; ?>]" >
                                                        <option value=0>&nbsp;</option>
                                                        <?php foreach(TIME_AMPM as $select_row){ ?>
                                                            <?php $select = ($select_row['id']==$row['ampm_flag']) ? "selected" : ""; ?>
                                                            <option <?php echo $select; ?> value="<?php echo $select_row['id'] ?>"><?php echo $select_row['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                <?php 
                                                    }
                                                ?>
                                                <?php // echo get_lesson_timezone($row['timezone']); ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div>
