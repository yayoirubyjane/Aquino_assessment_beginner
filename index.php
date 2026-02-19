<?php
include "db.php";
 
$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];
 
$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>
<body>

<?php include "nav.php"; ?>

<div class="wrapper py-5">
    <div class="d-flex flex-column justify-content-center align-items-center gap-3">
        
        <div class="card p-5 shadow-md rounded-5" style="width: 26rem;">
            <h2 style="font-weight: 600; text-align: center; color: #443A35;">Dashboard</h2>
            
            <hr>

            <ul style="list-style-type: none; padding: 0; font-size: 1.1rem; line-height: 2;">
                <li class="d-flex justify-content-between">Total Clients: <b><?php echo $clients; ?></b></li>
                <li class="d-flex justify-content-between">Total Services: <b><?php echo $services; ?></b></li>
                <li class="d-flex justify-content-between">Total Bookings: <b><?php echo $bookings; ?></b></li>
                <li class="d-flex justify-content-between">Total Revenue: <b class="text-success">₱<?php echo number_format($revenue,2); ?></b></li>
            </ul>

            <hr>

            <p style="text-align: center; font-size: 0.9rem; margin-bottom: 10px;">Quick links</p>
            <div class="d-flex flex-column gap-2">
                <a href="/assessment_beginner/pages/clients_add.php" class="btn btn-outline-dark" style="border-radius: 8px;">Add Client</a>
                <a href="/assessment_beginner/pages/bookings_create.php" class="btn btn-outline-dark" style="border-radius: 8px;">Create Booking</a>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>