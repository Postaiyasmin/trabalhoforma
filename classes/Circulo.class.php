<?php
require_once("../classes/UnidadeMedida.class.php");
require_once("../classes/Database.class.php");

class Circulo{
    
    private $idCirculo;
    private $diametro;
    private $cor;
    private $unidade;

    public function __construct($idCirculo = 0, $diametro = "", $cor = "black", UnidadeMedida $unidade = null){

        $this->setId($idCirculo);
        $this->setDiametro($diametro); 
        $this->setCor($cor);
        $this->setUnidade($unidade);
    }

    public function setId($novoIdCirculo){
        if ($novoIdCirculo < 0)
        throw new Exception("Erro: id inválido!");
    else
        $this->idCirculo = $novoIdCirculo;
    }

    
    public function setDiametro($novoDiametro){
        if ($novoDiametro == "")
            throw new Exception("Erro: Tamanho inválido!");
        else
            $this->diametro = $novoDiametro;
    }

    public function setCor($novaCor){
        if ($novaCor =="")
            throw new Exception("Erro: Cor inválida!");
        else
            $this->cor = $novaCor;
    }

    public function setUnidade(UnidadeMedida $novaUnidade){
        if ($novaUnidade == "")
            throw new Exception("Erro: Unidade de Medida inválida!");
        else
            $this->unidade = $novaUnidade;
    }
    
    public function getId(){ return $this->idCirculo; }
    public function getDiametro() { return $this->diametro;}
    public function getCor() { return $this->cor;}
    public function getUnidade() { return $this->unidade;}

    public function incluir(){

        $sql = 'INSERT INTO circulo (idCirculo, diametro, cor, un)   
                     VALUES (:idCirculo, :diametro, :cor, :un)';


        $parametros = array(
            ':idCirculo' =>$this->idCirculo,
            ':diametro' => $this->diametro,
            ':cor' => $this->cor,
            ':un' => $this->unidade->getIdUnidade()
        );

        return Database::executar($sql, $parametros);
    }  
    
    public function desenhar(){
        return "<center> <a href='index.php?idCirculo=".$this->getId()."'>
        <div  class='container' style='background-color: ".$this->getCor() . ";
        border-radius: 50%; 
        width:".$this->getDiametro().$this->getUnidade()->getUnidadeMedida()."; 
        height:".$this->getDiametro().$this->getUnidade()->getUnidadeMedida()."'> 
        </div></a></center><br>";
    }
   
    
    public function excluir(){
        $conexao = Database::getInstance();
        $sql = 'DELETE 
                  FROM circulo
                 WHERE idCirculo = :idCirculo';

        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':idCirculo',$this->idCirculo);
        return $comando->execute();
    }  

    public function alterar(){

        $sql = 'UPDATE circulo 
                   SET diametro = :diametro, cor = :cor, un = :un
                 WHERE idCirculo = :idCirculo';
                 
        $parametros = array(
            ':diametro' => $this->diametro,
            ':cor' => $this->cor,
            ':un' => $this->unidade->getIdUnidade(),
            ':idCirculo' =>$this->idCirculo
        );

        return Database::executar($sql, $parametros);       

    }  
    


    public static function listar($tipo = 0, $busca = "" ){
        $conexao = Database::getInstance();
     
        $sql = "SELECT * FROM circulo";        
        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE idCirculo = :busca"; break;
                case 2: $sql .= " WHERE cor like :busca"; $busca = "%{$busca}%"; break;
                case 3: $sql .= " WHERE diametro like :busca";  $busca = "%{$busca}%";  break;
                case 4: $sql .= " WHERE un like :busca";  $busca = "%{$busca}%";  break;
            }
        $comando = $conexao->prepare($sql);        
        if ($tipo > 0 )
            $comando->bindValue(':busca',$busca); 
        $comando->execute(); 

        $circulos = array();    

        while($forma = $comando->fetch(PDO::FETCH_ASSOC)){  

            $unidade = UnidadeMedida::listar(1,$forma['un'])[0];
            $circulo = new Circulo($forma['idCirculo'],$forma['diametro'],$forma['cor'], $unidade); 
            array_push($circulos,$circulo); 
        }
        return $circulos;
    }    

    public function calcularPerimetro(){
        return  $this->diametro * 3.14 . " " . $this->getUnidade()->getUnidadeMedida();  
    }

    public function calculararea(){
        return 3.14 * (($this->diametro/2) * ($this->diametro/2)) . " " . $this->getUnidade()->getUnidadeMedida()."²";   
    }

}