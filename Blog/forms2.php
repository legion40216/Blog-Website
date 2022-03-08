
<?php


// connect to database
$conn= mysqli_connect('localhost','root','','blog_data');

// check connection
if(!$conn)
{
echo 'connection errror'.mysqli_connect_error();
}

if(isset($_POST['submit']))
{
    $text=$_POST['text'];
    $blog=$_POST['blog'];
    $name=$_POST['name'];
    $date=$_POST['date'];
    $imgupload=$_FILES['imgupload']['name'];
    $imgupload2=$_FILES['imgupload2']['name'];

    $query = "INSERT INTO `blog`(`text`, `blog`, `name`, `date`,`img_background`,`img_avatar`) VALUES('$text',' $blog','$name', '$date','$imgupload','$imgupload2')"; 
          

    //upload images
    $target_dir = "Website Projects/Uploads/";
$target_file = $target_dir . basename($_FILES["imgupload"]["name"]);


// mover files to upload floder for further access
if (move_uploaded_file($_FILES["imgupload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["imgupload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }


  $target_file = $target_dir . basename($_FILES["imgupload2"]["name"]);
  
  if (move_uploaded_file($_FILES["imgupload2"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["imgupload2"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }


    // run query
    if(mysqli_query($conn,$query))
    {
        // after running query redirect to the latest blog created;
        $querys = "SELECT * FROM `blog` WHERE `id` = ( SELECT MAX(`id`) FROM `blog`)";
        $querys = mysqli_query($conn,$querys);
        $blog_id = mysqli_fetch_assoc($querys);
       
        header('Location:Website Projects/blog.php?id='.$blog_id['id']);
    }
    else
    {
        echo 'query error'. mysqli_error($conn);
    }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Great+Vibes&family=Indie+Flower&family=Mochiy+Pop+P+One&family=Quicksand:wght@300;400;500;600&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1 class="heading">Blog Builder</h1>
    
    <div class="main">
     
         <h1>We Would Love To Create Your Blogs</h1>

        <form action="forms2.php" method="post" enctype="multipart/form-data">
          <div class="main-block" >
             <div class="block-1">

                 <div class="status-images"><i class="fas fa-user"></i></div>
      
                <div class="input-group">
                      <label for="blog">Blog Title</label>
                      <input type="text" name="blog"   required placeholder="My First Blog e.g " >

                </div>
        
                          
                 <div class="input-group">
                      <label for="name">Your Name</label>
                      <input type="text" name="name"  required  placeholder="Enter Your Full Name">
                 </div>
            
                 <div class="input-date input-group">
        
                     <label for="date">Enter Date</label>
                     <input type="date"  required name="date">
        
                 </div>

            </div>

             <div class="block-2">

                     <span>Write Your Blog</span>
                     <div class="input-group">
                         <textarea name="text" cols="30" rows="10" placeholder="Type your blog article"></textarea>
    
                     </div>
             </div>
            </div>
        

        <div class="image-upload">

             <div class="status-images"><i class="fas fa-images"></i></div>

             <h1>Upload Images</h1>

                    <div class="img-container">
                       
                      <div class="image-background-box">
                         <div class="image-box">
                              <img src="cloud-upload-outline.svg" alt="">
                         </div>
                         <span>Upload Background Image</span>
                       <label for="imgupload">  <img class="plus" src="add-circle.svg"  alt=""></label>
                     </div>

                         <div class="image-background-box-2">
                             <div class="image-box2">
                                 <img src="cloud-upload-outline.svg" alt="">
                             </div>
                             <span>Upload Avatar</span>
                           <label for="imgupload2"> <img class="plus" src="add-circle.svg"   alt=""></label> 

                         </div>
                     </div>
      

        </div>
        <input type="file"  id="imgupload"  name="imgupload" style="display:none" accept="image/*" /> 
         <input type="file" id="imgupload2" name="imgupload2" style="display:none" accept="image/*"/> 
         <button type="submit" name="submit">Create</button>
        </form>
     </div>
     
     


<script>
    var background_img2=document.querySelector("#imgupload2");
    var background2=document.querySelector(".image-box2");

    var background_img=document.querySelector("#imgupload");
    var background=document.querySelector(".image-box");
    
    background_img2.addEventListener("change", () =>{
          
          
           var bk2=background_img2.files[0].name;
          
            
            background2.style.backgroundImage= "url('" + bk2 + "')";
            background2.style.backgroundSize="contain";
            background2.style.backgroundRepeat="no-repeat";
            background2.style.backgroundPosition="center";
            background2.querySelector("img").style.opacity="0";
        })

      

    
    background_img.addEventListener("change", () =>{
          
          
           var bk=background_img.files[0].name;
          
            
            background.style.backgroundImage= "url('" + bk + "')";
            background.style.backgroundSize="contain";
            background.style.backgroundRepeat="no-repeat";
            background.style.backgroundPosition="center";
            background.querySelector("img").style.opacity="0";
        })



</script>

</body>
</html>