import {Component} from "angular2/core";
import {CommunityService} from "../../service/CommunityService";

@Component({
    selector: 'cass-community-menu',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityMenuComponent
{
    constructor(private service: CommunityService){}
}