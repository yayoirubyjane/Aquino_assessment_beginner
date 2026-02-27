<?php
include "../db.php";
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
if (isset($_POST['update'])) {
  $name = $_POST['service_name'];
  $desc = $_POST['description'];
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];
 
  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");
 
  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
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
            <h2 style="font-weight: 600; text-align: center; color: #443A35; margin-bottom: 20px;">Edit Service</h2>
             
            <form method="post" class="d-flex flex-column gap-3">
              <div>
                  <label class="form-label text-muted mb-1">Service Name</label>
                  <input type="text" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" class="form-control" style="border-radius: 8px;">
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Description</label>
                  <textarea name="description" rows="4" class="form-control" style="border-radius: 8px;"><?php echo htmlspecialchars($service['description']); ?></textarea>
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Hourly Rate</label>
                  <input type="number" step="0.01" name="hourly_rate" value="<?php echo $service['hourly_rate']; ?>" class="form-control" style="border-radius: 8px;">
              </div>
             
              <div>
                  <label class="form-label text-muted mb-1">Active</label>
                  <select name="is_active" class="form-select" style="border-radius: 8px;">
                    <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Yes</option>
                    <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>No</option>
                  </select>
              </div>
             
              <button type="submit" name="update" class="btn btn-dark mt-3" style="border-radius: 8px; padding: 10px;">Update</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>