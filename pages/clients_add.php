<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zalando+Sans+SemiExpanded:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="wrapper py-5">
    <div class="d-flex flex-column justify-content-center align-items-center gap-3">
        
        <div class="card p-5 shadow-md rounded-5" style="width: 26rem;">
            <h2 style="font-weight: 600; text-align: center; color: #443A35;">Add Client</h2>
            
            <hr>

            <?php if(!empty($message)): ?>
                <p class="text-danger text-center fw-bold"><?php echo $message; ?></p>
            <?php endif; ?>
            
            <form method="post" class="d-flex flex-column gap-3">
                <div>
                    <label class="form-label fw-bold mb-1">Full Name*</label>
                    <input type="text" name="full_name" class="form-control w-100">
                </div>
            
                <div>
                    <label class="form-label fw-bold mb-1">Email*</label>
                    <input type="email" name="email" class="form-control w-100">
                </div>
            
                <div>
                    <label class="form-label fw-bold mb-1">Phone</label>
                    <input type="text" name="phone" class="form-control w-100">
                </div>
            
                <div>
                    <label class="form-label fw-bold mb-1">Address</label>
                    <input type="text" name="address" class="form-control w-100">
                </div>
            
                <button type="submit" name="save" class="btn btn-dark mt-2" style="border-radius: 8px;">Save Client</button>
            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>