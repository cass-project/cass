import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CollectionEntity} from "../../../../../definitions/entity/collection";
import {CollectionCardHelper} from "../../helper";

@Component({
    selector: 'cass-collection-card-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CollectionCardList
{
    @Input('entity') entity: CollectionEntity;
    @Output('open') openEvent: EventEmitter<CollectionEntity> = new EventEmitter<CollectionEntity>();

    constructor(
        private helper: CollectionCardHelper
    ) {}

    open() {
        this.openEvent.emit(this.entity);
    }
}