import {Component} from "@angular/core";

@Component({
    selector: 'cass-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ModalComponent
{
    private id = Math.random().toString(36).substring(7);

    public getId(): string {
        return this.id;
    }
}