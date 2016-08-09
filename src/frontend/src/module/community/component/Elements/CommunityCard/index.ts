import {Component, Input, Output, EventEmitter} from "@angular/core";

import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {CommunityImage} from "../CommunityImage/index";
import {PostCard} from "../../../../post/component/Forms/PostCard/index";
import {CommunityEntity} from "../../../definitions/entity/Community";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {Router} from "@angular/router";

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

    constructor(private themeService: ThemeService,
                private router: Router) {}
    
    getTheme(){
       return this.themeService.findById(this.entity.theme.id);
    }

    getCommunityTitle(): string {
        return this.entity.title;
    }

    getCommunityDescription(): string {
        return this.entity.description;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.entity.image).public_path;
    }

    hasTheme() {
        return this.entity.theme.has;
    }

    goCommunity() {
        this.router.navigate(['/Community', 'Community', { 'sid': this.entity.sid }]);
    }
}