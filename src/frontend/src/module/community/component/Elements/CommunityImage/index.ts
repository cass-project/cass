import {Component, Input, Directive} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-community-image'})
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

        return `community-image-border community-image-border-${border}`;
    }
}