<?php
// Include database connection file
include_once('config.php');

if (isset($_POST['submit'])) {
    $errorMsg = "";
    
    // Escape user inputs to prevent SQL injection
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $role     = $conn->real_escape_string($_POST['role']);
    
    // Insert user data into database
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    $result = $conn->query($query);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        $errorMsg = "Failed to register. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registred</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="card text-center" style="padding:20px;">
  <h3>Registred</h3>
</div><br>
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
      <div class="col-md-6">      
        <?php if (isset($errorMsg)) { ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $errorMsg; ?>
          </div>
        <?php } ?>
        <form action="" method="POST">
          <div class="form-group">  
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" placeholder="Enter Username" required="">
          </div>
          <div class="form-group">  
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Enter Password" required="">
          </div>
          <div class="form-group">  
            <label for="role">Role:</label>
            <select class="form-control" name="role" required="">
              <option value="">Select Role</option>
              <option value="admin">admin</option>
              <option value="kasir">kasir</option>
            </select>
          </div>
          <div class="form-group">
            <p>Already have account ?<a href="login.php"> Login</a></p>
            <input type="submit" name="submit" class="btn btn-primary">
          </div>
        </form>
      </div>
  </div>
</div>
</body>
</html>