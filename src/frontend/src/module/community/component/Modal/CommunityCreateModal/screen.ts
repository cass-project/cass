import {Output, EventEmitter} from "@angular/core";

export class Screen
{
    @Output("abort") abortEvent = new EventEmitter<Screen>();
    @Output("next") nextEvent = new EventEmitter<Screen>();

    next() {
        this.nextEvent.emit(this);
    }

    abort() {
        this.abortEvent.emit(this);
    }
}