import {Output, EventEmitter} from "@angular/core";

export class Screen
{
    @Output("abort") abortEvent: EventEmitter<Screen> = new EventEmitter<Screen>();
    @Output("next") nextEvent: EventEmitter<Screen> = new EventEmitter<Screen>();

    next() {
        this.nextEvent.emit(this);
    }

    abort() {
        this.abortEvent.emit(this);
    }
}