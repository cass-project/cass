import {Injectable} from "@angular/core";

import {ViewOption, ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";

@Injectable()
export class ViewOptionService
{
    static LOCAL_STORAGE_KEY = 'cass.module.public.view-option';

    public option: ViewOption = new ViewOption();

    constructor() {
        if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY]) {
            this.option.setAsCurrent(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY]);
        }
    }

    switchTo(value: ViewOptionValue) {
        window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] = value;
        this.option.setAsCurrent(value);
    }

    isOn(value: ViewOptionValue) {
        return this.option.isOn(value);
    }
}