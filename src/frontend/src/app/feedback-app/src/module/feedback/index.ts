import {Component} from "@angular/core";
import {ROUTER_DIRECTIVES, Router} from "@angular/router";
import {RouteParams} from '@angular/router-deprecated'

import {Title} from '@angular/platform-browser'

import {AccountService} from "../../../../../module/account/service/AccountService";
import {AuthService} from "../../../../../module/auth/service/AuthService";
import {FeedbackService} from "../../../../../module/feedback/service/FeedbackService";
import {FeedbackRESTService} from "../../../../../module/feedback/service/FeedbackRESTService";
import {FeedbackEntity} from "../../../../../module/feedback/definitions/entity/Feedback";

import {SidebarComponent} from "../sidebar/component/SidebarComponent/index";
import {SidebarTogglerComponent} from "../sidebar/component/SidebrTogglerComponent/index";
import {FeedbackCardComponent} from "./component/Elements/FeedbackCardComponent/index";
import {FeedbackQueryModel} from "./FeedbackQueryParamsModel";
import {PaginationComponent} from "../pagination/index";
import {InfiniteScrollDirective} from "../infine-scroll/directive/index";


@Component({
    selector: 'cass-feedback-landing',
    template: require('./template.jade'),
    directives:[
        ROUTER_DIRECTIVES,
        SidebarComponent,
        FeedbackCardComponent,
        SidebarTogglerComponent,
        PaginationComponent,
        InfiniteScrollDirective
    ],
    providers:[
        FeedbackService,
        FeedbackRESTService,
        FeedbackQueryModel
    ]
})

export class FeedbackComponent {
    private feedbacks:FeedbackEntity[] = [];
    private isInfineScrollActive:boolean = true;
    private isLoading:boolean = false;
    private totalPages:number;
    private params: {[key: string]: string;}
    private layout:string = 'list';
    constructor(
        private service: FeedbackService,
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
                        this.params = routeParams.params;
                        this.params['page'] = this.params['page']||"1";
                        this.initFeedbacks();
                    } else {
                        this.goToAccessDenied()
                    }
                },
                () => {
                    this.goToAccessDenied()
                }
            )
        } else {
            this.goToAccessDenied();
        }
    }

    
    initFeedbacks() {
        this.getFeedbacks((data)=>{
            this.feedbacks = data.entities;
            this.totalPages = Math.ceil(this.feedbacks.length / this.model.limit);
        })
    }
    
    appendFeedbacks() {
        this.isInfineScrollActive = false;
        if(parseInt(this.params['page']) < this.totalPages) {
            this.params['page'] = (parseInt(this.params['page'])+1).toString();
            this.getFeedbacks((data)=> {
                this.isInfineScrollActive = true;
                this.feedbacks.push(data.entities[0]);
                for(let feedback of data.entities){
                    this.feedbacks.push(feedback);
                }
            })
        }
    }


    getFeedbacks(callback:Function) {
        this.titleService.setTitle("Getting feedbacks...");
        this.isLoading = true;

        for(let property in this.params) {
            if(this.params.hasOwnProperty(property)) {
                if(this.model.hasOwnProperty(property)) {
                    this.model[property] = this.params[property];
                }
            }
        }
        
        this.model.offset = this.model.limit * (parseInt(this.params['page']) - 1);

        this.service.list(this.model).subscribe(data => {
            this.titleService.setTitle("Feedback Dashboard");
            callback(data);
            this.isLoading = false;
        });

    }
    
    goToAccessDenied() {
        this.router.navigate(["/FeedbackRoute","AccessDenied"]);
    }

    toGridLayout(){
        this.layout = 'grid';
    }
    
    toListLayout(){
        this.layout = 'list';
    }
    
    filter() {
        this.initFeedbacks();
    }
}