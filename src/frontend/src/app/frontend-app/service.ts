import {Injectable, ElementRef} from "angular2/core";
import {Observable} from "rxjs/Observable";
import {Observer} from "rxjs/Observer";

@Injectable()
export class AppService {
    content: ElementRef;
    
    public scrollObservable: Observable<ContainerScrollEvent>;
    private scrollObserver: Observer<ContainerScrollEvent>;
    
    constructor(){
        this.scrollObservable = Observable.create(observer => {
            this.scrollObserver = observer;
        })
    }

    onScroll($event){
        if(this.content && this.scrollObserver) {
            this.scrollObserver.next({
                html: this.content.nativeElement
            })
        }
    }
}


interface ContainerScrollEvent
{
    html: ElementRef
}