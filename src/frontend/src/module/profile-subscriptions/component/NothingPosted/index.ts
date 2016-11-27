import {Component, Input} from "@angular/core";

import {SubscriptionTypeStr} from "../../../subscribe/definitions/types";

@Component({
    selector: 'cass-profile-subscriptions-nothing-posted',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class NothingPosted
{
    @Input('type') type: SubscriptionTypeStr;

    getText() {
        switch(this.type) {
            default:
                return 'No subscriptions available | profile-subscribe';
            case SubscriptionTypeStr.Theme:
                return "Nothing here. Subscribe to themes to view something here! | profile-subscribe";
            case SubscriptionTypeStr.Profile:
                return "Nothing here. Subscribe to people to view something here! | profile-subscribe";
            case SubscriptionTypeStr.Collection:
                return "Nothing here. Subscribe to collections to view something here! | profile-subscribe";
            case SubscriptionTypeStr.Community:
                return "Nothing here. Subscribe to communities to view something here! | profile-subscribe";
        }
    }
}