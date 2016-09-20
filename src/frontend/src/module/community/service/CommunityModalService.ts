import {Injectable} from "@angular/core";
import {ModalControl} from "../../common/classes/ModalControl";

@Injectable()
export class CommunityModalService
{
    public route: ModalControl = new ModalControl();
    public join: ModalControl = new ModalControl();
    public create: ModalControl = new ModalControl();
}