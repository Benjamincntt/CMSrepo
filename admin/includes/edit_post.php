<?php
if(isset($_GET['p_id'])){
    $the_post_id =  $_GET['p_id'];
    


$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_posts = mysqli_query($connection, $query); 
    while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }
}
    if(isset($_POST['update_post'])){
        $post_author = $_POST['author'];
        $post_title = $_POST['title'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        $post_content = $_POST['post_content'];
        $post_tags = $_POST['post_tags'];

        move_uploaded_file($post_image_temp, "../images/$post_image");
        if(empty($post_image)){
            $query_image = "SELECT * FROM posts WHERE post_id = $the_post_id";
            $select_image = mysqli_query($connection, $query_image); 
            while($row = mysqli_fetch_assoc($select_image)){
                $post_image = $row['post_image'];
            }
        }

        $query = "UPDATE posts SET ";
        $query .="post_title   = '{$post_title}', ";
        $query .="post_category_id = '{$post_category_id}', ";
        $query .="post_date    = now(), ";
        $query .="post_author  = '{$post_author}', ";
        $query .="post_status  = '{$post_status}', ";
        $query .="post_tags    = '{$post_tags}', ";
        $query .="post_content = '{$post_content}', ";
        $query .="post_image   = '{$post_image}' ";
        $query .="WHERE post_id = {$the_post_id} ";
        $update_post = mysqli_query($connection,$query);
        confirmQuery($update_post);
        header("Location: posts.php");
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title;?>" type="text" class="form-control" name="title">
    </div>
    <div class="row">   
        <div class="form-group col-lg-2">
            <label for="title">Post Category</label>
            <select class="form-control" name="post_category" id="">
                <?php
                    $query = "SELECT * FROM categories";
                    $select_categories = mysqli_query($connection, $query);
                    confirmQuery($select_categories);

                    while($row = mysqli_fetch_assoc($select_categories)){
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];   
                        echo "<option value='{$cat_id}'>{$cat_title}</option>";
                    }
                ?>
                
            </select>
        </div>
        <div class="form-group col-lg-2">
            <label for="title">Post Status</label>
            <select class="form-control" name="post_status" id="">
                <option value='<?php echo $post_status;?>'><?php echo $post_status;?></option>
                <?php
                    if($post_status == 'published'){
                        echo "<option value='draft'>draft</option>";
                    }else{
                        echo "<option value='published'>published</option>";
                    }
                ?>
            </select>
        </div> 
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input value="<?php echo $post_author;?>" type="text" class="form-control" name="author">
    </div>
    
       

    <div class="form-group">
        <img width=200px src="../images/<?php echo $post_image;?>" alt="">
        <input  type="file" class="form-control" name="post_image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags;?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10">
        <?php echo $post_content;?>"
        </textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post"/> 
    </div>
</form>