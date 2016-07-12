import {Component, Input, EventEmitter, Output} from "angular2/core";

import {ProfileImage} from "../ProfileImage/index";
import {ProfileEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Router} from "angular2/router";

var moment = require('moment');

@Component({
    selector: 'cass-profile-card-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
    ]
})
export class ProfileCardHeader
{
    @Input('profile') profile: ProfileEntity;
    @Input('time') time: Date;
    
    constructor(private router: Router) {}

    getTime(): string {
        return moment().format('MMMM Do YYYY, h:mm:ss a');
    }

    hasTime(): boolean {
        return this.time instanceof Date;
    }

    getProfileName(): string {
        return this.profile.greetings.greetings;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Avatar, this.profile.image).public_path;
    }

    getProfileLink(): string {
        return this.router.generate(['/Profile', 'Profile', { 'id': this.profile.id }]).toLinkUrl();
    }

    goProfile() {
        this.router.navigate(['/Profile', 'Profile', { 'id': this.profile.id }]);
    }
}