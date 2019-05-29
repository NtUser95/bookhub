<?php

namespace App;

use Helpers\Flashes;

class Controller
{

    public $layoutFile = 'layout_main';

    // $body может использоваться в динамически подключаемом шаблоне
    public function renderLayout($body): string
    {
        $flashes = $this->renderFlashes();
        ob_start();
        $layoutDir = ROOT_PATH . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $this->layoutFile . '.php';
        require $layoutDir;
        return ob_get_clean();
    }

    public function renderFlashes()
    {
        $flashes = '';

        foreach (App::$user->getFlashes() as $key => $value) {
            $flashes .= Flashes::generate($value['type'], $value['message']);
        }

        return $flashes;
    }

    public function render($viewName, array $params = []): string
    {
        $viewFile = ROOT_PATH . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $viewName . '.php';
        extract($params);
        ob_start();
        require $viewFile;
        $body = ob_get_clean();
        ob_end_clean();
        /*if (defined(NO_LAYOUT)){
            return $body;
        }*/
        return $this->renderLayout($body);
    }

}
