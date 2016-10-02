import {Component, Output, EventEmitter} from "@angular/core";

@Component({
    selector: 'cass-profile-switcher-create-profile-placeholder',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CreateProfilePlaceholder
{
    @Output('create') createEvent: EventEmitter<boolean> = new EventEmitter<boolean>();

    create() {
        this.createEvent.emit(true);
    }
}