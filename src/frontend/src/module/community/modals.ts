import {Injectable} from "@angular/core";
import {ModalControl} from "../common/classes/ModalControl";

@Injectable()
export class CommunityModals
{
    settings: ModalControl = new ModalControl();
    interests: ModalControl = new ModalControl();
    createCollection: ModalControl = new ModalControl();
}