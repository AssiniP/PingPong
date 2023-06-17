<?php
class EditorController{
    private $renderer;
    private $editorModel;

    public function __construct($EditorModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->editorModel = $EditorModel;
    }

    public function list()
    {
    }
}
