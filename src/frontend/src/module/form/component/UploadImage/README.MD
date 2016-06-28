UPLOAD IMAGE
============

Как использовать?
-----------------

#### 1. Создайте стратегию аплоада картинки:

```typescript
// app/module/profile/util/UploadProfileImageStrategy.ts

import {UploadImageStrategy} from "../../util/component/UploadImage/strategy";
import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {UploadImageModal} from "../../util/component/UploadImage/index";

export class UploadProfileImageStrategy implements UploadImageStrategy
{
    getCropperOptions() {
        return {
            aspectRatio: 1 /* 1/1 */,
            viewMode: 2 /* VM3 */,
            background: false,
            center: true,
            highlight: false,
            guides: false,
            movable: true,
            minCropBoxWidth: 150,
            minCropBoxHeight: 150,
            rotatable: false,
            scalable: false,
            toggleDragModeOnDblclick: false,
            zoomable: true,
            minContainerWidth: 500,
            minContainerHeight: 500
        };
    }

    abort(file: Blob, modal: UploadImageModal) {
        console.log('upload aborted');
        modal.progress.abort();
    }

    process(file: Blob, model: UploadImageCropModel, modal: UploadImageModal) {
        console.log('upload image');

        modal.progress.reset();

        setTimeout(() => {
            modal.progress.update(50);

            setTimeout(() => {
                console.log('upload complete');
                modal.progress.complete();
                modal.close();
            }, 1000);
        }, 1000);
    }
}
```

#### 2. Подключить директиву в компонент, который должен вызывать модальное окно UploadImage'а, и установите стратегию аплоада файлов

```typescript
@Component({
    selector: 'cass-profile-modal-tab-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        UploadImageModal,
    ],
    providers: [
        CORE_DIRECTIVES,
        UploadImageService
    ]
})

@Injectable()
export class ImageTab
{
    upload: UploadImageModalControl = new UploadImageModalControl();

    constructor(private uploadImageService: UploadImageService) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy());
    }

    uploadProfileImage() {
        this.upload.open();
    }

    closeUploadProfileImageModal() {
        this.upload.close();
    }
}

class UploadImageModalControl extends ModalControl {}
```

#### 3. Добавьте в шаблон модальное окно:


```typescript
// app/module/profile/component/ProfileModal/Tab/Image/template.html
<div>
  <!-- .... -->
  <div *ngIf="upload.isOpened()">
    <cass-upload-image-modal (close)="upload.close()"></cass-upload-image-modal>
  </div>
</div>
```
