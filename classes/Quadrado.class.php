<?php
require_once("../config/config.inc.php");

require_once("../classes/Database.class.php");

class Quadrado{
    
    private $idQuadrado;
    private $lado;
    private $cor;
    private $unidadeMedida;

    public function __construct($idQuadrado = 0, $lado = 1, $cor = "black", $unidadeMedida = "px"){

        $this->setIdQuadrado($idQuadrado);
        $this->setLado($lado); 
        $this->setCor($cor);
        $this->setUnidadeMedida($unidadeMedida);
    }

    public function setIdQuadrado($novoIdQuadrado){
        if ($novoIdQuadrado < 0)
        throw new Exception("Erro: id inválido!");
    else
        $this->idQuadrado = $novoIdQuadrado;
    }

    
    public function setLado($novoLado){
        if ($novoLado == "")
            throw new Exception("Erro: Tamanho inválido!");
        else
            $this->lado = $novoLado;
    }

    public function setCor($novaCor){
        if ($novaCor =="")
            throw new Exception("Erro: Cor inválida!");
        else
            $this->cor = $novaCor;
    }

    public function setUnidadeMedida($novaUnidadeMedida){
        if ($novaUnidadeMedida == "")
            throw new Exception("Erro: Unidade de Medida inválida!");
        else
            $this->unidadeMedida = $novaUnidadeMedida;
    }
    
    public function getIdQuadrado(){ return $this->idQuadrado; }
    public function getLado() { return $this->lado;}
    public function getCor() { return $this->cor;}
    public function getUnidadeMedida() { return $this->unidadeMedida;}

    public function incluir(){

        $conexao = Database::getInstance();
        $sql = 'INSERT INTO quadrado (idQuadrado, lado, cor, un)   
                     VALUES (:idQuadrado, :lado, :cor, :unidadeMedida)';

        $comando = $conexao->prepare($sql);  
        $comando->bindValue(':idQuadrado',$this->idQuadrado); 
        $comando->bindValue(':lado',$this->lado);
        $comando->bindValue(':cor',$this->cor);
        $comando->bindValue(':unidadeMedida',$this->unidadeMedida);

        return $comando->execute(); 
    }  
    
    public function desenhar(){
        return "<center> <a href='index.php?idQuadrado=".$this->getIdQuadrado()."'><div  class='container' style='background-color: ".$this->getCor() . "; width:".$this->getLado().$this->getUnidadeMedida()->getUnidadeMedida()."; height:".$this->getLado().$this->getUnidadeMedida()->getUnidadeMedida()."'> </div></a></center><br>";
    }

    public function excluir(){
        $conexao = Database::getInstance();
        $sql = 'DELETE 
                  FROM quadrado
                 WHERE idQuadrado = :idQuadrado';

        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':idQuadrado',$this->idQuadrado);
        return $comando->execute();
    }  

    public function alterar(){
        $conexao = Database::getInstance();
        $sql = 'UPDATE quadrado 
                   SET lado = :lado, cor = :cor, unidadeMedida = :unidadeMedida
                 WHERE idQuadrado = :idQuadrado';
                 
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':idQuadrado',$this->idQuadrado);
        $comando->bindValue(':lado',$this->lado);
        $comando->bindValue(':cor',$this->cor);
        $comando->bindValue(':unidadeMedida',$this->unidadeMedida);

        return $comando->execute();
    }  
    


    public static function listar($tipo = 0, $busca = "" ){
        $conexao = Database::getInstance();
     
        $sql = "SELECT * FROM quadrado";        
        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE idQuadrado = :busca"; break;
                case 2: $sql .= " WHERE cor like :busca"; $busca = "%{$busca}%"; break;
                case 3: $sql .= " WHERE lado like :busca";  $busca = "%{$busca}%";  break;
                case 4: $sql .= " WHERE un like :busca";  $busca = "%{$busca}%";  break;
            }
        $comando = $conexao->prepare($sql);        
        if ($tipo > 0 )
            $comando->bindValue(':busca',$busca); 
        $comando->execute(); 

        $quadrados = array();          
        while($registro = $comando->fetch()){  

            $quadrado = new Quadrado($registro['idQuadrado'],$registro['lado'],$registro['cor'], $registro['un']); 
            array_push($quadrados,$quadrado); 
        }
        return $quadrados;
    }    

}