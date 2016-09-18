import {Component} from "@angular/core";
import {PublicService} from "../../../service";

@Component({
    selector: 'cass-public-feed-source-selector',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SourceSelector
{
    constructor(private catalog: PublicService) {}

    isOn(source: string) {
        return this.catalog.source === source;
    }
}