<?php
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $password = $_POST['password'];

    if ($user === 'user' && $password === '') {

        include "../includes/open_db.php";
        //GET USER'S ROLE FOR COOKIE
        $query = "SELECT * FROM users WHERE username = '$user'";
        $userResult = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($userResult);
        $role = $row['role'];
        $user_id = $row['id'];
        $nickname = $row['nickname'];
        include '../includes/close_db.php';

        setcookie('user_cookie', $user, time() + 60 * 5); // Save login in session for later use
        setcookie('user_id', $user_id, time() + 60 * 5);
        setcookie('login_status', 1, time() + 60 * 5);
        setcookie('role', $role, time() + 60 * 5);
        setcookie('nickname', $nickname, time() + 60 * 5);

        header('Location: blog.php');
        exit();
    } else {
        // Credentials are incorrect, display error message
        $error = 'Incorrect login or password';
    }
}


?>


<main class="login-page">
    <div class="login-container">
        <h3 class="h3-header">Sign In</h3>
        <?php
        if (isset($error)) {
            echo '<div class="login-error">' . $error . '</div>';
        }
        ?>
        <form class="credentials-container" action="login.php" method="post">
            <div class="credentials forms"><input type="text" name="user" placeholder="user id"></div>
            <div class="credentials forms"><input type="password" name="password" placeholder="password"></div>
            <div class="credentials forms"><input class="form-btn" type="submit" value="login"></div>
        </form>
    </div>
</main>

<?php
include '../includes/footer.php';
?>