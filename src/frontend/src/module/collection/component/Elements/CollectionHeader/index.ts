import {Component, Input, OnInit} from "@angular/core";
import {CollectionEntity} from "../../../definitions/entity/collection";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {getBackdropTextColor} from "../../../../backdrop/functions/getBackdropTextColor";

@Component({
    selector: 'cass-collection-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionHeader implements OnInit
{
    @Input('entity') private entity: CollectionEntity;
    @Input('is-own') private isOwn: boolean;

    private textColor: string;

    ngOnInit(): void {
        this.textColor = getBackdropTextColor(this.entity.backdrop);
    }

    isPublished(): boolean {
        return this.entity.public_options.public_enabled;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.entity.image).public_path;
    }

    openSettings() {
    }

    openPublicSettings() {
    }
}