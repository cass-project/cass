import {Injectable} from "angular2/core";
import {CriteriaManager} from "../feed/service/FeedService/criteria";

@Injectable()
export class PublicService
{
    public source: string;
    public criteria: CriteriaManager = new CriteriaManager();
}