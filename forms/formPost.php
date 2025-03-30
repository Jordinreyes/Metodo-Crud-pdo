<?php 
    require_once "../conexionGbd/conexion.php";
    require_once "../clases/Post.php";

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $error = [];
        
        if(empty($_POST["title"])){
            $error["title"] = "<b style='color:#f00'>Campo obligatorio</b>" . "<br>";
        }else{
            $title = htmlspecialchars($_POST["title"]);
        }

        if(empty($_POST["description"])){
            $error["description"] = "<b style='color:#f00'>Campo obligatorio</b>" . "<br>";
        }else{
            $description = htmlspecialchars($_POST["description"]);
        }

        if(empty($_POST["publicationDate"])){
            $error["publicationDate"] = "<b style='color:#f00'>Campo obligatorio</b>" . "<br>";
        }else{
            $publicationDate = htmlspecialchars($_POST["publicationDate"]);
        }

        if(empty($_POST["publication"])){
            $error["publication"] = "<b style='color:#f00'>Campo obligatorio</b>" . "<br>";
        }else{
            $publication = htmlspecialchars($_POST["publication"]);
        }

        if(empty($error)){
            try{
                $post = new Post($conexion);
                $post->setDatos($title, $description, $publicationDate, $publication);

                if($post->posts()){
                    $title="";
                    $description="";
                    $publicationDate = "";
                    $publication = "";
                    echo "<h1 style='color:green'>The news has been added correctly</h1>";
                }else{
                    throw new Exception("No se ha podido insertar");
                }
            }catch(PDOException $e){
                echo "<b>Error: </b>" . $e->GetMessge();
            }finally{
                $conexion=null;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form post</title>
</head>
<body>
    <form action="" method="post">
        <h1 style='color:#48e'>Add new</h1>

        <div>
            <?= isset($error["title"]) ? $error["title"] : '' ?>
            <label for="title">Titte: </label>
            <input type="text" name="title" id="title" value="<?= isset($_POST["title"]) ? htmlspecialchars($_POST["title"]) : ''; ?>">
        </div><br>

        <div>
            <?= isset($error["description"]) ? $error["description"] : '' ?>
            <label for="description">Description about news: </label>
            <input type="text" name="description" id="description" value="<?= isset($_POST["description"]) ? htmlspecialchars($_POST["description"]) : ''; ?>">
        </div><br>

        <div>
            <?= isset($error["publicationDate"]) ? $error["publicationDate"] : '' ?>
            <label for="publicationDate">Description about news: </label>
            <input type="date" name="publicationDate" id="publicationDate" value="<?= isset($_POST["publicationDate"]) ? htmlspecialchars($_POST["publicationDate"]) : ''; ?>">
        </div><br>

        <div>
            <?= isset($error["publication"])?>
            <label for="publication">Publication: 
                <select name="publication" id="publication">
                    <?php 
                        $options = ["Choose any option", "Si", "No"];
                        foreach($options as $value){
                            echo "<option>$value</option>";
                        }
                    ?>
                </select>
            </label>
        </div><br><br><br>

        <button type="submit">Create New</button>
    </form>
</body>
</html>