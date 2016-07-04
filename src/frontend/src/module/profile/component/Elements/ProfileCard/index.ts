import {Component, Input, Output, EventEmitter} from "angular2/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {ProfileImage} from "../ProfileImage/index";

@Component({
    selector: 'cass-profile-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
    ]
})
export class ProfileCard
{
    @Input('profile') entity: ProfileEntity;
    @Output('click') clickEvent = new EventEmitter<number>();

    private expertIn: Theme[] = [];
    private interestingIn: Theme[] = [];

    constructor(private themes: ThemeService) {}

    ngOnInit() {
        this.expertIn = this.entity.expert_in_ids.map((id: number) => {
            return this.themes.findById(id);
        });

        this.interestingIn = this.entity.interesting_in_ids.map((id: number) => {
            return this.themes.findById(id);
        });
    }
    
    click() {
        this.clickEvent.emit(this.entity.id);
    }

    getGreetings(): string {
        return this.entity.greetings.greetings;
    }

    getProfileURL(): string {
        return queryImage(QueryTarget.Card, this.entity.image).public_path;
    }

    hasAnyExperts() {
        return this.expertIn.length > 0;
    }

    hasAnyInterests() {
        return this.interestingIn.length > 0;
    }
}