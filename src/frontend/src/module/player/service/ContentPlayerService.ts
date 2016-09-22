import {Injectable} from "@angular/core";

@Injectable()
export class ContentPlayerService
{
    private enabled: boolean = false;

    isEnabled(): boolean {
        return this.enabled;
    }
}