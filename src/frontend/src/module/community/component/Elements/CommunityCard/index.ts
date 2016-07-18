import {Component, Input, Output, EventEmitter} from "angular2/core";

import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {CommunityImage} from "../CommunityImage/index";
import {PostCard} from "../../../../post/component/Forms/PostCard/index";
import {CommunityEntity} from "../../../definitions/entity/Community";
import {ThemeService} from "../../../../theme/service/ThemeService";

@Component({
    selector: 'cass-community-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityImage,
        PostCard,
    ]
})
export class CommunityCard
{
    @Input('community') entity: CommunityEntity;
    @Output('click') clickEvent = new EventEmitter<number>();

    constructor(private themeService: ThemeService) {}
    
    getTheme(){
       return this.themeService.findById(this.entity.theme.id);
    }
    
    click() {
        this.clickEvent.emit(this.entity.id);
    }

    getCommunityTitle(): string {
        return this.entity.title;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.entity.image).public_path;
    }

    hasTheme() {
        return this.entity.theme.has;
    }
}