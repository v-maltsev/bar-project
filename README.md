#Тестовое задание:
В бар приходят посетители выпивают и заказывают музыку. У посетителей есть любимые жанры.  
Если играет композиция любимого жанра посетителя он идет танцевать, иначе он идет в бар и берет себе коктейли.  
Необходимо эмулировать бар с произвольным кол-вом посетителей с произвольным набором любимых жанров (у посетителя может быть как один так и несколько любимых жанров).
Необходимо реализовать код, с помощью которого можно собрать в клуб определенную публику.  
Желательно, чтобы код был расширяем.  
Поведение посетителей (что происходит в баре в данный момент) следует выводить на экран текстом.  
Результат должен быть проверяемым: должно быть понятно, какая музыка играет, и какой конкретно посетитель какие действия выполняет.  
Проект должен быть загружен на github или gitlab или любой другой публичный сервис управления репозиториями. Процедура установки должна быть описана в Readme.md.

Дополнительно (не обязательно, но будет плюсом):
1. Использование composer, сторонних библиотек и фреймворков;
2. Запуск приложения в виде веб-сервиса с поддержкой REST. Возможность запрашивать текущее состояние бара. Ограничение доступа, авторизация;
3. Настроенный Docker образ.
##Установка (только linux)
Из корня проекта:
```
make init
```
Удаление:
```
make docker-down-rmi
```
#REST API
Текущий статус:
```
http://localhost:8080/api/bar
"GET"
```
###Композиции
Список композиций
```
http://localhost:8080/api/composition
"GET"
```
Подборная информация о композиции
```
http://localhost:8080/api/composition/1
"GET"
```
###Жарны
Список жанров
```
http://localhost:8080/api/genre
"GET"
```
Подборная информация о жанре
```
http://localhost:8080/api/genre/1
"GET"
```
###Посетители
Список посетителей
```
http://localhost:8080/api/visitor
"GET"
```
Подборная информация о жанре
```
http://localhost:8080/api/visitor/1
"GET"
```
Список посетителей на танцполе
```
http://localhost:8080/api/visitor/dance
"GET"
```
Список посетителей в баре
```
http://localhost:8080/api/visitor/drink
"GET"
```
###Плейлист
Текущая композиция
```
http://localhost:8080/api/playlist
"GET"
```
Добавить композицию
```
http://localhost:8080/api/playlist/add
"PUT"
{
    "compositionId": 4
}
```
#Консольные команды
Добавление нового жанра
```
php bin/console bar:genre:create
```
Добавление новой композиции
```
php bin/console bar:composition:create
```
Добавление нового посетилея
```
php bin/console bar:visitor:create
```
Добавление включение композиции по id
```
php bin/console bar:playlist:add
```