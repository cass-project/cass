import {Component, EventEmitter, Output} from "@angular/core";
import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {CommunityJoinModalModel} from "./model";
import {ScreenControls} from "../../../../common/classes/ScreenControls";

enum CommunityJoinScreen
{
    SID = <any>"SID",
    Processing = <any>"Processing",
    Complete = <any>"Complete" // TODO: Редирект на коммунити
}

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityJoinModalModel
    ],selector: 'cass-community-join-modal'})
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