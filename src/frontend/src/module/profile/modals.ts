import {Injectable} from "angular2/core";

import {ModalControl} from "../common/classes/ModalControl";

@Injectable()
export class ProfileModals
{
    authDev: ModalControl = new ModalControl();
    setup: ModalControl = new ModalControl();
    settings: ModalControl = new ModalControl();
    switcher: ModalControl = new ModalControl();
    interests: ModalControl = new ModalControl();
    createCollection: ModalControl = new ModalControl();
}