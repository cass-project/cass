import {Component, Input, Output, EventEmitter} from "@angular/core";
import {Collection} from "../../../definitions/entity/collection";

@Component({
    selector: 'cass-collections-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class CollectionsList
{
    @Input('is-own') isOwn: boolean = false;
    @Input('collections') collections: Collection[];
    @Output('create') createEvent = new EventEmitter<Event>();

    create($event) {
        this.createEvent.emit($event);
    }
}