import {Component, Input, Output, OnInit, EventEmitter} from "@angular/core";

import {Theme, THEME_PREVIEW_PUBLIC_PREFIX} from "../../../../../definitions/entity/Theme";

@Component({
    selector: 'cass-theme-card-list-item',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})
export class ThemeCardList implements OnInit
{
    private prefix: string = THEME_PREVIEW_PUBLIC_PREFIX;
    private hasAnyChildren: boolean = false;
    private children: Theme[] = [];

    @Input('theme') theme: Theme;
    @Output('go') goEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    ngOnInit() {
        this.hasAnyChildren = (this.theme.children !== undefined) && (this.theme.children.length > 0);

        if(this.hasAnyChildren) {
            let i = 0;

            while(this.theme.children[i] !== undefined) {
                this.children.push(this.theme.children[i]);
                i++;
            }
        }
    }

    go(theme: Theme) {
        this.goEvent.emit(theme);
    }
}