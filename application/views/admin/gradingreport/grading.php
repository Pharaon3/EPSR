<?php 
    $url = $_SERVER["REQUEST_URI"];
       $actionUrl = 'admin/grading_result/GradingReport';
  //  if (str_contains($url, 'GradingReport')) $actionUrl = 'admin/grading_result/GradingReport';
?>
<div class="content-wrapper" style="min-height: 946px;">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">

                        <form role="form" action="<?php echo site_url($actionUrl) ?>" method="post">

                            <?php echo $this->customlib->getCSRF(); ?>

                            <div class="row">
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="searchclassid" name="class_id" onchange="getSectionByClass(this.value, 0, 'secid')" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                            ?>
                                                <option <?php
                                                        if ($class_id == $class["id"]) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $class['id'] ?>"><?php echo $class['class'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="class_id_error text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>

                                </div><!--./col-md-3-->
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select id="section_id" name="section_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($sectionlist as $section) {
                                            ?>
                                                <option <?php
                                                        if ($section_id == $section["id"]) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $section['id'] ?>"><?php echo $section['section'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <!-- session dropdown -->
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('session'); ?></label><small class="req"> *</small>
                                        <select id="session_id" name="session_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($session_list as $session) {
                                            ?>
                                                <option <?php
                                                        if ($session_id == $session["id"]) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $session['id'] ?>"><?php echo $session['session'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="session_id_error text-danger"><?php echo form_error('session_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" name="search" value="search_filter" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <?php
                    if (isset($subject_list)) {
                    ?>
                        <div class="box-body">

                            <div class="box-header ptbnull"></div>
                            <h4 class="box-title box-title"><?php echo $this->lang->line('Grading'); ?></h4>
                            <div class="box-header ptbnull">
                                <button id="print_report_btn" onclick="print()" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-print"></i> <?php echo $this->lang->line('view'); ?></button>
                            </div>
                            <div class="table-responsive mailbox-messages">
                                <div id="grading_table">
                                    <table class="table table-hover table-striped table-bordered example" id="subjects_table">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Class') ?></th>
                                                <!-- <th id="section"><?php echo $this->lang->line('section') ?></th> -->
                                                <th id="no"><?php echo $this->lang->line('no'); ?></th>
                                                <th><?php echo $this->lang->line('name'); ?></th>
                                                <?php
                                                $subjectCount = 0;
                                                foreach ($subject_list as $key => $subject) {
                                                    $subjectCount++;
                                                ?>
                                                    <th><?php echo $subject->name; ?></th>
                                                <?php
                                                }
                                                ?>
                                                <th><?php echo $this->lang->line('average'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($studentlist)) {
                                                $i = count($studentlist) - 1;
                                                $number = 1;
                                                while ($i > 0) {

                                            ?>
                                                    <tr>
                                                        <td><?php echo substr($curse, 0, 1); ?></td>
                                                        <td><?php
                                                            $index = 0;
                                                            while ($index < count($students)) {
                                                                if ($students[$index]['fullname'] == $studentlist[$i]['fullname'])
                                                                    break;
                                                                $index++;
                                                            }
                                                            echo $index + 1;
                                                            ?></td>
                                                        <td><?php echo $studentlist[$i]['firstname'] . " " . $studentlist[$i]['lastname']; ?></td>
                                                        <?php

                                                        $avarageTotal = 0;
                                                        $averageCF = 1;
                                                        


                                                        foreach ($subject_list as $key => $subject) {
                                                        ?>
                                                            <th><?php 
                                                            for ($j = count($subject_list) - 1; $j >= 0; $j--) {
                                                                if ($studentlist[$i - $j]["name"] == $subject->name) {
                                                                    $avarageTotal += $studentlist[$i - $j]["CF"];
                                                                    echo $studentlist[$i - $j]["CF"];
                                                                }
                                                            }
                                                            ?></th>
                                                        <?php
                                                        }


                                                        ?>
                                                        <td><?php  echo round (( $avarageTotal / $subjectCount),2); ?></td>
                                                    </tr>
                                            <?php

                                                    $i -= count($subject_list);
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function print() {
        var base_url = '<?php echo base_url() ?>';
        var section_id = $('#section_id').val();
        var class_id = $('#searchclassid').val();
        var session_id = $('#session_id').val();
        let url = base_url + "admin/grading_result/printGradingResult";

        var path = window.location.pathname;
        var parts = path.split('/');
        var lastPart = parts[parts.length - 1];
        lastPart = lastPart.split('?')[0];
        if (lastPart == "GradingReport") {
            url = base_url + "admin/grading_result/printGradingReport";
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                section_id: section_id,
                class_id: class_id,
                session_id: session_id,
            }, // serializes the form's elements.
            dataType: "JSON", // serializes the form's elements.
            success: function(response) {
                //console.log(response);
                Popup(response.page);
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
            }
        });
    }

    function Popup(data) {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";

        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/idcard.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write("<table>");
        frameDoc.document.write(data);
        frameDoc.document.write("</table>");
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function() {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
    $(document).ready(function() {
        $.extend($.fn.dataTable.defaults, {
            searching: true,
            ordering: true,
            paging: false,
            retrieve: true,
            destroy: true,
            info: false
        });

        $('#subjects_table').DataTable({
            "columnDefs": [
                //{ "orderable": false, "targets": [2] },
                {
                    "orderable": true,
                    "targets": 12
                }
            ],
            order: [[12, 'desc']]
        });
    });
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
