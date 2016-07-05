import {Component, Input} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {TAB_MODAL_DIRECTIVES} from "../../../form/component/TabModal/index";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {CollectionImage} from "../../../collection/component/Elements/CollectionImage/index";
import {DeleteCollectionModal} from "../../../collection/component/Modal/DeleteCollectionModal/index";
import {ModalControl} from "../../../util/classes/ModalControl";
import {CollectionRESTService} from "../../service/CollectionRESTService";
import {ColorPicker} from "../../../form/component/ColorPicker/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    selector: "cass-collection-settings",
    directives: [
        ModalComponent,
        ModalBoxComponent,
        TAB_MODAL_DIRECTIVES,
        ColorPicker,
        ThemeSelect,
        CollectionImage,
        DeleteCollectionModal,
    ]
})
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