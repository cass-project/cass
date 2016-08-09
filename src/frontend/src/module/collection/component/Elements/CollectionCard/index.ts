import {Component, Input} from "@angular/core";
import {CollectionEntity} from "../../../definitions/entity/collection";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {Router} from '@angular/router-deprecated';

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

    constructor(private theme: ThemeService,
                private router: Router) {}

    getImageURL(): string {
        let image = queryImage(QueryTarget.Card, this.entity.image).public_path;

        return `url('${image}')`;
    }

    goCollection() {
        if(this.entity.owner.type === 'community'){
            this.router.navigate(['/Community', 'Community', {sid: this.entity.owner_sid}, 'Collections', 'View', { sid: this.entity.sid }]);
        } else if(this.entity.owner.type === 'profile'){
            this.router.navigate(['/Profile', 'Profile', {id: this.entity.owner.id}, 'Collections', 'View', { sid: this.entity.sid }]);
        }

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