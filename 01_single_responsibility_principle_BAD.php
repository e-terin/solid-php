<?php

// Создадим класс документа
class Document
{
    private string $title;
    private string $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    // Добавим метод вывода документа на экран, вот он и есть нарушитель SRP
    public function printDocument(): void
    {
        echo $this->title . '<br>' . $this->body;
    }
}

// Клиентский код:
$document = new Document('title', 'body');
$document->printDocument(); // очень удобно же
// Красота, я крутой программист


