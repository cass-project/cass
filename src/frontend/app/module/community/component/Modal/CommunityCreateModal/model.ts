import {Injectable} from "angular2/core";

@Injectable()
export class CommunityCreateModalModel
{
    title: string = '';
    description: string = '';
    theme_ids: Array<number> = [];
}