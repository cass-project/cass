import {ElementRef} from "@angular/core";
import {UIStrategy} from "./ui.strategy";

export class FeedStrategy implements UIStrategy
{
    private pickedElem;
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
        let isFirst = true;
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    cur = index;
                    isFirst = false;
                    break;
                }
            }
            let prev = cur;
            if (!isFirst) {
                let currentItemRect = this.elements[cur].getBoundingClientRect();
                let prevRowY = currentItemRect.top;
                let nearestX = 0;
                for (let index = cur; index >= 0; index--) {
                    let stepItemRect = this.elements[index].getBoundingClientRect();

                    // Handle only previous row.
                    if (stepItemRect.top < currentItemRect.top) {
                        if (prevRowY == currentItemRect.top) { // First item in the previous row.
                            prev = index;
                            prevRowY = stepItemRect.top;
                            nearestX = Math.abs(stepItemRect.left - currentItemRect.left);
                        } else {
                            if (stepItemRect.top < prevRowY) {
                                break;
                            }

                            // Find the nearest item.
                            let offsetX = Math.abs(stepItemRect.left - currentItemRect.left);
                            if (offsetX < nearestX) {
                                prev = index;
                                nearestX = offsetX;
                            }
                        }
                    }
                }
            }

            this.elements[prev].classList.add('x-navigation-entity-active');
            this.pickedElem = this.elements[prev];

            this.scrollIntoView(this.elements[prev], true, -10);
        }
    }

    down()
    {
        let cur = 0;
        let isFirst = true;
        if (this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    cur = index;
                    isFirst = false;
                    break;
                }
            }
            let next = cur;
            if (!isFirst) {
                let currentItemRect = this.elements[cur].getBoundingClientRect();
                let nextRowY = currentItemRect.top;
                let nearestX = 0;
                for (let index = cur; index < this.elements.length; index++) {
                    let stepItemRect = this.elements[index].getBoundingClientRect();

                    // Handle only next row.
                    if (stepItemRect.top > currentItemRect.top) {
                        if (nextRowY == currentItemRect.top) { // First item in the next row.
                            next = index;
                            nextRowY = stepItemRect.top;
                            nearestX = Math.abs(stepItemRect.left - currentItemRect.left);
                        } else {
                            if (stepItemRect.top > nextRowY) {
                                break;
                            }

                            // Find the nearest item.
                            let offsetX = Math.abs(stepItemRect.left - currentItemRect.left);
                            if (offsetX < nearestX) {
                                next = index;
                                nearestX = offsetX;
                            }
                        }
                    }
                }
            }

            this.elements[next].classList.add('x-navigation-entity-active');
            this.pickedElem = this.elements[next];

            this.scrollIntoView(this.elements[next], false, 10);
        }
    }

    left()
    {
        let prev = 0;
        if(this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    prev = (index > 0) ? index - 1 : index;
                    break;
                }
            }
            this.elements[prev].classList.add('x-navigation-entity-active');
            this.pickedElem = this.elements[prev];

            this.scrollIntoView(this.elements[prev], true, -10);
        }
    }

    right() {
        let next = 0;
        if(this.elements.length > 0) {
            for (let index = 0; index < this.elements.length; index++) {
                if (this.elements[index].classList.contains('x-navigation-entity-active')) {
                    this.elements[index].classList.remove('x-navigation-entity-active');
                    next = (index < this.elements.length - 1) ? index + 1 : index;
                    break;
                }
            }
            this.elements[next].classList.add('x-navigation-entity-active');
            this.pickedElem = this.elements[next];

            this.scrollIntoView(this.elements[next], false, 10)
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
        if(this.pickedElem.getElementsByClassName('x-navigation-click').length > 0){
           this.pickedElem.getElementsByClassName('x-navigation-click')[0].click();
        }
    }

    scrollIntoView(elem, pozition, px){
        console.log(elem.offsetTop, elem.offsetHeight, this.content.nativeElement.scrollTop, this.content.nativeElement.offsetHeight);
        let offset = (elem.offsetTop + elem.offsetHeight) - this.content.nativeElement.scrollTop;
        if(offset > this.content.nativeElement.offsetHeight || elem.offsetTop < this.content.nativeElement.scrollTop) {
            elem.scrollIntoView(pozition);
            this.content.nativeElement.scrollTop = this.content.nativeElement.scrollTop + px;
        }
    }
}