import {Component, Output, EventEmitter} from "@angular/core";

import {Backdrop} from "../../../definitions/Backdrop";
import {ChangeBackdropModel} from "./model";

@Component({
    selector: 'cass-change-backdrop-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ChangeBackdropModel,
    ]
})
export class ChangeBackdropModal
{
    @Output('close') closeEvent: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('complete') completeEvent: EventEmitter<Backdrop<any>> = new EventEmitter<Backdrop<any>>();

    private tab: ChangeBackdropModalTab = ChangeBackdropModalTab.Image;

    switchTab(tab: ChangeBackdropModalTab) {
        this.tab = tab;
    }

    isOn(tab: ChangeBackdropModalTab) {
        return this.tab === tab;
    }

    close() {
        this.closeEvent.emit(true);
    }
}

enum ChangeBackdropModalTab
{
    Image = <any>"image",
    Palette = <any>"palette"
}