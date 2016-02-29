Стандарты кода - Angular
========================

Расположение файлов
-------------------

1. Компонент/Сервис занимает один файл:

```
    module/
        square/
            service/
                SquareRESTService.js
```

2. Компонент/Сервис состоит из нескольких файлов:

```
    module/
        square/
            /component
                /SquareCalculateComponent
                    component.ts <<< Исходный код
                    template.html
                    style.shadow.scsss
```

3. Компонент/Сервис занимает один файл и содержит дочерние компоненты и сервисы:

```
    module/
        square/
            /component
                component/
                    SquareOptionsComponent
                        component.ts
                        template.html
                        style.shadow.scss
                        global.head.css
                    SquareForm.ts
                service/
                    SquareRESTService.ts
                SquareCalculateComponent.ts
```

3. Компонент/Сервис состоит из нескольких файлов и содержит дочерние компоненты и сервисы:

```
    module/
        square/
            /component
                component/
                    SquareOptionsComponent
                        component.ts
                        template.html
                        style.shadow.scss
                        global.head.css
                    SquareForm.ts
                service/
                    SquareRESTService.ts
                SquareCalculateComponent/
                    component.ts
                    template.html
                    style.shadow.scss
```

4. Исключение: модуль

```
    module/
        square/
            ...
            index.ts
            template.html
            style.shadow.scss
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

Проблемы
--------

Q. PhpStorm со временем начинает тормозить
A. ~/www/app/asssets/bundles/main.js -> mark as plain text

Обязательно к прочтению:
------------------------

- HTTP в Angular 2: (https://auth0.com/blog/2015/10/15/angular-2-series-part-3-using-http/)

- Providing Custom View Templates For Components: (http://www.bennadel.com/blog/3034-providing-custom-view-templates-for-components-in-angular-2-beta-6.htm), (http://www.michaelbromley.co.uk/blog/513/components-with-custom-templates-in-angular-2)