import {Component, Input, EventEmitter, Output} from "@angular/core";
import {ROUTER_DIRECTIVES} from '@angular/router-deprecated';
import {FeedbackQueryModel} from "../../../feedback/FeedbackQueryParamsModel";
import {FormBuilder, ControlGroup} from "@angular/common";
import {FeedbackFilterModel} from "./model";

declare var jQuery;

@Component({
    selector: 'cass-feedback-landing-sidebar',
    template: require('./template.jade'),
    directives:[
        ROUTER_DIRECTIVES
    ]
})
export class SidebarComponent {

    @Input('loading') isLoading:boolean = false;
    @Output('onfilter') filterEvent = new EventEmitter<FeedbackQueryModel>();

    private form:ControlGroup;
    private hasChanged:boolean = false;
    
    constructor(
        private feedbackQueryModel: FeedbackQueryModel,
        private formBuilder: FormBuilder
    ) {
        this.initFormBuilder();
    }

    initFormBuilder() {
        this.form = this.formBuilder.group(new FeedbackFilterModel());
        this.hasChanged = false;
        this.form.valueChanges.subscribe(() => {
            this.hasChanged = true;
            this.filter();
        });
    }

    ngAfterContentInit() {
        jQuery('[data-toggle="tooltip"]').tooltip();
    }
    
    filter() {
        console.log();
            let model:FeedbackFilterModel = this.form.value;

        if(model.answer && model.not_answer || !model.answer && !model.not_answer){
            this.feedbackQueryModel.answer = undefined;
        }else{
            this.feedbackQueryModel.answer = model.answer;
        }
        if(model.read && model.not_read || !model.read && !model.not_read){
            this.feedbackQueryModel.read = undefined;
        }else{
            this.feedbackQueryModel.read = model.read;
        }

        this.filterEvent.emit(this.feedbackQueryModel)
    }

    reset() {
        this.initFormBuilder();
        this.filter();
    }
}
