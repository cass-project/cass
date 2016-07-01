import {Component} from "angular2/core";
import {Router} from "angular2/router";

@Component({
    selector: 'cass-feedback-create-button',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class FeedbackCreateButton
{
    private isVisible:boolean = true;

    constructor(private router: Router) {
        this.router.subscribe(() => {
            this.isVisible = !this.isRouteFeedbackCreateActive();
        });
    }

    isRouteFeedbackCreateActive() {
        return this.router.isRouteActive(this.router.generate(['/Feedback', 'FeedbackCreate']));
    }

    goToCreateFeedback() {
        this.router.navigateByUrl("/feedback/create");
    }
}
