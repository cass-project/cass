import {Component} from "angular2/core";
import {ScreenControls} from "../../../util/classes/ScreenControls";
import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";

let communitySettingsScreenMap = (sc: ScreenControls<CommunitySettingsScreen>) => {
    sc.add({ from:  CommunitySettingsScreen.Community, to: CommunitySettingsScreen.Image })
      .add({ from:  CommunitySettingsScreen.Image, to: CommunitySettingsScreen.Features })
      .add({ from:  CommunitySettingsScreen.Features, to: CommunitySettingsScreen.Collections })
      .add({ from:  CommunitySettingsScreen.Collections, to: CommunitySettingsScreen.Image })
};

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
    ]
})
export class CommunitySettingsModalDemo
{
    private screens: ScreenControls<CommunitySettingsScreen> = new ScreenControls<CommunitySettingsScreen>(CommunitySettingsScreen.Features, communitySettingsScreenMap);
}

enum CommunitySettingsScreen
{
    Community = <any>"Community",
    Image = <any>"Image",
    Features = <any>"Features",
    Collections = <any>"Collection"
}