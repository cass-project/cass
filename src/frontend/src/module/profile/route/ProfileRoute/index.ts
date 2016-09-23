import {Component, OnInit, OnDestroy} from "@angular/core";
import {Router, ActivatedRoute} from "@angular/router";

import {ProfileRouteService} from "./service";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {Session} from "../../../session/Session";
import {ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {GetProfileByIdResponse200} from "../../definitions/paths/get-by-id";

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

export class ProfileRoute implements OnInit, OnDestroy
{
    private profile: ProfileExtendedEntity;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private session: Session,
    ) {}
    
    ngOnInit() {
        this.route.data.forEach((data: { profile: GetProfileByIdResponse200 }) => {

        });
    }

    ngOnDestroy() {
    }

    isOwnProfile() {
        return !!this.profile && this.profile.is_own;
    }

    isOtherProfile() {
        return ! (!!this.profile && this.profile.is_own);
    }
}