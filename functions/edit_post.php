<?php  
session_start();

include("../includes/connection.php");
include("../functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WELCOME USER!</title>
    <link rel="stylesheet" href="../styles/home_style.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <script src="main.js"></script>
</head>
<body>
<!-- CONTAINER START HERE
=============================================================================================-->
<div class="container">

 <!-- HEADER WRAPER START
 =============================================================================================-->
 <div id="head_wrap">
    <div id="header">
        
         <ul id="menu">
             <li><a href="home.php">Home</a></li>
             <li><a href="members.php">Members</a></li>
             <strong>Topics:</strong>
             <?php
               $get_topics = "select * from topics";
               $run_topics = mysqli_query($con,$get_topics);

               while($row=mysqli_fetch_array($run_topics)){

                $topic_id = $row['topic_id'];
                $topic_name = $row['topic_name'];

                echo "<li><a href='topic.php?topic=$topic_id'>$topic_name</a></li>";

               }
             ?>
         </ul><!-- menu ends here -->
         <form method="get" action="result.php" id="form1">
             <input type="text" name="user_query" placeholder="Search a Topic" />
             <input type="submit" name="search" value="Search" />
         </form><!-- form1 ends here -->

    </div><!-- header ends here -->
 </div> <!-- head_wrap ends here -->
 

 <!--  CONTENT START
 =============================================================================================--> 
 <div class="content">

    <div id="user_timeline">
        <div id="user_details">
            <?php
               $user = $_SESSION['user_email'];
               $get_user = "select * from users where user_email='$user'";
               $run_user = mysqli_query($con,$get_user);
               $row = mysqli_fetch_array($run_user);

               $user_id = $row['user_id'];
               $user_name = $row['user_name'];
               $user_country = $row['user_country'];
               $user_image = $row['user_image'];
               $register_date = $row['user_reg_date'];
               $last_login = $row['user_last_login'];
               
               $user_posts = "select * from posts where user_id='$user_id'";
               $run_post = mysqli_query($con, $user_posts);
               $posts = mysqli_num_rows($run_post);

               //getting the number of uuread massage 
               $sel_msg = "select * from messages where reciver='$user_id' AND status='unread' ORDER by 1 DESC";
               $run_msg = mysqli_query($con,$sel_msg);
               $count_msg = mysqli_num_rows($run_msg);

               echo "
                     <center>
                        <img src='../images/users/$user_image' width='200' height='200' />
                     </center>
                     <div id='user_mention'>
                         <p><strong>Name:</strong> $user_name </P>
                         <p><strong>Country:</strong> $user_country </P>
                         <p><strong>Last Login:</strong> $last_login </P>
                         <p><strong>Member Since:</strong> $register_date </P>
                         <p><a href='my_message.php?u_id=$user_id'>Message($count_msg)</a></P>
                         <p><a href='my_posts.php?u_id=$user_id'>My Post ($posts)</a></P>
                         <p><a href='edit_profile.php'?u_id='$user_id'>Edit My Account</a></P>
                         <p><a href='logout.php'>Logout</a></p>
                     </div><!-- user_mention ends here -->
               ";
            
            ?>
        </div> <!-- user_details ends here -->
    </div><!-- user_timeline ends here -->

    <div id="content_timeline">
	   <?php
	    if(isset($_GET['post_id'])){
			$get_id = $_GET['post_id'];

			$get_post = "select * from posts where post_id='$get_id'";
			$run_post = mysqli_query($con,$get_post);
			$row = mysqli_fetch_array($run_post);

			$post_title = $row['post_title'];
			$post_con = $row['post_content'];
		}
	   ?>
	   <form action="" method="post" id="f">
		   <h2>Edit Your Post</h2>
		   <input type="text" name="title" value="<?php echo $post_title; ?>" size="82" required><br>
		   <textarea cols="83" rows="4" name="content">
			   <?php echo $post_con; ?>
		   </textarea>
		   <select name="topic" id="">
			   <option>Select Topic </option>
			   <?php getTopics(); ?>
		   </select>
		   <input type="submit" name="update" value="Update Post">
       </form> <!-- f ends here -->
       
       <?php
          if(isset($_POST['update'])){
             $title = $_POST['title'];
             $content = $_POST['content'];
             $topic = $_POST['topic'];

             $update_post = "update posts set post_title='$title', post_content='$content' ,topic_id='$topic' where post_id='$get_id'";
             $run_update = mysqli_query($con,$update_post);

             if($run_update){
                 echo "<script>alert('post has been updated')</script>";
                 echo "<script>window.open('../home.php' , '_self')</script>";
             }
          }
       ?>
	   
    </div><!-- content_timeline ends here -->

 </div><!-- content ends here -->



</div><!--container ends here -->   

</body>
</html>