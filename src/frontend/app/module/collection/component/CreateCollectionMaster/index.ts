import {Component, Input, Output, EventEmitter} from "angular2/core";
import {ColorPicker} from "../../../util/component/ColorPicker/index";

@Component({
    selector: 'cass-collection-create-master',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ColorPicker
    ]
})
export class CreteCollectionMaster
{
    @Input ('for') _for: string;
    @Input ('for-id') for_id: number;
    @Output ('complete') complete = new EventEmitter();
    @Output ('error') error = new EventEmitter();
}