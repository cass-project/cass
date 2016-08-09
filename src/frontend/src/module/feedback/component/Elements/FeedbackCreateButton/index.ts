import {Component, Output, EventEmitter} from "@angular/core";
import {FeedbackTypeEntity} from "../../../definitions/entity/FeedbackType";
import {FeedbackTypesService} from "../../../service/FeedbackTypesService";

@Component({
    selector: 'cass-feedback-create-button',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class FeedbackCreateButton
{
    @Output('open') openEvent = new EventEmitter<FeedbackTypeEntity>();
    
    constructor (private feedbackTypesService: FeedbackTypesService){}

    openFeedbackModal() {
        this.openEvent.emit(this.feedbackTypesService.getDefaultFeedbackType());
    }
}
