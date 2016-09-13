import {Component, Input, ViewChild, ElementRef, EventEmitter, Output, Directive} from "@angular/core";

import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {PostRESTService} from "../../../service/PostRESTService";
import {PostTypeEntity} from "../../../definitions/entity/PostType";
import {PostAttachmentRESTService} from "../../../../post-attachment/service/PostAttachmentRESTService";
import {PostFormLinkInput} from "../PostFormLinkInputComponent/index";
import {PostAttachment} from "../../../../post-attachment/component/Elements/PostAttachment/index";
import {PostEntity} from "../../../definitions/entity/Post";
import {Session} from "../../../../session/Session";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
import {PostFormModel} from "./model";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-post-form'})

export class PostForm
{
    static DEFAULT_POST_TYPE = 'default';

    @Input('post-type') postType: PostTypeEntity;
    @Input('collection') collection: CollectionEntity;
    
    @Output('success') successEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    @ViewChild('contentTextArea') contentTextArea: ElementRef;

    private status: LoadingManager = new LoadingManager();
    private model: PostFormModel;
    private focused: boolean = false;
    private linkRequested: boolean = false;

    constructor(
        private session: Session,
        private service: PostRESTService,
        private attachments: PostAttachmentRESTService
    ) {}

    ngOnInit() {
        this.model = new PostFormModel(
            this.postType.int,
            this.session.getCurrentProfile().getId(),
            this.collection.id
        );
    }

    onFileChange($event) {
        let files: FileList = $event.target.files;

        if(files.length > 0) {
            let file = files[0];
            let status = this.status.addLoading();
            
            this.attachments.upload(file).subscribe(
                (response) => {
                    this.model.attachments.push(response.entity);
                    this.contentTextArea.nativeElement.focus();
                    this.focused = true;

                    status.is = false;
                },
                (error) => {
                    status.is = false;
                }
            );
        }
    }

    isLoading(): boolean {
        return this.status.isLoading();
    }

    isExtended(): boolean {
        let testIsModelEmpty = this.model.isEmpty();
        let testIsFocused = this.focused;
        let testIsLoading = this.isLoading();

        return !testIsModelEmpty || testIsFocused || testIsLoading;
    }

    requestLinkBox() {
        this.linkRequested = true;
    }

    isLinkBoxRequested(): boolean {
        return this.linkRequested && ! this.hasAttachments();
    }

    cancel() {
        this.reset();
    }

    focus() {
        this.focused = true;
    }

    blur() {
        this.focused = false;
    }

    submit() {
        var status = this.status.addLoading();
        
        this.service.createPost(this.model.createRequest()).subscribe(
            (response) => {
                status.is = false;
                this.successEvent.emit(response.entity);
                this.reset();
            },
            (error) => {
                status.is = false;
            }
        )
    }

    reset() {
        this.model.reset();
        this.focused = false;
        this.linkRequested = false;
        this.contentTextArea.nativeElement.blur();
    }

    hasAttachments(): boolean {
        return this.model.attachments.length > 0;
    }

    deleteAttachments() {
        this.model.deleteAttachments();
        this.linkRequested = false;

        if(this.model.isEmpty()) {
            this.cancel();
        }
    }
}