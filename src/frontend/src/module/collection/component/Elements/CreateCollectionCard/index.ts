import {Component, EventEmitter, Output} from "@angular/core";

@Component({
    selector: 'cass-create-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CreateCollectionCard
{
    @Output('click') clickEvent = new EventEmitter<Event>();

    private click($event) {
        this.clickEvent.emit($event);
    }
}