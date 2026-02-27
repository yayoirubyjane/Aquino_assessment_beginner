<?php
include "../db.php";
 
$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="wrapper py-5">
    <div class="container d-flex justify-content-center">
        <div class="card p-4 shadow-md rounded-5" style="max-width: 900px; width: 100%;">
            <h2 style="font-weight: 600; text-align: center; color: #443A35; margin-bottom: 20px;">Payments</h2>
             
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                      <tr>
                        <th>ID</th><th>Client</th><th>Booking ID</th><th>Amount</th><th>Method</th><th>Date</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php while($p = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?php echo $p['payment_id']; ?></td>
                      <td><?php echo $p['full_name']; ?></td>
                      <td>#<?php echo $p['booking_id']; ?></td>
                      <td class="text-success fw-bold">₱<?php echo number_format($p['amount_paid'],2); ?></td>
                      <td><span class="badge bg-secondary"><?php echo $p['method']; ?></span></td>
                      <td><?php echo $p['payment_date']; ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>