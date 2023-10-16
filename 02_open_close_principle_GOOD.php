<?php

// Создадим абстрактный класс "Животные" и обяжем детей реализовать функцию по подсчету ног
abstract class Animal
{
    abstract public function getLegsQuantity(): int;
}

class Duck extends Animal
{
    public function getLegsQuantity(): int{
        return 2;
    }
}

class Dog extends Animal
{
    public function getLegsQuantity(): int{
        return 4;
    }
}

// Клиентский код:
$duck = new Duck();
$dog = new Dog();
// все работает, как и в плохом примере
echo $duck->getLegsQuantity();
echo $dog->getLegsQuantity();

// и вот теперь если мне нужен новый тип Животного, я просто добавлю новый класс Snake
// и в нем реализую функцию по подсчету ног getLegsQuantity, а классы Duck,Dog и Animal Я ТРОГАТЬ НЕ БУДУ!!!
class Snake extends Animal
{
    public function getLegsQuantity(): int{
        return 4;
    }
}
$snake = new Snake();
echo $snake->getLegsQuantity();

