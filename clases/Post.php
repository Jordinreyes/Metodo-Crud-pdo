<?php 

/**
 * Clase post
 * @property int id => El id de la noticia
 * @var string title => El titulo de la noticia
 * @var string description => La descripcion de la noticia
 * @var DateTime publicacionDarE => La fecha de la noticia 
 * @var string publication => Si se publica o no
 * @method conexion
 */
class Post 
{
    private int $id;
    private string $title;
    private string $description;
    private $publicationDate; 
    private string $publication;
    private $conexion;

    /**
     * @return string conexion => conexion a la base de datos
     */
    public function __construct($conexion){
        try{
            if(empty($conexion)){
                throw new Exception("No puede estar vacio el campo de ID");
            }else{
                $this->conexion = $conexion;
            }
        }catch (Exception $e){
            return $e->GetMessage();
        }
    }

    public function setDatos(string $title, string $description, $publicationDate, string $publication)
    {
        try{
            if(empty($title) || empty($description) || empty($publicationDate) || empty($publication)){
                throw new Exception("Los campos no pueden estar vacio");
            }else{
                $this->title = $title;
                $this->description = $description;
                $this->publicationDate = $publicationDate;
                $this->publication = $publication;
            }
            
        }catch (Exception $e){
            return $e->GetMessage();
        }
    }

    public function posts()
    {
        try{
            $stmt = $this->conexion->prepare("INSERT INTO posts (title, description, publication_date, publication) 
            VALUES (:title, :description, :publication_date, :publication)");
            $stmt->bindValue(":title", $this->title);
            $stmt->bindValue(":description", $this->description);
            $stmt->bindValue(":publication_date", $this->publicationDate);
            $stmt->bindValue(":publication", $this->publication);
            
            if($stmt->execute()){
                return true;
            }else{
                throw new Exception("No se ha podido insertar en la base de datos");
            }
        }catch(ExcePDOExceptionption $e){
            return $e->GetMessage();
        }finally{
            $this->conexion=null;
        }
    }
}