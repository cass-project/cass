import {Component} from "@angular/core";
import {Session} from "../../../../../../session/Session";
import {AuthModalsService} from "../../../../../../auth/component/Auth/modals";
import {Router} from "@angular/router";

@Component({
    selector: 'cass-public-not-enough-collections',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class NotEnoughCollections
{
    constructor(
        private session: Session,
        private auth: AuthModalsService,
        private router: Router
    ) {}

    goMyCollections() {
        this.router.navigate(['/profile/current/collections']);
    }

    signIn() {
        this.auth.signIn();
    }

    isSignedIn(): boolean {
        return this.session.isSignedIn();
    }
}