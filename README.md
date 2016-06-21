## Плагин для интаграции формы AmoCRM в CMS Joomla!

### Настройка формы в AmoCRM

* Зайдите в раздел «Сделки»
* Нажмите кнопку «Еще»
* Нажмите кнопку «Добавить форму»
* Если форма ранее не была создана, то будет создана новая с четырьмя стандартными полями: Названия контакта, Телефон, E-mail, Компания

После настройки формы, будет указан код для интеграции с WordPress, в нашем случае он подойдет тоже!
```
[amocrm id=xxxxx hash=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx locale=ru]
```
Скопируйте его и разместите в любом материале или HTML модуле в Joomla (если код размещен в модуле, убедитесь, что модуль обрабатывается плагинами). 
После настройки формы и размещения кода убедитесь, что данный плагин опубликован

Такой подход позволяет правильно разместить форму в коде страницы, минуя фильтры Joomla (да их можно выключить, но это не безопасно для сайта)
