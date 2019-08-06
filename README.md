## Как использовать:

```
$linker = new Idegart\Linker\Linker();

// Сохраняем ссылку и формируем ее короткую версию
// Вернется строка вида 'JAKMu48D8s' (предполагается что домен будет добавлен отдельно)
$linker->storeLink('https://test.com');

$linker->getRealLink('JAKMu48D8s'); // Получаем ссылку

```

## Дополнительные параметры:
Чтобы изменить параметры БД, можно использовать константы:
+ `LINKER_CONNECTION` - Схема соединения, по дефолту: `mysql:host=127.0.0.1`
+ `LINKER_TABLE_NAME` - Название таблицы, по дефолту `linker`
+ `LINKER_TABLE_USER` - Пользователь, по дефолту `root`
+ `LINKER_TABLE_PASSWORD` - Пароль, по дуфолту `''` 
