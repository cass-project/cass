import {Component, Input} from "@angular/core";
import {CollectionEntity} from "../../../definitions/entity/collection";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";

@Component({
    selector: 'cass-collection-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionHeader
{
    @Input('entity') private entity: CollectionEntity;
    @Input('is-own') private isOwn: boolean;

    isPublished(): boolean {
        return this.entity.public_options.public_enabled;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.entity.image).public_path;
    }

    getBackdrop(): string {
        return this.entity.backdrop;
    }

    openSettings() {
    }

    openPublicSettings() {
    }
}