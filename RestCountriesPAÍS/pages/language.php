<?php
$mensagem = "";
$idioma = filter_input(INPUT_GET, 'idioma', FILTER_SANITIZE_SPECIAL_CHARS);

if ($idioma) {
    $url = "https://restcountries.com/v3.1/name/" . rawurlencode($idioma);

    $options = [
        "http" => [
            "method" => "GET",
            "header" => "Content-Type: application/json"
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        $mensagem = "<h1>Erro ao acessar a API Rest Countries!</h1>";

    } else {

        $data = json_decode($response, true);

        if (isset($data[0])) {
            $nome = $data[0]['name']['common'] ?? 'N/A';
            $language = isset($data[0]['languages']) ? implode(", ", array_values($data[0]['languages'])) : 'N/A';

        } else {
            $mensagem = "<h1>Idioma não encontrado.</h1>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações dos Países</title>
    <link rel="stylesheet" href="./../css/style.css">
</head>
<body>
    <div id="idioma-buscado">
        <div><br>
            <p>Nome do País:</p>
            <input class="input2" type="text" value="<?= $nome ?>" disabled>
        </div>

        <div><br>
            <p>Idioma(s):</p>
            <input class="input3" type="text" value="<?= $language ?>" disabled>
        </div>
        <?= $mensagem ?>
    </div>
</body>
</html>