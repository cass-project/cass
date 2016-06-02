import {Component} from "angular2/core";
import {ModalService} from "./service";

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

    constructor(private service: ModalService) {
    }

    ngOnInit() {
        this.service.attach(this);
    }

    ngOnDestroy() {
        this.service.detach(this);
    }

    public getId(): string {
        return this.id;
    }
}