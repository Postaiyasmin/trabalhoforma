<?php

require_once("../classes/UnidadeMedida.class.php");
require_once("../classes/Database.class.php");

class Triangulo{
    
    private $idTriangulo;
    private $lado1;
    private $lado2;
    private $lado3;
    private $tipo;
    private $cor;
    private $unidade;

    public function __construct($idTriangulo = 0, $lado1 = "null", $lado2 = "null", $lado3 = "null", $tipo = "null", $cor = "black", UnidadeMedida $unidade = null){

        $this->setIdTriangulo($idTriangulo);
        $this->setLado1($lado1); 
        $this->setLado2($lado2); 
        $this->setLado3($lado3); 
        $this->setTipo($tipo);
        $this->setCor($cor);
        $this->setUnidade($unidade);
    }

    public function setIdTriangulo($novoIdTriangulo){
        if ($novoIdTriangulo < 0)
        throw new Exception("Erro: id inválido!");
    else
        $this->idTriangulo = $novoIdTriangulo;
    }

    
    public function setLado1($novoLado1){
        if ($novoLado1 == "")
            throw new Exception("Erro: Tamanho inválido!");
        else
            $this->lado1 = $novoLado1;
    }

    public function setLado2($novoLado2){
        if ($novoLado2 == "")
            throw new Exception("Erro: Tamanho inválido!");
        else
            $this->lado2 = $novoLado2;
    }

    public function setLado3($novoLado3){
        if ($novoLado3 == "")
            throw new Exception("Erro: Tamanho inválido!");
        else
            $this->lado3 = $novoLado3;
    }

    public function setTipo($novoTipo){
        if ($novoTipo =="")
            throw new Exception("Erro: Tipo inválido!");
        else
            $this->tipo = $novoTipo;
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
    
    public function getId(){ return $this->idTriangulo; }
    public function getLado1() { return $this->lado1;}
    public function getLado2() { return $this->lado2;}
    public function getLado3() { return $this->lado3;}
    public function getTipo() { return $this->tipo;}
    public function getCor() { return $this->cor;}
    public function getUnidade() { return $this->unidade;}

    public function incluir(){

        $sql = 'INSERT INTO triangulo (idTriangulo, lado1, lado2, lado3, tipo, cor, un)   
                     VALUES (:idTriangulo, :lado1, :lado2, :lado3, :tipo, :cor, :un)';


        $parametros = array(
            ':idTriangulo' =>$this->idTriangulo,
            ':lado1' => $this->lado1,
            ':lado2' => $this->lado2,
            ':lado3' => $this->lado3,
            ':tipo'  => $this->tipo,
            ':cor' => $this->cor,
            ':un' => $this->unidade->getIdUnidade()
        );

        return Database::executar($sql, $parametros);
    }  
    
   
    public function desenhar()
    {
        return "<center>
        <a href='index.php?idTriangulo=" . $this->getId() . "'>
            <div style='position: relative; display: inline-block;'>
                <div style='
                    width: 0;
                    height: 0;
                    border-left: " . $this->getLado1() . $this->getunidade()->getUnidadeMedida() . " solid transparent;
                    border-right: " . $this->getLado2() . $this->getunidade()->getUnidadeMedida() . " solid transparent;
                    border-bottom: " . $this->getLado3() . $this->getunidade()->getUnidadeMedida() . " solid " . $this->getCor() . ";
                '></div>
                <div style='
                    position: absolute;
                    top: 0;
                    left: 50%;
                    transform: translateX(-50%);
                    width: 100%;
                    height: 100%;
                 
                    background-size: 100% 100%;
                    clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
                    pointer-events: none;
                '></div>
            </div>
        </a>
        </center><br>";
    }

  
    public function excluir(){
        $conexao = Database::getInstance();
        $sql = 'DELETE 
                  FROM triangulo
                 WHERE idTriangulo = :idTriangulo';

        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':idTriangulo',$this->idTriangulo);
        return $comando->execute();
    }  

    public function alterar(){

        $sql = 'UPDATE triangulo
                   SET lado1 = :lado1, lado2 = :lado2, lado3 = :lado3, tipo = :tipo,  cor = :cor, un = :un
                 WHERE idTriangulo = :idTriangulo';
                 
        $parametros = array(
            ':lado1' => $this->lado1,
            ':lado2' => $this->lado2,
            ':lado3' => $this->lado3,
            ':tipo' => $this->tipo,
            ':cor' => $this->cor,
            ':un' => $this->unidade->getIdUnidade(),
            ':idTriangulo' =>$this->idTriangulo
        );

        return Database::executar($sql, $parametros);       

    }  
    


    public static function listar($tipo = 0, $busca = "" ){
        $conexao = Database::getInstance();
     
        $sql = "SELECT * FROM triangulo";        
        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE idTriangulo = :busca"; break;
                case 2: $sql .= " WHERE cor like :busca"; $busca = "%{$busca}%"; break;
                case 3: $sql .= " WHERE lado1 like :busca";  $busca = "%{$busca}%";  break;
                case 4: $sql .= " WHERE lado2 like :busca";  $busca = "%{$busca}%";  break;
                case 5: $sql .= " WHERE lado3 like :busca";  $busca = "%{$busca}%";  break;
                case 6: $sql .= " WHERE un like :busca";  $busca = "%{$busca}%";  break;
            }
        $comando = $conexao->prepare($sql);        
        if ($tipo > 0 )
            $comando->bindValue(':busca',$busca); 
        $comando->execute(); 

        $triangulos = array();    

        while($forma = $comando->fetch(PDO::FETCH_ASSOC)){  

            $unidade = UnidadeMedida::listar(1,$forma['un'])[0];
            $triangulo = new Triangulo($forma['idTriangulo'],$forma['lado1'],$forma['lado2'],$forma['lado3'], $forma['tipo'], $forma['cor'], $unidade); 
            array_push($triangulos,$triangulo); 
        }
        return $triangulos;
    }    

}