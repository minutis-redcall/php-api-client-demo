<?php

require_once(__DIR__.'/vendor/autoload.php');

if (!is_file('config.yml')) {
    die('You should copy config.yml.dist into config.yml');
}

$config = \Symfony\Component\Yaml\Yaml::parse(
    file_get_contents('config.yml')
);

$redCall = new \App\Service\RedCallClient(
    $config['token'], $config['secret']
);

$app = new \Symfony\Component\Console\Application();

$app->addCommands([
    new \App\Command\DemoCommand($redCall),
]);

$app->run();
