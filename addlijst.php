<?php
session_start();

include "conn.php";

if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id())) {
    header("location: inlog.php");
}

if (isset($_POST['submit'])) {
    $hoofdstuk_naam = htmlspecialchars($_POST['hoofdstuk_naam']);
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO `hoofdstukken_elearn` (`user_id`, `hoofdstuk_naam`) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_id, $hoofdstuk_naam);
    $result = $stmt->execute();

    $endid = mysqli_insert_id($conn);

    $aantal = count($_POST);
    $aantal = $aantal - 2;
    $aantal = $aantal / 2;

    for ($i = 0; $i < $aantal; $i++) {
        $nl_woord = htmlspecialchars($_POST['nl_woord' . $i + 1]);
        $en_woord = htmlspecialchars($_POST['en_woord' . $i + 1]);
        $vraagnr = $i + 1;

        $sql1 = "INSERT INTO `vragen_elearn` (`hoofdstukken_id`, `user_id`, `vraag`, `antwoord`, `vraagnr`) VALUES (?, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("sssss", $endid, $user_id, $en_woord, $nl_woord, $vraagnr);
        $result1 = $stmt1->execute();
    }
}

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <title>Lijst toevoegen</title>
</head>

<body>
    <div class="wrapper">
        <div class="hoofd_text">
            <h2>Lijsten toevoegen</h2>
            <a href="overzicht.php" id="terug_btn">Naar overzicht</a>
        </div>

        <div class="form_blok">
            <div class="nl_en">
                <form action="<?php print htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form" id="form">
                    <table class="table">
                        <input type="text" class="hoofdstuk_naam" name="hoofdstuk_naam" placeholder="Lijst Naam:">
                        <tr>
                            <th>Nederlands</th>
                            <th>Engels</th>
                        </tr>

                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;<input type="text" class="input_woord" name="nl_woord1" placeholder="Nederlands">
                            </td>
                            <td>
                                <input type="text" class="input_woord" name="en_woord1" placeholder="Engels">
                            </td>

                        </tr>

                    </table>
                    <div class="buttons">
                        <button id="add_btn">Regel Toevoegen</button>

                        <button id="del_btn">Reset</button>

                        <button type="submit" name="submit" id="done_btn">Klaar!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
    $(function() {
        let counter = 2;

        $("#add_btn").on("click", function(event) {
            event.preventDefault();

            let newRow = $("<tr>");
            let cols = '';

            cols += '<td>' + counter + '\n<input type="text" class="input_woord" name="nl_woord' + counter + '" placeholder="Nederlands"></td>';
            cols += '<td><input type="text" class="input_woord" name="en_woord' + counter + '" placeholder="Engels "></td>';

            newRow.append(cols);

            $("table").append(newRow);

            counter++;
        });

        $("table").on("click", "#del_btn", function(event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });
</script>


</html>