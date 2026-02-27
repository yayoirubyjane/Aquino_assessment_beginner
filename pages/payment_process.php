<?php
include "../config/db.php";
 
$booking_id = $_GET['booking_id'];
 
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));
 
$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];
 
$balance = $booking['total_cost'] - $total_paid;
$message = "";
 
if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];
 
  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
    // 1) Insert payment
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");
 
    // 2) Recompute total paid (after insert)
    $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
 
    // 3) Recompute new balance
    $new_balance = $booking['total_cost'] - $total_paid2;
 
    // 4) If fully paid, update booking status to PAID
    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }
 
    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include "../components/nav.php"; ?>
 
<div class="wrapper py-5">
    <div class="container d-flex justify-content-center">
        <div class="card p-5 shadow-md rounded-5" style="max-width: 500px; width: 100%;">
            <h2 style="font-weight: 600; text-align: center; color: #443A35;">Process Payment</h2>
            <p style="text-align: center; color: #666; margin-bottom: 20px;">Booking #<?php echo $booking_id; ?></p>
             
            <div class="bg-light p-3 rounded-4 mb-3 border">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Cost:</span>
                    <span>₱<?php echo number_format($booking['total_cost'],2); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Paid:</span>
                    <span>₱<?php echo number_format($total_paid,2); ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-5 fw-bold">
                    <span>Balance:</span>
                    <span class="text-danger">₱<?php echo number_format($balance,2); ?></span>
                </div>
            </div>
             
            <?php if($message): ?>
                <div class="alert alert-danger py-2"><?php echo $message; ?></div>
            <?php endif; ?>
             
            <form method="post" class="d-flex flex-column gap-3">
              <div>
                  <label class="form-label text-muted mb-1">Amount Paid</label>
                  <input type="number" name="amount_paid" step="0.01" class="form-control" style="border-radius: 8px;" required>
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Method</label>
                  <select name="method" class="form-select" style="border-radius: 8px;">
                    <option value="CASH">CASH</option>
                    <option value="GCASH">GCASH</option>
                    <option value="CARD">CARD</option>
                  </select>
              </div>
             
              <button type="submit" name="pay" class="btn btn-dark mt-3" style="border-radius: 8px; padding: 10px;">Save Payment</button>
            </form>
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>