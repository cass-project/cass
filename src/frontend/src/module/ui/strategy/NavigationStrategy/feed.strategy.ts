import {ElementRef} from "@angular/core";
import {UIStrategy} from "./ui.strategy";

export class FeedStrategy implements UIStrategy
{
    content: ElementRef;
    elements;

    constructor(private elem: ElementRef)
    {
        this.content = elem;
        this.elements = this.content.nativeElement.getElementsByClassName('x-navigation-entity');
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
        if(this.elements.length > 0){
            for(let index = 0; index < this.elements.length; index++){
                if(this.elements[index].classList.contains('x-navigation-entity-active') && index !== 0){
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    this.elements[index-1].classList.add('x-navigation-entity-active');
                    this.content.nativeElement.scrollTop = this.elements[index-1].getBoundingClientRect().top;
                } else if(!this.elements[index].classList.contains('x-navigation-entity-active')){
                    this.elements[0].classList.add('x-navigation-entity-active');
                    this.content.nativeElement.scrollTop = this.elements[0].getBoundingClientRect().top;
                }
            }
        }
    }

    right() {
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active') && index !== this.elements.length - 1) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    this.elements[index + 1].classList.add('x-navigation-entity-active');
                    this.content.nativeElement.scrollTop = this.elements[index + 1].getBoundingClientRect().top;
                    console.log(this.elements[index + 1].getBoundingClientRect().top);
                    break;
                } else if (index === this.elements.length - 1) {
                    this.elements[0].classList.add('x-navigation-entity-active');
                    this.content.nativeElement.scrollTop = this.elements[0].getBoundingClientRect().top;
                    console.log(this.elements[0].getBoundingClientRect().top)
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