import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, RouteParams, Router} from "angular2/router";
import {Title} from "angular2/src/platform/browser/title";

import {AccountService}          from "../../../../../module/account/service/AccountService";
import {AuthService}             from "../../../../../module/auth/service/AuthService";
import {FeedbackService}         from "../../../../../module/feedback/service/FeedbackService";
import {FeedbackRESTService}     from "../../../../../module/feedback/service/FeedbackRESTService";
import {FeedbackEntity}          from "../../../../../module/feedback/definitions/entity/Feedback";

import {LandingSidebarComponent}        from "../sidebar/component/LandingSidebarComponent/index";
import {LandingSidebarTogglerComponent} from "../sidebar/component/LandingSidebrTogglerComponent/index";
import {FeedbackCardComponent}          from "./component/Elements/FeedbackCardComponent/index";
import {FeedbackQueryModel}             from "./FeedbackQueryParamsModel";


@Component({
    selector: 'cass-feedback-landing',
    template: require('./template.jade'),
    directives:[
        ROUTER_DIRECTIVES,
        LandingSidebarComponent,
        FeedbackCardComponent,
        LandingSidebarTogglerComponent
    ],
    providers:[
        FeedbackService,
        FeedbackRESTService,
        FeedbackQueryModel
    ]
})

export class FeedbackComponent {
    private feedbacks:FeedbackEntity[] = [];
    private isLoading:boolean = false;
    private curPage:number = 1;
    constructor(
        public service: FeedbackService,
        private routeParams: RouteParams,
        private router:Router,
        private authService: AuthService,
        private accountService: AccountService,
        private titleService: Title,
        private model: FeedbackQueryModel
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
        this.isLoading = true;

        for(let property in this.routeParams.params) {
            if(this.routeParams.params.hasOwnProperty(property)) {
                if(this.model.hasOwnProperty(property)) {
                    this.model[property] = this.routeParams.params[property];
                }
            }
        }
        
        if(this.routeParams.get("page")) {
            this.curPage = parseInt(this.routeParams.get("page"));
            this.model.offset = this.model.limit * (this.curPage - 1);
        }

        this.service.list(this.model).subscribe(data => {
                this.titleService.setTitle("Feedback Dashboard");
                this.feedbacks = data.entities;
                this.isLoading = false;
            });

    }
    
    getPages() : {index:number}[] {
        let length = Math.ceil(this.feedbacks.length / this.model.limit);
        let pages:{index:number}[] = [];
        for(let i=1; i<=length; i++) {
            pages.push({index:i});
        }
        return pages;
    }
    
    goToAccessDenied() {
        this.router.navigate(["/FeedbackRoute","AccessDenied"]);
    }
}