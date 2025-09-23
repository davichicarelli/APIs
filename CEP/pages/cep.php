<?php
$mensagem = "";
$cep = filter_input(INPUT_GET, "cepBuscado", FILTER_VALIDATE_INT);

if (isset($cep) == false || strlen($cep) != 8) {
  $mensagem = "Cep inválido!";
} else {
  $url = "https://viacep.com.br/ws/{$cep}/json/";

  $options = [
    "https" => [
      "method" => "GET",
      "header" => "Contente-Type: application/json"
    ]
  ];

  $context = stream_context_create($options);
  $response = file_get_contents($url, false, $context);

  if ($response === false) {
    $mensagem = "Erro ao acessar a API via CEP!";
  } else {

    $dados = json_decode($response, true);
    // json_decode() é uma função do PHP que transforma uma string no formato JSON em um array associativo.

    if (isset($dados['erro']) == true) {
      $mensagem = "<h2>CEP não encontrado!</h2>";
    } else {
      $mensagem = "
    <h1>CEP encontrado!</h1><br>
    <p>Endereço:</p>
    <input type='text' value='{$dados['logradouro']}' disabled><br>
    <p>Número e Complemento:</p>
    <input type='text' value='{$dados['complemento']}'><br>
    <p>Bairro:</p>
    <input type='text' value='{$dados['bairro']}' disabled><br>
    <p>Cidade:</p>
    <input type='text' value='{$dados['localidade']}' disabled><br>
    <p>Estado:</p>
    <input type='text' value='{$dados['estado']}' disabled><br>
    ";
      //echo "<h2>Endereço encontrado!</h2>";
      //echo "<input type='text' value='${dados['logradouro']}'><br>";
      //echo "<input type='text' value='${dados['complemento']}'><br>";
      //echo "<input type='text' value='${dados['bairro']}'><br>";
      //echo "<input type='text' value='${dados['localidade']}'><br>";
      //echo "<input type='text' value='${dados['estado']}'><br>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../css/style.css">
  <title>Consulta de CEP</title>
</head>

<body>
  <?= $mensagem ?>
</body>
</html>