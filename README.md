## Как использовать:

```
$linker = new Idegart\Linker\Linker();

// Сохраняем ссылку и формируем ее короткую версию
// Вернется строка вида 'JAKMu48D8s' (предполагается что домен будет добавлен отдельно)
$linker->storeLink('https://test.com');

$linker->getRealLink('JAKMu48D8s'); // Получаем ссылку

```
