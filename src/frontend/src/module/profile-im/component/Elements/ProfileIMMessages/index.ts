import {Component} from "angular2/core";
import {Autosize} from "angular2-autosize/angular2-autosize";


@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [Autosize]
})

export class ProfileIMMessages
{
}
