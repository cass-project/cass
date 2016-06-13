import {Injectable} from "angular2/core";
import {ModalControl} from "../util/classes/ModalControl";

@Injectable()
export class CommunityComponentService
{
    public modals: {
        route: ModalControl,
        join: ModalControl,
        create: ModalControl
        settings: ModalControl
    } = {
        route: new ModalControl(),
        join: new ModalControl(),
        create: new ModalControl(),
        settings: new ModalControl()
    };
}