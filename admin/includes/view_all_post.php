<?php
   if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId ){
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options){
                case 'Published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                    $update_to_published_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_published_status);
                    break;
                case 'Draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                    $update_to_draft_status = mysqli_query($connection,$query);
                    confirmQuery($update_to_draft_status);
                    break;
                case 'Delete':
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                    $delete_status = mysqli_query($connection,$query);
                    confirmQuery($delete_status);
                    break;
                case 'Clone':
                    $query = "SELECT * FROM posts Where post_id='{$postValueId}'";
                        $select_posts_query = mysqli_query($connection, $query); 
                        while($row = mysqli_fetch_array($select_posts_query)){
                            $post_id = $row['post_id'];
                            $post_author = $row['post_author'];
                            $post_title = $row['post_title'];
                            $post_category_id = $row['post_category_id'];
                            $post_status = $row['post_status'];
                            $post_image = $row['post_image'];
                            $post_tags = $row['post_tags'];
                            $post_date = $row['post_date'];
                            $post_content = $row['post_content'];  
                        }
                        $query ="INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
                        $query .="VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
                        $copy_query = mysqli_query($connection, $query);
                        if(!$copy_query){
                            die('QUERY FAILED' . mysqli_error($connection));
                        }
                        break;
            }
        }
   }
   
?>
<form action="" method="post">

<table class="table table-bordered table-hover">
    <div id="bulkOptionContainer" class="col-xs-3">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Published">Publish</option>
            <option value="Draft">Draft</option>
            <option value="Delete">Delete</option>
            <option value="Clone">Clone</option> 
        </select>     
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add new</a>
    </div>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAllBoxes"></th>
                                <th> Id</th>
                                <th> Author</th>
                                <th> Title</th>
                                <th> Category</th>
                                <th> Status</th>
                                <th> Images</th>
                                <th> Tags</th>
                                <th> Comments</th>
                                <th> Date</th>
                                <th> View Post</th>
                                <th> Edit</th>
                                <th> Delete</th>
                                <th> Views </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT * FROM posts ORDER BY post_id DESC";
                        $select_posts = mysqli_query($connection, $query); 
                        while($row = mysqli_fetch_assoc($select_posts)){
                            $post_id = $row['post_id'];
                            $post_author = $row['post_author'];
                            $post_user = $row['post_user'];
                            $post_title = $row['post_title'];
                            $post_category_id = $row['post_category_id'];
                            $post_status = $row['post_status'];
                            $post_image = $row['post_image'];
                            $post_tags = $row['post_tags'];
                            $post_comment_count = $row['post_comment_count'];
                            $post_date = $row['post_date'];
                            $post_view_count = $row['post_view_count'];
                            echo "<tr>";
                            ?>
                                <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
                            <?php

                            echo "<td>$post_id</td>";
                            if(!empty($post_author)){
                                echo "<td>$post_author</td>";
                            }else if(!empty($post_user)){
                                echo "<td>$post_user</td>";
                            }
                            
                            echo "<td>$post_title</td>";

                            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                                    $select_categories_id = mysqli_query($connection, $query); 
                                    while($row = mysqli_fetch_assoc($select_categories_id)){
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];  
                                    echo "<td>{$cat_title}</td>";
                                    }
                            echo "<td>$post_status</td>";
                            echo "<td><img class='img-responsive' src='../images/$post_image' alt='image'></td>";
                            echo "<td>$post_tags</td>";
                            //count comment
                            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                            $send_comment_query = mysqli_query($connection, $query);
                            $row = mysqli_fetch_assoc($send_comment_query);
                            $count_comments = mysqli_num_rows($send_comment_query);
                            if($count_comments > 0){
                                $comment_post_id = $row['comment_post_id'];
                                echo "<td><a href='post_comments.php?id=$comment_post_id'>$count_comments</a></td>";
                            }else{
                                echo "<td><a href='#'>$count_comments</a></td>";
                            }
                            echo "<td>$post_date</td>";
                            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>View Post</a></td>";
                            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                            echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
                            echo "<td><a href='posts.php?reset={$post_id}'>{$post_view_count}</a></td>";
                            echo "</tr>";
                        }
                        ?>
                        
                    </tbody>
                    </table>
                    <?php
                        if(isset($_GET['delete'])){
                            $the_post_id = $_GET['delete'];
                            $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
                            $delete_query = mysqli_query($connection, $query);
                            header("Location: posts.php");
                        }
                        if(isset($_GET['reset'])){
                            $the_post_id = $_GET['reset'];
                            $query = "UPDATE posts SET post_view_count=0 WHERE post_id= " .mysqli_real_escape_string($connection, $_GET['reset']) ." ";
                            $reset_query = mysqli_query($connection, $query);
                            header("Location: posts.php");
                        }
                    ?>
                    </form>