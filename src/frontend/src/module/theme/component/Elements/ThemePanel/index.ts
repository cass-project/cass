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

    private selected: Theme;

    constructor(
        private service: ThemeService
    ) {}

    ngOnInit() {
        this.selected = this.root;
    }

    go(theme: Theme) {
        this.changeEvent.emit(theme);

        this.selected = theme;

        if(theme.children !== undefined && theme.children.length > 0) {
            this.root = theme;
        }
    }

    home() {
        this.go(this.service.getRoot());
    }

    back() {
        if(this.isBackAvailable()) {
            this.root = this.service.findById(this.root.parent_id);
            this.changeEvent.emit(this.root);
            this.selected = this.root;
        }
    }

    isAtHome() {
        return this.root === this.service.getRoot();
    }

    isBackAvailable() {
        return !! this.root.parent_id;
    }

    isSelected(compare: Theme): boolean {
        return this.selected === compare;
    }
}