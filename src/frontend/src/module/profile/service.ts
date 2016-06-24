import {Injectable} from "angular2/core";

@Injectable()
export class ProfileComponentService
{
    currentProfileCollections;
    currentCollection;

    updateCollections($event){
        this.currentProfileCollections.push($event);

        this.modals.createCollectionMaster.close();
    }

    public modals: {
        setup: SetupModal,
        settings: SettingsModal,
        switcher: SwitchProfileModal,
        createCollectionMaster: CreateCollectionMaster,
        collectionSettings: CollectionSettings
    } = {
        setup: new SetupModal(),
        settings: new SettingsModal(),
        switcher: new SwitchProfileModal(),
        createCollectionMaster: new CreateCollectionMaster(),
        collectionSettings: new CollectionSettings()
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
class CreateCollectionMaster extends Modal {}
class CollectionSettings extends Modal {}