import {Component, Input} from '@angular/core';
import {SwipeService} from "../../../../swipe/service/SwipeService";
import {UIService} from "../../../../ui/service/ui";

@Component({
    selector: 'cass-public-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class PublicMenu
{
    @Input('is-extended') isExtended: boolean = false;

    constructor(
        private swipe: SwipeService,
        private ui: UIService
    ) {

    }

}