<?php
if(isset($_POST['create_user'])){
    $user_name = escape($_POST['user_name']);
    $user_firstname= escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    $user_password = hash_password(escape($_POST['user_password']));

    // $user_image = $_FILES['image']['name'];
    // $user_image_temp = $_FILES['image']['tmp_name'];
    $user_role = escape($_POST['user_role']);

    // move_uploaded_file($user_image_temp, "../images/$user_image");

    $query ="INSERT INTO users(user_name, user_password, user_firstname, user_lastname, user_email, user_role) ";
    $query .="VALUES('{$user_name}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_role}')";
    $create_user_query = mysqli_query($connection, $query);
    
    confirmQuery($create_user_query);
    echo "User Created: " . " " . "<a href='users.php'> View user</a>";
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="Admin">Select Option</option>
            <option value="Admin">Admin</option>
            <option value="Subscriber">Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_name">User name</label>
        <input type="text" class="form-control" name="user_name">
    </div>
    <!-- <select name="user_role" id="">
    <?php
        // $query = "SELECT * FROM users";
        // $select_users = mysqli_query($connection,$query);
        // confirmQuery($select_users);
        // while($row = mysqli_fetch_assoc($select_users)){
        //     $user_id = $row['user_id'];
        //     $user_role = $row['user_role'];
        //     echo "<option value='$user_id'>{$user_role}</option>";
        // }
    ?>
    </select> -->
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="text" class="form-control" name="user_password">
    </div>

    <!-- <div class="form-group">
        <label for="user_image">user Image</label>
        <input type="file" name="image">
    </div> -->
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add user"> 
    </div>
</form>
