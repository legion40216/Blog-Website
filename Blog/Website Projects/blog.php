<?php

// connect to database
$conn= mysqli_connect('localhost','root','','blog_data');

// check connection
if(!$conn)
{
echo 'connection errror'.mysqli_connect_error();
}
//to retrive the blog from the forum inputs
if(isset($_GET['id']))
{
  $id=mysqli_real_escape_string($conn,$_GET['id']);
  if($id=="")
  {
    $id=1;
  }
  
  $sql ="SELECT * FROM blog WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  $blog_details= mysqli_fetch_assoc($result);
}
//total number of intrires of data ammeded in the side bar card each with a unique id
$query = "SELECT * FROM blog";
$result = mysqli_query($conn,$query);
$blogs = mysqli_fetch_all($result,MYSQLI_ASSOC);

//delete a blog
if (isset($_POST['delete']))
{ 

  $id_delete=$_POST['id_delete'];
  $query = "DELETE FROM blog WHERE id = $id_delete";

  if(mysqli_query($conn,$query))
{ 
  //after running the delete query auto redirect to the next latest blog
   $query="SELECT `id` FROM `blog` WHERE `id` = ( SELECT MAX(`id`) FROM `blog`)";
   $results = mysqli_query($conn,$query);
   $blog_next_id= mysqli_fetch_assoc($results);
   header('location:blog.php?id='.$blog_next_id['id']);
    //success
} else {
   echo 'query error:'.mysqli_error($conn);

}
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&family=Indie+Flower&family=Mochiy+Pop+P+One&family=Quicksand&family=Raleway:wght@200&display=swap"rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap"rel="stylesheet"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="blogs.css" />
    <title>Document</title>

  </head>
  <body style='background-image:radial-gradient(
      50% 50% at center,
      rgba(0, 0, 0, 0.66),
      #262626
    ),url("Uploads/<?= $blog_details['img_background']; ?>");'>

    

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="\blog\forms2.php">Blog Web</a>
<div class="menu_items">
    <button class="btn btn-secondary" onclick="search()"><i class="fas fa-search"></i></button>
   <a href="\blog\forms2.php"><button class="btn btn-secondary "><i class="fas fa-plus"></i> Create</button></a>
      </div>
    </div>
    <div class="search_wrapper">
      <form class="search_form" action="">
        <span>Search Blog</span>
      <input type="text"><button class="btn serach_btn"><i class="fas fa-search"></i></button>
      </form>
    </div>
  </nav>
    
    <div class="wrapper">
  
    <div class="main">
    <?php if($blog_details):?>
    
      <div class="blog-content-container">
        <div class="blog-content-group">
          <h1><?= $blog_details['blog'] ?></h1>

          <div class="blog-details">
            <img src="Uploads/<?=$blog_details['img_avatar']?>" alt="" width="45px" height="45px" />
            <span><?= $blog_details['name'] ?></span>
            <span>on</span>
            <span><?= $blog_details['date'] ?></span>
          </div>
        </div>
        <div class="text-container">
          <p>
          <?= $blog_details['text'] ?>
          </p>
        </div>
<div class=delete>
<form action="blog.php?id=<?=$id?>" method="post">
<input type="hidden" name="id_delete"  value="<?= $id ?>">
<input type="submit" name='delete' value='Delete' class='class="btn btn-danger btn-lg'>
</form>
        
        </div>
      </div>

      <div class="blog-sidebar">

      <?php foreach($blogs as $blog) :?>
        <div class="sidebar-card">
          <a href="blog.php?id=<?= $blog['id']?>"><img src="Uploads/<?= $blog['img_background']; ?>" alt="" /></a>
          <span><?= $blog['blog'] ?></span>
        </div>
        <?php endforeach;?>
        <button class="btn btn-secondary">See all</button>
      </div>



      
      <?php else: ?>
        <div class="wrapper">
        <h1 class="noblogs">No such blog exists !</h1>
        <div class="main">
        <div class="blog-content-container"></div>
         <div class="blog-sidebar">
         <h5 class="tryblogs">Oopse Try these blogs</h5>     
    <?php foreach($blogs as $blog) :?>
      <div class="sidebar-card">
    <a href="blog.php?id=<?= $blog['id']?>"><img src="Uploads/<?= $blog['img_background']; ?>" alt="" /></a>
    <span><?= $blog['blog'] ?></span>
  </div>
  <?php endforeach;?>
  </div>
  </div>
  </div>
 <?php endif ?>

    </div>
     </div>

     <script>
       var search_bar=document.querySelector(".search_wrapper");
       function search()
       {
        search_bar.classList.toggle("enable");
       }
     </script>
  </body>
</html>
