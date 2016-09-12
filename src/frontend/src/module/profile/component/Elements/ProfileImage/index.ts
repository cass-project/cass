import {Component, Input, Directive} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-profile-image'})

export class ProfileImage
{
    @Input('url') url: string;
    @Input('border') border: string = 'circle';

    static allowedBorders = ['circle', 'square'];

    getURL(): string {
        return this.url;
    }

    getCSSClasses(): string {
        let border = this.border;

        if(!~ProfileImage.allowedBorders.indexOf(border)) {
            throw new Error(`Invalid border ${border}`);
        }

        return `profile-image-border profile-image-border-${border}`;
    }
}