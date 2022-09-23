<?php
if(isset($_GET['user_id'])){
    $the_user_id = $_GET['user_id'];

    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection, $query); 
    while($row = mysqli_fetch_assoc($select_users_query)){
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];

    }
}
    if(isset($_POST['edit_user'])){
        $user_name = $_POST['user_name'];
        $user_firstname= $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_role = $_POST['user_role'];


        $query = "SELECT randSalt FROM users";
            $select_randsalt_query = mysqli_query($connection, $query);
            if(!$select_randsalt_query){
                die("Query Failed" . mysqli_error($connection));
            }
        $row = mysqli_fetch_array($select_randsalt_query);
        $salt = $row['randSalt'];
        $hashed_password = crypt($user_password, $salt);

        $query = "UPDATE users SET ";
        $query .="user_name   = '{$user_name}', ";
        $query .="user_password = '{$hashed_password}', ";
        $query .="user_firstname  = '{$user_firstname}', ";
        $query .="user_lastname  = '{$user_lastname}', ";
        $query .="user_email  = '{$user_email}', ";
        $query .="user_role    = '{$user_role}' ";
        $query .="WHERE user_id = {$the_user_id} ";
        $update_user = mysqli_query($connection,$query);
        confirmQuery($update_user);
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname;?>">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname"value="<?php echo $user_lastname;?>">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
            <?php
            if($user_role == 'Admin'){
                echo "<option value='Subscriber'>Subscriber</option>";
            }else{
                echo "<option value='Admin'>Admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="user_name">User name</label>
        <input type="text" class="form-control" name="user_name" value="<?php echo $user_name;?>">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" class="form-control" name="user_email"value="<?php echo $user_email;?>">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="text" class="form-control" name="user_password" value="<?php echo $user_password;?>">
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Edit user"> 
    </div>
</form>
