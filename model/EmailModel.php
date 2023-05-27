<?php

class EmailModel
{

    public function __construct()
    {
    }

    public function enviarMail($mail) {
       include_once("vendor/EmailSend.php");
        enviarMail($mail);
    }
}