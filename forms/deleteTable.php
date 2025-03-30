<?php 
    require_once "../conexionGbd/conexion.php";
    require_once "../clases/Select.php";
    require_once "../clases/Delete.php";

    $get = new Select($conexion);
    $select = $get->get();

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        try{
            $id = $_POST["id"];
            $delete  = new Delete($conexion);
            $delete->setId($id);

            if($delete->delete()){
                echo "<h1 style='color:green'>Se ha eliminado correctamente</h1>";
            }else{
                throw new Exception("No se ha podido eliminar la noticia");
            }
        }catch(PDOException $e){
            echo "<b>Error</b>" . $e->GetMessage();
        }finally{
            $conexion=null;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>
    <?php require_once "../navbar/navbar.php"?>
    
    <h1 style='color:#f00'>Form to delete the news </h1>
    <table border="1">
        <tr>
            <th>ID news</th>
            <th>Title</th>
            <th>Descrition</th>
            <th>Publication date</th>
            <th>Publication</th>
        </tr>

        <?php foreach ($select as $value) {?>
            <tr>
                <td><?= $value["id"]?></td>
                <td><?= $value["title"]?></td>
                <td><?= $value["description"]?></td>
                <td><?= $value["publication_date"]?></td>
                <td><?= $value["publication"]?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" id="id" value="<?= $value["id"]?>">
                        <button type="submit">Delete New</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>