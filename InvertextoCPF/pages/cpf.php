<?php
$mensagem = "";
$cpf = filter_input(INPUT_GET, "cpfBuscado", FILTER_SANITIZE_NUMBER_INT);

if (!$cpf || strlen($cpf) != 11) {
    $mensagem = "<p style='color:red;'>CPF inválido!</p>";
} else {
    $url = "https://api.invertexto.com/v1/validator?token=21978|vEuSFnt4TQRmqYWtkYAMecxpin2xx0TQ&value={$cpf}&type=cpf";

    $options = [
        "http" => [
            "method"  => "GET",
            "header"  => "Content-Type: application/json\r\n"
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        $mensagem = "<p style='color:red;'>Erro ao acessar a API de CPF!</p>";
        
    } else {
        $dados = json_decode($response, true);

        if (isset($dados['valid']) && $dados['valid'] === true) {
            $mensagem = "
                <h1>CPF válido!</h1>
                <p>Número do CPF: <input type='text' value='{$cpf}' disabled></p>
            ";
        } else {
            $mensagem = "<p style='color:red;'>CPF inválido!</p>";
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
  <title>Consulta de CPF</title>
</head>
<body>
  <?= $mensagem ?>
</body>
</html> 