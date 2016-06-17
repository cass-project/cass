import {Component, Input, Output, EventEmitter} from "angular2/core";

@Component({
    selector: 'cass-profile-menu',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileMenuComponent
{
    @Input('profile') profile: any;
    @Output('create_collection') create_collection = new EventEmitter();

    ProfileCollectionsList;

    constructor(){

    }
}