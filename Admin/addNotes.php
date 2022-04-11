<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Notes');
define('PAGE', 'notes');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 if(isset($_REQUEST['notesSubmitBtn'])){
  // Checking for Empty Fields
  if(($_REQUEST['notes_name'] == "") || ($_REQUEST['notes_desc'] == "") || ($_REQUEST['course_id'] == "") || ($_REQUEST['course_name'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   // Assigning User Values to Variable
   $notes_name = $_REQUEST['notes_name'];
   $notes_desc = $_REQUEST['notes_desc'];
   $course_id = $_REQUEST['course_id'];
   $course_name = $_REQUEST['course_name'];
   $notes_link = $_FILES['notes_link']['name']; 
   $notes_link_temp = $_FILES['notes_link']['tmp_name'];
   $link_folder = '../notes/'.$notes_link; 
   move_uploaded_file($notes_link_temp, $link_folder);
    $sql = "INSERT INTO notes (notes_name, notes_desc, notes_link, course_id, course_name) VALUES ('$notes_name', '$notes_desc','$link_folder', '$course_id', '$course_name')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> NoTES Added Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add   Notes </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New notes</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="course_id">Course ID</label>
      <input type="text" class="form-control" id="course_id" name="course_id" value ="<?php if(isset($_SESSION['course_id'])){echo $_SESSION['course_id'];} ?>" readonly>
    </div>
    <div class="form-group">
      <label for="course_name">Course Name</label>
      <input type="text" class="form-control" id="course_name" name="course_name" value ="<?php if(isset($_SESSION['course_name'])){echo $_SESSION['course_name'];} ?>" readonly>
    </div>
    <div class="form-group">
      <label for="notes_name">Notes Name</label>
      <input type="text" class="form-control" id="notes_name" name="notes_name">
    </div>
    <div class="form-group">
      <label for="notes_desc">Notes Description</label>
      <textarea class="form-control" id="notes_desc" name="notes_desc" row=2></textarea>
    </div>
    <div class="form-group">
      <label for="notes_link">Notes Link</label>
      <input type="file" class="form-control-file" id="notes_link" name="notes_link">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="notesSubmitBtn" name="notesSubmitBtn">Submit</button>
      <a href="notes.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }

</script>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
include('./adminInclude/footer.php'); 
?>