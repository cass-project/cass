import {Component, Injectable} from "@angular/core";

import {ModalService} from "./service";
import {AuthService} from "../../auth/service/AuthService";

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

    ngOnInit() {
    }

    ngOnDestroy() {
    }

    public getId(): string {
        return this.id;
    }
}