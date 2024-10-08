<?php
require_once("../classes/UnidadeMedida.class.php");
require_once("../classes/Database.class.php");

class Quadrado{
    
    private $idQuadrado;
    private $lado;
    private $cor;
    private $unidade;
    private $imagem;


    public function __construct($idQuadrado = 0, $lado = "null", $cor = "black", UnidadeMedida $unidade = null, $imagem = "null"){

        $this->setIdQuadrado($idQuadrado);
        $this->setLado($lado); 
        $this->setCor($cor);
        $this->setUnidade($unidade);
        $this->setImagem($imagem);

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
   
            $this->cor = $novaCor;
    }

    public function setUnidade(UnidadeMedida $novaUnidade){
        if ($novaUnidade == "")
            throw new Exception("Erro: Unidade de Medida inválida!");
        else
            $this->unidade = $novaUnidade;
    }

    public function setImagem($novaimagem){
       
            $this->imagem = $novaimagem;
    }

    
    public function getIdQuadrado(){ return $this->idQuadrado; }
    public function getLado() { return $this->lado;}
    public function getCor() { return $this->cor;}
    public function getUnidade() { return $this->unidade;}
    public function getImagem() { return $this->imagem;}

    public function incluir(){

        $sql = 'INSERT INTO quadrado (idQuadrado, lado, cor, un , imagem)   
                     VALUES (:idQuadrado, :lado, :cor, :un :imagem)';


        $parametros = array(
            ':idQuadrado' =>$this->idQuadrado,
            ':lado' => $this->lado,
            ':cor' => $this->cor,
            ':un' => $this->unidade->getIdUnidade(),
            ':imagem' => $this->imagem,
        );

        return Database::executar($sql, $parametros);
    }  
    
    public function desenhar(){
        return "<center> <a href='index.php?idQuadrado=".$this->getIdQuadrado()."'>
        <div  class='container' style='background-color: ".$this->getCor() . " ;  
        background-image:url(".'"'.$this->getImagem().'"'.");
        background-repeat:no repeat;
        background-size: 100% 100%;
        width:".$this->getLado().$this->getUnidade()->getUnidadeMedida()."; 
        height:".$this->getLado().$this->getUnidade()->getUnidadeMedida()."'> </div></a></center><br>";
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

        $sql = 'UPDATE quadrado 
                   SET lado = :lado, cor = :cor, un = :un , imagem = :imagem
                 WHERE idQuadrado = :idQuadrado';
                 
        $parametros = array(
            ':lado' => $this->lado,
            ':cor' => $this->cor,
            ':un' => $this->unidade->getIdUnidade(),
            ':idQuadrado' =>$this->idQuadrado,
            ':imagem' =>$this->imagem
        );

        return Database::executar($sql, $parametros);       

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

        while($forma = $comando->fetch(PDO::FETCH_ASSOC)){  

            $unidade = UnidadeMedida::listar(1,$forma['un'])[0];
            $quadrado = new Quadrado($forma['idQuadrado'],$forma['lado'],$forma['cor'], $unidade , $forma['imagem']); 
            array_push($quadrados,$quadrado); 
        }
        return $quadrados;

    }    

    
    public function calcularPerimetro(){
        return  $this->getLado() *  4  ."". $this->getUnidade()->getUnidadeMedida();  
    }

    public function calculararea(){
        return  $this->getLado() * $this->getLado() . " " . $this->getUnidade()->getUnidadeMedida()."²";   
    }

}