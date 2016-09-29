import {Component, Input} from "@angular/core";
import {Router} from "@angular/router";

import {Theme} from "../../../../theme/definitions/entity/Theme";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {CommunityEntity} from "../../../definitions/entity/Community";

@Component({
    selector: 'cass-profile-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCard
{
    @Input('profile') entity: CommunityEntity;
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
        this.router.navigate(['/profile', this.entity.id]);
    }
}