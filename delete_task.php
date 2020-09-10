<?php

require 'connect.php';

date_default_timezone_set("Asia/Calcutta");


$dt = Date("Y-m-d h:i:s");
$cur_date= Date("Y-m-d");
$cur_time=Date("h:i:s");




if (isset($_REQUEST['task_id'])) {
    $task_id = ($_REQUEST['task_id']) ? $_REQUEST['task_id'] : NULL;
}

// $task_name $due_date $category $task_description

$qry = "delete FROM task_info
          WHERE task_id=".$task_id;
$res = mysqli_query($con, $qry);



$str="";
if($res==true)
{
  $str="Task Deleted Succesfully";
}
else {
  $str="Opps! Something Wrong !";
}
    echo $str;
     ?>
