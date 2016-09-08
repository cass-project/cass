import {Component, Input} from "@angular/core";
import {Router} from '@angular/router';

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {ProfileImage} from "../ProfileImage/index";
import {PostCard} from "../../../../post/component/Forms/PostCard/index";

@Component({
    selector: 'cass-profile-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        PostCard,
    ]
})
export class ProfileCard
{
    @Input('profile') entity: ProfileEntity;
    @Input('is-own') isOwn: boolean;

    private expertIn: Theme[] = [];
    private interestingIn: Theme[] = [];

    constructor(private router:Router, private themes: ThemeService) {}

    ngOnInit() {
        this.expertIn = this.entity.expert_in_ids.map((id: number) => {
            return this.themes.findById(id);
        });

        this.interestingIn = this.entity.interesting_in_ids.map((id: number) => {
            return this.themes.findById(id);
        });
    }
    
    goChat() {
        this.router.navigate(['/ProfileIM', 'Messages', { id: this.entity.id.toString() }]);
    }

    getGreetings(): string {
        return this.entity.greetings.greetings;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.entity.image).public_path;
    }

    hasAnyExperts() {
        return this.expertIn.length > 0;
    }

    hasAnyInterests() {
        return this.interestingIn.length > 0;
    }

    goProfile() {
        this.router.navigate(['/Profile', 'Profile', { 'id': this.entity.id }]);
    }
}