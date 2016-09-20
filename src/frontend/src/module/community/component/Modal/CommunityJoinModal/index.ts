import {Component, EventEmitter, Output} from "@angular/core";

import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {CommunityJoinModalModel} from "./model";
import {ScreenControls} from "../../../../common/classes/ScreenControls";

enum CommunityJoinScreen
{
    SID = <any>"SID",
    Processing = <any>"Processing",
    Complete = <any>"Complete",
}

@Component({
    selector: 'cass-community-join-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityJoinModalModel
    ]
})
export class CommunityJoinModal
{
    constructor(
        private service: CommunityRESTService,
        public model: CommunityJoinModalModel
    ) {}

    @Output("close") closeEvent = new EventEmitter<CommunityJoinModal>();

    public screens = new ScreenControls<CommunityJoinScreen>(CommunityJoinScreen.SID, (sc: ScreenControls<CommunityJoinScreen>) => {
        sc.add({ from: CommunityJoinScreen.SID, to: CommunityJoinScreen.Processing })
          .add({ from: CommunityJoinScreen.Processing, to: CommunityJoinScreen.Complete });
    });

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