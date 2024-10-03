<?php 
require_once("../config/config.inc.php");
require_once("../classes/Database.class.php");

class UnidadeMedida{
    private $idUnidade;
    private $UnidadeMedida;


    public function __construct($idUnidade = 0, $UnidadeMedida = "px"){
        $this->setIdUnidade($idUnidade);
        $this->setUnidadeMedida($UnidadeMedida);


    }

    public function setIdUnidade($novoIdUnidade){
        if ($novoIdUnidade < 0)
        throw new Exception("Erro: id inválido!");
    else
        $this->idUnidade = $novoIdUnidade;
    }
 
    public function setUnidadeMedida($novaUnidadeMedida){
        if ($novaUnidadeMedida == "")
            throw new Exception("Erro: Unidade de Medida inválida!");
        else
            $this->UnidadeMedida = $novaUnidadeMedida;
    }
    
    public function getIdUnidade(){ return $this->idUnidade; }
    public function getUnidadeMedida() { return $this->UnidadeMedida;}

    public function incluir(){

        $sql = 'INSERT INTO unidade (idUnidade, UnidadeMedida) 
                     VALUES (:idUnidade, :UnidadeMedida)';

            $parametros = array(
            ':idUnidade' =>$this->idUnidade,
            ':UnidadeMedida' => $this->UnidadeMedida
             );

        return Database::executar($sql, $parametros);

    }  

    public function excluir(){
        $conexao = Database::getInstance();
        $sql = 'DELETE 
                  FROM unidade
                 WHERE idUnidade= :idUnidade';

        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':idUnidade',$this->idUnidade);
        return $comando->execute();
    }  

    public function alterar(){

        $sql = 'UPDATE unidade 
                   SET  UnidadeMedida = :UnidadeMedida
                 WHERE idUnidade = :idUnidade';
                 
        $parametros = array(
        ':idUnidade' =>$this->idUnidade,
        ':UnidadeMedida' => $this->UnidadeMedida
        );
        
        return Database::executar($sql, $parametros);
    }  
    
    public static function listar($tipo = 0, $busca = "" ){
        $conexao = Database::getInstance();
     
        $sql = "SELECT * FROM unidade";        
        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE idUnidade = :busca"; break;
              
                case  2: $sql .= " WHERE UnidadeMedida like :busca";  $busca = "%{$busca}%";  break;
            }
        $comando = $conexao->prepare($sql);        
        if ($tipo > 0 )
            $comando->bindValue(':busca',$busca); 
        $comando->execute(); 

        $unidades = array();          
        while($registro = $comando->fetch()){  

            $unidade = new UnidadeMedida($registro['idUnidade'], $registro['UnidadeMedida']); 
            array_push($unidades,$unidade); 
        }
        return $unidades;
    }  

}