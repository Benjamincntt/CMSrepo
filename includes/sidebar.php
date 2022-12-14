            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit" name="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                        <!-- login -->
                <div class="well">
                    <h4>Login</h4>
                    <form action="includes/login.php" method="POST" >
                        <div class="form-group">
                            <input type="text" id="username" name="username" placeholder="Tài khoản" class="form-control"/>
                        </div>
                            
                        <div class="input-group">
                            <input type="password" id="password" name="password" placeholder="Mật khẩu" class="form-control"/>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" name="login">
                                    <span >Đăng nhập</span>
                                </button>
                            </span>
                        </div>
            
        </form>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">                

                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                    $query = "SELECT * FROM categories";
                                    $select_categories_sidebar = mysqli_query($connection, $query);  
                                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['cat_id'];
                                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>            
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php";?>

            </div>
