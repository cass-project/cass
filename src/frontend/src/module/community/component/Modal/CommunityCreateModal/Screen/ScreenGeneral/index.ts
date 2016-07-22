import {Component, ElementRef} from "angular2/core";

import {CommunityCreateModalModel} from "../../model";
import {Screen} from "../../screen";
import {CommunityCreateModalForm} from "../../Form";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";

@Component({
    selector: 'cass-community-create-modal-screen-general',
    template: require('./template.jade'),
    directives:[
        CommunityCreateModalForm,
        ThemeSelect,
    ]
})
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