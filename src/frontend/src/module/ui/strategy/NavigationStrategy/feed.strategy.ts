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
        let cur = 0;
        let step = 0;
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    cur = index;
                    step = cur - 1;
                    console.log("current " + cur);
                    break;
                }
            }
            let prev = cur;
            for (let index = step; index >= 0; index--) {

                // Previous item with same X.
                if (this.elements[index].getBoundingClientRect().left == this.elements[cur].getBoundingClientRect().left) {
                    prev = index;
                    break;
                }
            }
            console.log("previous " + prev);
            this.elements[prev].classList.add('x-navigation-entity-active');
            console.log(this.elements[prev]);

            this.scrollToElement(this.elements[prev])
        }
    }

    down()
    {
        let cur = 0;
        let step = 0;
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    cur = index;
                    step = cur + 1;
                    console.log("current " + cur);
                    break;
                }
            }
            let next = cur;
            for (let index = step; index < this.elements.length; index++) {

                // Next item with same X.
                if (this.elements[index].getBoundingClientRect().left == this.elements[cur].getBoundingClientRect().left) {
                    next = index;
                    break;
                }
            }

            this.elements[next].classList.add('x-navigation-entity-active');
            console.log(this.elements[next]);

            this.scrollToElement(this.elements[next])
        }
    }

    left()
    {
        let prev = 0;
        if(this.elements.length > 0){
            for(let index = 0; index < this.elements.length; index++){
                if(this.elements[index].classList.contains('x-navigation-entity-active') && index > 0) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    console.log("current " + index);
                    prev = index - 1;
                    break;
                }
            }
        }
        this.elements[prev].classList.add('x-navigation-entity-active');
        console.log(this.content.nativeElement.scrollTop, this.elements[prev].getBoundingClientRect().top, this.elements[prev].getBoundingClientRect().bottom);

        this.scrollToElement(this.elements[prev])
    }

    right() {
        console.log(this.content, this.elements);
        let next = 0;
        if(this.elements.length > 0){
            for(let index = 0; index < this.elements.length; index++){
                if(this.elements[index].classList.contains('x-navigation-entity-active') && index < this.elements.length - 1) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    console.log("current " + index);
                    next = index + 1;
                    break;
                }
            }
        }
        this.elements[next].classList.add('x-navigation-entity-active');

        this.scrollToElement(this.elements[next])
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
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].click();
                }
            }}
    }

    scrollToElement(element) {
        let top = element.getBoundingClientRect().top;
        let bottom = element.getBoundingClientRect().bottom;
        let midY = (top + bottom) / 2;
        if (midY < 0 || midY >= this.content.nativeElement.clientHeight) {
            this.content.nativeElement.scrollTop += top;
        }
    }
}