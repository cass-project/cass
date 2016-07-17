Mofile First
============

Мы придерживаемся принципа "mobile first": по умолчанию всю вертску мы делаем для мобильных устройств.

Вся верстка должна делаться по следующему шаблону:


```
/* @ MOBILE-FIRST */

@import "";

article.component-my-component {
   ...
}

@include media-tablet {
    ...
}

@include media-screen {
   ...
}
```