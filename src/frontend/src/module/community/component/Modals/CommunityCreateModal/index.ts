import {Component, EventEmitter, Output} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {CommunityCreateModalModel} from "./model";
import {ScreenControls} from "../../../../common/classes/ScreenControls";
import {AuthService} from "../../../../auth/service/AuthService";
import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";
import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
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
    ]
})
export class CommunityCreateModal
{
    constructor(
        private model: CommunityCreateModalModel,
        private authService: AuthService,
        private communityRESTService: CommunityRESTService,
        private notifier: CommunityCreateModalNotifier
    ) {}

    @Output('success') successEvent = new EventEmitter<CommunityExtendedEntity>();
    @Output('close') closeEvent = new EventEmitter<CommunityCreateModal>();

    private loading: LoadingManager = new LoadingManager();

    public screens: ScreenControls<CreateStage> = new ScreenControls<CreateStage>(CreateStage.General, (sc: ScreenControls<CreateStage>) => {
        sc.add({ from: CreateStage.General, to: CreateStage.Features });
    });

    ngOnInit() {
        if(! this.authService.isSignedIn()) {
            this.closeEvent.emit(this);
        }
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

interface LoadingStatus { is: boolean; }