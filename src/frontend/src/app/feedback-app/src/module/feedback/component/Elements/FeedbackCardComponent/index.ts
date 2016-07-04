import {Component, Input, ViewChild} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

import {FeedbackEntity}         from "../../../../../../../../module/feedback/definitions/entity/Feedback";
import {FeedbackTypesService}   from "../../../../../../../../module/feedback/service/FeedbackTypesService";
import {FeedbackModalComponent} from "../../Modals/FeedbackModalComponent/index";
declare var jQuery;

@Component({
    selector: 'cass-feedback-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        FeedbackModalComponent
    ],
    providers: [
        FeedbackTypesService
    ]
})
export class FeedbackCardComponent{
    @Input('feedback') feedback:FeedbackEntity;
    @ViewChild('feedbackModal') feedbackModalComponent;
    
    constructor(private feedbackTypesService:FeedbackTypesService) {}
    
    showModal() {
        let feedbackModal = this.feedbackModalComponent.feedbackModal.nativeElement;
        jQuery(feedbackModal).modal('show', {backdrop: 'static'});
    }

    getFeedbackType(code:string|number) :string {
        return this.feedbackTypesService.getFeedbackType(code).code.string;
    }

    /**
     * Usage Date in template see at \node_modules\angular2\src\common\pipes\date_pipe.d.ts 
     */
    stringToDate(date:string) {
        return new Date(date);
    }

    archive() {
        console.log('NOT IMPLEMENTED');
    }

    ban() {
        console.log('NOT IMPLEMENTED');
    }



}