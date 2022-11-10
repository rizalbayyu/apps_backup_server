<!DOCTYPE html>
<html>
 <head>
  <title>PHP Repository Backup</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br /><br />
  <div class="container">
   <h2 align="center">PHP Repository Backup</a></h2>
   <br />
   <div align="right">
    <button type="button" name="restore" id="restore-repo" class="btn btn-success">Restore Repo</button>
    <button type="button" name="delete" id="delete-btn" class="btn btn-danger">Delete Repo</button>
   </div>
   <br />
   <div class="table-responsive" id="folder_table">
   </div>
  </div>
 </body>
</html>

<div id="deleteRepo" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Nama Repo</h4>
   </div>
   <div class="modal-body" id="delete_id"> </div>
   </div>
 </div>
</div>

<div id="repoList" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Repo ID</h4>
   </div>
   <div class="modal-body" id="repo_id"> </div>
  </div>
 </div>
</div>

<div id="filelistModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">File List</h4>
   </div>
   <div class="modal-body" id="file_list">
    
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<script>
$(document).ready(function(){
 
 load_folder_list();
 
 function load_folder_list()
 {
  var action = "fetch";
  $.ajax({
   url:"action.php",
   method:"POST",
   data:{action:action},
   success:function(data)
   {
    $('#folder_table').html(data);
   }
  });
 }
 
 $(document).on("click", ".backup", function(){
    var action = "backup";
    var folder_name = $(this).data("name");
    $.ajax({
        url:"action.php",
        method:"POST",
        data:{action:action, folder_name:folder_name},
        success:function(data)
        {
            alert(data);
            location.reload();
        }
    });
 });

 $(document).on("click", ".backup", function(){
    var action = "database";
    var folder_name = $(this).data("name");
    $.ajax({
        url:"db.php",
        method:"POST",
        data:{action:action, folder_name:folder_name},
        success:function(data)
        {
            alert(data);
        }
    });
 });
 
 $(document).on("click", ".delete", function(){
  var folder_name = $(this).data("name");
  var action = "delete";
  if(confirm("Are you sure you want to remove it?"))
  {
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{folder_name:folder_name, action:action},
    success:function(data)
    {
     load_folder_list();
     alert(data);
     location.reload();
    }
   });
  }
 });
 
 $(document).on('click', '.view_files', function(){
  var folder_name = $(this).data("name");
  var action = "fetch_files";
  $.ajax({
   url:"action.php",
   method:"POST",
   data:{action:action, folder_name:folder_name},
   success:function(data)
   {
    $('#file_list').html(data);
    $('#filelistModal').modal('show');
   }
  });
 });

 $(document).on('click', '#restore-repo', function(){
  var action = "repo_list";
  $.ajax({
   url:"action.php",
   method:"POST",
   data:{action:action},
   success:function(data)
   {
    $('#repo_id').html(data);
    $('#repoList').modal('show');
   }
  });
 });

 $(document).on('click', '#delete-btn', function(){
  var action = "delete_repo";
  $.ajax({
   url:"action.php",
   method:"POST",
   data:{action:action},
   success:function(data)
   {
    $('#delete_id').html(data);
    $('#deleteRepo').modal('show');
   }
  });
 });

 $(document).on("click", ".restore", function(){
    var action = "restore";
    var repo_name = $(this).data("name");
    $.ajax({
        url:"action.php",
        method:"POST",
        data:{action:action, repo_name:repo_name},
        success:function(data)
        {
            alert(data);
            location.reload();
        }
    });
 });
 
});
</script>
