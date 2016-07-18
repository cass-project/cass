import {Injectable} from "angular2/core";

import {ModalControl} from "../util/classes/ModalControl";

@Injectable()
export class CommunityModals
{
    settings: ModalControl = new ModalControl();
    interests: ModalControl = new ModalControl();
    createCollection: ModalControl = new ModalControl();
}