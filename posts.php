<div class="posts mt-3 mb-3 p-3">
    <?php
    $sql="SELECT * FROM posts";
    $sqlquery=$conn->query($sql);

    while($row=$sqlquery->fetch_assoc()) {
        
        $row_userid=$row["userid"];
        $postid=$row["postid"];
        
        $sqluser="SELECT username FROM users WHERE userid = $row_userid";
        $sqluserquery=$conn->query($sqluser);
        $username=($sqluserquery -> fetch_assoc());

        echo"<div id='".$row['postdatetime']."' class='posthead'><div class='text-start p-2'>".strtoupper($username["username"])."</div>";
        
        if (isset($_COOKIE["user"]) && $_COOKIE["user"]==$username["username"]) { echo "<div class='text-center'><form action='index.php' method='POST'><input type='hidden' name='deleteidpost' value='".$postid."'><button type='submit' class='deletebutton btn-sm mt-1 mb-0' name='submitdelete'>Delete</button></form></div>";
        } else { echo"<div></div>"; }

        echo "<div class='text-center p-2'>".$row['postdatetime']."</div></div><div class='posttext p-2'>".$row['posttext']."</div>";
    }
    ?>
</div>