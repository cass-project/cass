import {Component} from 'angular2/core';
import {Theme} from '../../../theme/Theme';

@Component({
    styles: [
        require('./style.shadow.scss')
    ],
    template: require('./template.html')
})
export class CreateThemeForm
{
    title: string;
    parent: Theme;

    submit() {
        console.log(this.title);
    }
}