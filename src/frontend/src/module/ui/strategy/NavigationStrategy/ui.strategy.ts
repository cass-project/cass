import {ElementRef} from "@angular/core";

export interface UIStrategy
{
    content: ElementRef;

    up();
    down();
    left?();
    right?();
    top();
    bottom();
    enter();
}