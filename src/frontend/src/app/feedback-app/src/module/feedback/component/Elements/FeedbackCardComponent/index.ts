import {Component, Input, ViewChild} from "angular2/core";
import {FeedbackModalComponent} from "../../Modals/FeedbackModalComponent/index";
import {FeedbackEntity} from "../../../../../../../../module/feedback/definitions/entity/Feedback";
declare var jQuery;

@Component({
    selector: 'cass-feedback-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives:[
        FeedbackModalComponent
    ]
})
export class FeedbackCardComponent{
    @Input('feedback') feedback:FeedbackEntity;
    @ViewChild('feedbackModal') feedbackModalComponent;
    
    showModal(){
        let feedbackModal = this.feedbackModalComponent.feedbackModal.nativeElement;
        jQuery(feedbackModal).modal('show', {backdrop: 'static'});
    }





    /**
     * Usage in template see at \node_modules\angular2\src\common\pipes\date_pipe.d.ts 
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