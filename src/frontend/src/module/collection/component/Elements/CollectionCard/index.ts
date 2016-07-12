import {Component, Input, EventEmitter, Output} from "angular2/core";
import {CollectionEntity} from "../../../definitions/entity/collection";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";

@Component({
    selector: 'cass-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionCard
{
    @Input('entity') entity: CollectionEntity;
    @Output('click') clickEvent: EventEmitter<CollectionEntity> = new EventEmitter<CollectionEntity>();

    getImageURL(): string {
        let image = queryImage(QueryTarget.Card, this.entity.image).public_path;

        return `url('${image}')`;
    }

    click() {
        this.clickEvent.emit(this.entity);
    }
}