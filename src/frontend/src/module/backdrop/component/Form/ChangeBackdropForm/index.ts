import {Component, Input, Output, EventEmitter} from "@angular/core";
import {Backdrop} from "../../../definitions/Backdrop";
import { UploadProfileImageStrategy } from "../../../../profile/common/UploadProfileImageStrategy";

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

    @Output('changeTextColor') changeTextColor: EventEmitter<string> = new EventEmitter<string>();
    @Output('submit') submit: EventEmitter<any> = new EventEmitter<any>();

    submitEvent(event){
        this.submit.emit(event);
    }

    changeTextColorEvent(event){
        this.changeTextColor.emit(event);
    }
    
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