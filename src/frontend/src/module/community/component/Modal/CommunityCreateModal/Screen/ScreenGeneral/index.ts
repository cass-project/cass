import {Component, ElementRef} from "@angular/core";

import {CommunityCreateModalModel} from "../../model";
import {Screen} from "../../screen";

@Component({
    selector: 'cass-community-create-modal-screen-general',
    template: require('./template.jade')
})
export class ScreenGeneral extends Screen
{
    constructor(
        public model: CommunityCreateModalModel,
        private elementRef: ElementRef) { super(); }

    ngAfterViewInit() {
        this.elementRef.nativeElement.getElementsByClassName('form-input')[0].focus();
    }

    abort() {
        this.abortEvent.emit(this);
    }
}