import {Component, Input} from "@angular/core";

import {CollectionEntity} from "../../../definitions/entity/collection";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {ThemeService} from "../../../../theme/service/ThemeService";

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
    @Input('params') params;

    constructor(
        private theme: ThemeService
    ) {}

    getImageURL(): string {
        let image = queryImage(QueryTarget.Card, this.entity.image).public_path;

        return `url('${image}')`;
    }

    hasTheme(): boolean {
        return this.entity.theme_ids.length > 0;
    }

    getThemeTitle(): string {
        if(this.hasTheme()) {
            return this.theme.findById(this.entity.theme_ids[0]).title;
        }else{
            return 'N/A';
        }
    }
}