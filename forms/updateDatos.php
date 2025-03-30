<?php 
    require_once "../conexionGbd/conexion.php";
    require_once "../clases/Select.php";
    require_once "../clases/Update.php";

    $get = new Select($conexion);
    $select = $get->get();

    $title = "";
    $description = "";
    $publicationDate = "";
    $publication="";

    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])){
        try {
            $id = $_GET["id"];
            $stmt = $conexion->prepare("SELECT title, description, publication_date, publication FROM posts WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $filas = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($filas) {
                $title = $filas["title"];
                $description = $filas["description"];
                $publicationDate = $filas["publication_date"];
                $publication = $filas["publication"];
            } else {
                throw new Exception("No se ha podido hacer el select");
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    };

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        try{
            $id = $_GET["id"] ?? '';
            $title = (isset($_POST["title"])) ? $_POST["title"] : '';
            $description = (isset($_POST["description"])) ? $_POST["description"] : '';
            $publicationDate = (isset($_POST["publicationDate"])) ? $_POST["publicationDate"] : '';
            $publication = (isset($_POST["publication"])) ? $_POST["publication"] : '';

            $stmt = new Update($conexion);            
            $stmt->getId($id);
            $stmt->getDatos($title, $description, $publicationDate, $publication);

            if($stmt->update()){
                $title = "";
                $description = "";
                $publicationDate = "";
                $publication="";
                $id = "";
                $_POST = [];
                echo "<h1 style='color:green'>Datos actualizados</h1>";
                
            }else{
                throw new Exception("No se ha podido actualizar los datos");
            }
        }catch(PDOException $e){
            echo "<b>Error: </b>" . $e->GetMessage();
        }finally{
            $conexion = null;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>
<body>
    <?php require_once "../navbar/navbar.php"?>
    <form action="" method="POST">
        <h1 style="color:#48e">Form to update the news</h1>
        <div>
            <label for="title">Title: </label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>">
        </div><br>

        <div>
            <label for="description">Description: </label>
            <input type="text" name="description" id="description" value="<?= htmlspecialchars($description) ?>">
        </div><br>

        <div>
            <label for="publicationDate">Publication Date: </label>
            <input type="date" name="publicationDate" id="publicationDate" value="<?= htmlspecialchars($publicationDate) ?>">
        </div><br>

        <div>
            <label for="publication">Publication: 
                <select name="publication" id="publication">
                    <?php 
                        $options = ["Choose any option", "Si", "No"];
                        $sticky = "";
                        foreach($options as $value){
                            $selected = ($value == $publication) ? "selected" : "";
                            echo "<option value='$value' $selected>$value</option>";
                        }
                    ?>
                </select>
            </label>
        </div><br><br>

        <button type="submit">Update new</button>

    </form><br><br><hr>

    <table border="1">
        <tr>
            <th>ID news</th>
            <th>Title</th>
            <th>Description</th>
            <th>Publication date</th>
            <th>Publication</th>
        </tr>

        <?php foreach ($select as $value){?>
            <tr>
                <td><?= $value["id"] ?></td>
                <td><?= $value["title"] ?></td>
                <td><?= $value["description"] ?></td>
                <td><?= $value["publication_date"] ?></td>
                <td><?= $value["publication"] ?></td>
                <td>
                    <form action="" method="GET">
                        <input type="hidden" name="id" id="id" value="<?= $value["id"]?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php }?>
    </table>
</body>
</html>