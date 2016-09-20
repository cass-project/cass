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
import {BrowserModule} from "@angular/platform-browser";
import {ModalBoxComponent} from "./component/Modal/box/index";
import {ModalComponent} from "./component/Modal/index";

export const CASSCommonModule = {
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
        ModalBoxComponent,
        ModalComponent,
    ],
    providers: [
        RESTService,
    ],
    imports: [
        BrowserModule,
    ]
};