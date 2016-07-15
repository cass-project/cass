import {Component, Input} from "angular2/core";

@Component({
    selector: 'cass-profile-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityImage
{
    @Input('url') url: string;
    @Input('border') border: string = 'circle';

    static allowedBorders = ['circle', 'square'];

    getURL(): string {
        return this.url;
    }

    getCSSClasses(): string {
        let border = this.border;

        if(!~CommunityImage.allowedBorders.indexOf(border)) {
            throw new Error(`Invalid border ${border}`);
        }

        return `profile-image-border profile-image-border-${border}`;
    }
}