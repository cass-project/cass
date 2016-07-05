import {Component, Input, Output, EventEmitter} from "angular2/core";

import {ModalComponent} from "../../../../modal/component/index";
import {ThemeSelect} from "../../../../theme/component/ThemeSelect/index";
import {CollectionRESTService} from "../../../service/CollectionRESTService";
import {CollectionEntity, Collection} from "../../../definitions/entity/collection";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ColorPicker} from "../../../../form/component/ColorPicker/index";
import {ScreenControls} from "../../../../util/classes/ScreenControls";

enum CreateCollectionMasterStage
{
    Common = <any>"Common",
    Options = <any>"Options",
}

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    selector: "cass-collection-create-master",
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ColorPicker,
        ThemeSelect,
    ]
})
export class CollectionCreateMaster
{
    constructor(private collectionRESTService: CollectionRESTService) {
        this.collection = new Collection(this.ownerType, this.ownerId);
    }

    private screens: ScreenControls<CreateCollectionMasterStage> = new ScreenControls<CreateCollectionMasterStage>(CreateCollectionMasterStage.Common, (sc) => {
        sc.add({ from: CreateCollectionMasterStage.Common, to: CreateCollectionMasterStage.Options });
    });

    @Input ('for') ownerType: any;
    @Input ('for_id') ownerId: string;
    @Output('complete') complete = new EventEmitter<CollectionEntity>();
    @Output('error') error = new EventEmitter();
    
    collection: Collection;
    hasThemeIds: boolean = true;
    


    checkFields() {
        return this.collection.theme_ids.length;
    };

    create(){
        // TODO: this.collectionRESTService.create(this.collection);
    };

    private buttons = new Buttons(this.screens);
}

class Buttons {
    constructor(private screens: ScreenControls<CreateCollectionMasterStage>) {}

    isBackButtonAvailable() {
        return this.screens.isIn([
            CreateCollectionMasterStage.Options
        ]);
    };

    isFinish() {
        return this.screens.isIn([
            CreateCollectionMasterStage.Options
        ]);
    };
}