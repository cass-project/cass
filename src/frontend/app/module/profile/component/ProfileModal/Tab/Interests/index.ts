import {Component} from "angular2/core";

import {ThemeSelect} from "../../../../../theme/component/ThemeSelect/index";

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