import {Component, Directive} from "@angular/core";
import {Input} from "@angular/core";

@Component({
    template: '<div class="cass-modal-box" [ngStyle]="getStyle()"><ng-content></ng-content></div>',
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-modal-box'})

export class ModalBoxComponent {
    @Input('width') width: string = 'auto';

    getStyle() {
        return {
            width: this.width
        };
    }
}