<?php


class Game {
    public string $word; 
    public int $maxAttempts; 
    public int $attemptsLeft;
    public array $usedLetters;
    
    public function __construct(string $word,int $maxAttempts = 6, ?array $state = null) { 
            if ($state) {
            $this->word = $state['word'];
            $this->maxAttempts = $state['maxAttempts'];
            $this->attemptsLeft = $state['attemptsLeft'];
            $this->usedLetters = $state['usedLetters'];
        } else {
            $this->word = strtoupper($word);
            $this->maxAttempts = $maxAttempts;
            $this->attemptsLeft = $maxAttempts;
            $this->usedLetters = [];
        }}
    
    public function guessLetter(string $letter): void {
        $letter = strtoupper($letter);
        if (!in_array($letter, $this->usedLetters)) {
            $this->usedLetters[] = $letter;
        }
        if (strpos($this->word, $letter) === false) {
            $this->attemptsLeft--;
            
        }
    }
    public function getMaskedWord(): string {
        $maskedword = "";
        foreach (str_split($this->word) as $letter) {
            $maskedword .= in_array($letter, $this->usedLetters) ? $letter : "_";
        }
        return $maskedword;
    }
    public function getAttemptsLeft(): int {
        return $this->attemptsLeft;
    }
    public function getUsedLetters(): array {
        return $this->usedLetters;
    }
    public function isWon(): bool {
        return $this->getMaskedWord() === $this->word;
    }
    public function isLost(): bool {
        return $this->attemptsLeft <= 0;
    }
    public function toState(): array {
        return [
            'word' => $this->word,
            'maxAttempts' => $this->maxAttempts,
            'attemptsLeft' => $this->attemptsLeft,
            'usedLetters' => $this->usedLetters
        ];

    }
  }



class WordProvider {
    private array $palabras = [];
    public function __construct(
    private string $filePath,
    ) {}

  public function randomWord(): string {
    
    $this->palabras = explode(",",file_get_contents($this->filePath));
    $this->palabras = array_filter(array_map('trim', $this->palabras));
    return $this->palabras[array_rand($this->palabras)];
  }
}

