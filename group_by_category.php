<?php
require "connect.php";

if (isset($_REQUEST['order'])) {
    $order = ($_REQUEST['order']) ? $_REQUEST['order'] : NULL ;
}
if (isset($_REQUEST['work_finished'])) {
    $work_finished = ($_REQUEST['work_finished']) ? $_REQUEST['work_finished'] : NULL ;
}

$zero="0000-00-00 00:00:00";
     if($work_finished=='true') {
            $qry3 = "SELECT * FROM  task_info INNER JOIN categories
                        where task_info.cate_id=categories.cate_id
                        and ending_time!='".$zero."'
                        order by  task_info.cate_id ".$order;
                      }
        else{
          $qry3 = "SELECT * FROM  task_info INNER JOIN categories
                      where task_info.cate_id=categories.cate_id
                      and ending_time='".$zero."'
                      order by  task_info.cate_id ".$order;
        }

echo"<script>";
echo"alert('$qry3')";
echo"</script>";
$res3 = mysqli_query($con, $qry3);

$str="";
$i=0;
$cmd='';
$c=0;

 while ($row3 = mysqli_fetch_array($res3)) {
   $i++;


if($row3['starting_time']=='0000-00-00 00:00:00')
  {
  $bg='bg-light';$d_p_one='block';$d_p_two='none';
  }
else
 {

     if( $row3['ending_time']!='0000-00-00 00:00:00'  )
     {
           $bg='bg-success'; $d_p_one='none';$d_p_two='none';
     }
     else
     {
            $bg='bg-warning'; $d_p_one='none';$d_p_two='block';
     }



  }


  if ( $c !=  $row3['cate_id'] ) {

           if($c != 0) {  $str.="</div>";}
           $c =  $row3['cate_id'];
          $str.=" <h5 class='modal-title text-centered text-white border-danger'>".$row3['cate_name']." : </h5>
                          <div class='card-columns p-2'>  ";

    }

  $str.="
       <div class='card text-center card ".$bg." m-2 p-1 ' id='full_card' >
               <div class='card-header'>

                  <button type='button' style='display :".$d_p_one.";' class='close float-left'
                  aria-label='start'  onclick='start_task(".$row3['task_id'].")'>
                 <span  id='cross' aria-hidden='true'>&#9656;</span>
                  </button>
                  <button type='button' style='display :".$d_p_two.";' class='close float-left'
                  aria-label='finish'  onclick='finish_task(".$row3['task_id'].")'>
                 <span  id='cross' aria-hidden='true'>&#9724;</span>
                  </button>

                    <span class='text-muted'> ".$row3['cate_name']."</span>

                    <button type='button' class='close float-right' aria-label='Close'  onclick='delete_card(".$row3['task_id'].")'>
                      <span  id='cross' aria-hidden='true'>&times;</span>
                    </button>

              </div>
               <div class='card-body' >
                  <h4 class='card-title'><span class='text-muted'>[".$i."]</span> ".$row3['task_name']."</h4>
                  <p class='card-text'>".$row3['description']."</p>
              </div>


              <div class='card-footer text-muted text-centered'>

               <span> DUE DATE:  ".$row3['due_date']." </span>
               <button type='button' class='close float-right' aria-label='Edit'  onclick='edit_modal(".$row3['task_id'].")'>
                 <span aria-hidden='true'>&#128393;</span>
               </button>
              </div>

         </div>
        ";
      }

    echo $str;
?>
