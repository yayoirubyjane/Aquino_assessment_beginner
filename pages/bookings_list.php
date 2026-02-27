<?php
include "../db.php";
 
$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
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
        <div class="card p-4 shadow-md rounded-5" style="max-width: 1000px; width: 100%;">
            <h2 style="font-weight: 600; text-align: center; color: #443A35;">Bookings</h2>
            
            <div class="mb-3 d-flex justify-content-end">
                <a href="bookings_create.php" class="btn btn-dark" style="border-radius: 8px;">+ Create Booking</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                      <tr>
                        <th>ID</th><th>Client</th><th>Service</th><th>Date</th><th>Hours</th><th>Total</th><th>Status</th><th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php while($b = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?php echo $b['booking_id']; ?></td>
                      <td><?php echo $b['client_name']; ?></td>
                      <td><?php echo $b['service_name']; ?></td>
                      <td><?php echo $b['booking_date']; ?></td>
                      <td><?php echo $b['hours']; ?></td>
                      <td class="text-success fw-bold">₱<?php echo number_format($b['total_cost'],2); ?></td>
                      <td>
                          <span class="badge <?php echo $b['status'] == 'PAID' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                              <?php echo $b['status']; ?>
                          </span>
                      </td>
                      <td>
                        <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" class="btn btn-sm btn-outline-dark" style="border-radius: 6px;">Process Payment</a>
                      </td>
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