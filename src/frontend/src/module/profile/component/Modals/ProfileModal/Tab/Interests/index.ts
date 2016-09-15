import {Component} from "@angular/core";
import {ThemeService} from "../../../../../../theme/service/ThemeService";
import {ProfileModalModel} from "../../model";

enum InterestsTabScreen
{
    InterestingIn = <any>"InterestingIn",
    ExpertIn = <any>"ExpertIn"
}

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-modal-tab-interests'})


export class InterestsTab
{
    constructor(private themeService: ThemeService, private model: ProfileModalModel){}

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