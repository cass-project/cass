import {Component, Input, Output, EventEmitter} from "angular2/core";

import {ModalComponent} from "../../../../modal/component/index";
import {ThemeSelect} from "../../../../theme/component/ThemeSelect/index";
import {CollectionRESTService} from "../../../service/CollectionRESTService";
import {CollectionEntity, Collection} from "../../../definitions/entity/collection";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ColorPicker} from "../../../../form/component/ColorPicker/index";
import {ScreenControls} from "../../../../util/classes/ScreenControls";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {CurrentProfileService} from "../../../../profile/service/CurrentProfileService";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {Router} from "angular2/router";

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
        ProgressLock,
    ]
})
export class CollectionCreateMaster
{
    constructor(
        private collectionRESTService: CollectionRESTService,
        private currentProfileService: CurrentProfileService,
        private messages: MessageBusService,
        private router: Router
    ) {}

    private screens: ScreenControls<CreateCollectionMasterStage> = new ScreenControls<CreateCollectionMasterStage>(CreateCollectionMasterStage.Common, (sc) => {
        sc.add({ from: CreateCollectionMasterStage.Common, to: CreateCollectionMasterStage.Options });
    });

    @Input ('for') ownerType: string;
    @Input ('for_id') ownerId: string;
    @Output('complete') complete = new EventEmitter<CollectionEntity>();
    @Output('close') close = new EventEmitter<boolean>();
    @Output('error') error = new EventEmitter();
    
    private collection: Collection;
    private haveThemesSwitcher: boolean = false;
    private loading: boolean;

    cancel(){
        this.close.emit(true);
    }

    ngOnInit(){
        this.collection = new Collection(this.ownerType, this.ownerId);
    }


    checkFields() {
        return (this.collection.title.length > 0);
    };

    create() {
        this.loading = true;

        this.collectionRESTService.createCollection(this.collection).subscribe(
            (data) => {
                this.loading = false;
                this.currentProfileService.get().entity.collections.push(data.entity);
                this.messages.push(MessageBusNotificationsLevel.Info, `Создана коллекция "${data.entity}"`);
                this.close.emit(true);
            },
            (error) => {
                this.loading = false;
            }
        );
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