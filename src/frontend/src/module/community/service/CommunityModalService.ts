import {Injectable} from "@angular/core";
import {ModalControl} from "../../common/classes/ModalControl";

@Injectable()
export class CommunityModalService
{
    private themeId: number;

    public route: ModalControl = new ModalControl();
    public join: ModalControl = new ModalControl();
    public create: ModalControl = new ModalControl();

    public openCreateCommunityModal(themeId?: number) {
        this.themeId = themeId || undefined;
        this.create.open();
    }
}