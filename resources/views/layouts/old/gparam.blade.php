<?php
//include "includes/dbconn.php";
$rest = "select * from gparam ";
$presult = mysqli_query($conn, $rest);
while ($grow = mysqli_fetch_array($presult)) {
  $id=$grow['id'];

  $day1=$grow['day1'];
  $stime11=$grow['stime11'];
  $etime11=$grow['etime11'];
  $stime12=$grow['stime12'];
  $etime12=$grow['etime12'];
  $holiday1=$grow['holiday1'];

  $day2=$grow['day2'];
  $stime21=$grow['stime21'];
  $etime21=$grow['etime21'];
  $stime22=$grow['stime22'];
  $etime22=$grow['etime22'];
  $holiday2=$grow['holiday2'];

  $day3=$grow['day3'];
  $stime31=$grow['stime31'];
  $etime31=$grow['etime31'];
  $stime32=$grow['stime32'];
  $etime32=$grow['etime32'];
  $holiday3=$grow['holiday3'];

  $day4=$grow['day1'];
  $stime41=$grow['stime41'];
  $etime41=$grow['etime41'];
  $stime42=$grow['stime42'];
  $etime42=$grow['etime42'];
  $holiday4=$grow['holiday4'];

  $day5=$grow['day5'];
  $stime51=$grow['stime51'];
  $etime51=$grow['etime51'];
  $stime52=$grow['stime52'];
  $etime52=$grow['etime52'];
  $holiday5=$grow['holiday5'];

  $day6=$grow['day1'];
  $stime61=$grow['stime61'];
  $etime61=$grow['etime61'];
  $stime62=$grow['stime62'];
  $etime62=$grow['etime62'];
  $holiday6=$grow['holiday6'];

  $day7=$grow['day7'];
  $stime71=$grow['stime71'];
  $etime71=$grow['etime71'];
  $stime72=$grow['stime72'];
  $etime72=$grow['etime72'];
  $holiday7=$grow['holiday7'];

  $messg=$grow['messg'];

  $content=$grow['content'];
  }
?>

