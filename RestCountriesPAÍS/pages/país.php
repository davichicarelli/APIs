<?php
$mensagem = "";
$pais = filter_input(INPUT_GET, 'pais', FILTER_SANITIZE_SPECIAL_CHARS);

if ($pais) {
    $url = "https://restcountries.com/v3.1/translation/" . rawurlencode($pais);

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
            $oficial = $data[0]['name'] ['official'] ?? 'N/A';
            $capital = $data[0]['capital'][0] ?? 'N/A';
            $regiao = $data[0]['subregion'] ?? 'N/A';
            $populacao = number_format($data[0]['population'] ?? 0, 0, ',', '.');
            $idioma = isset($data[0]['languages']) ? implode(", ", array_values($data[0]['languages'])) : 'N/A';
            $moeda = isset($data[0]['currencies']) ? implode(", ", array_keys($data[0]['currencies'])) : 'N/A';
            $comumente = $data[0]['cca3'] ?? 'N/A';
            $bandeira = $data[0]['flags']['png'] ?? '';
            $gentílico = $data[0]['demonyms'] ['eng'] ['f'] ?? 'N/A';

            if ($bandeira) {
                $mensagem .= "<img src='$bandeira' alt='Bandeira de $nome' style='width:350px;' />";
            }
        } else {
            $mensagem = "<p>País não encontrado.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do País</title>
    <link rel="stylesheet" href="./../css/style.css">
</head>
<body>
    <div id="pais-buscado">
    <span id="error"> <?= $mensagem ?></span>
    <div><br>
    <h1>Nome:</h1>
    <input  class="input2" type="text" value="<?= $nome ?>" disabled>
    </div>
    
    <div><br>
    <p>Oficial:</p>
    <input class="input2" type="text" value="<?= $oficial ?>" disabled>
    </div>

    <div><br>
    <p>Gentílico:</p>
    <input class="input2" type="text" value="<?= $gentílico ?>" disabled>
    </div>

    <div><br>
    <p>Região:</p>
    <input class="input2" type="text" value="<?= $regiao ?>" disabled>
    </div>

    <div><br>
    <p>Capital:</p>
    <input class="input2" type="text" value="<?= $capital ?>" disabled>
    </div>

    <div><br>
    <p>População:</p>
    <input class="input2" type="text" value="<?= $populacao ?>" disabled>
    </div>

    <div><br>
    <p>Idioma(s):</p>
    <input class="input2" type="text" value="<?= $idioma ?>" disabled>
    </div>

    <div><br>
    <p>Moeda:</p>
    <input class="input2" type="text" value="<?= $moeda ?>" disabled>
    </div>

    <div><br>
    <p>Comumente:</p>
    <input class="input2" type="text" value="<?= $comumente ?>" disabled>
    </div>
    <br><a href="./../index.html">🔙 Voltar</a>
</div>
</body>
</html>