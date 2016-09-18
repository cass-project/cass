import {Component, OnInit, OnDestroy} from "@angular/core";
import {Subscription} from "rxjs/Subscription";
import {Router, RouterModule, ActivatedRoute} from "@angular/router";

import {CommunityCollectionsRoute} from "../CommunityCollectionsRoute/index";
import {CommunityDashboardRoute} from "../CommunityDashboardRoute/index";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {CurrentCommunityService} from "./service";

RouterModule.forChild([
    {
        path: '/',
        component: CommunityDashboardRoute,
    },
    {
        path: '/collections/...',
        component: CommunityCollectionsRoute
    },
]);

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CurrentCommunityService,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class CommunityRoute implements OnInit, OnDestroy
{
    private sub: Subscription;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private service: CurrentCommunityService
    ) {}

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            let sid = params['sid'];
            if (sid){
                this.service.loadCommunityBySID(sid);
            }else{
                this.router.navigate(['/Community/NotFound']);
                return;
            }

            if (this.service.getObservable() !== undefined) {
                this.service.getObservable().subscribe(
                    (response) => {},
                    (error) => {
                        this.router.navigate(['/Community/NotFound']);
                    }
                )
            }else{
                this.router.navigate(['/Community/NotFound']);
            }
        })
    }

    ngOnDestroy() {
        this.sub.unsubscribe();
    }
}