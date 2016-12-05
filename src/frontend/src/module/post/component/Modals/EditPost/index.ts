import {Component, Input, Output, EventEmitter} from "@angular/core";
import {PostEntity} from "../../../definitions/entity/Post";
import {AttachmentRESTService} from "../../../../attachment/service/AttachmentRESTService";
import {PostRESTService} from "../../../service/PostRESTService";
import {Session} from "../../../../session/Session";
import {PostFormModel} from "../../Forms/PostForm/model";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
import { AttachmentEntity } from "../../../../attachment/definitions/entity/AttachmentEntity";


@Component({
    selector: 'cass-edit-post',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class EditPost
{
    @Input('post') post: PostEntity;
    @Input('force-theme-id') forceThemeId: number;
    @Output('close') close: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('submitEdit') submitEdit: EventEmitter<number> = new EventEmitter<number>();

    private model: PostFormModel;
    private status: LoadingManager = new LoadingManager();
    private linkRequested: boolean = false;

    constructor(
        private session: Session,
        private service: PostRESTService,
        private attachments: AttachmentRESTService
    ) {}


    ngOnInit(){
        this.initPost();
    }

    initPost(){
        this.model = new PostFormModel(
            this.post.post_type.int,
            this.session.getCurrentProfile().getId(),
            this.post.collection_id
        );

        if(this.post.title.has){
            this.model.title = this.post.title.value;
        }
        if(this.post.attachments.length > 0){
            this.model.attachments = JSON.parse(JSON.stringify(this.post.attachments));
        }

        this.model.content = this.post.content;
    }

    getStyle(){
        if(!this.hasAttachments()){
            return {'width': '100%'};
        }
    }

    onFileChange($event) {
        let files: FileList = $event.target.files;

        if(files.length > 0) {
            let file = files[0];
            let status = this.status.addLoading();

            this.attachments.upload(file).subscribe(
                (response) => {
                    this.model.addAttachment(response.entity);

                    status.is = false;
                },
                (error) => {
                    status.is = false;
                }
            );
        }
    }
    
    getAttachmentURL(): string{
        return this.model.attachments[0].link.url;
    }

    requestLinkBox() {
        this.linkRequested = true;
    }

    isLinkBoxRequested(): boolean {
        return this.linkRequested && ! this.hasAttachments();
    }

    hasAttachments(): boolean {
        return this.model.attachments.length > 0;
    }

    deleteAttachments() {
        this.model.deleteAttachments();
        this.linkRequested = false;

        if(this.model.isEmpty()) {
            this.initPost();
        }
    }
    
    closeModal(){
        this.close.emit(true);
    }

}
