import {Component, Input, OnInit} from "@angular/core";
import {Theme} from "../../definitions/entity/Theme";
import {ThemeService} from "../../service/ThemeService";

@Component({
    selector: 'cass-theme-browser',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemeBrowserComponent implements OnInit
{
    @Input('root') root: Theme;

    private maxLevel: Theme;
    private themes: Theme[] = [];

    constructor(
        private service: ThemeService
    ) {}

    ngOnInit() {
        this.maxLevel = this.root;
        this.fetchThemes();
    }

    private fetchThemes() {
        this.themes = this.root.children;
    }
}