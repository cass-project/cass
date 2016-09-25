import {Component, Input, EventEmitter, Output} from "@angular/core";

import {ColorEntity} from "../../../definitions/entity/Color";

@Component({
    selector: 'cass-color-picker',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ColorPicker
{
    static DEFAULT_COLOR = { code: 'white', hexCode: '#ffffff' };

    @Input('variants') variants: ColorEntity[];
    @Input('value') value: ColorEntity = ColorPicker.DEFAULT_COLOR;
    @Output('change') changeEvent: EventEmitter<ColorEntity> = new EventEmitter<ColorEntity>();

    getValue(): ColorEntity {
        return this.value;
    }

    setValue(value: ColorEntity) {
        this.value = value;
        this.changeEvent.emit(value);
    }
}