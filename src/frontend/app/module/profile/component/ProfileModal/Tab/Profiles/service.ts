import {Injectable} from "angular2/core";

@Injectable()
export class ProfilesTabService
{
    private modalSwitchActive: boolean = false;
    private modalDeleteActive: boolean = false;

    isModalSwitchProfileActive(): boolean {
        return this.modalSwitchActive;
    }

    isModalDeleteProfileActive(): boolean {
        return this.modalDeleteActive;
    }
}