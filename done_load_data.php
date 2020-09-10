<?php
require "connect.php";

date_default_timezone_set("Asia/Calcutta");

$order="";
$cate_type="";

if (isset($_REQUEST['order'])) {
    $order = ($_REQUEST['order']) ? $_REQUEST['order'] : NULL ;
}
if (isset($_REQUEST['cate_type'])) {
    $cate_type = ($_REQUEST['cate_type']) ? $_REQUEST['cate_type'] : NULL ;
}
$zero="0000-00-00 00:00:00";
$qry3 = "SELECT * FROM  task_info INNER JOIN categories
            where task_info.cate_id=categories.cate_id
            and ending_time != '".$zero."'
            and cate_name like '".$cate_type."'
            order by task_id ".$order;
$res3 = mysqli_query($con, $qry3);



$str="";
$i=0;
 while ($row3 = mysqli_fetch_array($res3)) {
   $i++;

  // echo"<script>";
  // echo"alert('$whole')";
  // echo"</script>";


  $str.="
       <div class='card text-center card bg-success m-1 p-2 ' id='full_card' >
               <div class='card-header'>

                    <span >".$row3['cate_name']."</span>

                    <button type='button' class='close float-right' aria-label='Close'  onclick='delete_card(".$row3['task_id'].")'>
                      <span  id='cross' aria-hidden='true'>&times;</span>
                    </button>

              </div>
               <div class='card-body' >
                  <h4 class='card-title'>[".$i."]  </span>".$row3['task_name']."</h4>
                  <p class='card-text'>".$row3['description']."</p>
              </div>


              <div class='card-footer  text-centered'>

               <span> Finished at :   ".$row3['ending_time']." </span>

              </div>

         </div>
        ";
      }

    echo $str;
?>
