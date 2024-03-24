<?php

function get_lesson_timezone($timezone) {
    foreach(TIME_AMPM as $row)
    {
        if($row['id']==$timezone) return $row['name'];
    }
    return "";
}

?>