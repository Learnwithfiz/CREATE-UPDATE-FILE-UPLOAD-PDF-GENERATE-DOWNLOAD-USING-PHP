<?php
 include 'db.php';
  $id = $_GET['id'];
  $OldImgName = $_GET['imgName'];
  $sql="SELECT * FROM user_info where id = $id";
  $ex = mysqli_query($con,$sql);
  $data = mysqli_fetch_array($ex);
  if(isset($_POST['UpdateBt']))
  {
       $name = $_POST['name'];
       $email = $_POST['email'];
       $imgName = $_FILES['img']['name'];
       $tmpName = $_FILES['img']['tmp_name'];
       $folder = "img/";
       if(file_exists($folder.$imgName))
       {
        $update = "UPDATE user_info SET name ='$name',email='$email' WHERE id = $id";
        $ex = mysqli_query($con,$update);
        echo "<script>alert('data Update success')</script>";

       }else{
            
            $upload = move_uploaded_file($tmpName,$folder.$imgName);
            if($upload)
            {
                $update = "UPDATE user_info SET name ='$name',email='$email' , img='$imgName' WHERE id = $id";
                $ex = mysqli_query($con,$update);
                unlink("img/$OldImgName");
                echo "<script>alert('data update hoyese')</script>";
            }
           

       }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1 class="bg-success p-2 text-center text-white">User Update Info</h1>
    

    <div class="container">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <form enctype="multipart/form-data" method="post" class="form">
                    <label for="">Enter Name</label>
                    <input name="name" value="<?php echo $data['name']; ?>" type="text" placeholder="enter name" class="form-control"> 
                    <label for="">Enter Email</label>
                    <input name="email" value="<?php echo $data['email']; ?>" type="text" placeholder="enter Email" class="form-control"> 
                    <label for="">Upload File</label>
                     <div>
                        <img height="40"width="40" src="img/<?php echo $data['img'] ?>" alt="">
                     </div>
                    <input onchange="OnHandleFile(event)" name="img" type="file"  class="form-control"> 
                    <div>
                        <img src="dumy_user.png" id="display_img" height="120" widht="120" alt="">
                    </div>
                    <button name="UpdateBt" class="btn btn-success p-2 text-white" >Update</button>
                    <a href="index.php">home page</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function OnHandleFile(event)
        {
            var display_img = document.getElementById("display_img");
            display_img.src = URL.createObjectURL(event.target.files[0]);
            
        }
    </script>
  </body>
</html>