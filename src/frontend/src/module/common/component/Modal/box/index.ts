import {Component, Input} from "@angular/core";

@Component({
    selector: 'cass-modal-box',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class ModalBoxComponent {
    @Input('width') width: string = 'auto';
    @Input('height') height: string = 'auto';

    getStyle() {
        return {
            width: this.width,
            height: this.height
        };
    }
}