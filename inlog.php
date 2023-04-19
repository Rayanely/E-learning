<?php
session_start();

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

include 'conn.php';

if(isset($_POST['submit'])) {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $sql = "SELECT id, username, password, rol FROM users_elearn WHERE username = ? AND status = 'TRUE'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    try {
        while ($row = $result->fetch_array()) {
            $passwordreturn = password_verify($password, $row['password']);
            $role = $row['rol'];

            if ($passwordreturn) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username;
                $_SESSION['rol'] = $row['rol'];
                $_SESSION['sessionid'] = session_id();
                //alert('Je bent ingelogd');
    
            }
        }
    } catch (Exception $e) {
        $e->getMessage();
    }

    
    if($_SESSION['rol'] == 'admin') {
        header('Location: crud.php');
    } else {
        header("Refresh:0.1; url=overzicht.php", true, 303);
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Inloggen</title>
</head>

<body>
    <div class="blok">
        <form action="inlog.php" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="imgcontainer">
                <img src="img/avatar.png" alt="Avatar" class="avatar">
            </div>

            <div class="inlog_form">
                <i class="login__icon fa-solid fa-user"></i>
                <input type="text" name="username" class="login_input" placeholder="Naam" required>
                <br>
                <i class="login__icon fa-solid fa-lock"></i>
                <input type="password" name="password" class="login_input" placeholder="Wachtwoord" id="myPassword" required>
                <i class="show_password fa-solid fa-eye-slash" onclick="myFunction()"></i>
                <br>
                <br>
                <button type="submit" name="submit" class="login_submit">
                    <span class="button_text">Inloggen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <i class="button_icon fa-solid fa-arrow-right"></i>
                </button>
                <br>
                <br>
                <br>
                <p>Nog geen account? <br><a href="register.php">Klik hier om te registreren!</a></p>
            </div>
        </form>
    </div>
</body>
<script>
    function myFunction() {
        var x = document.getElementById("myPassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

</html>