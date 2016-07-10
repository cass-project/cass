import {Component, Input, ViewChild, ElementRef} from "angular2/core";

import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {CurrentProfileService} from "../../../../profile/service/CurrentProfileService";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {PostRESTService} from "../../../service/PostRESTService";
import {CreatePostRequest} from "../../../definitions/paths/create";
import {PostTypeEntity} from "../../../definitions/entity/PostType";
import {PostAttachmentRESTService} from "../../../../post-attachment/service/PostAttachmentRESTService";
import {PostAttachmentEntity} from "../../../../post-attachment/definitions/entity/PostAttachment";
import {OpenGraphRESTService} from "../../../../opengraph/service/OpenGraphRESTService";
import {PostFormLinkInput} from "../PostFormLinkInputComponent/index";
import {FileAttachment} from "../../../../post-attachment/definitions/entity/attachment/FileAttachment";
import {LinkAttachment} from "../../../../post-attachment/definitions/entity/attachment/LinkAttachment";
import {YouTubeLinkAttachment} from "../../../../post-attachment/definitions/entity/attachment/YouTubeLinkAttachment";

@Component({
    selector: 'cass-post-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProgressLock,
        PostFormLinkInput,
    ]
})
export class PostForm
{
    static DEFAULT_POST_TYPE = 'default';

    @Input('post-type') postType: PostTypeEntity;
    @Input('collection') collection: CollectionEntity;

    @ViewChild('contentTextArea') contentTextArea: ElementRef;

    private status: LoadingStatus[] = [];
    private model: PostFormModel;
    private focused: boolean = false;

    constructor(
        private profile: CurrentProfileService,
        private service: PostRESTService,
        private attachments: PostAttachmentRESTService,
        private og: OpenGraphRESTService
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
                    this.contentTextArea.nativeElement.focus();
                    this.focused = true;

                    status.loading = false;
                },
                (error) => {
                    status.loading = false;
                }
            );
        }
    }

    isLoading(): boolean {
        return this.status.filter((input: LoadingStatus) => {
            return input.loading === true;
        }).length > 0;
    }

    isExtended(): boolean {
        let testIsModelEmpty = this.model.isEmpty();
        let testIsFocused = this.focused;
        let testIsLoading = this.isLoading();

        return !testIsModelEmpty || testIsFocused || testIsLoading;
    }

    cancel() {
        this.model.reset();
        this.focused = false;
        this.contentTextArea.nativeElement.blur();
    }

    focus() {
        this.focused = true;
    }

    blur() {
        this.focused = false;
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

    deleteAttachments() {
        this.model.deleteAttachments();

        if(this.model.isEmpty()) {
            this.cancel();
        }
    }
}

class PostFormModel
{
    public content: string = '';
    public attachments: PostAttachmentEntity<FileAttachment>[] = [];
    public links: PostAttachmentEntity<LinkAttachment|YouTubeLinkAttachment>[] = [];

    constructor(
        public postType: number,
        public profileId: number,
        public collectionId: number
    ) {}

    createRequest(): CreatePostRequest {
        // ...
        return {
            post_type: this.postType,
            profile_id: this.profileId,
            collection_id: this.collectionId,
            content: this.content,
            attachments: this.attachments.map((attachment) => {
                return attachment.id;
            }),
            links: []
        }
    }

    reset() {
        this.content = '';
        this.deleteAttachments();
    }

    isEmpty(): boolean {
        let testHasContent = this.content.length > 0;
        let testHasLinks = this.links.length > 0;
        let testHasAttachments = this.attachments.length > 0;

        return ! (testHasContent || testHasLinks || testHasAttachments);
    }

    isValid(): boolean {
        return ! this.isEmpty();
    }

    hasAttachments(): boolean
    {
        return this.links.length > 0 || this.attachments.length > 0;
    }

    getAllAttachments(): PostAttachmentEntity<any>[]
    {
        if(this.links.length) {
            return this.links;
        }else if(this.attachments.length) {
            return this.attachments;
        }else{
            return [];
        }
    }

    attachLink(link: PostAttachmentEntity<LinkAttachment | YouTubeLinkAttachment>) {
        console.log('attached', link);

        this.links = [];
        this.links.push(link);
    }

    detachLink() {
        this.links = [];
    }

    deleteAttachments() {
        this.attachments = [];
        this.links = [];
    }
}

class LoadingStatus
{
    public loading: boolean = true;
}