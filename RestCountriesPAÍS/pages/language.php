<?php
$mensagem = "";
$paises = [];
$idioma = filter_input(INPUT_GET, 'idioma', FILTER_SANITIZE_SPECIAL_CHARS);

if ($idioma) {
    // Endpoint correto para pegar países por idioma
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

        if (is_array($data) && count($data) > 0) {
            foreach ($data as $pais) {
                $paises[] = $pais['name']['common'] ?? 'N/A';
            }
        } else {
            $mensagem = "<h1>Nenhum país encontrado para esse idioma.</h1>";
        }
    }
} else {
    $mensagem = "<h1>Nenhum idioma selecionado.</h1>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Países por Idioma</title>
    <link rel="stylesheet" href="./../css/style.css">
</head>
<body>
    <div id="resultado">
        <h1>Países que falam esse idioma:</h1><br>
        <?php if (!empty($paises)): ?>
            <ul>
                <?php foreach ($paises as $pais): ?>
                    <div><br>
                    <input  class="input2" type="text" value="<?= $pais ?>" disabled>
                    </div>
                    <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <?= $mensagem ?>
        <?php endif; ?>

        <br><a href="./../index.html">🔙 Voltar</a>
    </div>
</body>
</html>