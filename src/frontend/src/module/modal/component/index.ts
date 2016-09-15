import {Component} from "@angular/core";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-modal'})
export class ModalComponent
{
    private id = Math.random().toString(36).substring(7);

    ngOnInit() {
    }

    ngOnDestroy() {
    }

    public getId(): string {
        return this.id;
    }
}