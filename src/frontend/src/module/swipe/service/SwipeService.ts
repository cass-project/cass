import {Injectable} from "@angular/core";

import {Session} from "../../session/Session";

@Injectable()
export class SwipeService
{
    static LOCAL_STORAGE_KEY = 'cass.module.swipe.screen.current';

    private screen: SwipeScreen = SwipeScreen.Theme;

    constructor(
        private session: Session
    ) {
        let goingTo = window.localStorage[SwipeService.LOCAL_STORAGE_KEY];

        if(goingTo !== undefined) {
            if(goingTo === SwipeScreen.Personal && ! this.session.isSignedIn()) {
                this.screen = SwipeScreen.Theme; // Do not save choice!
            }else{
                this.screen = goingTo;
            }
        }else{
            this.switchToTheme();
        }
    }

    isPersonalScreenAvailable(): boolean {
        return this.session.isSignedIn();
    }

    isAtPersonalScreen(): boolean { return this.screen === SwipeScreen.Personal; }
    isAtThemeScreen(): boolean { return this.screen === SwipeScreen.Theme; }
    isAtContentScreen(): boolean { return this.screen === SwipeScreen.Content; }

    switchToPersonal() {
        if(! this.isPersonalScreenAvailable()) {
            this.screen = SwipeScreen.Theme;
            window.localStorage[SwipeService.LOCAL_STORAGE_KEY] = this.screen;
        }else{
            this.switchToTheme();
        }
    }

    switchToTheme() {
        this.screen = SwipeScreen.Theme;
        window.localStorage[SwipeService.LOCAL_STORAGE_KEY] = this.screen;
    }

    switchToContent() {
        this.screen = SwipeScreen.Content;
        window.localStorage[SwipeService.LOCAL_STORAGE_KEY] = this.screen;
    }
}

export enum SwipeScreen
{
    Personal = <any>"personal",
    Theme = <any>"theme",
    Content = <any>"content"
}