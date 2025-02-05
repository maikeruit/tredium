# Инструкция

```bash
# Cборка проекта
composer install
npm install
npm run build 
```

```bash
# Sail и Миграция
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
```

# Проект будет доступен по адресу

## https://localhost

# Тестовое задание для веб-разработчика

## Предисловие
Уважаемые соискатели, уважайте свое время и время программиста, проверяющего вашу работу. Если так получилось, что вы не можете (не успеваете\не хотите) выполнить задание до конца - сообщите пожалуйста об этом HR. Проверьте пожалуйста работоспособность вашего проекта ([чек-лист проверки](#чек-лист-сдачи-проекта)).

Подойдите пожалуйста к исполнению задания максимально усердно. Продумайте архитектуру проекта, используйте "плюшки" фреймворка, которые сделают ваш код качественным. Максимально хорошо организуйте код. Если можно что то вынести в сервисный слой - выносите, если можно где то использовать eloquent scopes - используйте.

Не забывайте, что мне необходимо по этому, крайне небольшому, заданию оценить ваши знания. Я хочу увидеть production ready сервис, который вы можете запустить в работу прямо сейчас.

Если у вас PHPStorm или другая IDE, то сделайте так, чтобы он не ругался на код. Подключите ide-helper (https://github.com/barryvdh/laravel-ide-helper), сгенерируйте файлы _ide_helper.php и _ide_helper_models.php. После этого прогуляйтесь по своему коду и поправьте в соответствии с рекомендациями.

**Если вам не понятно задание - задавайте мне вопросы**.

## Описание
Необходимо написать небольшой сайт - статейник. Макет не принципиален. Можно взять bootstrap или любой другой фреймворк. Так же можно использовать любые JS фреймворки. Главное, чтобы на страницах присутствовали все компоненты.

Можно не реализовывать хранение изображений. Для заглушек можно юзать сервис [https://placeholder.com/](https://placeholder.com/) или подобный (чтобы не заморачиваться с нарезкой). Либо сделать 2 изображения (миниатюра и обычное) и переиспользовать их.

Всю логику реализуем встроенным функционалом Laravel.

Результат необходимо загрузить в публичный репозиторий GitHub.

## Стек
- PHP 7.4 или выше
- Laravel 8 или выше

## Разделы сайта
- [Главная страница](#главная-страница)
- [Каталог статей](#каталог-статей)

## Страницы сайта
- Главная страница
  Url: /
- Каталог статей
  Url: /articles
- Страница статьи
  Url: /articles/{slug}

## Описание страниц
### Главная страница
Компоненты:
- [Навигационное меню](#навигационное-меню). Активный пункт "Главная страница".
- Последние добавленные статьи. 6 [миниатюр статей](#миниатюра-статьи) в сортировке LIFO

### Каталог статей
Компоненты:
- [Навигационное меню](#навигационное-меню). Активный пункт "Каталог статей".
- Листинг статей. Сортировка LIFO. 10 [миниатюр статей](#миниатюра-статьи) на страницу
- [Пейджинация](#пейджинация)

### Статья
Компоненты:
- [Навигационное меню](#навигационное-меню). Активный пункт "Каталог статей".
- Обложка статьи
- Текст статьи
- [Теги статьи](#тег-статьи)
- [Счетчик лайков статьи](#счетчик-лайков-статьи)
- [Счетчик просмотров статьи](#счетчик-просмотров-статьи)
- [Форма коментария](#форма-комментария)

## Компоненты

### Навигационное меню
Необходимо сделать так, чтобы в блоке меню был помечен пункт раздела, в котором находится в текущий момент пользователь. Правила формирования подсветки выбранного раздела описаны в блоке [**Описание страниц**](#описание-страниц)

### Пейджинация
Стандартная пейджинация Laravel ([https://laravel.com/docs/7.x/pagination#introduction](https://laravel.com/docs/7.x/pagination#introduction))

### Миниатюра статьи
Блок состоит из следующих элементов:
- миниатюра обложки статьи
- заголовок статьи
- краткое описание статьи - первые 100 симоволов от текста статьи

### Тег статьи
Ссылка. Состоит из url и label.

### Счетчик лайков статьи
Элемент является кнопкой, на которой в качестве label написано число.
При клике на кнопку отправляется AJAX запрос, инкрементирующий счетчик. В ответе на запрос
возвращается новое значение, которое необходимо отобразить в label.

### Счетчик просмотров статьи
Текстовый элемент, отображающие текущий счетчик просмотров. Через 5 секунд после открытия статьи отправляется запрос, инкрементирующий счетчик. В ответе на запрос возвращается новое значение, которое необходимо отобразить в элементе.

### Форма комментария
Форма, состоящая из 2х полей:
- Тема сообщения
- Текст сообщения

При нажатии на кнопку "Отправить" отправляется AJAX запрос. При успешной обработке форма заменяется на плашку "Ваше сообщение успешно отправлено".

## API методы
При реализации API методов учтите, что онлайн блога заранее не известен.
Ваша реализация должна позволять избежать блокировок БД в случае огромного количества входящих запросов (допустим 1 млн входящих запрос на инкрементацию счетчика просмотров). Это требования необходимо вам для организации правильного хранения лайков и просмотров.
Ответ: application/json

### Инкрементирование счетчика лайка
Ответ: новое значение счетчика

### Инкрементирование счетчика просмотров
Ответ: новое значение счетчика

### Создание комментария к статье
Вводные данные: Подразумеваем, что данный механизм очень медленный по какой то причине (100500 операций). Для того, чтобы не городить реально долго выполняющуюся логику, используйте для теста команду sleep(600), которая остановит исполнение кода на 10 минут.

Необходимо реализовать следующую механику:
- API метод получает запрос
- метод возращает ответ клиенту
- метод исполняет логику в фоновом режиме

Передаваемые поля:
- subject. Varchar(255).
- body. LongText

Ответы:
- ValidationException. Если не заполнено одно из полей.
- Success. Любой, главное чтобы с 200 кодом.

## Развертывание
Развертывание должно производиться через стандартные механизмы:
- git clone ...
- php artisan migrate
- php artisan db:seed
- php artisan serve

То есть никакие импорты SQL файлов \ загрузка zip архивов - не приемлемы.

## Тестирование
- ArticleSeed. Должен сгенерировать 20 статей с рандомной датой и рандомным текстом (длина текста от 200 символов). Используем Faker.
- ArticleTagSeed. Должен сгенерировать некоторое количество тегов, чтобы хотя бы 1 был в каждой статье.

## Чек-лист сдачи проекта
- удаляем директорию vendor и node_modules (если требуется)
- удаляем все таблицы с тестовой БД (или пересоздаем БД)
- удаляем файл .env из корня проекта
- создаем файл .env на базе .env.example
- запускаем composer install
- запускаем npm install (если требуется)
- создаем ключ (php artisan key:generate)
- запускаем миграции (php artisan migrate)
- запускаем сиды (php artisan db:seed)
- запускаем локальный сервер (php artisan serve)
- проверяем весь написанный функционал. Все страницы должны содержать все элементы, описанные в блоке [**Описание страниц**](#описание-страниц)

## Примерный вид интерфейсов
### Главная страница
![Главная страница](https://i.ibb.co/Yykzsby/3.jpg)
### Каталог статей
![Каталог статей](https://i.ibb.co/f4WF9nb/4.jpg)
![Каталог статей](https://i.ibb.co/sFpCfrz/2.jpg)
### Статья
![Статья](https://i.ibb.co/5LYDhRT/1.jpg)
