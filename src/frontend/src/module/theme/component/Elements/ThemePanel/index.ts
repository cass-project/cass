import {Component, Input, Output, EventEmitter} from "@angular/core"

import {Theme} from "../../../definitions/entity/Theme";
import {ThemeService} from "../../../service/ThemeService";

@Component({
    selector: 'cass-theme-panel',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemePanel
{
    @Input('root') root: Theme;
    @Output('change') changeEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    private path: Theme[] = [];
    private selected: Theme;

    constructor(
        private service: ThemeService
    ) {}

    ngOnInit() {
        this.selected = this.root;
        this.generatePath();
    }

    go(theme: Theme) {
        this.changeEvent.emit(theme);

        this.selected = theme;

        if(theme.children !== undefined && theme.children.length > 0) {
            this.root = theme;
            this.generatePath();
        }
    }

    back(theme: Theme) {
        if(this.path.length > 1) {
            this.root = this.path.pop();
            this.changeEvent.emit(this.root);
            this.selected = this.root;
            this.generatePath();
        }
    }

    isBackAvailable() {
        return this.path.length > 1;
    }

    isSelected(compare: Theme): boolean {
        return this.selected === compare;
    }

    private generatePath() {
        if(this.root === undefined) {
            this.root = this.service.getRoot();
        }

        this.path = [];
        this.path.push(this.root);

        let root = this.root;

        while(root.parent_id !== null) {
            this.path.push(this.service.findById(root.parent_id));
            root = this.service.findById(root.parent_id);
        }
    }
}