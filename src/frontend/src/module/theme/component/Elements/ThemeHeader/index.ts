import {Component, Input, Output, EventEmitter} from "@angular/core";
import {Theme} from "../../../definitions/entity/Theme";
import {ThemeService} from "../../../service/ThemeService";

@Component({
    selector: 'cass-theme-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemeHeader
{
    @Input('theme') theme: Theme;
    @Output('go') goEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    constructor(private service: ThemeService) {}

    getTitle(): string {
        return this.theme.title;
    }

    isRoot() {
        return typeof(this.theme.parent_id) !== "number";
    }

    getPath(): Theme[] {
        let path: Theme[] = [];
        let current = this.theme;

        while(current.parent_id !== null) {
            path.push(current = this.service.findById(current.parent_id));
        }

        return path;
    }

    go(theme: Theme) {
        this.goEvent.emit(theme);
    }
}