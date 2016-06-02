import {Output} from "angular2/core";
import {EventEmitter} from "angular2/core";

import {CommunityCreateModalModel} from "./model";

export class Screen
{
    @Output("abort") abortEvent = new EventEmitter<Screen>();
    @Output("next") nextEvent = new EventEmitter<Screen>();

    constructor(protected model: CommunityCreateModalModel) {}

    next() {
        this.nextEvent.emit(this);
    }

    abort($event) {
        $event.preventDefault();
        this.abortEvent.emit(this);
    }
}