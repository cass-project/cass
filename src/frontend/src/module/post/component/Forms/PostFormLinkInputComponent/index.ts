import {Component, EventEmitter, Output, ViewChild, ElementRef} from "angular2/core";

import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {PostAttachmentRESTService} from "../../../../post-attachment/service/PostAttachmentRESTService";
import {PostAttachmentEntity} from "../../../../post-attachment/definitions/entity/PostAttachment";

var validUrl = require('valid-url');

@Component({
    selector: 'cass-post-form-link-input',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProgressLock,
    ]
})
export class PostFormLinkInput
{
    static FADEOUT_TIME_SEC = 5;

    @ViewChild('urlInput') urlInput: ElementRef;

    @Output('cancel') cancelEvent = new EventEmitter<string>();
    @Output('detach-link') detachEvent = new EventEmitter<string>();
    @Output('attach-link') attachEvent: EventEmitter<PostAttachmentEntity<any>> = new EventEmitter<PostAttachmentEntity<any>>();

    private loading: boolean = false;
    private url: string = '';
    private error: string;
    private interval;
    private current: PostAttachmentEntity<any>;

    constructor(private service: PostAttachmentRESTService) {}

    ngAfterViewInit() {
        this.urlInput.nativeElement.focus();
    }

    private fetch() {
        if(this.loading) return;

        if(! this.url.length && this.current) {
            this.cancel();
        }
        
        setTimeout(() => {
            if (validUrl.isUri(this.url)) {
                this.loading = true;

                this.service.link(this.url).subscribe(
                    (response) => {
                        this.attach(response.entity);
                        this.loading = false;
                    },
                    (error) => {

                        this.displayError(this.service.parseError(error));
                        this.loading = false;
                    }
                );
            }else{
                this.displayError('То, что вы сюда вставили, не очень похоже на адрес веб-страницы');
            }
        }, 100);
    }
    
    private blur() {
        if (!this.loading && validUrl.isUri(this.url)) {
            this.fetch();
        }
    }

    private attach(attachment: PostAttachmentEntity<any>) {
        this.current = attachment;

        this.attachEvent.emit(this.current);
    }

    private detach() {
        this.current = undefined;
        this.detachEvent.emit('detach');
    }

    private cancel() {
        this.url = '';
        this.detach();
        this.cancelEvent.emit('cancel');
    }

    private displayError(message: string) {
        if(this.interval) {
            clearTimeout(this.interval)
        }

        this.error = message;

        this.interval = setTimeout(() => {
            this.error = undefined;
        }, 1000 * PostFormLinkInput.FADEOUT_TIME_SEC)
    }
}