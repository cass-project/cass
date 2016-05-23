import {Component} from "angular2/core";
import {ThemeSelect} from "../../../../../theme/component/ThemeSelect/index";
import {ThemeService} from "../../../../../theme/service/ThemeService";
import {ProfileService} from "../../../ProfileService/ProfileService";
import {ProfileModalModel} from "../../model";


enum InterestsTabScreen
{
    InterestingIn = <any>"InterestingIn",
    ExpertIn = <any>"ExpertIn"
}

@Component({
    selector: 'cass-profile-modal-tab-interests',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect
    ]
})
export class InterestsTab
{
    constructor(private themeService: ThemeService, private profileService: ProfileService, private model: ProfileModalModel){}

    screen: Screens = new Screens();


}

class Screens
{

    static DEFAULT_SCREEN = InterestsTabScreen.InterestingIn;

    public current: InterestsTabScreen = Screens.DEFAULT_SCREEN;

    go(screen: InterestsTabScreen) {
        this.current = screen;
    }

    isOn(screen: InterestsTabScreen) {
        return this.current === screen;
    }
}