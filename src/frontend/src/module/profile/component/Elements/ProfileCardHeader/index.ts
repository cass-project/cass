import {Component, Input, EventEmitter, Output} from "@angular/core";

import {ProfileImage} from "../ProfileImage/index";
import {ProfileEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Router} from '@angular/router-deprecated';

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
        return (`${this.time.toLocaleDateString()} at ${this.time.getHours()}:${this.time.getMinutes()}`);
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
    
    goProfile() {
        this.router.navigate(['/Profile', 'Profile', { 'id': this.profile.id }]);
    }
}