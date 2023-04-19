<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>CRUD-Systeem</title>
</head>

<body>
    <div class="container">
        <table class="table_crud">
            <thead>

                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Geslacht</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Actie</th>
                </tr>
            </thead>
   
            <tbody>

            <?php
            include "conn.php";
            $sql = "select * from `users_elearn`";
            $result = $conn->query($sql);

            if ($result) {
                while ($row = $result->fetch_object()) {
                    $id = $row->id;
                    $username = $row->username;
                    $email = $row->email;
                    $geslacht = $row->geslacht;
                    $rol = $row->rol;

                    echo '<tr class="actief">
                    <th scope="row">' . $id . '</th>
                    <td data-label="Naam: ">' . $username . '</td>
                    <td data-label="Email: ">' . $email . '</td>
                    <td data-label="Geslacht: ">' . $geslacht . '<br>' . '</td>
                    <td data-label="Rol: ">' . $rol . '</td>
            
                    <td>
                    <button class="trash"><a href="wis.php? wisid=' . $id . '">Wis</a></button>
                    
                    </td>
                
                    </tr>';
                }
            }

            ?>

        </tbody>

        </table>
    </div>
</body>

</html>