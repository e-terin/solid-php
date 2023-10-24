<?php

// Наш исходный, базовый тип Т
class T
{
    // та самая функция q
    public function getNumber()
    {
        return random_int(0,9); // возвращает целое число
    }
}

// Подтип типа Т - класс T1
class T1 extends T
{
    // та же самая функция q, но уже в подтипе
    public function getNumber()
    {
        return 1; // ведет себя так же как и getNumber в родителе - возвращает целое число!
    }
}

// функция, изначально работающая с базовым типом Т
function doSomethingWithT(T $object)
{
    return random_int($object->getNumber(), 99);
}

$x = new T();
echo doSomethingWithT($x); // все работает

// а теперь попытаемся использовать функцию, изначально работавшую с базовым типом Т, но передадим ей
// объект подтипа Т - типа T1
$y = new T1();
echo doSomethingWithT($y);
// все работает так же, как и с базовым типом Т, никаких ошибок нет

