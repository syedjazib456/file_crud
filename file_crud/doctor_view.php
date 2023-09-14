<?php
require_once "config.php";
$fetch_doctors = "SELECT * FROM doctor";
$res_doctor = mysqli_query($con,$fetch_doctors);
$total_rows = mysqli_num_rows($res_doctor);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Profile</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if($total_rows!=0){
                        while($data = mysqli_fetch_assoc($res_doctor)){
                        ?>
                        <tr>
                            <td><?php echo $data['doc_id']?></td>
                             <td><?php echo $data['doc_name']?></td>
                              <td><?php echo $data['doc_contact']?></td>
                               <td><img src="media/<?php echo $data['doc_profile']?>" alt="" width="100" height="100"></td>
                              <td>
                                <a href="edit_doctor.php?doc_id=<?php echo $data['doc_id']?>" class="btn btn-primary btn-outline-light">Edit</a>
                                <a href="delete_doctor.php" class="btn btn-danger btn-outline-light">Delete</a>

                            </td>
                            </tr>
                        <?php
                        }
                    }
                         
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>