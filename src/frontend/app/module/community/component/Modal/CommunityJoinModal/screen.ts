import {Output} from "angular2/core";
import {EventEmitter} from "angular2/core";
import {CommunityJoinModalModel} from "./model";

export class Screen
{
    @Output("abort") abortEvent = new EventEmitter<Screen>();
    @Output("next") nextEvent = new EventEmitter<Screen>();

    constructor(private model: CommunityJoinModalModel) {}

    next() {
        this.nextEvent.emit(this);
    }

    abort() {
        this.abortEvent.emit(this);
    }
}