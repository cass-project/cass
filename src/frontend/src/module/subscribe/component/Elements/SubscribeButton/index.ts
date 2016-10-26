import {Component,Input,Output,EventEmitter} from "@angular/core"

@Component({
    selector : "cass-subscribe-button",
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SubscribeButton
{
    @Input("subscribed") subscribed: boolean = false;
    @Input("is-loading") isLoading: boolean = false;
    @Output('subscribe') private subscribeEvent: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('unsubscribe') private unsubscribeEvent: EventEmitter<boolean> = new EventEmitter<boolean>();

    constructor() {}

    isSubscribed(): boolean
    {
        return this.subscribed;
    }

    subscribe() {
        this.subscribeEvent.emit(true);
    }

    unsubscribe() {
        this.unsubscribeEvent.emit(true);
    }
}

