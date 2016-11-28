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
    @Output('close') close: EventEmitter<boolean> = new EventEmitter<boolean>();
    @Output('submitEdit') submitEdit: EventEmitter<number> = new EventEmitter<number>();

    private model: PostFormModel = new PostFormModel(undefined, undefined, undefined);
    private status: LoadingManager = new LoadingManager();

    constructor(
        private session: Session,
        private service: PostRESTService,
        private attachments: AttachmentRESTService
    ) {}


    ngOnInit(){
        this.initPost();
    }

    initPost(){
        if(this.post.title.has){
            this.model.title = this.post.title.value;
        }
        if(this.post.attachments.length > 0){
            this.model.attachments = JSON.parse(JSON.stringify(this.post.attachments));
        }

        this.model.content = this.post.content;
    }

    getStyle(){
        if(!this.haveAttachment()){
            return {'width': '100%'};
        }
    }

    haveAttachment(){
        return this.post.attachments.length > 0;
    }


    deleteAttachments() {
        this.model.deleteAttachments();

        if(this.model.isEmpty()) {
            this.initPost();
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

    closeModal(){
        this.close.emit(true);
    }

}
