<?php
$config = require __DIR__ . '/../config/config.php';

$wordsPath   = $config['storage']['words_file'];
$gamesPath   = $config['storage']['games_file'];
$maxAttempts = (int)$config['game']['max_attempts'];
