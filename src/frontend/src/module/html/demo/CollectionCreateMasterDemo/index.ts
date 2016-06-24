import {Component} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {ScreenControls} from "../../../util/classes/ScreenControls";
import {ColorPicker} from "../../../form/component/ColorPicker/index";

enum CreateCollectionMasterStage
{
    Common = <any>"Common",
    Options = <any>"Options",
}

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ColorPicker,
        ThemeSelect,
    ]
})
export class CollectionCreateMasterDemo
{
    private screens: ScreenControls<CreateCollectionMasterStage> = new ScreenControls<CreateCollectionMasterStage>(CreateCollectionMasterStage.Common, (sc) => {
        sc.add({ from: CreateCollectionMasterStage.Common, to: CreateCollectionMasterStage.Options });
    });

    private buttons = new Buttons(this.screens);
}

class Buttons {
    constructor(private screens: ScreenControls<CreateCollectionMasterStage>) {}

    isBackButtonAvailable() {
        return this.screens.isIn([
            CreateCollectionMasterStage.Options
        ]);
    }

    isFinish() {
        return this.screens.isIn([
            CreateCollectionMasterStage.Options
        ]);
    }
}