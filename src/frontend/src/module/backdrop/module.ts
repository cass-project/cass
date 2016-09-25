import {PresetBrowser} from "./component/Modals/ChangeBackdropModal/component/PresetBrowser/index";
import {ImageSettings} from "./component/Modals/ChangeBackdropModal/component/ImageSettings/index";
import {PaletteBrowser} from "./component/Modals/ChangeBackdropModal/component/PaletteBrowser/index";
import {ChangeBackdropModal} from "./component/Modals/ChangeBackdropModal/index";

export const CASSBackdropModule = {
    declarations: [
        ChangeBackdropModal,
        ImageSettings,
        PaletteBrowser,
        PresetBrowser,
    ],
    providers: []
};