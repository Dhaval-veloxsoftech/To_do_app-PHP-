<?php

require 'connect.php';

date_default_timezone_set("Asia/Calcutta");

// $task_name = "";
// $category= "";
// $due_date  = "";
// $task_description= "";

$dt = Date("Y-m-d h:i:s");
$cur_date= Date("Y-m-d");
$cur_time=Date("h:i:s");


if (isset($_REQUEST['task_id']))
{
    $task_id = ($_REQUEST['task_id']) ? $_REQUEST['task_id'] : NULL;
}
if (isset($_REQUEST['task_name'])) {
    $task_name = ($_REQUEST['task_name']) ? $_REQUEST['task_name'] : NULL;
}
if (isset($_REQUEST['due_date'])) {
    $due_date = ($_REQUEST['due_date']) ? $_REQUEST['due_date'] : NULL;
}
if (isset($_REQUEST['task_description'])) {
    $task_description = ($_REQUEST['task_description']) ? $_REQUEST['task_description'] : NULL;
}

if (isset($_REQUEST['category'])) {
    $category = ($_REQUEST['category']) ? $_REQUEST['category'] : NULL;
}
// $task_name $due_date $category $task_description

$qry = "SELECT cate_id FROM categories
          WHERE cate_name='$category'";
$res = mysqli_query($con, $qry);



if($row = mysqli_fetch_array($res))
{
$cate_id=$row['cate_id'];
}
else {
  $q = "INSERT INTO `categories`( `cate_name`)
                 VALUES ( '$category')";
  mysqli_query($con, $q);
  $cate_id= mysqli_insert_id($con);
}



$qry2 = "UPDATE task_info SET cate_id='$cate_id',
                            task_name='$task_name',
                            description='$task_description',
                            due_date='$due_date'
                            where task_id=$task_id";

$res2= mysqli_query($con, $qry2);

if($res2==true)
{
  $str="Task Edited Succesfully";
}
else {
  $str="Opps! Something Wrong !";
}
echo $str;

 ?>
