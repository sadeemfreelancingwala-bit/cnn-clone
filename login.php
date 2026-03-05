<?php include 'db.php';
$error = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if ($q && mysqli_num_rows($q) > 0) {
        $u = mysqli_fetch_assoc($q);
        if(password_verify($password, $u['password'])){
            $_SESSION['user'] = $u['name'];
            $_SESSION['user_id'] = $u['id'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=2.5">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="auth-container fade-up">
        <form class="auth-form" method="post">
            <h2>Login</h2>
            <?php if(isset($_GET['msg']) && $_GET['msg'] == 'signup_success'): ?>
                <p style="color: #00ff00; background: rgba(0, 255, 0, 0.1); padding: 10px; border-radius: 6px; margin-bottom: 1rem; text-align: center;">Account created! Please login.</p>
            <?php endif; ?>
            <?php if($error): ?>
                <p style="color: #ff4d4d; margin-bottom: 1rem;"><?= $error ?></p>
            <?php endif; ?>
            <input name="email" placeholder="Email" required>
            <input name="password" type="password" placeholder="Password">
            <button>Login</button>
        </form>
    </div>
</body>
</html>
