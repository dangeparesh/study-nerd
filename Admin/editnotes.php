<?php 
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Edit Notes');
define('PAGE', 'notes');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 // Update
 if(isset($_REQUEST['requpdate'])){
  // Checking for Empty Fields
  if(($_REQUEST['notes_id'] == "") || ($_REQUEST['notes_name'] == "") || ($_REQUEST['notes_desc'] == "") || ($_REQUEST['course_id'] == "") || ($_REQUEST['course_name'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
    // Assigning User Values to Variable
    $nid = $_REQUEST['notes_id'];
    $nname = $_REQUEST['notes_name'];
    $ndesc = $_REQUEST['notes_desc'];
    $cid = $_REQUEST['course_id'];
    $cname = $_REQUEST['course_name'];

    $notes_link = $_FILES['notes_link']['name']; 
    $notes_link_temp = $_FILES['notes_link']['tmp_name'];
    $notes_folder = '../notes/'.$notes_link; 
    move_uploaded_file($notes_link_temp, $notes_folder);

   
    
   $sql = "UPDATE notes SET notes_id = '$nid', notes_name = '$nname', notes_desc = '$ndesc', course_id='$cid', course_name='$cname', notes_link='$notes_folder' WHERE notes_id = '$nid'";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Update Notes Details</h3>
  <?php
 if(isset($_REQUEST['view'])){
  $sql = "SELECT * FROM notes WHERE notes_id = {$_REQUEST['id']}";
 $result = $conn->query($sql);
 $row = $result->fetch_assoc();
 }
 ?>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="notes_id">Notes ID</label>
      <input type="text" class="form-control" id="notes_id" name="notes_id" value="<?php if(isset($row['notes_id'])) {echo $row['notes_id']; }?>" readonly>
    </div>
    <div class="form-group">
      <label for="notes_name">Notes Name</label>
      <input type="text" class="form-control" id="notes_name" name="notes_name" value="<?php if(isset($row['notes_name'])) {echo $row['notes_name']; }?>">
    </div>

    <div class="form-group">
      <label for="notes_desc">Notes Description</label>
      <textarea class="form-control" id="notes_desc" name="notes_desc" row=2><?php if(isset($row['notes_desc'])) {echo $row['notes_desc']; }?></textarea>
    </div>
    <div class="form-group">
      <label for="course_id">Course ID</label>
      <input type="text" class="form-control" id="course_id" name="course_id" value="<?php if(isset($row['course_id'])) {echo $row['course_id']; }?>" readonly>
    </div>
    <div class="form-group">
      <label for="course_name">Course Name</label>
      <input type="text" class="form-control" id="course_name" name="course_name" onkeypress="isInputNumber(event)" value="<?php if(isset($row['course_name'])) {echo $row['course_name']; }?>" readonly>
    </div>
    <div class="form-group">
      <label for="notes_link">Notes Link</label>
      <div class="embed-responsive embed-responsive-16by9">
       <iframe class="embed-responsive-item" src="<?php if(isset($row['notes_link'])) {echo $row['notes_link']; }?>" allowfullscreen></iframe>
      </div>     
      <input type="file" class="form-control-file" id="notes_link" name="notes_link">
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="requpdate" name="requpdate">Update</button>
      <a href="notes.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
include('./adminInclude/footer.php'); 
?>