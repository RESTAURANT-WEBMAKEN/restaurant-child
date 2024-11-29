<?php

namespace Resources\Views\Layouts\Partials\Frontend\Partials;

// Use the Eloquent model
use App\Models\OpeningHour;

global $rollingMessage;
global $id;
global $day1;
global $stime11;
global $etime11;
global $stime12;
global $etime12;
global $holiday1;
global $day2;
global $stime21;
global $etime21;
global $stime22;
global $etime22;
global $holiday2;
global $day3;
global $stime31;
global $etime31;
global $stime32;
global $etime32;
global $holiday3;
global $day4;
global $stime41;
global $etime41;
global $stime42;
global $etime42;
global $holiday4;
global $day5;
global $stime51;
global $etime51;
global $stime52;
global $etime52;
global $holiday5;
global $day6;
global $stime61;
global $etime61;
global $stime62;
global $etime62;
global $holiday6;
global $day7;
global $stime71;
global $etime71;
global $stime72;
global $etime72;
global $holiday7;
global $messg;
global $content;



$rollingMessage = OpeningHour::first();

$id = $rollingMessage->id;

$day1 = $rollingMessage->day1;
$stime11 = $rollingMessage->stime11;
$etime11 = $rollingMessage->etime11;
$stime12 = $rollingMessage->stime12;
$etime12 = $rollingMessage->etime12;
$holiday1 = $rollingMessage->holiday1;

$day2 = $rollingMessage->day2;
$stime21 = $rollingMessage->stime21;
$etime21 = $rollingMessage->etime21;
$stime22 = $rollingMessage->stime22;
$etime22 = $rollingMessage->etime22;
$holiday2 = $rollingMessage->holiday2;

$day3 = $rollingMessage->day3;
$stime31 = $rollingMessage->stime31;
$etime31 = $rollingMessage->etime31;
$stime32 = $rollingMessage->stime32;
$etime32 = $rollingMessage->etime32;
$holiday3 = $rollingMessage->holiday3;

$day4 = $rollingMessage->day1;
$stime41 = $rollingMessage->stime41;
$etime41 = $rollingMessage->etime41;
$stime42 = $rollingMessage->stime42;
$etime42 = $rollingMessage->etime42;
$holiday4 = $rollingMessage->holiday4;

$day5 = $rollingMessage->day5;
$stime51 = $rollingMessage->stime51;
$etime51 = $rollingMessage->etime51;
$stime52 = $rollingMessage->stime52;
$etime52 = $rollingMessage->etime52;
$holiday5 = $rollingMessage->holiday5;

$day6 = $rollingMessage->day1;
$stime61 = $rollingMessage->stime61;
$etime61 = $rollingMessage->etime61;
$stime62 = $rollingMessage->stime62;
$etime62 = $rollingMessage->etime62;
$holiday6 = $rollingMessage->holiday6;

$day7 = $rollingMessage->day7;
$stime71 = $rollingMessage->stime71;
$etime71 = $rollingMessage->etime71;
$stime72 = $rollingMessage->stime72;
$etime72 = $rollingMessage->etime72;
$holiday7 = $rollingMessage->holiday7;

$messg = $rollingMessage->messg;

$content = $rollingMessage->content;

?>
