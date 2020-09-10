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

$qry2 = "INSERT INTO task_info(`cate_id`, `task_name`, `description`, `due_date`)
               VALUES ( '$cate_id','$task_name', '$task_description', '$due_date')";
$res= mysqli_query($con, $qry2);

if($res==true)
{
  $str="Task Added Succesfully";
}
else {
  $str="Opps! Something Wrong !";
}
echo $str;
// echo"<script>";
// echo"alert('$uid')";
// echo"</script>"
// $qry3 = "SELECT * FROM  task_info INNER JOIN categories  where task_info.cate_id=categories.cate_id order by task_id desc";
// $res3 = mysqli_query($con, $qry3);
// $str="";
//  while ($row = mysqli_fetch_array($res3)) {
//
//
//   $str.="
//        <div class='card text-center card text-white bg-success mb-3'>
//            <div class='card-header'>
//                  <i>".$row['cate_name']."</i>
//           </div>
//
//           <div class='card-body'>
//             <h5 class='card-title'> <b>".$row['task_name']."</b></h5>
//             <p class='card-text'>".$row['description']."</p>
//
//             <div> <a href='#' class='btn btn-primary'>Edit</a>
//               <a href='#'class='btn btn-primary'>Cancle</a> </div>
//             </div>
//           </div>
//
//            <div class='card-footer text-muted text-centered'>
//                <p>   ".$row['due_date']." <p>
//            </div>
//
//          </div>
//         ";
//       }



 ?>
