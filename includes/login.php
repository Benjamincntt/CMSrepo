<?php include "db.php";?>
<?php session_start();?>
<?php
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = mysqli_real_escape_string($connection,$username);
    $password = mysqli_real_escape_string($connection,$password);

    $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
    $select_user_query =  mysqli_query($connection, $query);
    if(!$select_user_query){
        die("query failed" );
    }
    while($row = mysqli_fetch_array($select_user_query)){
        
       $db_id = $row['user_id'];
       $db_username = $row['user_name'];
       $db_password = $row['user_password'];
       $db_firstname = $row['user_firstname'];
       $db_lastname = $row['user_lastname'];
       $db_role = $row['user_role']; 
    }

    if($username === $db_username && password_verify($password, $db_password)==true){
        $_SESSION['username'] = $db_username;      
        $_SESSION['user_role'] = $db_role;
        header("Location: ../admin");
    }else{
        header("Location: ../index.php");
        }
    }
?>