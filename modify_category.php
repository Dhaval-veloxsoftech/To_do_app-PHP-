<?php

require 'connect.php';


if (isset($_REQUEST['cate_name'])) {
    $cate_name= ($_REQUEST['cate_name']) ? $_REQUEST['cate_name'] : NULL;
}

if (isset($_REQUEST['cmd'])) {
    $cmd = ($_REQUEST['cmd']) ? $_REQUEST['cmd'] : NULL;
}
// $task_name $due_date $category $task_description

if($cmd=='add')
{
$qry = "insert into categories (cate_name) value('".$cate_name."')";
$res = mysqli_query($con, $qry);
}
else if($cmd=='delete')
{
$qry = " delete from categories where cate_name='".$cate_name."'";
$res = mysqli_query($con, $qry);
}
else if($cmd=='edit')
{
$arr=explode(",",$cate_name);

$qry = "update categories set cate_name='".$arr[1]."'
          WHERE cate_name='".$arr[0]."'";
$res = mysqli_query($con, $qry);
}

$str="";
if($res==true)
{
  $str="Category ".$cmd."ed ! ";
}
else {
  $str="Opps! Something Wrong !";
}
    echo $str;
     ?>
