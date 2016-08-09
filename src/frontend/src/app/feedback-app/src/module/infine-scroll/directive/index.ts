import {Directive, Output, EventEmitter, ElementRef, HostListener, Input} from '@angular/core';

@Directive({
    selector: '[infinite-scroll]',
    host: {
        '(window:scroll)': 'onScroll()'
    }
})

export class InfiniteScrollDirective {

    @Output('onScrolled') scrolled = new EventEmitter<InfiniteScrollDirective>();
    @Input('isInfineScrollActive') isInfineScrollActive: boolean;
    private container:scrollParams;
    private child:scrollParams;
    
    constructor(private element: ElementRef) {}
    
    ngOnInit(){
        //window.addEventListener('scroll', ($event) => this.onScroll($event))
    }
    
    onScroll($event) {
        this.container = {
            offsetTop: window.pageYOffset,
            height: document.body.clientHeight,
            offsetBottom: window.pageYOffset + document.body.clientHeight
        };
        
        this.child = {
            offsetTop: this.element.nativeElement.offsetTop,
            height: this.element.nativeElement.offsetHeight,
            offsetBottom: this.element.nativeElement.offsetTop + this.element.nativeElement.offsetHeight
        };
        
        if(this.container.offsetBottom > this.child.offsetBottom - 100 && this.isInfineScrollActive){
            this.scrolled.emit(this);
        }
    }
    
    onScrollDown() {
        this.scrolled.emit(this);
    }
}

export interface scrollParams
{
    offsetTop:number;
    offsetBottom:number;
    height:number;
}