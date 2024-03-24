<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('grading_competences'); ?> <small><?php echo $this->lang->line('competence'); ?></small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info" style="padding:5px;">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                        <div class="pull-right box-tools">                            
                            <a href="<?php echo site_url('admin/grading_competence/exportformat') ?>">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-download"></i> <?php echo $this->lang->line('dl_sample_import'); ?></button>
                            </a>
                        </div>
                    </div>
                    <div class="box-body">      
                        <?php if ($this->session->flashdata('msg')) { ?> <div>  <?php echo $this->session->flashdata('msg') ?> </div> <?php } ?><br/>
                        1. <?php echo $this->lang->line('import_grading_competence_step1'); ?><br/>
                        2. <?php echo $this->lang->line('import_grading_competence_step2'); ?><br/>
                        3. <?php echo $this->lang->line('import_grading_competence_step3'); ?><br/>
                        4. <?php echo $this->lang->line('import_grading_competence_step4'); ?><br/>
                        5. <?php echo $this->lang->line('import_grading_competence_step5'); ?><br/>
                        <hr/></div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="sampledata">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($fields as $key => $value) {
                                        echo $value; ?>
                                        <th><?php echo $add . "<span>" . $value . "</span>"; ?>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php foreach ($fields as $key => $value) {
                                        ?>    
                                        <td><?php echo "Sample Data" ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>

                        </table>        
                    </div>
                    <hr/> 
                    <form action="<?php echo site_url('admin/grading_competence/import') ?>"  id="competenceform" name="competenceform" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('level'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="level_id" name="level_id" onchange="getClsByLevel(this.value, 0)" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($levelList as $level) {
                                            ?>
                                                <option <?php if (set_value('level_id') == $level["id"])  echo "selected"; ?> value="<?php echo $level['id'] ?>"><?php echo $level['level'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="class_id_error text-danger"><?php echo form_error('level_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                    <select id="class_id" name="class_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                    <span class="class_id_error text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile"><?php echo $this->lang->line('select_csv_file'); ?></label><small class="req"> *</small>
                                        <div><input class="filestyle form-control" type='file' name='file' id="file" size='20' />
                                            <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                                    </div></div>
                                <div class="col-md-6 pt20">
                                    <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('import_competences'); ?></button>
                                </div>     
                            </div>
                        </div>
                    </form>
                    <div>
                    </div>
                </div>
                </section>
            </div>

            <script type="text/javascript">
                function getClsByLevel(level_id, class_id) {
                    if (level_id != "") {
                        $('#class_id').html("");
                        var base_url = '<?php echo base_url() ?>';
                        var cls_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                        $.ajax({
                            type: "GET",
                            url: base_url + "admin/grading_competence/getByLevel",
                            data: {
                                'level_id': level_id
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#class_id').addClass('dropdownloading');
                            },
                            success: function(data) {
                                $.each(data.class, function(i, obj) {
                                    var sel = "";
                                    if (class_id == obj.id) {
                                        sel = "selected";
                                    }
                                    cls_data += "<option value=" + obj.id + " " + sel + ">" + obj.class + "</option>";
                                });
                                $('#class_id').html(cls_data);
                            },
                            complete: function() {
                                $('#class_id').removeClass('dropdownloading');
                            }
                        });
                    }
                }
                $(document).ready(function () {
                    $("#sampledata").DataTable({
                        searching: false,
                        ordering: false,
                        paging: false,
                        bSort: false,
                        info: false, });

                    var level_id = $('#level_id').val();
                    var class_id = '<?php echo set_value('class_id') ?>';
                    getClsByLevel(level_id, class_id);
                });
            </script>