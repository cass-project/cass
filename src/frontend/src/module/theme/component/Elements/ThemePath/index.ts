import {Component, Input, OnInit, EventEmitter, Output} from "@angular/core"
import {Theme} from "../../../definitions/entity/Theme";
import {ThemeService} from "../../../service/ThemeService";

@Component({
    selector: 'cass-theme-path',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemePath implements OnInit
{
    @Input('root') root: Theme;
    @Output('change') changeEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    private path: Theme[] = [];

    constructor(
        private service: ThemeService
    ) {}

    ngOnInit() {
        this.generatePath();
    }

    go(theme: Theme) {
        this.root = theme;
        this.changeEvent.emit(theme);
        this.generatePath();
    }

    back(theme: Theme) {
        if(this.path.length > 1) {
            this.root = this.path.pop();
            this.changeEvent.emit(this.root);
            this.generatePath();
        }
    }

    isBackAvailable() {
        return this.path.length > 1;
    }

    private generatePath() {
        if(this.root === undefined) {
            this.root = this.service.getRoot();
        }

        let root = this.root;

        while(root.parent_id !== null) {
            this.path.push(this.service.findById(root.parent_id));
            root = this.service.findById(root.parent_id);
        }
    }
}