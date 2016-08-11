import {Component, Output, EventEmitter} from "@angular/core";
import {Router} from "@angular/router-deprecated";

import {Session} from "../../../../session/Session";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ProfileCommunitiesRESTService} from "../../../../profile-communities/service/ProfileCommunitiesRESTService";
import {CommunityJoinModalNotifier} from "./notify";

@Component({
    selector: 'cass-community-join-modal',
    template: require('./template.jade'),
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProgressLock
    ]
})

export class CommunityJoinModal
{
    private loading: LoadingManager = new LoadingManager();
    private communitySID: string;
    @Output("close") closeEvent = new EventEmitter<CommunityJoinModal>();

    constructor(
        private profileCommunityRestService: ProfileCommunitiesRESTService,
        private session:Session,
        private router:Router,
        private notifier: CommunityJoinModalNotifier
    ) {
    }
    
    submit() {
        let status = this.loading.addLoading();
        let profileId = this.session.getCurrentProfile().getId();
        
        this.profileCommunityRestService.joinCommunity(profileId, this.communitySID).subscribe(
            data => {
                status.is = false;
                this.router.navigate(['/CommunityRoot', 'Community', { 'id': data.entity.community_id }]);
                this.notifier.publish(data.entity.community);
                this.close();
            },
            error => {
                status.is = false;
            }
        );
    }
    
    close() {
        this.closeEvent.emit(this);
    }
}