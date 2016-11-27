import {Component, Input} from "@angular/core";

import {SubscriptionTypeStr} from "../../../definitions/types";

@Component({
    selector: 'cass-subscribe-nothing-subscribed-to',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class NothingSubscribedTo
{
    @Input('type') type: SubscriptionTypeStr;

    getText() {
        switch(this.type) {
            default:
                return 'No subscriptions available | subscribe';
            case SubscriptionTypeStr.Theme:
                return "You're not subscribed to any themes | subscribe";
            case SubscriptionTypeStr.Profile:
                return "You're not subscribed to any people | subscribe";
            case SubscriptionTypeStr.Collection:
                return "You're not subscribed to any collections | subscribe";
            case SubscriptionTypeStr.Community:
                return "You're not subscribed to any communities | subscribe";
        }
    }
}