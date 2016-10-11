import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CollectionEntity} from "../../../../../definitions/entity/collection";
import {CollectionCardHelper} from "../../helper";

@Component({
    selector: 'cass-collection-card-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CollectionCardGrid
{
    @Input('entity') entity: CollectionEntity;
    @Output('open') openEvent: EventEmitter<CollectionEntity> = new EventEmitter<CollectionEntity>();

    constructor(
        private helper: CollectionCardHelper
    ) {}

    open($event) {
        $event.preventDefault();

        this.openEvent.emit(this.entity);
    }
}