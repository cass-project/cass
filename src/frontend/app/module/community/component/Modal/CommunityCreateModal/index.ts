import {Component, EventEmitter, Output} from "angular2/core";

import {EventEmitter} from "angular2/core";
import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ModalComponent} from "../../../../modal/component/index";
import {ScreenGeneral} from "./Screen/ScreenGeneral/index";
import {ScreenTheme} from "./Screen/ScreenTheme/index";
import {ScreenImage} from "./Screen/ScreenImage/index";
import {ScreenFeatures} from "./Screen/ScreenFeatures/index";
import {ScreenProcessing} from "./Screen/ScreenProcessing/index";
import {CommunityCreateModalModel} from "./model";

enum CreateStage {
    General = <any>"General",
    Theme = <any>"Theme",
    Image = <any>"Image",
    Features = <any>"Features",
    Processing = <any>"Processing",
    Complete = <any>"Complete"  // TODO: Редирект на коммунити
}

@Component({
    selector: 'cass-community-create-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityCreateModalModel
    ],
    directives: [
        ModalComponent,
        ScreenGeneral,
        ScreenTheme,
        ScreenImage,
        ScreenFeatures,
        ScreenProcessing,
    ]
})
export class CommunityCreateModal
{
    public screens: ScreenControls = new ScreenControls();

    @Output('close') closeEvent = new EventEmitter<CommunityCreateModal>();

    constructor(private service: CommunityRESTService, model: CommunityCreateModalModel) {}

    isHeaderVisible() {
        return !~([CreateStage.Processing, CreateStage.Complete]).indexOf(this.screens.current);
    }

    next() {
        this.screens.next();
    }

    abort() {
        this.close();
    }

    close() {
        this.closeEvent.emit(this);
    }
}

class ScreenControls
{
    static DEFAULT_SCREEN = CreateStage.General;
    static LIST_SCREENS = [
        CreateStage.General,
        CreateStage.Theme,
        CreateStage.Image,
        CreateStage.Features,
        CreateStage.Processing,
        CreateStage.Complete
    ];

    public current: CreateStage = ScreenControls.DEFAULT_SCREEN;
    private map = {};

    constructor() {
        this.map[CreateStage.General] = CreateStage.Theme;
        this.map[CreateStage.Theme] = CreateStage.Processing;
        // this.map[CreateStage.Image] = CreateStage.Features;
        // this.map[CreateStage.Features] = CreateStage.Processing;
        this.map[CreateStage.Processing] = CreateStage.Complete;
    }

    next() {
        if(!this.map[this.current]) {
            throw new Error('Nowhere to go.');
        }else{
            this.current = this.map[this.current];
        }
    }

    isOn(screen: CreateStage) {
        return this.current == screen;
    }
}