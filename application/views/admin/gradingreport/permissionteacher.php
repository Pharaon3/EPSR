<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('grading_report_permissionteacher', 'can_view')) {
            ?>
                <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line("permission_teacher") ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                        <style>
                            .red
                            {
                                font-size:1.0rem;
                                color:red;
                            }
                        </style>
                        <?php if( empty($view_role_id)) { ?>
                        <div class="box-header with-border" style="width: 230px; float: right; display:none;">
                            <h3 class="box-title" style="font-size:1.2rem;"><?php echo $this->lang->line("level") ?> <span class="red"> * </span> </h3>
                            <div class="box-tools pull-right">
                                <form method="post">
                                <select autofocus="" class="form-control"
                                    id="level_id" name="level_id" 
                                    onchange="submit();"
                                        >
                                    <?php
                                    foreach ($levellist as $level) {
                                        if($level['id']!=43) continue;
                                        ?>
                                        <option value="<?php echo $level['is_active']=='no' ? 0 : $level['id'] ?>" 
                                            <?php if ($selected_level_id == $level['id']) echo "selected=selected"; ?>
                                            <?php if ( empty($selected_level_id) && $level['is_active']=='no' ) echo "selected"; ?>
                                            ><?php echo $level['level'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                </form>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="box-body table-responsive" id="transfee">
                            <table class="table table-hover teacher-list" id="headerTable" data-export-title="<?php echo $this->lang->line('teacher') . " " . $this->lang->line('list') ?>">
                                <thead>
                                    <tr>
									<th><?php echo $this->lang->line('name'); ?></th>
									<?php for($i = 0; $i < count($levelperiod_list); $i ++) {
                                               $checkstr = $all_check_flag[$i]==1 ? "check" : "remove";
											echo "<th>"."<div onclick='changeall(event, $i, 0)' curval='".$all_check_flag[$i]."' title='toggle all permissions' class='btn btn-default btn-xs'><i class='fa fa-" .$checkstr. " '></i></div>" .
                                                        "&nbsp;" .
                                                        $levelperiod_list[$i]['label'].
                                                    " </th>";
									}
									?>   
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            
        </div>
        <div class="row">
            <!-- <div class="col-md-12">
            </div> -->
        </div>
    </section>

</div>
<script>
    function changepermission(e, index, staff_roles_id, staff_id)
	{
        e.preventDefault();
        if($("#level_id").val()==0)
        {
            alert("please select any level first");
            return;
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/grading_result/changepermission',
            data: {
                'staff_roles_id': staff_roles_id,
                'staff_id': staff_id,
				'index':index
            },
            dataType: 'JSON',
            success: function(res) {
                successMsg(res.message);
                let chkObject = e.target;
                if($(e.target).hasClass("btn"))
                {
                    chkObject = $(e.target).children()[0];
                }

                if($(chkObject).hasClass("fa-remove"))
                {
                    $(chkObject).removeClass("fa-remove");
                    $(chkObject).addClass("fa-check");
                }
                else
                {
                    $(chkObject).removeClass("fa-check");
                    $(chkObject).addClass("fa-remove");
                }
                // window.location.replace("<?php echo base_url("admin/grading_result/permissionteacher") ?>");
            }
        });
        
	}

    function changeall(e, index, permission)
    {
        e.preventDefault();
        let level_id = $("#level_id").val();
        let chkObject = e.target;
        if($(e.target).hasClass("btn"))
        {
            chkObject = $(e.target).children()[0];
        }
        permission = $(chkObject).parent().attr("curval");
        if($("#level_id").val()==0)
        {
            alert("please select any level first");
            return;
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/grading_result/changeallpermission',
            data: {
                permission : permission,
                level_id : level_id,
                index : index
            },
            dataType: 'JSON',
            success: function(res) {
                successMsg(res.message);
                
                if($(chkObject).hasClass("fa-remove"))
                {
                    $(chkObject).removeClass("fa-remove");
                    $(chkObject).addClass("fa-check");
                    $(chkObject).attr("curval", 1);
                }
                else
                {
                    $(chkObject).removeClass("fa-check");
                    $(chkObject).addClass("fa-remove");
                    $(chkObject).attr("curval", 0);
                }

                window.location.reload();
            }
        });

    }
    (function($) {
        
        $(document).ready(function() {
			/*
			initDatatable(_selector,_url,params={},rm_export_btn=[],pageLength=100,aoColumnDefs=[{ "bSortable": false, "aTargets": [ -1 ] ,'sClass': 'dt-body-right'}],searching=true,aaSorting=[],dataSrc="data")
			*/
            /*initDatatable('teacher-list', 'admin/grading_result/getteacherslist', [], ['btn-all'], 80,
                [{ "bSearchable":true, "bSortable": false, "aTargets": [ 1 , 2, 3 , 4 ] ,
                'sClass': 'dt-body-left'}],searching=true,aaSorting = []);
            */
            initDatatable('teacher-list', 'admin/grading_result/getteacherslist<?php echo !empty($selected_level_id) ? "/".$selected_level_id : "" ?>', [], ['btn-all'], 80,
                [{ "bSearchable":true, "bSortable": false, "aTargets": [ <?php for($i = 0; $i < count($levelperiod_list); $i ++) { if($i!=0) print(","); print($i+1); } ?> ] ,
                    'sClass': 'dt-body-left'}], searching=true, aaSorting = []
            );
        });
    }(jQuery))
</script>