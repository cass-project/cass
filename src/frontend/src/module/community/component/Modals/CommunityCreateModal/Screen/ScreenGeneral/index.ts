import {Component, ElementRef, EventEmitter, Output, Input} from "@angular/core";

import {CommunityCreateModalModel} from "../../model";
import {Screen} from "../../screen";

@Component({
    selector: 'cass-community-create-modal-screen-general',
    template: require('./template.jade')
})
export class ScreenGeneral extends Screen
{
    @Input('themeId') themeId: number;
    @Output('abort') abortEvent: EventEmitter<Screen> = new EventEmitter<Screen>();
    @Output('next') nextEvent: EventEmitter<Screen> = new EventEmitter<Screen>();

    constructor(
        public model: CommunityCreateModalModel,
        private elementRef: ElementRef) { super(); }

    ngOnChanges(){
        this.model.theme_ids = this.themeId ? [this.themeId] : [];
    }

    ngAfterViewInit() {
        this.elementRef.nativeElement.getElementsByClassName('form-input')[0].focus();
    }

    abort() {
        this.abortEvent.emit(this);
    }

    next() {
        this.nextEvent.emit(this)
    }
}