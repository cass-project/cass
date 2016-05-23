import {Component, EventEmitter, Output} from "angular2/core";

import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ModalComponent} from "../../../../modal/component/index";
import {CommunityJoinModalModel} from "./model";
import {ScreenProcessing} from "./Screen/ScreenProcessing/index";
import {ScreenSID} from "./Screen/ScreenSID/index";

enum CommunityJoinScreen
{
    SID = <any>"SID",
    Processing = <any>"Processing",
    Complete = <any>"Complete" // TODO: Редирект на коммунити
}

@Component({
    selector: 'cass-community-join-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ScreenProcessing,
        ScreenSID,
    ],
    providers: [
        CommunityJoinModalModel
    ]
})
export class CommunityJoinModal
{
    @Output("close") closeEvent = new EventEmitter<CommunityJoinModal>();

    public screens: ScreenControls = new ScreenControls();

    constructor(private service: CommunityRESTService, public model: CommunityJoinModalModel) {}

    isHeaderVisible() {
        return !~([CommunityJoinScreen.Processing, CommunityJoinScreen.Complete]).indexOf(this.screens.current);
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
    static DEFAULT_SCREEN = CommunityJoinScreen.SID;
    static LIST_SCREENS = [
        CommunityJoinScreen.SID,
        CommunityJoinScreen.Processing,
        CommunityJoinScreen.Complete
    ];

    public current: CommunityJoinScreen = ScreenControls.DEFAULT_SCREEN;
    private map = {};

    constructor() {
        this.map[CommunityJoinScreen.SID] = CommunityJoinScreen.Processing;
    }

    next() {
        if(!this.map[this.current]) {
            throw new Error('Nowhere to go.');
        }else{
            this.current = this.map[this.current];
        }
    }

    isOn(screen: CommunityJoinScreen) {
        return this.current == screen;
    }
}