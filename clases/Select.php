<?php 

/**
 * @method table => me devuelve una tabla
 */
class Select 
{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function get()
    {
        try{
            $sql = "SELECT * FROM posts";
            $resultado = $this->conexion->query($sql);
            $filas = $resultado->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($filas)){
                return $filas;
            }else{
                throw new Exception("No hay datos en la base de datos");
            }
        }catch(PDOException $e){
            return $e->GetMessage();
        }finally{
            $this->conexion=null;
        }
    }
}