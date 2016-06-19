import {Component, Input, Output, EventEmitter} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ColorPicker} from "../../../util/component/ColorPicker/index";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {ScreenControls} from "../../../util/classes/ScreenControls";
import {CollectionRESTService} from "../../service/CollectionRESTService";
import {Collection} from "../entity/Collection";

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
    @Input ('owner_profile_id') owner_profile_id: string;
    @Input ('owner_community_id') owner_community_id: string;
    @Output('complete') complete = new EventEmitter<Collection>();
    @Output('error') error = new EventEmitter();

    collection : Collection = {
        author_profile_id: this.owner_profile_id,
        owner_community_id: this.owner_community_id,
        title: '',
        description: '',
        theme_ids: [],
        theme: {has: false},
        image: {small: {public_path: '/dist/assets/community/community-default.png'}}
    };


    checkFields(){
        if(this.collection.theme.has){
            return this.collection.theme_ids.length > 0;
        } else return this.collection.title.length > 0;
    };

    create(){
        if(this._for === 'profile') {
            this.collection.author_profile_id = this.owner_profile_id;
            this.collectionRESTService.profileCreateCollection(this.collection).subscribe(data => {
                    this.complete.emit(this.collection);
                },
                err => {
                    this.error.emit(err);
                    console.log(err);
                });
        } else if(this._for === 'community'){
            this.collection.author_profile_id = this.owner_profile_id;
            this.collection.owner_community_id = this.owner_community_id;
            this.collectionRESTService.communityCreateCollection(this.collection).subscribe(data => {
                    this.complete.emit(this.collection);
                },
                err => {
                    this.error.emit(err);
                    console.log(err);
                });
        }
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