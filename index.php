<?php
    require_once("connect.php");

    // User Quit //
    if (isset($_GET["inc"])) {
        $_SESSION["inc"]=$_GET["inc"];
        if ($_SESSION["inc"]==="quit") {
            if (isset($_COOKIE["user"])) {
                setcookie("user",$_COOKIE["user"], time()-3000);
                $_SESSION["inc"]="";
                $_SESSION["passwordin"]="";
                $_SESSION["username"]="";
                header("Location: index.php");
            }
        }
    }

    // Login //
    if (isset($_POST["submitlogin"])) {
        $checkinputs=true;
        if (!strlen($_POST["passwordin"])>0) {
            $_SESSION["error_text"]="Password is missing!";
            $checkinputs=false;
        } else { 
            $_SESSION["passwordin"]=$_POST["passwordin"]; 
        }

        if (!strlen($_POST["username"])>0) {
            $_SESSION["error_text"]="Username is missing!";
            $checkinputs=false;
        } else { 
            $_SESSION["username"]=$_POST["username"];
        }

        if ($checkinputs===true) {

            $sqluserdatas = "SELECT username, userpassword FROM users";
            $sqluserdatasrequest = $conn->query($sqluserdatas);
            
            echo "Inputs: ".$_POST["username"]."<br>"; echo "".$_POST["passwordin"]."<br>";

            while($row= $sqluserdatasrequest->fetch_assoc()) {
                //echo "1. ".$row["username"]." 2. ".$row["userpassword"]."<br>";
                if ($row["username"]==$_POST["username"] && $row["userpassword"]==$_POST["passwordin"]) {
                    setcookie("user", $row["username"], time()+3000);
                    $_SESSION["passwordin"]="";
                    $_SESSION["username"]="";
                    header("Location: index.php");
                } else {
                    $_SESSION["error_text"]="Incorrect login!";
                }
            }
        }
    }

    //Registration
    if (isset($_POST["registrationsubmit"])) {

        echo $_POST["newusername"]."<br>";
        echo $_POST["regpasswordin"]."<br>";
        echo $_POST["repeatregpasswordin"]."<br>";

        if (isset($_POST["newusername"])) { $_SESSION["newusername"]=$_POST["newusername"]; }
        if (isset($_POST["regpasswordin"])) { $_SESSION["regpasswordin"]=$_POST["regpasswordin"]; }

        if (strlen($_POST["newusername"])>0) {

            if (strlen($_POST["regpasswordin"])>0) {
                if ($_POST["regpasswordin"]==$_POST["repeatregpasswordin"]) {
                    echo "Bent vagyok a SQL-nél!!!<br>";
                    $sql="SELECT * FROM users";
                    $sqlquery=$conn->query($sql);
                    
                    $nameisset=false;
                    
                    while ($row = $sqlquery->fetch_assoc()) {
                        echo "Bent vagyok a ROW-nál!!!<br>";
                        if ($_POST["newusername"]==$row["username"]) {
                            $nameisset=true;
                            $_SESSION["registrationmessage"]="Username exists!";
                        }
                    }

                    if ($nameisset==false) {
                        echo "WRITE!!!<br>";
                        $usernameinsert=$_POST["newusername"];
                        $passwordinsert=$_SESSION["regpasswordin"];

                        $sqlwrite="INSERT INTO users (username, userpassword) VALUES ('$usernameinsert', '$passwordinsert')";
                        if ($conn->query($sqlwrite) === true) {
                            echo"WRITE!!!<br>";
                            $_SESSION["registrationmessage"]="The new user has been added to the database!";
                            $_SESSION["newusername"]="";
                            $_SESSION["regpasswordin"]="";
                        } else {
                            echo "ERROR: ".$conn->error."<br>";
                        }
                    }

                } else {
                    $_SESSION["registrationmessage"]="passwords do not match!";
                }
            } else {
                $_SESSION["registrationmessage"]="passwords is missing!";
            }
        } else {
            $_SESSION["registrationmessage"]="Username is missing!";
        }
    }
    
    // Insert Message
    if (isset($_POST["submitinsert"])) {
        //echo "newmessage: ".$_POST["newmessage"]."<br>";
        if (strlen($_POST["newmessage"])>0) {
            if (isset($_COOKIE["user"])) {

                $row_username=$_COOKIE["user"];
                $sqluserid="SELECT userid FROM users WHERE username = '$row_username'";
                $sqluseridquery=$conn->query($sqluserid);
                $row = $sqluseridquery -> fetch_assoc();
                
                $useridinsert=$row["userid"];
                $inserttext=$_POST["newmessage"];
                $insertdatetime = date('Y-m-d H:i:s');

                $sql="INSERT INTO posts (posttext, postdatetime, userid) VALUES ('$inserttext', '$insertdatetime', '$useridinsert')";
                if ($conn->query($sql) === TRUE) {
                    header('Location: index.php');
                } else {
                    echo "ERROR: ".$conn->error."<br>";
                }
            }
        } else {
            $_SESSION["error_text"]="The message is missing!";
        }
    }

    //Delete message
    if (isset($_POST["submitdelete"])) {
        echo "POST deleteid: ".$_POST["deleteidpost"]."<br>";
        $deleteid=$_POST["deleteidpost"];
        $sql = "DELETE FROM posts WHERE postid = '$deleteid'";
        if ($conn->query($sql) === TRUE) {
            echo "Töröltük!<br>";
        } else {
            echo "ERROR: ".$conn->error."<br>";
        }
    }

    // Upload File
    if(isset($_POST["upload"])) {
        $directorie = "files/";
        $filename = $_FILES["file"]["name"];
        $temporary = $_FILES["file"]["tmp_name"];
        $fajlmeret = $_FILES["file"]["size"];

        if(!preg_match('/(txt|csv)$/i',$filename)) {
            $_SESSION["uploadmessage"]="The file extension is incorrect!";
        } else {
            if($fajlmeret > 3145728){
                $_SESSION["uploadmessage"]="File size exceeds allowed!";
            }
            else{
                move_uploaded_file($temporary, $directorie.$filename);
                $_SESSION["uploadmessage"]="File upload successful!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Mini PHP Guestbook</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="head col-12 bg-primary p-3">
                | <span><a class="menutext" href="index.php?inc=home">Home</a></span> |
                <span><a class="menutext" href="index.php?inc=upload">Upload File</a></span> |
                <?php 
                if (!isset($_COOKIE["user"])) {
                echo "<span'><a class='menutext' href='index.php?inc=registration'>Registration</a></span> |";
                }
                if (isset($_COOKIE["user"])) {
                    echo "<span class='headuser'><a class='menutext' href='index.php?inc=quit'>Log Out</a></span>";
                } else {
                    echo "<span class='headuser'><a class='menutext' href='index.php?inc=login'>Log In</a></span>";
                }
                ?>
            </div>
            <div class="contnetcenter col-12 mt-3">
            <?php
            if (isset($_COOKIE["user"])) { include_once("main.php"); }
                if (isset($_SESSION["inc"])) {
                    if ($_SESSION["inc"]==="login") {
                        include_once("login.php");
                    }

                    if ($_SESSION["inc"]==="upload") {
                        include_once("upload.php");
                    }

                    if ($_SESSION["inc"]==="profile") {
                        include_once("profile.php");
                    }

                    if ($_SESSION["inc"]==="registration") {
                        include_once("registration.php");
                    }
                }
            include("posts.php");
            if (isset($_COOKIE["user"])) { include_once("usermessage.php"); }
            ?>
            </div>
            <div class="footer col-12 bg-primary p-3 mt-3">
                <a href="#" class="menutext">Jump</a>
            </div>
        </div>
    </div>
</body>
</html>