<?php

// Класс документа - содержит данные (инкапсулированы) только о структуре документа и ни о чем больше
class Document
{
    private string $title;
    private string $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }
}

class DocumentPrinter
{
    private Document $document; // принтеру для работы нужен сам документ

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function printDocument(): void
    {
        echo $this->title . '<br>' . $this->body;
    }
}

// Клиентский код:
$document = new Document('title', 'body'); // создаем Документ, он не знает что с ним будут делать, это не его дело
$printer = new DocumentPrinter($document); // Создаем Принтер и передаем ему документ
$printer->printDocument(); // выводим на экран

// теперь, если нас попросят добавить вывод документа в XML мы будем менять класс DocumentPrinter, ответственный за это!


