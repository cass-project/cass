import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {RouteConfig, ROUTER_DIRECTIVES, RouterOutlet, RouteDefinition} from "angular2/router";
import {Module} from "../../module/common/classes/Module";
import {AppService} from "./service";

let routeDefinitions: RouteDefinition[] = [];
let appDefinition = {
    selector: 'cass-frontend-app',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [AppService],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        RouterOutlet
    ]
};

[
    require("./../../module/account/module.ts"),
    require("./../../module/auth/module.ts"),
    require("./../../module/avatar/module.ts"),
    require("./../../module/collection/module.ts"),
    require("./../../module/colors/module.ts"),
    require("./../../module/common/module.ts"),
    require("./../../module/community/module.ts"),
    require("./../../module/community-features/module.ts"),
    require("./../../module/contact/module.ts"),
    require("./../../module/email-verification/module.ts"),
    require("./../../module/feed/module.ts"),
    require("./../../module/feedback/module.ts"),
    require("./../../module/form/module.ts"),
    require("./../../module/frontline/module.ts"),
    require("./../../module/im/module.ts"),
    require("./../../module/message/module.ts"),
    require("./../../module/modal/module.ts"),
    require("./../../module/opengraph/module.ts"),
    require("./../../module/post/module.ts"),
    require("./../../module/post-attachment/module.ts"),
    require("./../../module/profile/module.ts"),
    require("./../../module/profile-communities/module.ts"),
    require("./../../module/profile-im/module.ts"),
    require("./../../module/public/module.ts"),
    require("./../../module/session/module.ts"),
    require("./../../module/sidebar/module.ts"),
    require("./../../module/theme/module.ts"),
].forEach((module: Module) => {
    module.decorate(appDefinition, routeDefinitions);
});

@Component(appDefinition)
@RouteConfig(routeDefinitions)
export class App
{
    static version(): string {
        return require('./../../../package.json').version;
    }

    constructor(private appService: AppService){}

    detectElem() {
        let html = document.documentElement;
        let elem = document.getElementById('FeedUpdateButton');

        if(elem && !this.appService.feedIsLoading){
            let rect = elem.getBoundingClientRect();

            if(!!rect
                && rect.bottom >= 0
                && rect.right >= 0
                && rect.top <= html.clientHeight
                && rect.left <= html.clientWidth ){
                console.log('detect')
            }
        } else if(!this.appService.feedIsLoading){
            throw new Error("Cant find Elem");
        }
    }
}

console.log(`CASS Frontend App: ver${App.version()}`);