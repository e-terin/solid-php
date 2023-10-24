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
        return 'один'; // ведет себя по-другому: возвращает строку, а не целое число! Вот оно, нарушение LSP!
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
$y = new T1(); // теперь у нас объект $y имеет два типа и T1 и Т - смело передаем его в функцию doSomethingWithT
echo doSomethingWithT($y); // и ... происходит ошибка "random_int() expects parameter 1 to be int, string given",
// поведение функции меняется, она ломается, т.к. в первый аргумент функции random_int(), которая находится
// внутри doSomethingWithT() попадет строка, а не число.
