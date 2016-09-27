import {Component, Input, OnInit, EventEmitter, Output} from "@angular/core";

import {Theme} from "../../../definitions/entity/Theme";
import {ThemeService} from "../../../service/ThemeService";
import {ViewOptionService} from "../../../../public/component/Options/ViewOption/service";

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
    private results: Theme[] = [];

    constructor(
        private service: ThemeService,
        private viewMode: ViewOptionService
    ) {}

    ngOnInit() {
        let root = this.root;

        this.setTheme(root);

        while(root.parent_id !== null) {
            this.path.push(this.service.findById(root.parent_id));
            root = this.service.findById(root.parent_id);
        }
    }

    getListCSSClass(): string {
        return `themes-list-${this.viewMode.option.current}`;
    }

    up() {
        if(this.path.length) {
            this.setTheme(this.path.pop());
            this.changeEvent.emit(this.root);
        }
    }

    go(theme: Theme) {
        this.changeEvent.emit(theme);
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
        this.results = theme.children;
    }
}