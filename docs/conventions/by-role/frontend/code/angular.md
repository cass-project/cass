Стандарты кода - Angular
========================

Расположение файлов
-------------------

Название файлов совпадает с [основным] классом, которые они в себе хранят
Если же какая-то <сущность> что-то состоит из нескольких файлов (стандартный пример: компонент), то все файлы помещаются в директорию с названием сущности ([основной] класс)

Для чего это сделано:

```
// Сработает как в случае одного файла: MyComponent.ts, так и в случае, если компонент в результате разработки раздробился: MyComponent/app.component.ts
import {MyComponent} from "my/some/MyComponent"
```

1. Кейс 1: Компонент или сервис занимает один файл:

```
    module/
        square/
            service/
                SquareRESTService.ts
```

2. Кейс 2: Компонент или сервис состоит из нескольких файлов:

```
    module/
        square/
            /component
                /SquareCalculate
                    app.component.ts <<< Исходный код
                    template.html
                    style.shadow.scsss
```

3. Кейс 3: Компонент/Сервис занимает один файл и содержит дочерние компоненты и сервисы:

```
    module/
        square/
            /component
                component/
                    Tab/
                        SquareSizeTab/
                            app.component.ts
                            template.html
                            style.shadow.scss
                        SquareColorTab/
                            app.component.ts
                            template.html
                            style.shadow.scss
                    SquareOptions
                        app.component.ts
                        service.ts <<< !
                        template.html
                        style.shadow.scss
```

4. Исключение: модуль

```
    module/
        square/
            ...
            app.component.ts
            template.html
            style.shadow.scss
```

Роуты
-----

- Компоненты, которые являются компонентами для роутера (т.е. используются в @RouteConfig), должны иметь постфикс `*Route`
- Компоненты-роуты находятся в отдельной директории `{MODULE_NAME}/route`


Постфикс Component запрещен
---------------------------
- Его использование избыточно
- Исключение: корневой элемент модуля (app/module/profile/app.component.ts, ProfileComponent)

Селекторы
---------

- Все селекторы (т.е. название кастомных тегов) должны начинаться с префикаса `cass-`

Импорты
-------

Импорты angular2-компонентов, и импорты модулей проекта должны быть отделены друг от друга одной пустой строкой.

```
import {Component} from "angular2/core";

import {MessageBusService} from "../../service/MessageBusService/index";

@Component({
// ....
```

Что такое style.shadow.scss и global.head.scss?
-----------------------------------------------

- .SCSS - это расширение для файлов, обрабатываемых SASS-препроцессором: http://sass-lang.com/
- Все SCSS-файлы, которые заканчиваются на `*.head.scss`, инклудятся в `<head>`
- Все SCSS-файлы, которые заканчиваются на `*.shadow.scss`, инклудятся в ShadowDOM компонента, к которому вы привязываете данный файл:

### Пример: использование *.shadow.scss

```typescript
// component.ts
@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
});
class MyComponent {}
```

```scss
article {
    border: 1px solid black;
    background-color: gray;
    padding: 10px;
    
    h1 {
        text-decoration: underline;
    }
}
```

```html
<!-- template.html -->
<article>
    <h1>ShadowDOM - это то, что инкапсулирует стиль этого компонента!</h1>
    <p>Все CSS-стили, которые описаны в <em>style.shadow.css</p>, будут влиять только на элементы, которые относятся к этому элементу, и не имееют никакого влияния на какие-либо еще.</p>
    <p>(Если вы опишите css-правила для BODY, они не будут работать вообще.)</p>
</article>
```

Сервисы
-------

Провайдеры сервисов, которые должны быть доступны глобально (практически все виды сервисов: REST-сервисы, сервисы предметной области,
 сервисы "бандл"-компонентов), должны добавляться в компонент `App`:

```typescript
@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    providers: [
        AuthService,
        AuthComponentService,
        ProfileComponentService,
        CommunityComponentService,
        CommunityRESTService,
        ThemeService,
        // ...
    ],
})
export class App {
    // ...
}
```

*Исключения*

- Сервисы, инстансы которых должны быть *локальными* на компонент (т.е. должны создаваться при каждом создании компонента):

```typescript
@Component({
    selector: 'cass-upload-image-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ImageCropperService, // Каждый компонент должен иметь дело со своим личным инстансом этого сервиса
    ],
    directives: [
        ModalComponent,
        ImageCropper,
    ]
})
export class UploadImageModal { /// ... }
```

Сущности
--------

- Сущности должны быть описаны в `{bundle}/entity/{EntityName}.ts`
- Сущности всегда должны быть описаны в виде интерфейса. Опционально сущности могут быть также описаны в виде класса.
- Если сущность описана в виде интерфейса, то ее название: `{EntityName}Entity`. Пример: `interface AccountEntity`
- Если сущность описана в виде класса, то ее название: `{EntityName}`. Пример: `class Account`

Проблемы
--------

Q. PhpStorm со временем начинает тормозить
A. ~/www/app/asssets/bundles/main.js -> mark as plain text

Обязательно к прочтению:
------------------------

- (https://angular.io/docs/ts/latest/guide/)[]

- HTTP в Angular 2: (https://auth0.com/blog/2015/10/15/angular-2-series-part-3-using-http/)

- Providing Custom View Templates For Components: (http://www.bennadel.com/blog/3034-providing-custom-view-templates-for-components-in-angular-2-beta-6.htm), (http://www.michaelbromley.co.uk/blog/513/components-with-custom-templates-in-angular-2)