class Storage {
    private string $key ;
    public function __construct(string $key = 'ahorcado')
     {
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->key = $key;
        if (!isset($_SESSION[$this->key])) {
            $_SESSION[$this->key] = [];
        }
     }
     public function get(string $name, $default = null): null {
        return $_SESSION[$this->key][$name] ?? $default;
     }
     public function set(string $name, $value): void{
        $_SESSION[$this->key][$name] = $value;
     }
        public function reset(): void {
            $_SESSION[$this->key] = [];
        }

  
}
class Renderer {
    public function ascii( int $attemptsLeft): string {
        $estados = [
        6 => "
             .-#################################################:                                  
             :#@:=-:::::::::::::::::::::::::::::::::::::::+*::::.                                  
             :#@             :%@+.                        =+                                       
             :#@         .=%@=.                           =+                                       
             :#@       .=@%-                              =+                                       
             :#@    ..+@%:                                ..                                       
             :#@   .#@*.                                                                           
             :#@.:+:                                                                               
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
    .%@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@.",
        5 => "                                                                           
             .-##################################################:                                  
             :#@:=-::::::::::::::::::::::::::::::::::::::::+*::::.                                  
             :#@             :%@+.                         =+                                       
             :#@         .=%@=.                            =+                                       
             :#@       .=@%-                               =+                                       
             :#@    ..+@%:                              :*@@@@#:                                    
             :#@   .#@*.                              .%@#:..:*@%:                                  
             :#@.:+:                                 .#@:      :@#:                                 
             :#@                                     :%%        #%-                                 
             :#@                                     .*@-      :@#.                                 
             :#@                                      .#@#-::-#@#.                                  
             :#@                                        .+#%%#+:                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
    .%@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@.",
        4 => "      
             .-##################################################:                                  
             :#@:=-::::::::::::::::::::::::::::::::::::::::+*::::.                                  
             :#@             :%@+.                         =+                                       
             :#@         .=%@=.                            =+                                       
             :#@       .=@%-                               =+                                       
             :#@    ..+@%:                              :*@@@@#:                                    
             :#@   .#@*.                              .%@#:..:*@%:                                  
             :#@.:+:                                 .#@:      :@#:                                 
             :#@                                     :%%        #%-                                 
             :#@                                     .*@-      :@#.                                 
             :#@                                      .#@#-::-#@#.                                  
             :#@                                        .+#@@#+:                                    
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           ##:                                      
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
    .%@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@.",
        3 => "
             .-##################################################:                                  
             :#@:=-::::::::::::::::::::::::::::::::::::::::+*::::.                                  
             :#@             :%@+.                         =+                                       
             :#@         .=%@=.                            =+                                       
             :#@       .=@%-                               =+                                       
             :#@    ..+@%:                              :*@@@@#:                                    
             :#@   .#@*.                              .%@#:..:*@%:                                  
             :#@.:+:                                 .#@:      :@#:                                 
             :#@                                     :%%        #%-                                 
             :#@                                     .*@-      :@#.                                 
             :#@                                      .#@#-::-#@#.                                  
             :#@                                        .+#@@#+:                                    
             :#@                                          .@@:                                      
             :#@                                       .:%@@@:                                      
             :#@                                    ..+@%+.%@:                                      
             :#@                                   :#@#-.  %@:                                      
             :#@                                   .-..    %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           ##:                                      
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
    .%@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@.",
        2 => " 
             .-##################################################:                                  
             :#@:=-::::::::::::::::::::::::::::::::::::::::+*::::.                                  
             :#@             :%@+.                         =+                                       
             :#@         .=%@=.                            =+                                       
             :#@       .=@%-                               =+                                       
             :#@    ..+@%:                              :*@@@@#:                                    
             :#@   .#@*.                              .%@#:..:*@%:                                  
             :#@.:+:                                 .#@:      :@#:                                 
             :#@                                     :%%        #%-                                 
             :#@                                     .*@-      :@#.                                 
             :#@                                      .#@#-::-#@#.                                  
             :#@                                        .+#@@#+:                                    
             :#@                                          .@@:                                      
             :#@                                       .:%@@@@%:.                                   
             :#@                                    ..+@%+.%@-+@@=..                                
             :#@                                   :#@#-.  %@: .-#@#:                               
             :#@                                   .-..    %@:   ..-.                               
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           ##:                                      
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
    .%@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@.",
        1 => "                                                                               
             .-##################################################:                                  
             :#@:=-::::::::::::::::::::::::::::::::::::::::+*::::.                                  
             :#@             :%@+.                         =+                                       
             :#@         .=%@=.                            =+                                       
             :#@       .=@%-                               =+                                       
             :#@    ..+@%:                              :*@@@@#:                                    
             :#@   .#@*.                              .%@#:..:*@%:                                  
             :#@.:+:                                 .#@:      :@#:                                 
             :#@                                     :%%        #%-                                 
             :#@                                     .*@-      :@#.                                 
             :#@                                      .#@#-::-#@#.                                  
             :#@                                        .+#@@#+:                                    
             :#@                                          .@@:                                      
             :#@                                       .:%@@@@%:.                                   
             :#@                                    ..+@%+.%@-+@@=..                                
             :#@                                   :#@#-.  %@: .-#@#:                               
             :#@                                   .-..    %@:   ..-.                               
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                          .%%:                                      
             :#@                                         .*@=                                       
             :#@                                        .=@+                                        
             :#@                                        :@*.                                        
             :#@                                       .@%:                                         
             :#@                                      .%@-                                          
             :#@                                     .*@-                                           
             :#@                                    .=@+                                            
             :#@                                    -@*.                                            
             :#@                                   :@#:                                             
             :#@                                   -*:                                              
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
    .%@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@.",
        0 => "                       
             .-##################################################:                                  
             :#@:=-::::::::::::::::::::::::::::::::::::::::+*::::.                                  
             :#@             :%@+.                         =+                                       
             :#@         .=%@=.                            =+                                       
             :#@       .=@%-                               =+                                       
             :#@    ..+@%:                              :*@@@@#:                                    
             :#@   .#@*.                              .%@#:..:*@%:                                  
             :#@.:+:                                 .#@:      :@#:                                 
             :#@                                     :%%        #%-                                 
             :#@                                     .*@-      :@#.                                 
             :#@                                      .#@#-::-#@#.                                  
             :#@                                        .+#@@#+:                                    
             :#@                                          .@@:                                      
             :#@                                       .:%@@@@%:.                                   
             :#@                                    ..+@%+.%@-+@@=..                                
             :#@                                   :#@#-.  %@: .-#@#:                               
             :#@                                   .-..    %@:   ..-.                               
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                           %@:                                      
             :#@                                          .%@:                                      
             :#@                                         .*@@#.                                     
             :#@                                        .=@+-@+.                                    
             :#@                                        :@*..+@-                                    
             :#@                                       .@%:  .#@:                                   
             :#@                                      .%@-    :%%:                                  
             :#@                                     .*@-      :@#.                                 
             :#@                                    .=@+        -@+.                                
             :#@                                    -@*.        .+@=                                
             :#@                                   :@#:          .#@-                               
             :#@                                   -*:            .%=.                              
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
             :#@                                                                                    
    .%@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@."
    ];
     return "<pre>" . $estados[$attemptsLeft] . "</pre>";
    }

}

$storage = new Storage('ahorcado');
$wordProvider = new WordProvider('words.txt'); 
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
            $message = "¡Game Over! La palabra era: " . $game->word;
        }
    } else {
        $message = "Por favor, introduce una sola letra valida.";
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        .win { background-color: #d4edda; color: #155724; }
        .lose { background-color: #f8d7da; color: #721c24; }
        .info { background-color: #d1ecf1; color: #0c5460; }
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
