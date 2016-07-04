import {Component} from "angular2/core";
import {RouteParams, Router} from "angular2/router";
import {Title} from "angular2/src/platform/browser/title";

import {AccountService}          from "../../../../../module/account/service/AccountService";
import {AuthService}             from "../../../../../module/auth/service/AuthService";
import {FeedbackService}         from "../../../../../module/feedback/service/FeedbackService";
import {FeedbackRESTService}     from "../../../../../module/feedback/service/FeedbackRESTService";
import {FeedbackEntity}          from "../../../../../module/feedback/definitions/entity/Feedback";
import {ListFeedbackQueryParams} from "../../../../../module/feedback/definitions/paths/list";

import {FeedbackCardComponent}          from "./component/Elements/FeedbackCardComponent/index";
import {LandingSidebarComponent}        from "../sidebar/component/LandingSidebarComponent/index";
import {LandingSidebarTogglerComponent} from "../sidebar/component/LandingSidebrTogglerComponent/index";


@Component({
    selector: 'cass-feedback-landing',
    template: require('./template.jade'),
    directives:[
        LandingSidebarComponent,
        FeedbackCardComponent,
        LandingSidebarTogglerComponent
    ],
    providers:[
        FeedbackService,
        FeedbackRESTService
    ]
})

export class FeedbackComponent {
    private feedbacks:FeedbackEntity[] = [];
    private isLoading:boolean = false;
    constructor(
        public service: FeedbackService,
        private routeParams: RouteParams,
        private router:Router,
        private authService: AuthService,
        private accountService: AccountService,
        private titleService: Title
    ) {
        if(authService.isSignedIn()) {
            accountService.appAccess().subscribe(
                data => {
                    if (data.access.apps.feedback) {
                        this.getFeedbacks();
                    } else {
                        this.goToAccessDenied()
                    }
                },
                () => {
                    this.goToAccessDenied()
                }
            )
        }else{
            this.goToAccessDenied();
        }
        
        
    }
    
    getFeedbacks() {
        this.titleService.setTitle("Getting feedbacks...");
        let t = setTimeout(() => { this.isLoading = true; }, 500);
        let qp:ListFeedbackQueryParams;

        if(Object.keys(this.routeParams.params).length){
            qp = this.routeParams.params;
        }
        this.service.list(0, 10, qp||{}).subscribe(data => {
            this.titleService.setTitle("Feedback Dashboard");
            this.feedbacks = data.entities;
            clearTimeout(t);
            this.isLoading = false;
        });
    }
    
    goToAccessDenied() {
        this.router.navigate(["/FeedbackRoute","AccessDenied"]);
    }
}