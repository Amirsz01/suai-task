<?php

namespace App;

use Twig\Error\LoaderError;

class App
{
    private $router;
    public function __construct()
    {
        $this->router = new Router();
    }

    public function render($action)
    {
        try {
            return $this->router->dispatch($action);
        } catch (\PDOException $e) {
            echo \json_encode(['Error' => 'PDO Error: ' . $e->getMessage()]);
        } catch (LoaderError $e) {
            echo \json_encode(['Error' => 'Twig Error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            echo \json_encode(['Error' => $e->getMessage()]);
        }
    }
}
