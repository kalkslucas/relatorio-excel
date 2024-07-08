<?php
session_start();//Iniciar a sessão

//Limpar o buffer
ob_start();


//INCLUSÃO DA CONEXÃO COM O BANCO
include 'config.php';
//QUERY PARA BUSCAR DADOS DOS FUNCIONARIOS
$sql = "SELECT id, NOME, EMAIL, SEXO, DEPARTAMENTO FROM funcionarios";
//PREPARAÇÃO DA QUERY
$query = $pdo->prepare($sql);
//EXECUÇÃO DA QUERY
$query->execute();

if($query && $linha = $query->rowCount() > 0){
  //Aceitar CSV ou Texto
  header('Content-Type: text/csv; charset=utf-8');

  //Nome do arquivo
  header('Content-Disposition: attachment; filename=arquivo.csv');

  //Gravar no buffer
  $resultado = fopen("php://output", 'w');

  //Criar o cabeçalho do Excel - Usar a função mb_convert_encoding para converter caracteres especiais
  $cabecalho = ["id", "NOME", "EMAIL", "SEXO", "DEPARTAMENTO"];

  //Escrever o cabeçalho no arquivo
  fputcsv($resultado, $cabecalho, ';');

  //Imprime os dados na tabela
  while($linha = $query->fetch(PDO::FETCH_ASSOC)){
    // Converta cada campo para UTF-8 antes de escrever no CSV
    foreach ($linha as $key => $value) {
      $linha[$key] = mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');
    }

    //Escrever o conteúdo
    fputcsv($resultado, $linha, ';');
  }

  //Fechar o arquivo
  fclose($resultado);
} else {
  $_SESSION['msg'] = "<p style='color: red;'> Nenhum usuário encontrado!</p>";
  header("Location: index.php");
}