import {Component, Input, EventEmitter, Output} from "angular2/core";
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
    @Output('click') clickEvent: EventEmitter<CollectionEntity> = new EventEmitter<CollectionEntity>();

    constructor(private theme: ThemeService) {}

    getImageURL(): string {
        let image = queryImage(QueryTarget.Card, this.entity.image).public_path;

        return `url('${image}')`;
    }

    click() {
        this.clickEvent.emit(this.entity);
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