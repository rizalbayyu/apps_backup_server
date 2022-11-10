<?php

function format_folder_size($size)
{
 if ($size >= 1073741824)
 {
  $size = number_format($size / 1073741824, 2) . ' GB';
 }
    elseif ($size >= 1048576)
    {
        $size = number_format($size / 1048576, 2) . ' MB';
    }
    elseif ($size >= 1024)
    {
        $size = number_format($size / 1024, 2) . ' KB';
    }
    elseif ($size > 1)
    {
        $size = $size . ' bytes';
    }
    elseif ($size == 1)
    {
        $size = $size . ' byte';
    }
    else
    {
        $size = '0 bytes';
    }
 return $size;
}

function get_folder_size($folder_name)
{
 $total_size = 0;
 $file_data = scandir($folder_name);
 foreach($file_data as $file)
 {
  if($file === '.' or $file === '..')
  {
   continue;
  }
  else
  {
   $path = $folder_name . '/' . $file;
   $total_size += filesize($path);
  }
 }
 return format_folder_size($total_size);
}

if(isset($_POST["action"]))
{
 if($_POST["action"] == "fetch")
 {
  $folder = array_filter(glob('/home/*'), 'is_dir');
  
  $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Folder Name</th>
    <th>Total File</th>
    <th>Size</th>
    <th>Backup</th>
    <th>View File</th>
   </tr>
   ';
  if(count($folder) > 0)
  {
   foreach($folder as $name)
   {
    $output .= '
     <tr>
      <td>'.$name.'</td>
      <td>'.(count(scandir($name)) - 2).'</td>
      <td>'.get_folder_size($name).'</td>
      <td><button type="button" name="backup" data-name="'.$name.'" class="backup btn btn-warning btn-xs">Backup</button></td>
      <td><button type="button" name="view_files" data-name="'.$name.'" class="view_files btn btn-default btn-xs">View Files</button></td>
     </tr>';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td colspan="6">No Folder Found</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }
 
 if($_POST["action"] == "delete")
 {

  $directory_name = $_POST["folder_name"];
  $delete = exec("sudo rm -rf $directory_name");

  echo "Directory $directory_name has been deleted";

 }

 if($_POST["action"] == "backup")
 {
    $repo_name = $_POST["folder_name"];
    $oldPath = getcwd();
    chdir('script/');
    exec("./script_backup_repo.sh $repo_name");
    chdir($oldPath);
    echo "Repo pada direktori ", $repo_name, " berhasil di backup";

 }
 
 if($_POST["action"] == "fetch_files")
 {
  $file_data = scandir($_POST["folder_name"]);
  $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>File Name</th>
   </tr>
  ';
  
  foreach($file_data as $file)
  {
   if($file === '.' or $file === '..')
   {
    continue;
   }
   else
   {
    $path = $_POST["folder_name"] . '/' . $file;
    $output .= '
    <tr>
     <td contenteditable="false" data-folder_name="'.$_POST["folder_name"].'"  data-file_name = "'.$file.'" class="view_file_name">'.$file.'</td>
    </tr>
    ';
   }
  }
  $output .='</table>';
  echo $output;
 }

 if($_POST["action"] == "repo_list")
 {
  $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Repo Name</th>
    <th>Date</th>
    <th>Time</th>
    <th>Restore</th>
    <th>Last Restore</th>
   </tr>
  ';
  $servername = "localhost";
  $username = "devops";
  $password = "devops!@#";
  $dbname = "repo";
 
// Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
  if ($conn->connect_error) {

      die("Connection failed: " . $conn->connect_error);
  }

  else {

    $sql = "SELECT * FROM nama_repo";

    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
  // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $id_repo = $row["repo_id"];
            $dateTime = $row["date"];
            $timestamp = $row["time"];
            $lastRestore = $row["last"];
            $output .= '
            <tr>
             <td contenteditable="false" data-name = "'.$id_repo.'" class="repo_id_name">'.$id_repo.'</td>
             <td contenteditable="false" data-name = "'.$dateTime.'" class="repo_id_name">'.$dateTime.'</td>
             <td contenteditable="false" data-name = "'.$timestamp.'" class="repo_id_name">'.$timestamp.'</td>
             <td><button type="button" name="restore" data-name="'.$id_repo.'" class="restore btn btn-success btn-xs">Restore</button></td>
             <td contenteditable="false" data-name = "'.$lastRestore.'" class="repo_id_name">'.$lastRestore.'</td>
            </tr>';
         }
        } else {
          echo "<td>" . "Tidak ada repo yang disimpan" . "</td>";
        }
      }
      $output .='</table>';
      echo $output;
    }
 
 if($_POST["action"] == "restore")
 {
    $repo_name = $_POST["repo_name"];
    $oldPath = getcwd();
    chdir('script/');
    exec("./script_restore_repo.sh $repo_name");
    chdir($oldPath);

    $servername = "localhost";
    $username = "devops";
    $password = "devops!@#";
    $dbname = "repo";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {

      die("Connection failed: " . $conn->connect_error);

    } else {
      $date = date("Y-m-d H:i:s");
      mysqli_query($conn, "UPDATE nama_repo SET `last`='$date' WHERE repo_id='$repo_name'");
      echo "Repo berhasil di restore";
    }

 }
  if($_POST["action"] == "delete_repo")
  {
    $folder = array_filter(glob('/home/*'), 'is_dir');
    
    $output = '
    <table class="table table-bordered table-striped">
    <tr>
      <th>Folder Name</th>
      <th>Delete</th>
    </tr>';
    if(count($folder) > 0)
    {
      foreach($folder as $name)
      {
        $output .= '
        <tr>
          <td>'.$name.'</td>
          <td><button type="button" name="delete" data-name="'.$name.'" class="delete btn btn-danger btn-xs">Delete</button></td>
        </tr>';
      }
    } else {
      $output .= '
      <tr>
        <td colspan="6">No Folder Found</td>
      </tr>';
    }
    $output .= '</table>';
    echo $output;
  }
  }
?>