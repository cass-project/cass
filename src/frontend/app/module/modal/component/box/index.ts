import {Component} from "angular2/core";
import {Input} from "angular2/core";

@Component({
    selector: 'cass-modal-box',
    template: '<div class="cass-modal-box" style="width: {{ width }};"><ng-content></ng-content></div>',
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ModalBoxComponent {
    @Input('width') width: string = 'auto';
}