import {Component, Output, EventEmitter} from "angular2/core";
import {PublicService} from "../../../service";

@Component({
    selector: 'cass-public-option-view',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class OptionView
{
    constructor(private service: PublicService) {}

    isVideoPlayerAvailable(): boolean {
        if(this.service.criteria.has('content_type')) {
            return this.service.criteria.getByCode('content_type').params.type === 'video';
        }else{
            return false;
        }
    }
}