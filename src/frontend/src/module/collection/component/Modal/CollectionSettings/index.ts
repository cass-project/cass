import {Component, Input} from "@angular/core";
import {ModalControl} from "../../../../common/classes/ModalControl";
import {CollectionRESTService} from "../../../service/CollectionRESTService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-collection-settings'})
export class CollectionSettings
{

    @Input('collection') collection;

    private deleteProcessVisible: boolean = false;

    constructor(private collectionRESTService: CollectionRESTService) {
    }

    avatarDeletingProcess(){
        this.deleteProcessVisible = true;
        this.collectionRESTService.deleteImageCollection(this.collection.id).subscribe(data => {
            /*this.collection.image = TODO: set default image*/
            this.deleteProcessVisible = false;
        });
    }


    private deleteModal: ModalControl = new ModalControl();

    requestDeleteCollection() {
        this.deleteModal.open();
    }
}