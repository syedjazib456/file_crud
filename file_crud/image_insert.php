<?php
require_once "config.php";
if(isset($_POST['register_doc'])){
  $docname = $_POST['docname'];
  $doccontact = $_POST['doccontact'];
  if(isset($_FILES['docprofile'])){
    //name,size,type,temp
    $filename = $_FILES['docprofile']['name'];
    $filesize = $_FILES['docprofile']['size'];
    $filetype = $_FILES['docprofile']['type'];
    $filetemp = $_FILES['docprofile']['tmp_name'];
  
    $allowed_extensions = array('jpg','png','jpeg','jfif');
    $fileextension = pathinfo($filename,PATHINFO_EXTENSION);//png
 

  }
  if(!in_array($fileextension,$allowed_extensions)){
    $_SESSION['check'] = "Only Allowed png,jpg,jpeg and jfif";
  }
  else{
  if(file_exists('media/'.$filename)){
    $_SESSION['check'] = "File Already Exist";
  }
	  else if($filesize > 1048576){
		  $_SESSION['check'] = "File is too large";  
	  }
  else{
  $insert_doc_sql ="INSERT INTO doctor(doc_name,doc_contact,doc_profile) VALUES('{$docname}','{$doccontact}','{$filename}')";
  $res_doc_sql = mysqli_query($con,$insert_doc_sql);
  if($res_doc_sql){
    move_uploaded_file($filetemp,'media/'.$filename);
    echo "<script>alert('Registered Successfully');</script>";
    echo "<script>window.location.href='http://localhost:82/file_crud/doctor_view.php'</script>";
  }
}
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <div class="mt-5 container">
        <div class="mt-5 row justify-content-center">
            <h1 class="text-primary text-center">Doctor Registration Form</h1>
            <div class="col-6">
            
<?php 

if(isset($_SESSION['check'])){
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
  echo $_SESSION['check'];
  echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>  
</div>';
  session_unset();
  session_destroy();
}
else{
  echo "";
}
?>

             <form method="POST" enctype="multipart/form-data">
                <label for="">Doctor Name</label>
                 <input type="text" class="form-control" name="docname">
                <label for="">Doctor Contact</label>
                 <input type="text" class="form-control" name="doccontact">

                <label for="">Doctor Profile</label>
                <input type="file" class="form-control" name="docprofile">
                <input type="submit" name="register_doc" class="mt-2 btn btn-primary btn-outline-light form-control" value="Register">
             </form>
            </div>
        </div>
    </div>
</body>
</html>