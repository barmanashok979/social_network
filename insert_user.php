<?php
include("includes/connection.php");

  if(isset($_POST['sign_up'])){
     $name = mysqli_real_escape_string($con,$_POST['u_name']);
     $pass = mysqli_real_escape_string($con,$_POST['u_pass']);
     $email = mysqli_real_escape_string($con,$_POST['u_email']);
     $country = mysqli_real_escape_string($con,$_POST['u_country']);
     $gender = mysqli_real_escape_string($con,$_POST['u_gender']);
     $birthday = mysqli_real_escape_string($con,$_POST['u_birthday']);
     $status = "unverified";
     $post ="no";
     $ver_code = mt_rand();

      if(strlen($pass)<8){
        echo "<script>alert('password minimum 8 cherecter');</script>";
        exit();
       }

       $check_email = "select * from users where user_email='$email'";
       $run_email = mysqli_query($con,$check_email);
       $check = mysqli_num_rows($run_email);

       if($check==1){

             echo "<script> alert('email already exits , please try another email' );</script>";
             exit();

       }

       

       $insert = "insert into users 
                 (user_name, user_pass, user_email, user_country, user_gender, user_birthday, user_image,user_reg_date, status, ver_code, posts  ) values 
                 ('$name', '$pass', '$email', '$country', '$gender', '$birthday','default.jpeg', NOW(), '$status', '$ver_code', '$post')";
       $query = mysqli_query($con,$insert);

       if($query){

        echo "<h3 style='font-size:18px;width:400px;color:green;padding:10px;'>
                check your email for final varification
             </h3>";

       }else {
         echo "<h3 style='width:400px;color:red;padding:10px;'>
             Registration faild , try again 
         </h3>";

       }
  }



?>