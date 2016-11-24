import {Component} from "@angular/core";

import {Backdrop} from "../../../definitions/Backdrop";

@Component({
    selector: 'cass-change-backdrop-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ChangeBackdropForm
{
    private tab: ChangeBackdropModalTab = ChangeBackdropModalTab.Image;

    switchTab(tab: ChangeBackdropModalTab) {
        this.tab = tab;
    }

    isOn(tab: ChangeBackdropModalTab) {
        return this.tab === tab;
    }
}

enum ChangeBackdropModalTab
{
    Image = <any>"image",
    Palette = <any>"palette",
    Preset = <any>"preset"
}