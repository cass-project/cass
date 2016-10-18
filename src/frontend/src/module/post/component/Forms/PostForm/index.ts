var autosize = require("autosize");

import {Component, Input, ViewChild, ElementRef, EventEmitter, Output, OnInit, AfterViewInit} from "@angular/core";

import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {PostRESTService} from "../../../service/PostRESTService";
import {PostTypeEntity} from "../../../definitions/entity/PostType";
import {PostEntity} from "../../../definitions/entity/Post";
import {Session} from "../../../../session/Session";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
import {PostFormModel} from "./model";
import {AttachmentRESTService} from "../../../../attachment/service/AttachmentRESTService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-post-form'})

export class PostForm implements OnInit, AfterViewInit
{
    static DEFAULT_POST_TYPE = 'default';

    @Input('post-type') postType: PostTypeEntity;
    @Input('collection') collection: CollectionEntity;
    @Input('force-theme-id') forceThemeId: number;
    @Output('success') successEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    @ViewChild('contentTextArea') contentTextArea: ElementRef;
    @ViewChild('titleTextArea') titleTextArea: ElementRef;

    private status: LoadingManager = new LoadingManager();
    private model: PostFormModel;
    private focused: boolean = false;
    private linkRequested: boolean = false;

    constructor(
        private session: Session,
        private service: PostRESTService,
        private attachments: AttachmentRESTService
    ) {}

    ngOnInit() {
        let collectionId: number;

        if(this.forceThemeId){
            collectionId = this.forceThemeId;
        } else {
            collectionId = this.collection.id;
        }

        this.model = new PostFormModel(
            this.postType.int,
            this.session.getCurrentProfile().getId(),
            collectionId
        );
    }

    ngAfterViewInit() {
        autosize(this.contentTextArea.nativeElement);
        autosize(this.titleTextArea.nativeElement);
    }

    onFileChange($event) {
        let files: FileList = $event.target.files;

        if(files.length > 0) {
            let file = files[0];
            let status = this.status.addLoading();
            
            this.attachments.upload(file).subscribe(
                (response) => {
                    this.model.addAttachment(response.entity);

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

    focusTitleBox() {
        this.titleTextArea.nativeElement.focus();
        this.focus();
    }

    filterTitle() {
        this.model.title = this.model.title.replace(/(\r\n|\n|\r)/gm,"");
    }

    blur() {
        this.focused = false;
    }

    submit() {
        var status = this.status.addLoading();
        var request = this.model.createRequest();
        request.content = this.model.createRequest().content;


        this.service.createPost(request).subscribe(
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
        this.focused = false; ``;
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