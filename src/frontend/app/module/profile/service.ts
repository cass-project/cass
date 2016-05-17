import {Injectable} from "angular2/core";

@Injectable()
export class ProfileComponentService
{
    public modals: {
        setup: SetupModal,
        settings: SettingsModal,
        switcher: SwitchProfileModal
    } = {
        setup: new SetupModal(),
        settings: new SettingsModal(),
        switcher: new SwitchProfileModal(),
    };
}

class Modal
{
    isActiveFlag: boolean = false;

    open() {
        this.isActiveFlag = true;
    }

    close() {
        this.isActiveFlag = false;
    }

    isActive() {
        return this.isActiveFlag;
    }
}

class SetupModal extends Modal {}
class SettingsModal extends Modal {}
class SwitchProfileModal extends Modal {}