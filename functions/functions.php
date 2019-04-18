<?php
$con = mysqli_connect("localhost", "root", "", "social_media") or die ("connection was not established");


//FUNCTION FOR GETTING TOPICS
function getTopics(){
 global $con;

 $get_topics = "select * from topics";

 $run_topics = mysqli_query($con,$get_topics);

 while($row=mysqli_fetch_array($run_topics)){
    $topic_id = $row['topic_id'];
	$topic_name = $row['topic_name'];
	
	echo "
	  <option value='$topic_id'>$topic_name </option>
	";
 }

}


//FUNCTION FOR INSERTING POSTS

function insertPosts() {
 global $con;
 
 if(isset($_POST['sub'])){
	global $user_id;
   $title = addslashes($_POST['title']);
	 $content = addslashes($_POST['content']);
	 $topic = $_POST['topic'];
	
   if($content=='' OR $title==''){
	  echo "<h2>Please Onter topic descriotion</h2>";
	  exit();
	 } else {
	
	       $insert = "insert into posts (user_id,topic_id,post_title,  post_content,post_date) values ('$user_id', '$topic', '$title' , '$content' , now())";
	  
	  $run = mysqli_query($con,$insert);

	  if($run){
		  echo "<h3>Post To timeline , Looks great";

		  $update = "update users set posts='yes' where user_id='$user_id'";
		  $run_update = mysqli_query($con,$update);
	  }
	}


 }

}

//GET_POSSTS() STAET HERE 

function getPosts(){
 global $con;

 //pagination
  $per_page = 5;
 if(isset($_GET['page'])){
  $page = $_GET['page'];
 } else {
	 $page = 1;
 } 
 $start_from = ($page-1) * $per_page;
 
	
 $get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";
 
 $run_posts = mysqli_query($con,$get_posts);
 while($row_posts = mysqli_fetch_array($run_posts)){
	 
	$post_id = $row_posts['post_id'];
	$user_id = $row_posts['user_id'];
	$post_title = $row_posts['post_title'];
	$content =substr($row_posts['post_content'],0,120);
	$post_date = $row_posts['post_date'];

	//getting the user who has posted the thread

	$user = "select * from users where user_id='$user_id' AND posts='yes'";
	$run_user = mysqli_query($con,$user);
	$row_user = mysqli_fetch_array($run_user);
	$user_name = $row_user['user_name'];
	$user_image = $row_user['user_image'];

	echo "

		 <div id='posts'>
				<p><img src='images/users/$user_image' width='50' height='50' /></p>
				<h3><a id='user_s' href='user_profile.php?u_id=$user_id'>By : $user_name</a></h3>
				<h3>$post_title</h3>
				<p><strong id='date_p'>Post time: $post_date</strong></p>
				<p>$content</p>
				<a href='single.php?post_id=$post_id' style='float:right;'><button>See Replies or Reply To this</button></a>
		 </div> <br> <!-- posts ends here -->
		 ";

 }
  include("functions/pagination.php");
}

//SINGLE POST START HERE 

function single_post(){
  if(isset($_GET['post_id'])){
		global $con;
		$get_id = $_GET['post_id'];
		$get_posts = "select * from posts where post_id='$get_id'";
		$run_post = mysqli_query($con,$get_posts);
		$row_posts = mysqli_fetch_array($run_post);

		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$post_title = $row_posts['post_title'];
		$content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];

		//getting the user who has posted the thread

  	$user = "select * from users where user_id='$user_id' AND posts='yes'";
  	$run_user = mysqli_query($con,$user);
  	$row_user = mysqli_fetch_array($run_user);
  	$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];
		
		//geting the user session 
    $user_com = $_SESSION['user_email'];
		$get_com = "select * from users where user_email='$user_com'";
		$run_com = mysqli_query($con,$get_com);
		$row_com = mysqli_fetch_array($run_com);
    $user_com_id = $row_com['user_id'];
		$user_com_name = $row_com['user_name'];
		
		//now display all at once
		echo "
	    	<div id='posts'>
	       	<p><img src='images/users/$user_image' width='50' height='50' /></p>
	      	<h3><a id='user_s' href='user_profile.php?u_id=$user_id'>By :       $user_name</a></h3>
		      <h3>$post_title</h3>
	      	<p><strong id='date_p'>Post time: $post_date</strong></p>
	      	<p>$content</p>
		      
        </div> <br> <!-- posts ends here -->
				 ";
				 include("functions/comments.php");

					 echo "
						 <form action='' method='post' id='reply'>
								<textarea cols='50' rows='5' name='comment' placeholder='write your reply...'></textarea> <br>
								<input type='submit' name='reply' value='Reply to This' />
						 </form><!-- reply ends here -->
					";
          if(isset($_POST['reply'])){
						$comment = $_POST['comment'];
						$insert = "insert into comments (post_id,user_id,comment,comment_author,date) values ('$post_id','$user_id','$comment','$user_com_name',NOW())";
						$run = mysqli_query($con,$insert);

						echo "<h2>Your Reply was added </h2>";
					} 

	}

}

// members start here 

function members(){
	global $con;
	//select members
	$user = "select * from users LIMIT 0,20";
	$run_user = mysqli_query($con,$user);

	echo "<h2>New members on this site :</h2>";
	while($row_user=mysqli_fetch_array($run_user)){
    $user_id = $row_user['user_id'];
    $user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];
		
		echo "
					<span>
						<a href='user_profile.php?u_id=$user_id'>
							<img src='images/users/$user_image' width='50' height='50' title='$user_name' style='float:left;padding:10px;margin:4px' />
						</a>
					</span>
		    ";
	}
}
