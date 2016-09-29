import {Component} from "@angular/core";

import {ContentPlayerService} from "../../module/player/service/ContentPlayerService";
import {UIService} from "../../module/ui/service/ui";

@Component({
    selector: 'cass-frontend-app',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: []
})
export class App
{
    constructor(
        private ui: UIService,
        private player: ContentPlayerService
    ) {}

    isPlayerEnabled(): boolean {
        return this.player.isEnabled();
    }

    static version(): string {
        return require('./../../../package.json').version;
    }
}

console.log(`CASS Frontend App: ver${App.version()}`);