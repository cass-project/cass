import {Component, Input} from "angular2/core";
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

    getImageURL(): string {
        let image = queryImage(QueryTarget.Card, this.entity.image).public_path;

        return `url('${image}')`;
    }
}