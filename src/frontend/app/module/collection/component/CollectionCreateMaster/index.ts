import {Component, Input, Output, EventEmitter} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ColorPicker} from "../../../util/component/ColorPicker/index";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {ScreenControls} from "../../../util/classes/ScreenControls";
import {CollectionRESTService} from "../../service/CollectionRESTService";

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
    constructor(private collectionRESTService: CollectionRESTService){}

    private screens: ScreenControls<CreateCollectionMasterStage> = new ScreenControls<CreateCollectionMasterStage>(CreateCollectionMasterStage.Common, (sc) => {
        sc.add({ from: CreateCollectionMasterStage.Common, to: CreateCollectionMasterStage.Options });
    });

    @Input ('for') _for: any;
    @Input ('for_id') for_id: string;
    @Output('complete') complete = new EventEmitter();
    @Output('error') error = new EventEmitter();

    collection = {title: '', description: '', haveTheme: false, theme_id: []};


    checkFields(){
        if(this.collection.haveTheme){
            return this.collection.theme_id.length > 0;
        } else return this.collection.title.length > 0;
    }

    create(){
        if(this._for === 'profile') {
            this.collectionRESTService.profileCreateCollection(this.for_id, this.collection).subscribe(data => {
                    this.complete.emit(data);
                },
                err => {
                    this.error.emit(err);
                    console.log(err);
                });
        } else if(this._for === 'community'){
            this.collectionRESTService.communityCreateCollection(this.for_id, this.collection).subscribe(data => {
                    this.complete.emit(data);
                },
                err => {
                    this.error.emit(err);
                    console.log(err);
                });
        }
    }

    private buttons = new Buttons(this.screens);
}

class Buttons {
    constructor(private screens: ScreenControls<CreateCollectionMasterStage>) {}

    isBackButtonAvailable() {
        return this.screens.isIn([
            CreateCollectionMasterStage.Options
        ]);
    }

    isFinish() {
        return this.screens.isIn([
            CreateCollectionMasterStage.Options
        ]);
    }
}