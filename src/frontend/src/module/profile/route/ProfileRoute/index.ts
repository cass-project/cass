import {Component, OnInit, OnDestroy} from "@angular/core";
import {Router, ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs/Subscription";
import {ProfileRouteService} from "./service";
import {AuthService} from "../../../auth/service/AuthService";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {Session} from "../../../session/Session";

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
    private sub: Subscription;
    
    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private service: ProfileRouteService,
        private session: Session,
        private authService: AuthService
    ) {}
    
    ngOnInit(){
        this.sub = this.route.params.subscribe(params => {
            let id = params['id'];
            if (this.authService.isSignedIn() && (id === 'current' || id === this.session.getCurrentProfile().getId().toString())) {
                this.service.loadCurrentProfile();
            } else if (Number(id)) {
                this.service.loadProfileById(Number(id));
            } else {
                this.router.navigate(['/profile/not-found']);
                return;
            }

            if (this.service.getObservable() !== undefined) {
                this.service.getObservable().subscribe(
                    (response) => {
                    },
                    (error) => {
                        this.router.navigate(['/profile/not-found']);
                    }
                )
            } else {
                this.router.navigate(['/public']);
            }
        })
    }

    ngOnDestroy(){
        this.sub.unsubscribe();
    }
        
    
    
    /*let id = params.get('id');

        if (authService.isSignedIn() && (id === 'current' || id === this.session.getCurrentProfile().getId().toString())) {
                service.loadCurrentProfile();
        } else if (Number(id)) {
            service.loadProfileById(Number(id));
        } else {
            router.navigate(['/Profile/NotFound']);
            return;
        }

        if (service.getObservable() !== undefined) {
            service.getObservable().subscribe(
                (response) => {
                },
                (error) => {
                    router.navigate(['/Profile/NotFound']);
                }
            )
        } else {
            router.navigate(['/Public']);
        }
    }*/
}