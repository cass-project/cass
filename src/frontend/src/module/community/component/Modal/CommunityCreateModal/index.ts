import {Component, EventEmitter, Output} from "@angular/core";

import {CommunityCreateModalModel} from "./model";

import {ScreenGeneral} from "./Screen/ScreenGeneral";
import {ScreenFeatures} from "./Screen/ScreenFeatures";

import {ModalComponent} from "../../../../modal/component";
import {ModalBoxComponent} from "../../../../modal/component/box";
import {ScreenControls} from "../../../../common/classes/ScreenControls";
import {AuthService} from "../../../../auth/service/AuthService";
import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";
import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
import {Observable} from "rxjs/Observable";
import {CommunityCreateModalNotifier} from "./notify";

enum CreateStage {
    General = <any>"General",
    Features = <any>"Features",
}

@Component({
    selector: 'cass-community-create-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityCreateModalModel,
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ScreenGeneral,
        ScreenFeatures,
        ProgressLock,
    ]
})

export class CommunityCreateModal
{
    private loading: LoadingManager = new LoadingManager();
    
    public screens: ScreenControls<CreateStage> = new ScreenControls<CreateStage>(CreateStage.General, (sc: ScreenControls<CreateStage>) => {
        sc.add({ from: CreateStage.General, to: CreateStage.Features });
    });

    @Output('success') successEvent = new EventEmitter<CommunityExtendedEntity>();
    @Output('close') closeEvent = new EventEmitter<CommunityCreateModal>();
    
    constructor(
        private model: CommunityCreateModalModel,
        private authService: AuthService,
        private communityRESTService: CommunityRESTService,
        private notifier: CommunityCreateModalNotifier
    ) {}

    ngOnInit() {
        if(! this.authService.isSignedIn()) {
            this.closeEvent.emit(this);
        }
    }

    isHeaderVisible() {
        return true;
    }

    next() {
        if(this.screens.current === CreateStage.Features) {
            this.submit();
        }else{
            this.screens.next();
        }
    }
    
    submit() {
        this.submitCreateCommunity().subscribe(
            response => {
                let status = this.loading.addLoading();
                let communityId = response.entity.community.id;
                let observables = [];

                for(let feature of this.model.features.filter(feature => feature.is_activated)) {
                    observables.push(this.communityRESTService.activateFeature({
                        communityId: communityId,
                        feature: feature.code
                    }));
                }

                Observable.forkJoin(observables).subscribe(
                    (success) => {
                        this.success(response.entity);
                        status.is = false;
                    } ,
                    (error) => {
                        this.success(response.entity);
                        status.is = false;
                    }
                );

                this.notifier.publish(response.entity);
            },
            error => {}
        );
    }
    
    private submitCreateCommunity() {
        let status = this.loading.addLoading();
        let observable = this.communityRESTService.create(this.model.createRequest());
        
        observable.subscribe(
            response => {
                status.is = false;
            },
            error => {
                status.is = false;
            }
        );
        
        return observable;
    }

    success(entity: CommunityExtendedEntity) {
        this.successEvent.emit(entity);
        this.close();
    }

    close() {
        this.closeEvent.emit(this);
    }
}