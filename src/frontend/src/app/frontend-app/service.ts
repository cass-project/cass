import {Injectable, ElementRef} from "angular2/core";
import {Observable} from "rxjs/Observable";
import {Observer} from "rxjs/Observer";
import {ProfileModals} from "../../module/profile/modals";

@Injectable()
export class AppService {
    content: ElementRef;
    
    public scrollObservable: Observable<ContainerScrollEvent>;
    private scrollObserver: Observer<ContainerScrollEvent>;
    
    constructor(private modals: ProfileModals){
        this.scrollObservable = Observable.create(observer => {
            this.scrollObserver = observer;
        })
    }
    

    authDevModal($event){
        console.log($event);
        this.modals.authDev.open();
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