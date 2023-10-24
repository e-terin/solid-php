# Принципы SOLID. Примеры на PHP

## S: Single Responsibility Principle (SRP - Принцип единственной ответственности)

### Определение

Для каждого класса должно быть определено единственное назначение. Все ресурсы, необходимые для его осуществления, должны быть инкапсулированы в этот класс и подчинены только этой задаче.

### Пример нарушения (01-single-responsibility-principle-BAD.php)

Я написал класс Document, описывающий структуру некоего Документа. Сам Документ не висит просто так в воздухе, а должен быть напечатан на экране. Поэтому я добавляю в класс Document функцию printDocument, которая выводит документ на экран. Будет очень удобно в клиентском коде - можно создать Документ и сразу его напечатать (строки 24-25). Однако именно это метод и нарушает принцип единственной ответственности, т.к. назначение класса Document - описать структуру Документа и единственной причиной для его изменения является изменение структуры Документа. Например, в Документ нужно будет добавить какое-нибудь новое сво-во: колонтитул, подвал и т.д - тогда я могу менять класс Document. Но действие "вывести на экран" к самому документу не относится, поэтому согласно SRP мы должны вынести печать в другой класс. Кстати и в реальной жизни вы же не поручаете печать документа самому документу - вы поручаете это принтеру. Нарушение этого принципа может привести к невообразимой каше и это легко понять, если представить, что по новому поручению руководства, вас попросили сделать экспорт этого документа в XMl, а потом например в CSV. Что вы будете делать в этом случае? Правильно, добавите в класс Document новую функцию printDocumentXml и т.д. В итоге наш бедный Document разрастется до таких размеров и будет содержать кучу методов, не относящихся к самому документу.

### Пример соблюдения (01_single_responsibility_principle_GOOD.php)

Вынесем метод печати из класса Document в отдельный класс DocumentPrinter. Мы разделили ответственность - Document отвечает за сам документ, за его структуру, а DocumentPrinter отвечает за действия с этим Документом. Теперь если нас попросят вывести документ еще и например в XML, то мы будем менять DocumentPrinter, а сам Document останется не тронутым - у нас не будет причины для его изменения.

## O: Open-Closed Principle (OCP - Принцип открытости/закрытости)

### Определение
Программные сущности должны быть открыты для расширения, но закрыты для модификации.

### Пример нарушения (02_open_close_principle_BAD.php)
Есть класс Animal, описывающий животных. В нем есть функция подсчета ног у животного - getLegsQuantity. Все работает хорошо, до тех пор, пока я не решу добавить какой-нибудь новый вид животного, например змею. И тогда мне придется изменять (модифицировать) метод getLegsQuantity, чтобы он учитывал еще и змею. Это и есть нарушение принципа OSP - согласно ему, мне нельзя менять метод getLegsQuantity. Причина проблемы здесь в том, что метод getLegsQuantity анализирует свойства конкретных объектов! Значит нужно двигаться в сторону абстракций, чтобы избежать этого.

### Пример соблюдения (02_open_close_principle_GOOD.php)

Сделаем класс Animal абстрактным. И обяжем потомков реализовать метод подсчета ног (сделаем функцию подсчета ног абстрактной). У каждого типа объекта такой метод будет свой. Посмотрим что у нас получается: есть Утка, есть Собака, они оба Животные и клиентский код работает так же как и прежде. Как же теперь добавить новое Животное - Змею? Создадим новый класс Snake по аналогии с имеющимися Duck и Dog, он так же наследуется от Animals и реализуем у этого класса функцию подсчета ног (ног у змеи вообще нет, возвращаем 0). Посмотрите что произошло: мы НЕ МОДИФИЦИРОВАЛИ классы Животного, Собаки и Утки, не трогали их вообще, но РАСШИРИЛИ класс Animals.

## L: Liskov Substitution Principle (LSP Принцип подстановки Барбары Лисков)

### Определение 
Если q(x) является свойством, верным относительно объектов x некоторого типа T, тогда q(y) также должно быть верным для объектов y типа T1, где T1 является подтипом типа T.  
Сложна? Знаю что сложно:) А если так:  
Есть класс Т, в нем есть метод q(). Расширим класс Т - создадим подкласс Т1, в нем также реализуем метод q(). Создадим от класса Т объект x, а от T1 объект y. Так вот $y->q() должен иметь ТАКОЕ ЖЕ ПОВЕДЕНИЕ как и $x->q(). 

Теперь на русском: функции, которые используют базовый тип, должны иметь возможность использовать подтипы базового типа, не зная об этом. Кажется, что не очень то вяжется с определением. Но давайте разбираться.

### Пример нарушения (03_liskov_substitution_principle_BAD.php) 

В это раз обойдемся без уточек, потому что хочется поближе к ацкому определению принципа показать пример. Создадим базовый класс Т (название прям беру из определения), в нем создадим какой-нибудь метод, который гарантированно возвращает целое число. В простом определении речь идет о функции, использующей базовый тип - делаю функцию doSomethingWithT(), которая аргументом принимает объект типа Т. Эта функция делает полезную работу с объектом типа Т (берет от него целое число при помощи метода getNumber() и как-то там использует). В клиентском коде, создаем объект "x" типа Т, передаем его в нашу функцию, все работает как нужно.

Теперь создадим подкласс T1 путем расширения класса Т и переопределим в нем функцию getNumber - теперь она возвращает не целое число, а строку. И попробуем теперь создать объект "у" подтипа Т1 и передать его в ту же самую функцию doSomethingWithT(), которая без ошибок работала у нас с объектом "x" базового класса Т. Так, как T1 является подклассом типа Т, то функция doSomethingWithT() с радостью примет в качестве параметра объект "у", ведь он также имеет и тип Т. Однако, в связи стем, что getNumber() в "у" кардинально (в нашем случае) отличается от getNumber() в "х" произойдет сбой - функция random_int() в doSomethingWithT() принимает аргументами только целые числа, а не строку!


