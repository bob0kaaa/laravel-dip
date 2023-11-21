# Дипломный проект по профессии «Веб-разработчик»
## Дипломный проект представляет собой создание сайта для бронирования онлайн билетов в кинотеатр и разработка информационной системы для администрирования залов, сеансов и предварительного бронирования билетов.

#### Проект реализован с помощью :
#### Laravel 10.30.0,
#### PHP 8.2,
#### NodeJS 18.16.0,
#### Сomposer 2.6.4,
#### PHPQrCode,
#### PostgreSQL

### Сущности

#### Кинозал (таблица halls)
Зал - место просмотра фильма, согласно забронированным и купленым билетам

#### Сеанс (таблица seances)
Сеанс - это временной промежуток, за которое в кинозале будет показываться фильм. На сеанс могут быть забронированы билеты.

#### Зрительское место (таблица seats)
Зрительские места могут быть VIP - VIP(обозначение в коде -VIP), STANDART - обычные (обозначение в коде -NORM), DISABLED - неиспользуемые(обозначение в коде -FAIL).


#### Фильм (таблица films)
Информация о фильме заполняется администратором. Фильм связан с сеансом в кинозале.

#### Билет (таблица tickets)
В билете обязательно указаны место, ряд, сеанс, qr-код c уникальным кодом бронирования.

#### Пользователь (таблица users)
Авторизованный или неавторизованный пользователь.


### Роли пользователей системы
* Администратор
* Гость

### Возможности администратора
* Создание/редактирование залов
* Создание/редактирование фильмов
* Настройка цен
* Создание/редактирование расписания

### Возможности пользователя
* Просмотр расписания
* Выбор места в кинозале
* Бронирование билета

### РЕАЛИЗОВАНО
### ---------------------
#### Клиентская часть полностью готова:
* Календарь обеспечивает показ сетки сеансов на 2 недели
* Показ сетки сеансов в залах.
* При выборе сеанса - переход на страницу выбора мест (1 и более )(щелчок левой клавиши -выбор).
* Button забронировать - переход на страницу показа билета
* Показ билета с qr кодом (PHP Qr Code). Закодирована строка: Фильм, зал, ряд, место, время, стоимость сеанса

#### Административная часть:
* Показ формы добавления зала
* Удаление зала с подтверждением
* Выбор зала
* Настройка цен
* Настройка конфигурации, визуализация только выполнена с изменением типов мест

### Выполнена вставка готовой вертски:
#### Форма авторизации на отдельной странице

* input "email"
* input "password"
* Button "Авторизоваться"

#### Форма "добавления зала" в popup

* input "Название зала"
* Button "Добавить зал"
* Button "Отменить"


#### Форма добавления фильма в popup

* input "Название фильма"
* input "Описание фильма"
* input "Страна фильма"
* input "Длительность фильма"
* input "Ссылка на изображение"
* Button "Добавить фильм"
* Button "Отменить"
* 
#### Форма изменения фильма в popup

* input "Название фильма"
* input "Описание фильма"
* input "Страна фильма"
* input "Длительность фильма"
* input "Ссылка на изображение"
* Button "Изменить фильм"
* Button "Отменить"

#### Button открытие/закрытие продаж:

Кнопка проверяет какие залы не открыты для продашь если есть таковы, то открывает продали.
Если все залы открылы, то кнопка меняется на "Закрыть продажу билетов"


#### Форма назначения сеанса для фильма:

При нажатии "+" (https://prnt.sc/TkGfTGf_M5I5) на карточке фильма открываться форма в popup
Селектор "Зал"(по умолчанию значение из результатов drag&drop
input "Время начала" (маска ввода в формате 00:00:00)

* Button "Добавить"
* Button "Отменить"

На карточке сеанса находится кнопка удаления сеанса https://prnt.sc/u6LyI2eq1wH4


* Button "Добавить"
* Button "Отменить"

#### Форма подтверждение удаления сеанса для фильма, "Снятие с показа":

При перетаскивании фильма из зала должна открываться форма удаления сеанса в popup

* Button "Удалить"
* Button "Отменить"

#### Условия редактирования конфигурации залов:

1. Редактировать цены, число, и типы мест можно только в зале без существующих сеансов.
   Если в зале существуют сеансы, то вкладка с информацией о зале недоступна, а у каждой вкладки высвечивается подсказка, что редактировать можно только залы без сеансов.
2. Удаление сеанса.
3. Удаление фильма возможно, если он снят со всех сеансов.
4. Удаление зала возможно, если в нем нет сеансов.
### ------------------

### Запуск проекта

#### composer install
#### npm install
#### npm run build
### ------------------
### Сделать миграции: очистить и наполнить базу:
#### php artisan migrate:fresh
#### php artisan migrate:refresh --seed
### ------------------
### Создать storage link для загрузки и хранения постеров
#### php artisan storage:link
### ------------------
### Сгенерить key
#### php artisan key:generate
### ------------------
### Запустить
#### php artisan serve


### Данные тестового пользователя-администратора:

#### Email: admin@test.ru
#### password: admin

### Данные тестового пользователя:

#### Email: test@test.ru
#### password: 12345678


#### P.S. При открытие главной страницы проекта не подгрузятся простеры фильмов нужно через админ панель саомостоятельно загрузить постеры
