import {Component, Input, OnInit, EventEmitter, Output} from "@angular/core";

import {Theme} from "../../definitions/entity/Theme";
import {ThemeService} from "../../service/ThemeService";

@Component({
    selector: 'cass-theme-browser',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemeBrowser implements OnInit
{
    @Input('root') root: Theme;
    @Output('change') changeEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    private path: Theme[] = [];

    constructor(
        private service: ThemeService
    ) {}

    ngOnInit() {
        let root = this.root;

        while(root.parent_id !== null) {
            this.path.push(this.service.findById(root.parent_id));
            root = this.service.findById(root.parent_id);
        }
    }

    up() {
        if(this.path.length) {
            this.setTheme(this.path.pop());
        }
    }

    go(theme: Theme) {
        this.setTheme(theme);
        this.path.push(theme);
    }

    isUpAvailable() {
        return this.path.length > 0;
    }

    getCurrentLevelThemes(): Theme[] {
        return this.root.children;
    }

    private setTheme(theme: Theme) {
        this.root = theme;
    }
}