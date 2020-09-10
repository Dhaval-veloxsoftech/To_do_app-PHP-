<?php

require 'connect.php';


if (isset($_REQUEST['task_id'])) {
    $task_id = ($_REQUEST['task_id']) ? $_REQUEST['task_id'] : NULL;
}

// $task_name $due_date $category $task_description


$qry5 = "SELECT * FROM  task_info INNER JOIN categories
                  where task_info.cate_id=categories.cate_id
                  and
                   task_id=".$task_id;
$res5 = mysqli_query($con, $qry5);

if($res5==true)
{   $row5=mysqli_fetch_array($res5);
       $str=$row5[0]."/".$row5[1]."/".$row5[2]."/".$row5[3]."/".$row5[4]."/"
       .$row5[5]."/".$row5[6]."/".$row5[7]."/".$row5[8]."";

}
else {
    $str= "Opps! Something Wrong !";
}

  echo $str;
