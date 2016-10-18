import {Component, Input} from "@angular/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Router} from "@angular/router";

var moment = require('moment');

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-card-header'})

export class ProfileCardHeader
{
    @Input('profile') profile: ProfileEntity;
    @Input('time') time: Date;
    
    constructor(private router: Router) {}

    getTime(): string {
        if(this.time.getMinutes() < 10){
            return (`${this.time.toLocaleDateString()} at ${this.time.getHours()}:0${this.time.getMinutes()}`);
        } else {
            return (`${this.time.toLocaleDateString()} at ${this.time.getHours()}:${this.time.getMinutes()}`);
        }
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
        this.router.navigate(['profile', this.profile.id]);
    }
}