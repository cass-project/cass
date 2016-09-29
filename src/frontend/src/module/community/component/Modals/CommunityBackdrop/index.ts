import {Component, Input, Output, EventEmitter, OnInit} from "@angular/core";

import {Backdrop} from "../../../../backdrop/definitions/Backdrop";
import {ChangeBackdropModel} from "../../../../backdrop/component/Form/ChangeBackdropForm/model";
import {CommunityEntity} from "../../../definitions/entity/Community";

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
    @Input('community') community: CommunityEntity;
    @Output('close') closeEvent: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('complete') completeEvent: EventEmitter<Backdrop<any>> = new EventEmitter<Backdrop<any>>();

    constructor(private model: ChangeBackdropModel) {}

    ngOnInit() {
        this.model.exportBackdrop(this.community.backdrop);
        this.model.exportSampleText(this.community.title);
    }

    close() {
        this.closeEvent.emit(true);
    }
}