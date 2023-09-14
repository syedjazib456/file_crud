<?php
require_once 'config.php';
$doc_id = $_GET['doc_id'];
$fetch_doctors = "SELECT * FROM doctor WHERE doc_id = '{$doc_id}'";
$res_doctor = mysqli_query($con,$fetch_doctors);
$total_rows = mysqli_num_rows($res_doctor);
if(isset($_POST['update_doc'])){
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
    $update_doc_sql ="UPDATE doctor SET doc_name='{$docname}', doc_contact='{$doccontact}',doc_profile='{$filename}' WHERE doc_id='{$doc_id}'";
    $res_doc_sql = mysqli_query($con,$update_doc_sql);
    if($res_doc_sql){
      move_uploaded_file($filetemp,'media/'.$filename);
      $_SESSION['update'] = 'Doctor Updated Successfully';
      header('Location:http://localhost:82/file_crud/doctor_view.php');
    //   header('refresh:5;url="http://localhost:82/file_crud/doctor_view.php"');
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
      header('Location:http://localhost:82/file_crud/doctor_view.php');
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
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <?php
                if($total_rows!=0){
                    while($data = mysqli_fetch_assoc($res_doctor)){
                ?>
          <form method="POST" enctype="multipart/form-data">
                <input type="text" class="form-control" hidden name="docid" value="<?php echo $data['doc_id']?>">
                <label for="">Doctor Name</label>
                 <input type="text" class="form-control" name="docname" value="<?php echo $data['doc_name']?>">
                <label for="">Doctor Contact</label>
                 <input type="text" class="form-control" name="doccontact" value="<?php echo $data['doc_contact']?>">

                <label for="">Doctor Profile</label>
                <img src="media/<?php echo $data['doc_profile']?>" alt="" width="100" height="100">
                <input type="file" class="form-control" name="docprofile">
                <input type="submit" name="update_doc" class="mt-2 btn btn-primary btn-outline-light form-control" value="Update Doctor">
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