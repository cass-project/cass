import {Component, Input} from "angular2/core";
import {FeedbackEntity} from "../../../../../../../../module/feedback/definitions/entity/Feedback";

@Component({
    selector: 'cass-feedback-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CardComponent {
    @Input('feedback') feedback:FeedbackEntity;

    reply() {
        console.log('NOT IMPLEMENTED');
    }
}