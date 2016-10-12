import {ElementRef} from "@angular/core";
import {UIStrategy} from "./ui.strategy";

export class ListStrategy implements UIStrategy
{
    content: ElementRef;

    constructor(private elem: ElementRef)
    {
        this.content = elem;
    }

    up()
    {
        console.log(this.content);
    }

    down()
    {
        console.log(this.content);
    }

    left()
    {
        let elements = this.content.nativeElement.getElementsByClassName('x-navigation-entity');

        if(elements.length > 0){
            for(let index = 0; index < elements.length; index++){
                if(elements[index].classList.contains('x-navigation-entity-active') && index !== 0){
                    elements[index].classList.remove('x-navigation-entity-active');
                    elements[index-1].classList.add('x-navigation-entity-active');
                    this.content.nativeElement.scrollTop = elements[index-1].getBoundingClientRect().top;
                } else if(!elements[index].classList.contains('x-navigation-entity-active')){
                    elements[0].classList.add('x-navigation-entity-active');
                    this.content.nativeElement.scrollTop = elements[0].getBoundingClientRect().top;
                }
            }
        }
    }

    right() {
        let elements = this.content.nativeElement.getElementsByClassName('x-navigation-entity');
        let navActive:boolean = false;

        if (elements.length > 0) {
            for (let index = 0; index < elements.length; index++) {
                if (elements[index].classList.contains('x-navigation-entity-active') && index !== elements.length - 1) {
                    elements[index].classList.remove('x-navigation-entity-active');
                    elements[index + 1].classList.add('x-navigation-entity-active');
                    navActive = true;
                    this.content.nativeElement.scrollTop = elements[index + 1].getBoundingClientRect().top;
                } else if (!navActive && index === elements.length - 1) {
                    elements[0].classList.add('x-navigation-entity-active');
                    this.content.nativeElement.scrollTop = elements[0].getBoundingClientRect().top;
                    console.log(elements[0].getBoundingClientRect().top)
                }
            }
        }
    }

    top()
    {
        this.content.nativeElement.scrollTop = 0;
    }

    bottom()
    {
        this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
    }

    enter()
    {
        console.log(this.content);
    }

}