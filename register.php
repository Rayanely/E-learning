<?php
session_start();

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

include 'conn.php';

if(isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $geslacht = $_POST['geslacht'];

    $sql = "SELECT username FROM users_elearn WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_array() == true) {
        echo "<script>alert('Account bestaat al');</script>";
    } else {
        $sql1 = "INSERT INTO `users_elearn` (`username`, `email`, `password`, `geslacht`) VALUES (?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("ssss", $username, $email, $password, $geslacht);
        $result1 = $stmt1->execute();
        $realResult = true;
        //alert('Account aangemaakt');
        header("Refresh:0.1; url=inlog.php", true, 303);   
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
    <title>Account aanmaken</title>
</head>

<body>
    <div class="blok">
        <form action="register.php" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="imgcontainer">
                <img src="img/avatarnl.png" alt="Avatar" class="avatar">
            </div>

            <div class="inlog_form">
                <i class="login__icon fa-solid fa-user"></i>
                <input type="text" name="username" class="login_input" placeholder="Naam" required>
                <br>
                <i class="login_icon fa-solid fa-envelope"></i>
                <input type="email" name="email" class="login_input" placeholder="E-mail" required>
                <br>
                <i class="login__icon fa-solid fa-lock"></i>
                <input type="password" class="login_input" name="password" placeholder="Wachtwoord" id="myPassword" required>
                <i class="show_password fa-solid fa-eye-slash" onclick="myFunction()"></i>
                <br>
                <br>
                <label for="geslacht">Geslacht: &nbsp;</label>
                <select name="geslacht" id="geslacht">
                    <option value="man">Man</option>
                    <option value="vrouw">Vrouw</option>
                </select>
                <br>
                <br>
                <button type="submit" name="submit" class="login_submit">
                    <span class="button_text">Registreren&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <i class="button_icon fa-solid fa-arrow-right"></i>
                </button>
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