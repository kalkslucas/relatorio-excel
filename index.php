<?php
session_start();//Iniciar a sessão

//INCLUSÃO DA CONEXÃO COM O BANCO
include 'config.php';
//QUERY PARA BUSCAR DADOS DOS FUNCIONARIOS
$sql = "SELECT * FROM funcionarios";
//PREPARAÇÃO DA QUERY
$query = $pdo->prepare($sql);
//EXECUÇÃO DA QUERY
$query->execute();

echo "
      <h1>Listar Funcionários</h1>
      <a href='gerarExcel.php'><h4>Gerar Excel</h4></a>
      ";

if(isset($_SESSION['msg'])){
  echo $_SESSION['msg'];
  unset($_SESSION['msg']);
}

if($query && $linha = $query->rowCount() > 0){
  while($linha = $query->fetch(PDO::FETCH_ASSOC)){
    /*
    $debug = print_r($linha);
    echo "<pre>";
    $debug;
    echo "</pre>";
    */
    extract($linha);
    echo "
          <p>ID: $id</p>
          <p>NOME: $NOME</p>
          <p>EMAIL: $EMAIL</p>
          <p>SEXO: $SEXO</p>
          <p>SETOR: $DEPARTAMENTO</p>
          <hr>
          ";
  }
} else {
  echo "<p style='color: red;'> Nenhum usuário encontrado!</p>";
}