import {Injectable} from "@angular/core";

import {ViewOption} from "./FeedService/options/ViewOption";
import {ViewOptionService} from "../../public/component/Options/ViewOption/service";

@Injectable()
export class FeedOptionsService
{
    public view: ViewOption;

    constructor(private service: ViewOptionService) {
        this.view = service.option;
    }
}