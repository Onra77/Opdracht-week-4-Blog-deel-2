<?php include 'header.php';?>
<body>

    <?php
    $sql = "SELECT * FROM categories ORDER BY id ASC";
    $res = mysqli_query($db, $sql) or die(mysqli_error($db));
    //$post ="";
    if(mysqli_num_rows($res) >0) {
        while($row = mysqli_fetch_assoc($res)) {
            $tagid = $row['id'];
            echo "<input type='radio' name='cats[]' value='$tagid'  />";
            echo $row['category'];
            }
        }else {echo "Geen categorieën.";
            }
    ?>
        
    <div id=makeup>
        <?php if(isset($_SESSION['username'])) { ?>
            <input type="button" value="Logout" onclick="logout();">
            <?php echo $_SESSION['username']; ?>
            <input type="button" value="Nieuwe bericht" onclick="location.href='post.php';">
            <input name="post" type="submit" value="Filter">    
            
        <?php 
            //true al ingelogd
            } else{
        ?>
            <input type="button" value="Login" onclick="login();">
            <input type="button" value="Registeer" onclick="location.href='register.php';">
        <?php } ?>
        
        <?php
            require_once("nbbc.php");
            $bbcode = new BBCode;
            //$sql = "SELECT * FROM post ORDER BY id DESC";
            $sql = "SELECT * FROM post WHERE cat_id like '3' ORDER BY id DESC";       
            
            /*    
            $x = 1;
            if ($x == 1) {
            echo $sql = "SELECT * FROM post WHERE cat_id like '1' ORDER BY id DESC;
            }
            elseif ($x == 2) {
            echo $sql = "SELECT * FROM post WHERE cat_id like '2' ORDER BY id DESC;
            }
            elseif ($x == 3) {
            echo $sql = "SELECT * FROM post WHERE cat_id like '3' ORDER BY id DESC;
            }
            elseif ($x == 4) {
            echo $sql = "SELECT * FROM post WHERE cat_id like '4' ORDER BY id DESC;
            }
            elseif ($x == 5) {
            echo $sql = "SELECT * FROM post WHERE cat_id like '5' ORDER BY id DESC;
            }
            elseif ($x == 6) {
            echo $sql = "SELECT * FROM post WHERE cat_id like '6' ORDER BY id DESC;
            }
            else {
            echo $sql = "SELECT * FROM post ORDER BY id DESC";
            }   */
               
            $res = mysqli_query($db, $sql) or die(mysqli_error($db));
            $post ="";
            // Geeft verschillende knoppen als je ingelog bent of niet.   
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                //true al ingelogd
                if(mysqli_num_rows($res) >0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $content = $row['content'];
                        $author = $row['author'];
                        //$cats = $row['cat_id'];
                        $date = $row['date'];
                        $admin = "<div><a href='del_post.php?pid=$id'>Delete</a>&nbsp;<a href='edit_post.php?pid=$id'>Edit</a>&nbsp;<a href='post.php?pid=$id'>New</a></div>";
                        $output = $bbcode->Parse($content);
                        $post = "<div><h2><a href='view_post/php?pid=$id'>$title</a></h2><H2>$author</h2><h3>$date</h3><p>$output</p>$admin</div>";
                        echo $post;
                        //select * from post where cat_id =2;
                    }
                } else {    echo "er zijn geen berichten.";
                    }
                    } else if(mysqli_num_rows($res) >0) {
                        while($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $content = $row['content'];
                            $date = $row['date'];
                            $output = $bbcode->Parse($content);
                            $post = "<div><h2><a href='view_post/php?pid=$id'>$title</a></h2><h3>$date</h3><p>$output</div>";
                            echo $post;
                        } 
                    }
        ?>

    </div>

    <script>
        function login() {
            location.href = "login.php";
        }
        function logout() {
            location.href = "logout.php";
        }
    </script>
</body>  
</html>