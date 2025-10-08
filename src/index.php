<?php

declare(strict_types=1);



use public\Storage as Storage;
use public\WordProvider as WordProvider;
use public\Renderer as Renderer;
use public\Game as Game;

$storage = new Storage('ahorcado');
$provider = new WordProvider(__DIR__ . '/../data/words.txt');
$renderer = new Renderer();


$message = "";


if (!isset($_SESSION['game_state']) || isset($_POST['new_game'])) {
    $randomWord = $wordProvider->randomWord();
    $game = new Game($randomWord, 6);
    $_SESSION['game_state'] = $game->toState();
} else {
    $game = new Game('', 6, $_SESSION['game_state']);
}


if (isset($_POST['letter']) && !$game->isWon() && !$game->isLost()) {
    $letter = strtoupper(trim($_POST['letter']));

    if (strlen($letter) === 1 && ctype_alpha($letter)) {
        $game->guessLetter($letter);
        $_SESSION['game_state'] = $game->toState();

        if ($game->isWon()) {
            $message = "¡Felicidades! Has ganado. La palabra era: " . $game->getMaskedWord();
        } elseif ($game->isLost()) {
            $message = "¡Game Over! La palabra era: " . $game->getWord();
        }
    }
}


if (isset($_POST['reset'])) {
    unset($_SESSION['game_state']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego del Ahorcado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .game-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .hangman-display {
            text-align: center;
            margin: 20px 0;
            font-family: monospace;
            white-space: pre;
            line-height: 1.2;
        }

        .word-display {
            font-size: 2em;
            letter-spacing: 0.2em;
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }

        .used-letters {
            text-align: center;
            margin: 15px 0;
            color: #666;
        }

        .attempts {
            text-align: center;
            font-weight: bold;
            color: #d35400;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            font-weight: bold;
        }

        .win {
            background-color: #d4edda;
            color: #155724;
        }

        .lose {
            background-color: #f8d7da;
            color: #721c24;
        }

        .info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        form {
            text-align: center;
            margin: 20px 0;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 1.2em;
            width: 50px;
            text-align: center;
            text-transform: uppercase;
        }

        button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .reset-btn {
            background-color: #e74c3c;
        }

        .reset-btn:hover {
            background-color: #c0392b;
        }

        .hangman-display pre {
            font-size: 10px;
            line-height: 1;
            margin: 0 auto;
            display: inline-block;
            transform: scale(0.6);
            transform-origin: center;
            max-width: 100%;
            overflow: hidden;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <div class="game-container">
        <h1 style="text-align: center;">Juego del Ahorcado</h1>
        <div class="hangman-display">
            <?php echo $renderer->ascii($game->getAttemptsLeft()); ?>
        </div>
        <div class="word-display">
            <?php echo implode(' ', str_split($game->getMaskedWord())); ?>
        </div>

        <div class="attempts">
            Intentos restantes: <?php echo $game->getAttemptsLeft(); ?>
        </div>

        <div class="used-letters">
            Letras usadas: <?php echo implode(', ', $game->getUsedLetters()); ?>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $game->isWon() ? 'win' : ($game->isLost() ? 'lose' : 'info'); ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (!$game->isWon() && !$game->isLost()): ?>
            <form method="post">
                <label for="letter">Introduce una letra:</label><br>
                <input type="text" name="letter" id="letter" maxlength="1" required
                    pattern="[A-Za-z]" title="Solo se permiten letras"
                    autocomplete="off" autofocus>
                <br><br>
                <button type="submit">Adivinar</button>
            </form>

            <form method="post">
                <button type="submit" name="new_game" class="reset-btn">Nuevo Juego</button>
            </form>
        <?php else: ?>
            <form method="post">
                <button type="submit" name="new_game" class="reset-btn">Jugar de Nuevo</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('letter')?.addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
</body>

</html>