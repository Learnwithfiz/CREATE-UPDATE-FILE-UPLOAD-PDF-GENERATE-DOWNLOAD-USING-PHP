<?php
   include 'db.php';
    if(isset($_POST['submitBtn']))
    {
         $name = $_POST['name'];
         $email = $_POST['email'];
         $imgName = $_FILES['img']['name'];
         $tmpName = $_FILES['img']['tmp_name'];
         $size = $_FILES['img']['size'];
         
         $ImgExten = explode(".",$imgName);
         $extention = end($ImgExten);
         $alloExt = ["pdf","jpg","png"];
       
       $checkExt =  in_array($extention,$alloExt);  
       if($checkExt)
       {
          //  only 100 K.B allow 
          $checkKB = 100 ; // 100 kb 
          $byte = 100*1024; // 102400 
           if($byte>$size)
           {
              // insert query 
             $folder = "img/";
             $upload = move_uploaded_file($tmpName,$folder.$imgName);
             if($upload)
             {
                $insert = "INSERT into user_info (name,email,img) VALUES('$name','$email','$imgName')";
                $ex = mysqli_query($con,$insert);
                if($ex)
                {
                    echo "<script>alert('data inserted')</script>";
                } 
                else 
                {
                    echo "<script>alert('data insert failed ')</script>";
                }  
             }
             else
             {
                echo "file upload failed";
             }

           }
           else
           {
            echo "<script>alert('100 kb file only allow')</script>";
           }
       }
       else
       {
         echo "<script>alert('File Not Allow , only allow pdf, jpg,png')</script>";
       }

    }


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1 class="bg-primary p-3 text-white text-center">CRUD USING FILE </h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <form enctype="multipart/form-data" method="post" class="form">
                    <label for="">Enter Name</label>
                    <input name="name" type="text" placeholder="enter name" class="form-control"> 
                    <label for="">Enter Email</label>
                    <input name="email" type="text" placeholder="enter Email" class="form-control"> 
                    <label for="">Upload File</label>
                    <input onchange="OnHandleFile(event)" name="img" type="file"  class="form-control"> 
                     <div>
                         <img src="dumy_user.png" id="display_img" height="120" widht="120" alt="">
                     </div>
                    <button name="submitBtn" class="btn btn-success p-2 text-white" >Submit</button>
                </form>
            </div>
            <div class="col-lg-6">
                <?php
                    $search="";
                    if(isset($_POST['srchBtn']))
                    {
                        $search = $_POST['search'];
                    }
                ?>
                <form method="post">
                    <input type="search" name="search" class="form-control">
                    <button name="srchBtn" class="btn btn-primary">Search</button>
                </form>
                <!-- <form method="post" action="multi_delete_controller.php"> -->
                <table class="table">
                    <thead>
                        <th><button name="dltMulBtn" class="btn btn-danger">Delete Multiple</button></th>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Img</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>View</th>
                        <th>Download</th>
                        <th>PDF Generate</th>
                    </thead>
                    <tbody>
                        <?php

                            $sql = "SELECT * FROM user_info WHERE name LIKE '%$search%'";
                            $ext = mysqli_query($con,$sql);
                            $i=1;
                            while($row=mysqli_fetch_array( $ext))
                            {
                                ?>
                                    <tr>
                                        <td><input name="multi_id[]" value="<? echo $row['id'] ?>" type="checkbox"></td>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><img height="40" width="40" src="img/<?php echo $row['img']; ?>" alt=""></td>
                                        <td><a href="edit_controller.php?id=<?php echo $row['id'] ?>&imgName=<?php echo $row['img'] ?>"><button class="btn btn-primary">Edit</button></a></td>
                                        <td><button class="btn btn-danger">Delete</button></td>
                                        <td><button class="btn btn-primary">view</button></td>
                                        <td><a href="img/<?php echo $row['img'] ?>" download="img/<?php echo $row['img'] ?>"><button class="btn btn-success">Download</button></a></td>
                                        <td><a href="generate_pdf_controller.php?id=<? echo $row['id'] ?>"><button class="btn btn-dark text-white">PDF Download</button></a></td>
                                    </tr>
                                <?
                                $i++;
                            }

                        ?>
                    </tbody>
                </table>
                <!-- </form> -->
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