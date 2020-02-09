<?php

//index.php

include('database_connection.php');

$query = "
 SELECT * FROM task_list
 WHERE username = '".$_SESSION["username"]."'
 ORDER BY task_list_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
 <head>
  <title>Developed To-Do List in PHP using Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
 </head>
 <body>
  <div class="container">
   <h1 align="center" style="margin: 15vh 0; font-size: 3rem;">My To-DO List</h1>
   <div class="panel">
    <div class="panel-heading">
      <div class="panel-title">
       <h3 >My To-Do List</h3>
      </div>
      <div class="panel-login" style="text-align: center;">
       <h3 >Welcome <?php echo $_SESSION['username'];?></h3>
      </div>
      <div class="panel-logout">
        <a href="../registration/index.php?logout='1'" style="color: red; font-weight: 700">Logout</a>
      </div>
    </div>
    <hr/>
      <div class="panel-body">
       <form method="post" id="to_do_form" class="input_form">
        <span id="message"></span>
        <div class="input-group">
         <input type="text" name="task_name" id="task_name" class="input-control" autocomplete="off" placeholder="Title..." />
         <button type="submit" name="submit" id="submit" class="btn"><span class="glyphicon glyphicon-plus">+</span></button>
        </div>
       </form>
       <!-- <br /> -->
       <h4 style="margin: 2vw 0;">Your Tasks</h4>
       <div class="list-group">
       <?php
       foreach($result as $row)
       {
        $style = '';
        if($row["task_status"] == 'yes')
        {
         $style = 'text-decoration: line-through';
        }
        echo '<a href="#" class="list-group-item" id="list-group-item-'.$row["task_list_id"].'" data-id="'.$row["task_list_id"].'">'.'<div class="task_text" style="'.$style.'">'.$row["task_details"].'</div>'.' <span class="badge" data-id="'.$row["task_list_id"].'">X</span></a>';
       }
       ?>
       </div>
      </div>
     </div>
  </div>
 </body>
</html>

<script>

 $(document).ready(function(){

  $(document).on('submit', '#to_do_form', function(event){
   event.preventDefault();

   if($('#task_name').val() == '')
   {
    $('#message').html('<div class="alert alert-danger">Enter Task Details</div>');
    return false;
   }
   else
   {
    $('#submit').attr('disabled', 'disabled');
    $.ajax({
     url:"add_task.php",
     method:"POST",
     data:$(this).serialize(),
     success:function(data)
     {
      $('#submit').attr('disabled', false);
      $('#to_do_form')[0].reset();
      $('.list-group').prepend(data).fadeIn('slow');
     }
    })
   }
  });

  $(document).on('click', '.list-group-item', function(){
   var task_list_id = $(this).data('id');
   $.ajax({
    url:"update_task.php",
    method:"POST",
    data:{task_list_id:task_list_id},
    success:function(data)
    {
     $('#list-group-item-'+task_list_id).css('text-decoration', 'line-through');
    }
   })
  });

  $(document).on('click', '.badge', function(){
   var task_list_id = $(this).data('id');
   $.ajax({
    url:"delete_task.php",
    method:"POST",
    data:{task_list_id:task_list_id},
    success:function(data)
    {
     $('#list-group-item-'+task_list_id).fadeOut('slow');
    }
   })
  });

 });
</script>
