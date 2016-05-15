import {Component, Input} from "angular2/core";

@Component({
    selector: 'cass-profile-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileImage
{
    @Input('url') url: string;
    @Input('border') border: string = 'circle';

    static allowedBorders = ['circle', 'square'];

    getURL() {
        return this.url;
    }

    getCSSClasses() {
        let border = this.border;

        if(!~ProfileImage.allowedBorders.indexOf(border)) {
            throw new Error(`Invalid border ${border}`);
        }

        return `profile-image-border profile-image-border-${border}`;
    }
}