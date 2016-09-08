import {Component, ModuleWithProviders, OnInit, OnDestroy} from "@angular/core";
import {Subscription} from 'rxjs/Subscription';
import {Router, Routes, RouterModule, ActivatedRoute} from '@angular/router';
import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {CommunityCollectionsRoute} from "../CommunityCollectionsRoute/index";
import {CommunityRouteService} from "./service";
import {CommunityDashboardRoute} from "../CommunityDashboardRoute/index";
import {CommunityHeader} from "../../component/Elements/CommunityHeader/index";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProgressLock,
        CommunityHeader,
    ],
    providers: [
        CommunityRouteService,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
const commutinyRoutes: Routes = [
    {
        path: '/',
        name: 'Dashboard',
        component: CommunityDashboardRoute,
        useAsDefault: true
    },
    {
        path: '/collections/...',
        name: 'Collections',
        component: CommunityCollectionsRoute
    },
];

export const publicRouting: ModuleWithProviders = RouterModule.forChild(commutinyRoutes);


export class CommunityRoute implements OnInit, OnDestroy
{
    private sub: Subscription;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private service: CommunityRouteService) {}

    ngOnInit(){
        this.sub = this.route.params.subscribe(params => {
            let sid = params['sid'];
            if (sid){
                this.service.loadCommunityBySID(sid);
            } else {
                this.router.navigate(['/Community/NotFound']);
                return;
            }

            if (this.service.getObservable() !== undefined) {
                this.service.getObservable().subscribe(
                    (response) => {
                    },
                    (error) => {
                        this.router.navigate(['/Community/NotFound']);
                    }
                )
            } else {
                this.router.navigate(['/Community/NotFound']);
            }
        })
    }

    ngOnDestroy(){
        this.sub.unsubscribe();
    }
}