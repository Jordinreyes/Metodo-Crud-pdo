<?php 

class Delete
{
    private int $id;
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function delete()
    {
        try{
            $stmt = $this->conexion->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->bindValue(":id", $this->id);
            if($stmt->execute()){
                return true;
            }else{
                throw new Exception("Error Processing Request");
            }
        }catch(PDOException){
            return $e->GetMessage();
        }finally{
            $this->conexion=null;
        }
    }
}