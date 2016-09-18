import {Component, Output, EventEmitter, Directive} from "@angular/core";

import {FeedbackTypeEntity} from "../../../definitions/entity/FeedbackType";
import {FeedbackTypesService} from "../../../service/FeedbackTypesService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-feedback-create-button'})

export class FeedbackCreateButton
{
    @Output('open') openEvent = new EventEmitter<FeedbackTypeEntity>();
    
    constructor (private feedbackTypesService: FeedbackTypesService){}

    openFeedbackModal() {
        this.openEvent.emit(this.feedbackTypesService.getDefaultFeedbackType());
    }
}
