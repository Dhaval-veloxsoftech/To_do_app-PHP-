<?php

require 'connect.php';

date_default_timezone_set("Asia/Calcutta");


$dt = Date("Y-m-d h:i:s");
$cur_date= Date("Y-m-d");
$cur_time=Date("h:i:s");




if (isset($_REQUEST['task_id'])) {
    $task_id = ($_REQUEST['task_id']) ? $_REQUEST['task_id'] : NULL;
}

if (isset($_REQUEST['cmd'])) {
    $cmd = ($_REQUEST['cmd']) ? $_REQUEST['cmd'] : NULL;
}
// $task_name $due_date $category $task_description

if($cmd=='start')
{
$qry = "update task_info set starting_time='$dt'
          WHERE task_id=".$task_id;
$res = mysqli_query($con, $qry);
}
else if($cmd=='finish')
{
$qry = "update task_info set ending_time='$dt'
          WHERE task_id=".$task_id;
$res = mysqli_query($con, $qry);
}

$str="";
if($res==true)
{
  $str="Task ".$cmd."ed ! ";
}
else {
  $str="Opps! Something Wrong !";
}
    echo $str;
     ?>
