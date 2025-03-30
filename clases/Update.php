<?php 

/**
 * Clase update
 * @property int id => El id de la noticia
 * @var string title => El titulo de la noticia
 * @var string description => La descripcion de la noticia
 * @var DateTime publicacionDarE => La fecha de la noticia 
 * @var string publication => Si se publica o no
 * @method conexion
 */
class Update
{
    private int $id;
    private string $title;
    private string $description;
    private $publicationDate;
    private string $publication;
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function getId($id)
    {
        $this->id = $id;
    }

    public function getDatos(string $title, string $description, $publicationDate, string $publication)
    {
        try{
            if(empty($title) || empty($description) || empty($publicationDate) || empty($publication)){
                throw new Exception ("Los campos no pueden estar vacio");
            }else{
                $this->title = $title;
                $this->description = $description;
                $this->publicationDate = $publicationDate;
                $this->publication = $publication;
            }
        }catch(PDOException $e){
            return $e->GetMessage();
        }
    }

    public function update(){
        try{
            $stmt = $this->conexion->prepare("UPDATE posts SET 
                title = :title,
                description = :description,
                publication_date = :publication_date,
                publication = :publication
                WHERE id = :id
            ");
            $stmt->bindValue(":title", $this->title);
            $stmt->bindValue(":description", $this->description);
            $stmt->bindValue(":publication_date", $this->publicationDate);
            $stmt->bindValue(":publication", $this->publication);
            $stmt->bindValue(":id", $this->id);

            if($stmt->execute()){
                return true;
            }else{
                throw new Exception("Mo se han podido actualizar los datos");
            }
        }catch(PDOException $e){
            return $e->GetMessage();
        }finally{
            $this->conexion=null;
        }
    }
}