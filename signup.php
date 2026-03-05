<?php include 'db.php';
$error = "";
 
// Ensure users table exists (Simple auto-fix for signup issues)
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_raw = $_POST['password'];
 
    if(strlen($password_raw) < 6){
        $error = "Password must be at least 6 characters long.";
    } else {
        $password = password_hash($password_raw, PASSWORD_DEFAULT);
 
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "This email is already registered!";
        } else {
            $q = mysqli_query($conn, "INSERT INTO users(name,email,password) VALUES('$name','$email','$password')");
            if($q){
                header("Location: login.php?msg=signup_success");
                exit();
            } else {
                $error = "Database Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup - CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=2.5">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="auth-container fade-up">
        <form class="auth-form" method="post">
            <h2>Signup</h2>
            <?php if($error): ?>
                <p style="color: #ff4d4d; margin-bottom: 1rem;"><?= $error ?></p>
            <?php endif; ?>
            <input name="name" placeholder="Name" required>
            <input name="email" type="email" placeholder="Email" required>
            <input name="password" type="password" placeholder="Password" required>
            <button>Create Account</button>
        </form>
    </div>
</body>
</html>
