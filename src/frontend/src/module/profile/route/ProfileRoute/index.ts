import {Component, OnInit} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {GetProfileByIdResponse200} from "../../definitions/paths/get-by-id";
import {ProfileRouteService} from "./service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileRouteService,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})

export class ProfileRoute implements OnInit
{
    private profile: ProfileExtendedEntity;

    constructor(
        private route: ActivatedRoute,
        private service: ProfileRouteService
    ) {}
    
    ngOnInit() {
        this.service.exportResponse(
            this.route.snapshot.data['profile']
        );

        this.profile = this.service.getEntity();
    }

    isOwnProfile() {
        return !!this.profile && this.profile.is_own;
    }

    isOtherProfile() {
        return ! (!!this.profile && this.profile.is_own);
    }
}