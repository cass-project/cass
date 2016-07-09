import {Component, Input} from "angular2/core";

import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {CurrentProfileService} from "../../../../profile/service/CurrentProfileService";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {PostRESTService} from "../../../service/PostRESTService";
import {CreatePostRequest} from "../../../definitions/paths/create";
import {PostTypeEntity} from "../../../definitions/entity/PostType";
import {FileAttachment} from "../../../../post-attachment/attachment/FileAttachment";
import {LinkAttachment} from "../../../../post-attachment/attachment/LinkAttachment";
import {PostAttachmentRESTService} from "../../../../post-attachment/service/PostAttachmentRESTService";

@Component({
    selector: 'cass-post-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProgressLock,
    ]
})
export class PostForm
{
    static DEFAULT_POST_TYPE = 'default';

    @Input('post-type') postType: PostTypeEntity;
    @Input('collection') collection: CollectionEntity;

    private status: LoadingStatus[] = [];
    private model: PostFormModel;

    constructor(
        private profile: CurrentProfileService,
        private service: PostRESTService,
        private attachments: PostAttachmentRESTService
    ) {}

    ngOnInit() {
        this.model = new PostFormModel(
            this.postType.int,
            this.profile.get().getId(),
            this.collection.id
        );
    }

    onFileChange($event) {
        let files: FileList = $event.target.files;

        if(files.length > 0) {
            let file = files[0];
            let status = new LoadingStatus();

            this.status.push(status);
            
            this.attachments.upload(file).subscribe(
                (response) => {
                    this.model.attachments.push(response.entity);
                    status.loading = false;
                },
                (error) => {
                    status.loading = false;
                }
            );
        }
    }

    isLoading() {
        return this.status.filter((input: LoadingStatus) => {
            return input.loading === true;
        }).length > 0;
    }

    submit() {
        var status = new LoadingStatus();

        this.status.push(status);
        this.service.createPost(this.model.createRequest()).subscribe(
            (response) => {
                status.loading = false;
                this.reset();
            },
            (error) => {
                status.loading = false;
            }
        )
    }

    reset() {
        this.model.reset();
    }

    hasAttachments(): boolean {
        return this.model.attachments.length > 0
            || this.model.links.length > 0;
    }
}

class PostFormModel
{
    public content: string = '';
    public attachments: FileAttachment[] = [];
    public links: LinkAttachment[] = [];

    constructor(
        public postType: number,
        public profileId: number,
        public collectionId: number
    ) {}

    reset() {
        this.content = '';
    }

    isValid(): boolean {
        let testHasContent = this.content.length > 0;
        let testHasLinks = this.links.length > 0;
        let testHasAttachments = this.attachments.length > 0;
        
        return testHasContent || testHasLinks || testHasAttachments;
    }

    createRequest(): CreatePostRequest {
        // ...
        return {
            post_type: this.postType,
            profile_id: this.profileId,
            collection_id: this.collectionId,
            content: this.content,
            attachments: [],
            links: []
        }
    }
}

class LoadingStatus
{
    public loading: boolean = true;
}