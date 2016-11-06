import {Component, Input, Output, EventEmitter, OnChanges} from "@angular/core"

import {Theme} from "../../../definitions/entity/Theme";
import {ThemeService} from "../../../service/ThemeService";

@Component({
    selector: 'cass-theme-panel',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemePanel implements OnChanges
{
    @Input('root') root: Theme;
    @Output('change') changeEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    private selected: Theme;

    constructor(
        private service: ThemeService
    ) {}

    ngOnChanges() {
        this.selected = this.root;
    }

    go(theme: Theme) {
        this.changeEvent.emit(theme);

        this.selected = theme;

        if(theme.children !== undefined && theme.children.length > 0) {
            this.root = theme;
        }
    }

    getChildren(): Theme[] {
        if(this.selected.children.length > 0) {
            return this.selected.children;
        }else{
            return this.service.findById(this.selected.parent_id).children;
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