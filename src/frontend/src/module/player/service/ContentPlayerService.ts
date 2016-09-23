import {Injectable} from "@angular/core";

@Injectable()
export class ContentPlayerService
{
    private enabled: boolean = false;
    private visible: boolean = false;

    toggle() {
        this.enabled = !this.enabled;
    }

    isEnabled(): boolean {
        return this.enabled;
    }

    shouldBeVisible(): boolean {
        return this.visible;
    }
}