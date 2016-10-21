import {Injectable} from "@angular/core";
import {Observable, Observer} from "rxjs/Rx";

import {ViewOption, ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";

@Injectable()
export class ViewOptionService
{
    static LOCAL_STORAGE_KEY = 'cass.module.public.view-option';

    public option: ViewOption = new ViewOption();

    public viewMode: Observable<any>;
    public viewModeObserver: Observer<any>;

    constructor() {
        if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY]) {
            this.option.setAsCurrent(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY]);
        } else {
            window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] = 'grid'
        }

        this.viewMode = Observable.create(observer => {
            this.viewModeObserver = observer;
        }).publish().refCount()
    }

    switchTo(value: ViewOptionValue) {
        window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] = value;
        this.viewModeObserver.next(value);
        this.option.setAsCurrent(value);
    }
    

    isOn(value: ViewOptionValue) {
        return this.option.isOn(value);
    }
}