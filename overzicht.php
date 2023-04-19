<?php
session_start();

include "conn.php";


if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id())) {
    header("location: inlog.php");
}

$username = ucfirst('username');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Overzicht</title>
</head>

<body>

    <div class="wrapper">

        <div class="hoofd_text">
            <h2>Welkom, <?php echo ucfirst($_SESSION['username']); ?></h2>
            <h2>Lijsten</h2>
        </div>
        <div class="header">
            <a href="logout.php"><i id="logout" class="fa-solid fa-right-from-bracket"></i></a>
        </div>
        <div class="hfstukken">
            <div class="hfst1">
                <div class="button_add">
                    <a href="addlijst.php" class="button_add">
                        <button type="button" class="button_add">Lijst +</button>
                    </a>
                </div>
                <br>

            </div>
            <br>
            <?php
            $sql = "SELECT DISTINCT `id`, `hoofdstuk_naam` FROM `hoofdstukken_elearn`";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_array()) {
                $hoofdstuk = "<form id='hft_button' action='opdrachten.php'>
                <input type='hidden' name='hoofdstuk' value=" . $row['id'] . ">
                <input type='submit' id='btn_check' value='" . $row['hoofdstuk_naam'] . "'>
                </form>";
                echo ($hoofdstuk);
            }
            ?>
        </div>

    </div>

</body>

</html>