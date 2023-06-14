<?php
require_once(SITE_ROOT . '/helpers/Session.php');
class AdminController
{
    private $renderer;
    private $partidaModel;
    public function __construct($partidaModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->partidaModel = $partidaModel;
    }

    public function list()
    {
        $this->renderer->render('admin');
    }
}
