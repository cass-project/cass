import {Component} from "angular2/core";
import {Input} from "angular2/core";

@Component({
    selector: 'cass-modal-box',
    template: '<div class="cass-modal-box" [ngStyle]="getStyle()"><ng-content></ng-content></div>',
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ModalBoxComponent {
    @Input('width') width: string = 'auto';

    getStyle() {
        return {
            width: this.width
        };
    }
}