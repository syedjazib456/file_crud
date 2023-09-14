<?php
require_once "config.php";
$doc_id = $_GET['doc_id'];
$fetch_doc = "SELECT * FROM doctor WHERE doc_id='{$doc_id}'";
$res_doctor = mysqli_query($con,$fetch_doc);
$total_rows = mysqli_num_rows($res_doctor);

if(isset($_POST['register_doc'])){
  if($_FILES['docprofile']['name']!=''){
    $doc_id = $_GET['doc_id'];
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
    $update_sql ="UPDATE doctor SET doc_name='{$docname}',doc_contact='{$doccontact}',doc_profile='{$filename}' WHERE doc_id='{$doc_id}'";
    $res_doc_sql = mysqli_query($con,$update_sql);
    if($res_doc_sql){
      move_uploaded_file($filetemp,'media/'.$filename);
      echo "<script>alert('Updated Successfully');</script>";
      echo "<script>window.location.href='http://localhost:82/file_crud/doctor_view.php'</script>";
    }
  }
    }
  }else{
    $doc_id = $_GET['doc_id'];
    $docname = $_POST['docname'];
    $doccontact = $_POST['doccontact'];
    $update_doc_sql ="UPDATE doctor SET doc_name='{$docname}', doc_contact='{$doccontact}' WHERE doc_id='{$doc_id}'";
    $res_doc_sql = mysqli_query($con,$update_doc_sql);
    if($res_doc_sql){
     
      $_SESSION['update'] = 'Doctor Updated Successfully';
      header('refresh:2;URL=http://localhost:82/file_crud/doctor_view.php');
    //   header('refresh:5;url="http://localhost:82/file_crud/doctor_view.php"');
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
else if(isset($_SESSION['update'])){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
  echo $_SESSION['update'];
  echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>  
</div>';
  session_unset();
  session_destroy();
}
else{
  echo "";
}
?>
<?php

   if($total_rows!=0){
    while($data=mysqli_fetch_assoc($res_doctor)){
 ?>

             <form method="POST" enctype="multipart/form-data">
                <input type="text" name="doc_id" value="<?php echo $data['doc_id']?>" hidden>
                <label for="">Doctor Name</label>
                 <input type="text" class="form-control" name="docname" value="<?php echo $data['doc_name']?>">
                <label for="">Doctor Contact</label>
                 <input type="text" class="form-control" name="doccontact" value="<?php echo $data['doc_contact']?>">

                <label for="">Doctor Profile</label>
                <input type="file" class="form-control" name="docprofile">
                <img src="media/<?php echo $data['doc_profile']?>" alt="" width="70" height="70"/>
                <input type="submit" name="register_doc" class="mt-2 btn btn-primary btn-outline-light form-control" value="Register">
             </form>
             <?php
    }
}
             ?>
            </div>
        </div>
    </div>
</body>
</html>