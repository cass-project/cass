import {Injectable} from "angular2/core";

@Injectable()
export class ProfileModalModel
{
    hasChanges(): boolean {
        return false;
    }
}