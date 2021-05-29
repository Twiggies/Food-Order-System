<?php
include_once("html_header.php");

$pageTitle = "User - Settings"; //change "Template" to whatever needed
?>

<html lang="en">

<head>
    <link href="admin2.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<?php
if (isset($_POST["changePass"])) {
    if ($system->updatePassword($_POST["oldPass"], $_POST["newPass"])) {
        echo "<script>window.alert('Password changed successfully.'); window.location.replace('settings.php')</script>";
    } else {
        echo "<script>window.alert('Password change failed.'); window.location.replace('settings.php')</script>";
    }
}

if (isset($_POST["deleteAccount"])) {
    if ($system->deleteAccount($system->getSession()->getUsername())) {
        echo "<script>window.alert('Account removed.'); window.location.replace('home.php')</script>";
    } else {
        echo "<script>window.alert('Account cannot be removed. Contact an admin.'); window.location.replace('home.php')</script>";
    }
}
?>

<body>
    <div id="container">
        <?php
        if (!$system->isLoggedIn()) {
            echo "<div id='overlay'>Account <a href='login.php'>log in</a> is required to access settings.</div>";
        } else {
            echo "<h3 class='head'>Change password</h3>";
            echo "<form class='addForm' action='' method='post'>";
            echo "<input type='hidden' name='changePass' value='1'>";
            echo "<p>";
            echo "<label> Old Password:</label> <input type='text' name='oldPass'>";
            echo "</p>";
            echo "<p>";
            echo "<label> New Password:</label> <input type='text' name='newPass'>";
            echo "</p>";
            echo "<br><button class='addBtn' name='changePass' type='submit'>Change Password</button>";
            echo "</form>";
            echo "<h3>Account removal</h3>";
            echo "<form class='addForm' action='' method='post'>";
            echo "<button class='addBtn' name='deleteAccount' type='submit'>Delete Account</button>";
            echo "</form>";
            echo "<p style=color:red >Note: You cannot recover your account after removal</p><br>";
        }
        ?>
    </div>
</body>

<?php
include_once("footer.php");
?>

</html>