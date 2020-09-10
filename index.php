<?php
//for database connection
require 'connect.php';

$qry4 = "SELECT * FROM  categories order by cate_id ";
$res4 = mysqli_query($con, $qry4);
$cate=[];
$i=0;
while($row4= mysqli_fetch_array($res4))
{
      $cate[$i]=$row4[1];
      $i++;
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">


      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


    <title>TO DO LIST</title>

    <style media="screen">


    </style>

    <script>


    $(document).ready(function () {
          sortby();
        });

     function edit_modal(id)
       {

          $.ajax({
                 url: "update_modal.php",
                 data: {task_id:id},
                success: function (data) {
                    str=data;
                    var parts= str.split("/");


                    $('#new_task_name').val(parts[2]);
                    $('#new_due_date').val(parts[4]);
                    $('#new_category').val(parts[8]);
                    $('#new_task_description').val(parts[3]);
                    $('#edit_task_id').val(parts[0]);
                    $('#edit_task_modal').modal('toggle');

                  }
            });

        }


        function delete_card(task_id)
        {
          $.ajax({

                       url: "delete_task.php",
                       data: {task_id:task_id},
                      success: function (data) {
                          alert(data);
                          sortby();
                        }
                  });

        }


        function edit_task()
            {
                    task_name = $('#new_task_name').val();
                   due_date = $('#new_due_date').val();
                     category= $('#new_category').val();
                     task_description = $('#new_task_description').val();
                    t_id = $('#edit_task_id').val().trim();


                    $.ajax({

                                 url: "edit_task.php",
                                 data: {task_id:t_id,task_name:task_name,due_date:due_date,task_description:task_description,category:category},
                                  success: function (data) {
                                    alert(data);
                                    sortby();
                                  }
                            });
                }



      function start_task(task_id)
                 {
                    var cmd="start";
                    $.ajax({

                                 url: "modify_task.php",
                                 data: {task_id:task_id,cmd:cmd},
                                  success: function (data) {
                                    alert(data);
                                    sortby();
                                  }
                            });
                }

                function finish_task(task_id)
                           {

                            // var parts=str.split(" ");
                              var cmd="finish";
                              $.ajax({

                                           url: "modify_task.php",
                                           data: {task_id:task_id,cmd:cmd},
                                            success: function (data) {
                                              alert(data);
                                              sortby();
                                            }
                                      });
                          }


        function delete_category()
            {

              var cate_name=document.getElementById('delete_cate_name').value;


                  $.ajax({

                                 url: "modify_category.php",
                                 data: {cate_name:cate_name,cmd:'delete'},
                                 success: function (data) {
                                  alert(data);
                                location.reload();
                                  }
                          });

            }

            function edit_category()
                {

                  var old=document.getElementById('old_cate_name').value;
                    var nw=document.getElementById('edit_cate_name').value;
                    var cate_name= old+","+nw;
                      $.ajax({

                                     url: "modify_category.php",
                                     data: {cate_name:cate_name,cmd:'edit'},
                                     success: function (data) {
                                      alert(data);
                                    location.reload();
                                      }
                              });

                }


                function add_category()
                    {

                      var cate_name=document.getElementById("add_cate_name").value;
                          $.ajax({

                                         url: "modify_category.php",
                                         data: {cate_name:cate_name,cmd:'add'},
                                         success: function (data) {
                                                  alert(data);
                                                  location.reload();
                                          }
                                  });

                    }



                    function group_by()
                     {

                         if(   document.getElementById('grp_by_button').checked==true)
                             {      order= document.getElementById('order_by').checked ;

                                    if(order==true)
                                      {  order = 'asc';}
                                    else {
                                           order='desc';
                                         }

                                           $("#"+ 'task_area').html("");
                                             $("#"+ 'done_task_area').html("");
                                               $("#" + 'group_task_area').html("");

                                    $.ajax({
                                            url: "group_by_category.php",
                                            data:{order:order,work_finished:'false'},
                                              success: function (data)
                                                {
                                                    $("#" + 'group_task_area').html(data);

                                                  }
                                            });

                                            $.ajax({
                                                    url: "group_by_category.php",
                                                    data:{order:order,work_finished:'true'},
                                                      success: function (data)
                                                        {
                                                            $("#" + 'group_done_task_area').html(data);

                                                          }
                                                    });
                              }
                          else
                          {     sortby();     }


                     }

     function sortby( )
       {
          cate_type= document.getElementById('cate_select').value;
          order= document.getElementById('order_by').checked;
          grp=document.getElementById('grp_by_button');

                    if(grp.checked==true)
                    {
                         group_by();
                    }
                    else {
                      load_data(cate_type,order)
                    }


       }


        function load_data(cate_type,order)
         {

               if(cate_type=='All Category') { cate_type='%';}
               if(order==true)
               {  order = 'asc';}
               else {
                 order='desc';
               }


            $.ajax({

                         url: "load_data.php",
                         data: {cate_type:cate_type,order:order},
                        success: function (data) {
                          $("#" + 'task_area').html(data);
                          $("#"+'group_task_area').html("");

                          }
                    });

                    $.ajax({

                                 url: "done_load_data.php",
                                 data: {cate_type:cate_type,order:order},
                                success: function (data) {
                                  $("#" + 'done_task_area').html(data);
                                    $("#" + 'group_done_task_area').html("");
                                  }
                            });

         }


            function add_task()
             {
                task_name = $('#task_name').val();
               due_date = $('#due_date').val();
                 category= $('#category').val();
                 task_description = $('#task_description').val();

                $.ajax({

                             url: "add_new_task.php",
                             data: {task_name:task_name,due_date:due_date,task_description:task_description,category:category},
                              success: function (data) {
                                alert(data);
                                sortby();
                              }
                        });
                              var d=new Date();
                         $('#task_name').val("");
                         $('#due_date').val(d);
                         $('#category').val("");
                         $('#task_description').val("");
               }

</script>


  </head>
<body class='bg-dark'>
  <!-- //there will 2 rows : 1 functionality bar
                          2 taskarea -->

<div class="container">

<!-- 1st row : functionality bar starts here -->
          <div class="p-2 m-2 btn-toolbar justify-content-between" role="toolbar">
            <div class="btn">


                            <input data-toggle="toggle" data-onstyle="outline-primary" data-offstyle="outline-primary" type="checkbox"  onchange="sortby()"
                                  data-on="Ascending" data-off="Descending" data-style="slow"
                                 id="order_by"  name="order_by" >
            </div>


            <div class="btn ">


                            <input data-toggle="toggle" data-onstyle="outline-primary" data-offstyle="outline-primary" type="checkbox"  onchange="group_by()"
                                  data-on="Group by" data-off="Normal" data-style="slow"
                                 id="grp_by_button"  name="grp_by_button" >
            </div>

              <div class="dropdown btn">
                     <select class="form-control btn-outline-primary" id="cate_select" name="cate_select"  onchange="sortby()">
                          <option>All Category</option>
                        <?php
                            $i=0;
                         while( $i < sizeof($cate)){ ?>
                            <option  value="<?php echo $cate[$i] ?>">  <?php echo $cate[$i] ?> </option>
                          <?php    $i++;             } ?>
                     </select>

            </div>



            <div class="btn ">

                  <button type="button" class="btn btn-outline-primary w-100 rounded " data-toggle="modal" data-target="#task_modal"> Add Task </button>

            </div>



            <div class=" btn">

                  <button type="button" class="btn btn-outline-primary w-100 rounded " data-toggle="modal" data-target="#modify_cate_modal"> Modify Category </button>

            </div>
          </div>
<!-- 1st row : functionality bar ends here-->

          <h4 class="modal-title text-centered text-white border-danger">TASK AREA  : </h4>
<!-- //2nd row : taskarea starts here -->
          <div class="card-columns p-2 " id="task_area"> </div>
            <div id="group_task_area"> </div>


          <h4 class="modal-title text-centered text-white"> FINISHED TASK  : </h4>
<!-- //3rd row : finsihed area starts here -->
          <div class="card-columns p-2  " id="done_task_area"></div>
               <div id="group_done_task_area"> </div>

<!-- container ends here -->
  </div>


<!-- //edit task modal-->
  <div id="edit_task_modal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog-centered " role="document">
      <!-- Modal content-->

      <div class="modal-content text-white bg-dark">

       <form  method="post" enctype="multipart/form-data" style="width:100%;">

        <div class="modal-header">
          <h4 class="modal-title">Edit Task Details</h4>
          <button type="button" class="close float-right" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

                  <div class="form-group">

                              <input id="edit_task_id" type="hidden" name="edit_task_id" >
                              <input id="new_task_name" type="text" class="form-control" name="task_name" placeholder="new_task_name">
                  </div>
                  <div class="form-group">
                              <input id="new_task_description" type="textarea" class="form-control" name="new_task_description"  placeholder="Description">
                  </div>

                  <div class="row">

                        <div class="form-group col-sm-6">



                              <input type="date" name="new_due_date" id="new_due_date" class="form-control">
                              <script>
                                $('new_due_date').datepicker();
                              </script>
                        </div>

                        <div class="form-group col-sm-6">
                              <!-- <input id="new_category" type="text" class="form-control" name="new_category" placeholder="category"> -->
                              <select class="form-control btn-outline-primary" id="new_category" name="new_category" required>
                                   <option  selected disabled>select category</option>
                                   <?php
                                       $i=0;
                                    while( $i < sizeof($cate)){ ?>
                                       <option  value="<?php echo $cate[$i] ?>"> <?php echo $cate[$i] ?></option>
                                     <?php    $i++;             } ?>
                              </select>
                        </div>
                </div>

        </div>

        <div class="modal-footer">
          <button type="submit"  name="edit_task_button" class="btn btn-default btn-outline-primary" data-dismiss="modal"  onclick="edit_task()"> EDIT </button>
        </div>

      </form>

      </div>

    </div>
  </div>

<!-- //add task modal-->
  <div id="task_modal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog-centered " role="document">
      <!-- Modal content-->

      <div class="modal-content text-white bg-dark">

       <form  method="post" enctype="multipart/form-data" style="width:100%;">

        <div class="modal-header">
          <h4 class="modal-title">Add Task Details</h4>
          <button type="button" class="close float-right" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body">

                  <div class="form-group">

                              <input id="task_name" type="text" class="form-control" name="task_name" placeholder="Task Name">
                  </div>
                  <div class="form-group">
                              <input id="task_description" type="textarea" class="form-control" name="task_description"  placeholder="Description">
                  </div>

                  <div class="row">

                        <div class="form-group col-sm-6">

                              <input type="date" name="due_date" id="due_date" placeholder="enter a date"
                                       class="form-control">

                                       <script>
                                        $('#datepicker').datepicker();
                                      </script>
                        </div>

                        <div class="form-group col-sm-6">

                           <select class="form-control btn-outline-primary" id="category" name="category" required>
                               <option  selected disabled>select category</option>
                               <?php
                                   $i=0;
                                while( $i < sizeof($cate)){ ?>
                                   <option  value="<?php echo $cate[$i] ?>"> <?php echo $cate[$i] ?></option>
                                 <?php    $i++;             } ?>
                          </select>

                        </div>
                </div>

        </div>

        <div class="modal-footer">
          <button type="submit"  name="add_task_button" class="btn btn-default btn-outline-primary " data-dismiss="modal"  onclick="add_task()"> ADD </button>
        </div>

      </form>

      </div>

    </div>
  </div>

<!-- //modify category modal-->
<div id="modify_cate_modal" class="modal fade " role="dialog">
 <div class="modal-dialog modal-dialog-centered " role="document">
    <!-- Modal content-->

   <div class="modal-content text-white bg-dark">

    <form  method="post" enctype="multipart/form-data" style="width:100%;">

       <div class="modal-header">
                      <h4 class="modal-title">Modify Category</h4>

                      <button type="button" class="close float-right" data-dismiss="modal">&times;</button>

              </div>

       <div class="modal-body">
           <nav class="nav-justified">
               <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-add-tab" data-toggle="tab" href="#nav-add" role="tab" aria-controls="nav-add" aria-selected="true">Add</a>
                    <a class="nav-item nav-link" id="nav-edit-tab" data-toggle="tab" href="#nav-edit" role="tab" aria-controls="nav-edit" aria-selected="false">Edit</a>
                    <a class="nav-item nav-link" id="nav-delete-tab" data-toggle="tab" href="#nav-delete" role="tab" aria-controls="nav-delete" aria-selected="false">Delete</a>
                 </div>

             </nav>

          <div class="tab-content" id="nav-tabContent">
               <div id="nav-add" class="tab-pane fade show active"  role="tabpanel" aria-labelledby="nav-add-tab">
                 <div class="row p-2 m-2">
                     <div class="form-group col-sm-8 p-3">
                             <input id="add_cate_name" type="text" class="form-control " name="add_cate_name" placeholder="Enter New Category">
                         </div>

                     <div class="form group col-sm-4 p-3">
                          <button type="submit"  name="add_cate_button" class="btn btn-default btn-outline-primary" data-dismiss="modal"  onclick="add_category()"> ADD </button>

                        </div>

                     </div>


                   </div>

               <div id="nav-edit" class="tab-pane fade"  role="tabpanel" aria-labelledby="nav-edit-tab">

                  <div class="row p-2 m-2">
                        <div class="col-sm-12 p-3">
                            <select class="form-control btn-outline-primary w-100" id="old_cate_name" name="old_cate_name" required>
                                <option  selected disabled>select category</option>
                                  <?php
                                      $i=0;
                                        while( $i < sizeof($cate)){ ?>
                                            <option  value="<?php echo $cate[$i] ?>"> <?php echo $cate[$i] ?></option>
                                  <?php    $i++;             } ?>
                              </select>
                        </div>

                         <script>

                         $("#old_cate_name").change(function(){
                           var inp=document.getElementById("edit_cate_name");
                           inp.value=$(this).val() ;

                         });

                       </script>

                      </div>


                  <div class="row p-2 m-2">
                      <div class="form-group col-sm-8 p-3">
                              <input id="edit_cate_name" type="text" class="form-control " name="edit_cate_name" placeholder="Enter New Category">
                          </div>

                      <div class="form group col-sm-4 p-3">
                           <button type="submit"  name="edit_cate_button" class="btn btn-default btn-outline-primary" data-dismiss="modal"onclick="edit_category()" > EDIT </button>

                         </div>

                      </div>


                </div>

               <div id="nav-delete" class="tab-pane fade"  role="tabpanel" aria-labelledby="nav-delete-tab">
                     <div class="row p-3 m-2">
                         <div class="form-group col-sm-8 ">

                      <select class="form-control btn-outline-primary" id="delete_cate_name" name="delete_cate_name" required>
                          <option  selected disabled>select category</option>
                              <?php
                                $i=0;
                                while( $i < sizeof($cate)){ ?>
                           <option  value="<?php echo $cate[$i] ?>"> <?php echo $cate[$i] ?></option>
                                <?php    $i++;             } ?>
                         </select>

                     </div>

                        <div class="form group col-sm-4 ">
                     <button type="submit"  name="delete_cate_button" class="btn btn-default btn-outline-primary" data-dismiss="modal" onclick="delete_category()"> DELETE </button>
                   </div>

                       </div>
                  </div>

             </div>
          </div>

       <div class="modal-footer">

          </div>

      </form>

    </div>

  </div>
</div>


</body>
</html>
