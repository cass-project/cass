import {ElementRef} from "@angular/core";
import {UIStrategy} from "./ui.strategy";

export class NoneStrategy implements UIStrategy
{
    content: ElementRef;

    constructor(private element: ElementRef)
    {
        this.content = element;
    }
}