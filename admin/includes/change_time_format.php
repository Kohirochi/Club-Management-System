<?php

// Change the format of time taken from database
function change_time_format($time)
{
    $time = new DateTime($time);
    $new_time = $time->format('H:i');
    return $new_time;
}