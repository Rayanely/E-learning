<?php
session_start();

include "conn.php";

if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id())) {
    header("location: inlog.php");
}
if (isset($_SESSION['aantal_goed'])) {
    $_SESSION['aantal_goed'] = 0;
}



$sql = "SELECT * FROM vragen_elearn WHERE `hoofdstukken_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_GET['hoofdstuk']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_array()) {
    $questions[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Opdrachten</title>
</head>

<body>

    <div id="vraag"><?php echo $questions[0]['vraag'] ?></div>
    <div id="aantal_goed"></div>`
    <div id="check">
        <input type="text" name="ant_veld" class="input_woord" id="ant_veld" onfocus=this.value='' placeholder="Antwoord">

        <button onclick="vraagin()" id="check">Controleren</button>
    </div>
    <script>
        let ant_veld = document.getElementById('ant_veld');

        let counter = 1;
        let counter_vraag = 1;

        let hoofdstuk = <?php echo $_GET['hoofdstuk'] ?>;

        function vraagin() {

            const data = {
                username: hoofdstuk,
                vraag: counter_vraag,
                aantal_goed: counter,
                antwoord: ant_veld.value

            };
            fetch("fetch.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data["Last"]) {
                        window.location.replace("overzicht.php");
                    } else {
                        console.log("Success:", data);

                        document.getElementById('vraag').innerHTML = data['vraag'];
                        document.getElementById('aantal_goed').innerHTML = "Aantal goed: " + data['aantal_goed'];
                    }

                })
                .catch((error) => {
                    console.error("Error:", error);
                });

            counter = counter + 1;
            counter_vraag = counter_vraag + 1;

        }

        function clearInput() {
            let getValue = document.getElementById("ant_veld");
            if (getValue.value != "") {
                getValue.value = "";
            }
        }
    </script>

</body>

</html>