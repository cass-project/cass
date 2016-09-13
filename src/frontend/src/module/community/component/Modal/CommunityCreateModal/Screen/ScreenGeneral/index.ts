import {Component, ElementRef, Directive} from "@angular/core";

import {CommunityCreateModalModel} from "../../model";
import {Screen} from "../../screen";
import {CommunityCreateModalForm} from "../../Form";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";

@Component({
    template: require('./template.jade')
,selector: 'cass-community-create-modal-screen-general'})
export class ScreenGeneral extends Screen
{
    constructor(public model: CommunityCreateModalModel, private elementRef: ElementRef) {
        super();
    }

    abort() {
        this.abortEvent.emit(this);
    }

    ngAfterViewInit() {
        this.elementRef.nativeElement.getElementsByClassName('form-input')[0].focus();
    }
}