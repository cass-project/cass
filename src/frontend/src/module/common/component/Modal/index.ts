import {Component, EventEmitter, Input, Output} from "@angular/core";

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
        this.outClickEvent.emit(true);
    }
}