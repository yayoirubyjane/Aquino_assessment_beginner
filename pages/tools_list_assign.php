<?php
include "../db.php";
 
$message = "";
 
// ASSIGN TOOL
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id = $_POST['tool_id'];
  $qty = $_POST['qty_used'];
 
  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));
 
  if ($qty > $toolRow['quantity_available']) {
    $message = "Not enough available tools!";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");
 
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
 
    $message = "Tool assigned successfully!";
  }
}
 
$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="wrapper py-5">
    <div class="container d-flex flex-column align-items-center gap-4">
        
        <?php if($message): ?>
            <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?> py-2 w-100" style="max-width: 800px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card p-4 shadow-md rounded-5" style="max-width: 800px; width: 100%;">
            <h3 style="color: #443A35; font-weight: 600;">Available Tools</h3>
            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                      <tr><th>Name</th><th>Total</th><th>Available</th></tr>
                  </thead>
                  <tbody>
                  <?php while($t = mysqli_fetch_assoc($tools)) { ?>
                    <tr>
                      <td><?php echo $t['tool_name']; ?></td>
                      <td><?php echo $t['quantity_total']; ?></td>
                      <td><span class="badge bg-primary rounded-pill"><?php echo $t['quantity_available']; ?></span></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
            </div>
        </div>

        <div class="card p-4 shadow-md rounded-5" style="max-width: 500px; width: 100%;">
            <h3 style="color: #443A35; font-weight: 600; text-align: center; margin-bottom: 20px;">Assign Tool</h3>
            
            <form method="post" class="d-flex flex-column gap-3">
              <div>
                  <label class="form-label text-muted mb-1">Booking ID</label>
                  <select name="booking_id" class="form-select" style="border-radius: 8px;">
                    <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
                      <option value="<?php echo $b['booking_id']; ?>">#<?php echo $b['booking_id']; ?></option>
                    <?php } ?>
                  </select>
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Tool</label>
                  <select name="tool_id" class="form-select" style="border-radius: 8px;">
                    <?php
                      $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
                      while($t2 = mysqli_fetch_assoc($tools2)) {
                    ?>
                      <option value="<?php echo $t2['tool_id']; ?>">
                        <?php echo $t2['tool_name']; ?> (Avail: <?php echo $t2['quantity_available']; ?>)
                      </option>
                    <?php } ?>
                  </select>
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Qty Used</label>
                  <input type="number" name="qty_used" min="1" value="1" class="form-control" style="border-radius: 8px;">
              </div>
             
              <button type="submit" name="assign" class="btn btn-dark mt-3" style="border-radius: 8px; padding: 10px;">Assign Tool</button>
            </form>
        </div>

    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>