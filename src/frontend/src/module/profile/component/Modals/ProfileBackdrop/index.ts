import {Component, Input, Output, EventEmitter, OnInit} from "@angular/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {Backdrop} from "../../../../backdrop/definitions/Backdrop";
import {ChangeBackdropModel} from "../../../../backdrop/component/Form/ChangeBackdropForm/model";

@Component({
    selector: 'cass-profile-backdrop-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ChangeBackdropModel,
    ]
})
export class ProfileBackdrop implements OnInit
{
    @Input('profile') profile: ProfileEntity;
    @Output('close') closeEvent: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('complete') completeEvent: EventEmitter<Backdrop<any>> = new EventEmitter<Backdrop<any>>();

    constructor(private model: ChangeBackdropModel) {}

    ngOnInit() {
        this.model.exportBackdrop(this.profile.backdrop);
        this.model.exportSampleText(this.profile.greetings.greetings);
    }

    close() {
        this.closeEvent.emit(true);
    }
}