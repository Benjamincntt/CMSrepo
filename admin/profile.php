
<?php include "includes/admin_header.php";?>
<?php
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
        $select_user_profile_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($select_user_profile_query)){
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];

        }
    }
?>
<?php
     if(isset($_POST['update_profile'])){
        $user_name = $_POST['user_name'];
        $user_firstname= $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];


        $query_password = "SELECT user_password FROM users WHERE user_name = '{$username}'";
        $get_user_query = mysqli_query($connection,$query_password);
        confirmQuery($get_user_query);
        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['user_password'];
            if($db_user_password!= $user_password){
                $hashed_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost'=>12));
            }


        $query = "UPDATE users SET ";
        $query .="user_name   = '{$user_name}', ";
        $query .="user_password = '{$hashed_password}', ";
        $query .="user_firstname  = '{$user_firstname}', ";
        $query .="user_lastname  = '{$user_lastname}', ";
        $query .="user_email  = '{$user_email}' ";
        $query .="WHERE user_name = '{$username}' ";
        $update_user = mysqli_query($connection,$query);
        confirmQuery($update_user);
        header("Location: users.php");
    }

?>
    <div id="wrapper">
        <?php include "includes/admin_navigation.php";?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            CHÀO MỪNG ĐẾN TRANG QUẢN TRỊ
                            <small><?php echo $user_name;?></small>
                        </h1>
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
                                <label for="user_name">User name</label>
                                <input type="text" class="form-control" name="user_name" value="<?php echo $user_name;?>">
                            </div>

                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="text" class="form-control" name="user_email"value="<?php echo $user_email;?>">
                            </div>

                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input autocomplete="off" type="text" class="form-control" name="user_password">
                            </div>
                            
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile"> 
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        <?php include "includes/admin_footer.php";?>