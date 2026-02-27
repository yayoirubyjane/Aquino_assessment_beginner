<?php
include "../db.php";
 
$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");
 
if (isset($_POST['create'])) {
  $client_id = $_POST['client_id'];
  $service_id = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours = $_POST['hours'];
 
  // get service hourly rate
  $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
 
  $total = $rate * $hours;
 
  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");
 
  header("Location: bookings_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking</title>
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
        <div class="card p-5 shadow-md rounded-5" style="max-width: 500px; width: 100%;">
            <h2 style="font-weight: 600; text-align: center; color: #443A35; margin-bottom: 20px;">Create Booking</h2>
             
            <form method="post" class="d-flex flex-column gap-3">
              <div>
                  <label class="form-label text-muted mb-1">Client</label>
                  <select name="client_id" class="form-select" style="border-radius: 8px;">
                    <?php while($c = mysqli_fetch_assoc($clients)) { ?>
                      <option value="<?php echo $c['client_id']; ?>"><?php echo $c['full_name']; ?></option>
                    <?php } ?>
                  </select>
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Service</label>
                  <select name="service_id" class="form-select" style="border-radius: 8px;">
                    <?php while($s = mysqli_fetch_assoc($services)) { ?>
                      <option value="<?php echo $s['service_id']; ?>">
                        <?php echo $s['service_name']; ?> (₱<?php echo number_format($s['hourly_rate'],2); ?>/hr)
                      </option>
                    <?php } ?>
                  </select>
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Date</label>
                  <input type="date" name="booking_date" class="form-control" style="border-radius: 8px;" required>
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Hours</label>
                  <input type="number" name="hours" min="1" value="1" class="form-control" style="border-radius: 8px;" required>
              </div>
             
              <button type="submit" name="create" class="btn btn-dark mt-3" style="border-radius: 8px; padding: 10px;">Create Booking</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>