<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
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
        <div class="card p-4 shadow-md rounded-5" style="max-width: 800px; width: 100%;">
            <h2 style="font-weight: 600; text-align: center; color: #443A35; margin-bottom: 20px;">Services</h2>
             
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                      <tr>
                        <th>ID</th><th>Name</th><th>Rate</th><th>Active</th><th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?php echo $row['service_id']; ?></td>
                      <td><?php echo $row['service_name']; ?></td>
                      <td class="text-success fw-bold">₱<?php echo number_format($row['hourly_rate'],2); ?></td>
                      <td>
                          <span class="badge <?php echo $row['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                              <?php echo $row['is_active'] ? "Yes" : "No"; ?>
                          </span>
                      </td>
                      <td>
                          <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-outline-dark" style="border-radius: 6px;">Edit</a>
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