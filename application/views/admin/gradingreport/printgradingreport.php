<style type="text/css" media="print">
    @page
    {
        size:  Letter portrait;   /* auto is the initial value */
        margin: 10mm;  /* this affects the margin in the printer settings */
    }

</style>

<style type="text/css">
    body {
        counter-reset: section;                     /* Устанавливает значение
                                                 счётчика, равным 0 */
    }
   
    @media print {
        .pagebreak {
            page-break-before: always;

        }
        tfoot { visibility: hidden; }
        /* page-break-after works, as well */
    }
    @media print {
        @page {
            margin-top: 0;
            margin-bottom: 0;
        }
        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important;  /*Firefox*/
        }
    }
    * {
        padding: 0;
        margin: 0;
    }

   


    .denifittable th {
        padding: 10px 10px;
        font-weight: normal;
        border-collapse: collapse;
        border-right: 1px solid #999;
        border-bottom: 1px solid #999;
    }

    .denifittable td {
        padding: 10px 10px;
        font-weight: bold;
        border-collapse: collapse;
        border-left: 1px solid #999;
    }

    .mark-container {
        width: 1000px;
        position: relative;
        z-index: 2;
        margin: 0 auto;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .pagebreak {
        page-break-before: always;
        counter-increment: section;
    }

    .tablemain {
        padding: 20px;
        position: relative;
        margin-top: 50px;
        z-index: 2
    }
    .tablemain td, .tablemain th {
        border: 1px solid black;
    }
    .tablemain td
    {
        padding: 2px 2px 2px 2px;
        text-align: center;
    }
    .bordertable,
    .bordertable th,
    .bordertable td {
        border: 1px solid black;
        border-collapse: collapse;
    }


    span:before {
        content: '';
        width: 100%;
        height: 3em;
        display: inline-block;
    }

    span {
        display: inline-block; /* Can remove if span:before width doesn't matter. */
    }
    div.sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        padding: 5px;
        background-color: #cae8ca;
        border: 2px solid #4CAF50;
        bottom: 8px;
    }
    .bottomright {
        position: absolute;
        bottom: 8px;
        right: 16px;
        font-size: 18px;
    }
    div.static {
        position: static;
        border: 3px solid #73AD21;
    }

    div.absolute {
        position: absolute;
        width: 50%;
        bottom: 10px;
        border: 3px solid #8AC007;
    }
    div.fixed {
        position: fixed;
        width: 100%;
        bottom: 10px;
        border: 3px solid #8AC007;
    }
    div.relative {
        position: relative;
        width: 50%;
        bottom: 5px;!important;
        margin-top: 500px;
        border: 3px solid #8AC007;
    }
    body{ min-height:100vh; margin:0; position:relative; }
    header{ min-height:50px; background:lightcyan; }
    footer{ background:PapayaWhip; }

    /* Trick: */
    body {
        position: relative;
        counter-reset: section;
    }

    body::after {
        content: '';
        display: block;
        height: 50px; /* Set same as footer's height */
    }

    .break {
        width: 100%;
        height: 50px;
    }

    span::before {
        counter-increment: section;                 /* Increment the value of section counter by 1 */
        content: counter(section) ": ";  /* Display counter value in default style (decimal) */
    }

    .grading_table {
        border-width: 0px;
    }
</style>

<div id="grading_table" class="grading_table">
    <div style="display: flex; margin-left: 20px; margin-top: 20px;"> Clase: <?php echo $class_name; ?> . Sección: <?php echo $section_name; ?> <?php echo $this->lang->line('session');?>: <?php echo $session_name; ?></div>
    <table id="subjects_table" cellpadding="0" cellspacing="0" width="100%" class="tablemain">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('CURSE') ?></th>
                <!-- <th id="section"><?php echo $this->lang->line('section')?></th> -->
                <th id="no"><?php echo $this->lang->line('no'); ?></th>
                <th><?php echo $this->lang->line('name'); ?></th>
                <?php
                 $subjectCount = 0;
                foreach($subject_list as $key => $subject)
                {
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
                while($i > 0) 
                {
                    $number++;
                    ?>
                    <tr>
                        <td><?php echo substr($curse,0,1); ?></td>
                        <!-- <td><?php echo $studentlist[$i]['section']; ?></td> -->
                        <td><?php 
                        $index = 0;
                        while($index < count($students))
                        {
                            if($students[$index]['fullname'] == $studentlist[$i]['fullname'])
                                break;
                            $index++;
                        }
                        echo $index + 1;
                        ?></td>
                        <td><?php echo $studentlist[$i]['firstname']." ".$studentlist[$i]['lastname']; ?></td>
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
                    if( $i < count($studentlist) && $number % 13 == 0)
                    {
                        echo "</tbody>";
                        echo "</table>";
                        echo '<div class="pagebreak"></div>';
                        echo '<div class="break"></div>';
                        echo '<div style="display: flex; margin-left: 20px; margin-top: 20px;"> Clase: ' . $class_name . ' . Sección: ' . $section_name . ' ' . $this->lang->line('session') . ' : ' . $session_name . '</div>';
                        echo '<table cellpadding="0" cellspacing="0" width="100%" class="tablemain" style="margin-top:30px;">
                        <thead>
                            <tr>
                                <th>'. $this->lang->line('CURSE') .'</th>
                                
                                <th id="no">'.$this->lang->line('no').'</th>
                                <th>'.$this->lang->line('name').'</th>';
                                foreach($subject_list as $key => $subject)
                                {
                                   echo '<th>'. $subject->name.'</th>';
                                }
                                echo '<th>'. $this->lang->line('average').'</th>';
                            echo '</tr>
                        </thead><tbody>';
                        
                    }
                    $i -= count($subject_list);
                }
            }
            ?>
        </tbody>
    </table>
</div>
