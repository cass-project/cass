import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ModalComponent} from "../../../../modal/component/index";
import {ThemeSelect} from "../../../../theme/component/ThemeSelect/index";
import {CollectionRESTService} from "../../../service/CollectionRESTService";
import {CollectionEntity, Collection} from "../../../definitions/entity/collection";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ScreenControls} from "../../../../common/classes/ScreenControls";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {Router} from '@angular/router-deprecated';
import {Session} from "../../../../session/Session";

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
        ThemeSelect,
        ProgressLock
    ]
})
export class CollectionCreateMaster
{
    constructor(
        private collectionRESTService: CollectionRESTService,
        private session: Session,
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
    }


    create(){
        if(this.ownerType === 'profile'){
            this.createForProfile();
        } else if(this.ownerType === 'community'){
            this.createForCommunity();
        }
    }

    createForCommunity(){
        //TODO: When community frontend will be completed, implement this method
    }

    createForProfile() {
        this.loading = true;

        this.collectionRESTService.createCollection(this.collection).subscribe(
            (data) => {
                let profileId;
                if(data.entity.owner.id === this.session.getCurrentProfile().getId().toString()){
                    profileId = 'current';
                } else {
                    profileId = data.entity.owner.id;
                }
                this.loading = false;
                this.session.getCurrentProfile().entity.collections.push(data.entity);
                this.messages.push(MessageBusNotificationsLevel.Info, `Создана коллекция "${data.entity.title}"`);
                this.router.navigate(['Profile/Profile', {id: profileId}, 'Collections/View', { sid: data.entity.sid }]);
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