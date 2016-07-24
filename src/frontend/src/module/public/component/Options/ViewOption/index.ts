import {Component, Output, EventEmitter} from "angular2/core";
import {PublicService} from "../../../service";

export enum ViewOption
{
    Feed = <any>"feed",
    Grid = <any>"grid",
    Table = <any>"table"
}

@Component({
    selector: 'cass-public-option-view',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class OptionView
{
    current: ViewOption = ViewOption.Feed;
    
    constructor(private service: PublicService) {}
    
    isOn(compare: ViewOption) {
        return this.current === compare;
    }
    
    setAsCurrent(option: ViewOption) {
        this.current = option;
    }

    isVideoPlayerAvailable(): boolean {
        if(this.service.criteria.has('content_type')) {
            return this.service.criteria.getByCode('content_type').params.type === 'video';
        }else{
            return false;
        }
    }
}