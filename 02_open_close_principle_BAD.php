<?php


class Animal
{
    private string $name = '';

    public function __construct($name)
    {
        $this->name = $name;
    }

    // Этот метод нарушает принцип OCP потому, что он анализирует качества конкретных объектов
    // и когда у нас появится новый тип объекта, нам придется этот метод менять
    public function getLegsQuantity()
    {
        if ($this->name === 'утка') {
            return 2;
        } elseif ($this->name === 'собака'){
            return 4;
        } // я должен буду дописать это иф, если у меня появится новый вид животного, например змея

    }
}

$duck = new Animal('утка');
$dog = new Animal('собака');
// до этого момента все работает прекрасно
echo $duck->getLegsQuantity();
echo $dog->getLegsQuantity();

// а тут проблема, работать не будет - нужно менять Animal::getLegsQuantity
$snake = new Animal('змея');
echo $snake->getLegsQuantity();
