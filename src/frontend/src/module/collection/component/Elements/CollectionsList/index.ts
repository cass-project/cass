import {Component, Input, Output, EventEmitter, Directive} from "@angular/core";

import {Collection} from "../../../definitions/entity/collection";
import {CollectionCard} from "../CollectionCard/index";
import {CreateCollectionCard} from "../CreateCollectionCard/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-collections-list'})
export class CollectionsList
{
    @Input('is-own') isOwn: boolean = false;
    @Input('collections') collections: Collection[];
    @Output('create') createEvent = new EventEmitter<Event>();

    create($event) {
        this.createEvent.emit($event);
    }
}