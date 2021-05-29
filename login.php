<?php
include_once("html_header.php");

$pageTitle = "Fast Food Order - Login"; //change "Template" to whatever needed
?>

<html lang="en">

<html lang="en">

<head>
    <link href="loginStyle.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>


<body>
    <?php
    if (isset($_POST["login"])) {
        //echo "Login request recieved <br>";
        if ($system->login($_POST["username"], $_POST["password"])) {
            echo "<script> window.alert('Login Successful'); window.location.replace('home.php')</script>";
        } else {
            echo "<script> window.alert('Login failed');</script>";
        }
    }
    ?>

    <div id="loginContainer">
        <!-- INSERT CODE HERE -->
        <b>Account Sign In</b>
        <form action="" method="post">
            <br> Username : <input type="text" placeholder="Username" name="username" />
            <br> Password : <input type="password" placeholder="Password" name="password" />
            <input type="hidden" name="login" value="1">
            <br><br> <button type="submit" class="loginButton">Login</button>
        </form>
        <button class="regButton" onclick="document.location='Register.php'">Don't have an account?<br>Register here</button>
    </div>
</body>

<?php
include_once("footer.php");
?>

<html>