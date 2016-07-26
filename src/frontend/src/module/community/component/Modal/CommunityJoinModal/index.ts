import {Component, EventEmitter, Output} from "angular2/core";

import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ModalComponent} from "../../../../modal/component/index";
import {CommunityJoinModalModel} from "./model";
import {ScreenProcessing} from "./Screen/ScreenProcessing/index";
import {ScreenSID} from "./Screen/ScreenSID/index";
import {ScreenControls} from "../../../../common/classes/ScreenControls";
import {ModalBoxComponent} from "../../../../modal/component/box/index";

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
        ModalBoxComponent,
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

    public screens: ScreenControls<CommunityJoinScreen> = new ScreenControls<CommunityJoinScreen>(CommunityJoinScreen.SID, (sc: ScreenControls<CommunityJoinScreen>) => {
        sc.add({ from: CommunityJoinScreen.SID, to: CommunityJoinScreen.Processing })
          .add({ from: CommunityJoinScreen.Processing, to: CommunityJoinScreen.Complete });
    });

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