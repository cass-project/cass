import {Component, EventEmitter} from "@angular/core";
import {Input, Output} from "@angular/core/src/metadata/directives";

@Component({
    selector: 'cass-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ModalComponent
{
    @Input('style') style: string = 'light';
    @Output('out-click') outClickEvent: EventEmitter<boolean> = new EventEmitter<boolean>();

    private id = Math.random().toString(36).substring(7);

    public getId(): string {
        return this.id;
    }

    outClick() {
        console.log('out click');
        this.outClickEvent.emit(true);
    }
}