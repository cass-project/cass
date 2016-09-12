import {Component, Injectable, Directive} from "@angular/core";

import {ModalService} from "./service";
import {AuthService} from "../../auth/service/AuthService";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-modal'})
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