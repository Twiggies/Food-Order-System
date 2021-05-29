<?php
include_once("html_header.php");

$pageTitle = "Fast Food Order - Contact Us"; //change "Template" to whatever needed



?>

<html lang="en">

<head>
    <link href="contactUs.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<body>
    <div id="contactContainer">
        <div id="contactMain">
            <p>Should you have any inquiries or feedbacks, contact us here:</p>
            <p>Email: <a href="mailto:ffOrders@gmail.com">ffOrders@gmail.com</a> </p>
            <p>Phone Number: 0320-69-8888</p>
            <p>Our location: </p>
            <p>42, Jalan Foodies 23 <br>
                55100 Kuala Lumpur, Malaysia</p>
        </div>
    </div>
</body>

<?php
include_once("footer.php");
?>

</html>