import {BackdropPreview} from "./component/Elements/BackdropPreview/index";
import {ImageSettings} from "./component/Form/ChangeBackdropForm/component/ImageSettings/index";
import {ChangeBackdropForm} from "./component/Form/ChangeBackdropForm/index";
import {PaletteBrowser} from "./component/Form/ChangeBackdropForm/component/PaletteBrowser/index";
import {PresetBrowser} from "./component/Form/ChangeBackdropForm/component/PresetBrowser/index";
import {BackdropComponent} from "./component/Elements/Backdrop/index";

export const CASSBackdropModule = {
    declarations: [
        BackdropComponent,
        ChangeBackdropForm,
        ImageSettings,
        PaletteBrowser,
        PresetBrowser,
        BackdropPreview,
    ],
    providers: []
};