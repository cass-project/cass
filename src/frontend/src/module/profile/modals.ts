import {Injectable} from "@angular/core";
import {ModalControl} from "../common/classes/ModalControl";

@Injectable()
export class ProfileModals
{
    setup: ModalControl = new ModalControl();
    settings: ModalControl = new ModalControl();
    switcher: ModalControl = new ModalControl();
    interests: ModalControl = new ModalControl();
    createCollection: ModalControl = new ModalControl();
}