import {NgModule} from '@angular/core';

import {RESTService} from "./service/RESTService";
import {Nothing} from "./component/Nothing/index";
import {WorkInProgress} from "./component/WorkInProgress/index";
import {ImageCropper} from "./component/ImageCropper/index";
import {LoadingIndicator} from "./component/LoadingIndicator/index";
import {PalettePicker} from "./component/PalettePicker/index";
import {ProgressLock} from "./component/ProgressLock/index";
import {TabModal} from "./component/TabModal/index";
import {TabModalHeader} from "./component/TabModal/component/TabModalHeader/index";
import {TabModalTab} from "./component/TabModal/component/TabModalTab/index";
import {UploadImageModal} from "./component/UploadImage/index";

@NgModule({
    declarations: [
        Nothing,
        WorkInProgress,
        ImageCropper,
        LoadingIndicator,
        PalettePicker,
        ProgressLock,
        TabModal,
        TabModalHeader,
        TabModalTab,
        UploadImageModal,
    ],
    providers: [
        RESTService,
    ]
})
export class CASSCommonModule {}