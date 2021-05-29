<?php
include_once("html_header.php");
$pageTitle = "Fast Food Order - Register"; //change "Template" to whatever needed

//register
if (isset($_POST["register"])) {
    if ($system->register($_POST["username"], $_POST["password"], $_POST["address"])) {
        echo "<script>window.alert('Registration successful!'); window.location.replace('login.php')</script>";
    } else {
        echo "<script>window.alert('Registration failed!'); window.location.replace('Register.php')</script>";
    }
}
?>

<html lang="en">

<head>
    <link href="loginStyle.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<body>
    <div id="registerContainer">
        <b>
            <h2> Register </h2>
            <br>
            <form action="" method="post">
                <br> Username : <input type="text" placeholder="Username" name="username" />
                <br> Password : <input type="password" placeholder="Password" name="password" />
                <br> Address : <input type="text" placeholder="Address" name="address" />
                <input type="hidden" name="register" value="1">
                <br> <input type="submit" />
            </form>
            </br>
        </b>
    </div>
</body>

<?php
include_once("footer.php");
?>

<html>