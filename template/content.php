
<!-- CONTENT START HERE 
============================================================== -->
<div id="content">
    <div>
        <img src="images/image1.png" style="float:left; margin-left:-40px;" />
    </div>
    <div id="form2">
        <form action="" method="post" >
            <h2> Sign Up Today </h2>
            <table>
                <tr>
                   <td align="right"><strong>Name : </strong></td>
                   <td><input type="texy" name="u_name" placeholder="write your name" required/></td>
                </tr>
                <tr>
                   <td align="right"><strong>Password : </strong></td>
                   <td><input type="password" name="u_pass" placeholder="write your name" required/></td>
                </tr>
                <tr>
                   <td align="right"><strong>Email : </strong></td>
                   <td><input type="email" name="u_email" placeholder="write your name" required/></td>
                </tr>
                <tr>
                   <td align="right"><strong>Country : </strong></td>
                   <td>
                       <select name="u_country">
                          <option>India</option> 
                          <option>United state</option>
                          <option>Bangaladesh</option> 
                          <option>Pakistan</option>
                          <option>Sreelanka</option>
                          <option>Afganistan</option>

                       </select>
                   </td>
                </tr>
                <tr>
                   <td align="right" ><strong>Gender : </strong></td>
                   <td>
                       <select name="u_gender">
                         <option>Male</option>
                         <option>Female</option>
                       </select>
                   </td>
                </tr>
                <tr>
                   <td align="right" ><strong>Birthday : </strong></td>
                   <td><input type="date" name="u_birthday" required/></td>
                </tr>
                <tr>
                   <td colspan="6"><button name="sign_up">Sign Up</button></td>
                </tr>  
            </table>
        </form>
        <?php include("insert_user.php");   ?>

    </div> <!-- form2 ends here -->
    
</div> <!-- content ends here -->