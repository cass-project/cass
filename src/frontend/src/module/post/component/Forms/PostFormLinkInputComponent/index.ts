import {Component, EventEmitter, Output} from "angular2/core";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {OpenGraphRESTService} from "../../../../opengraph/service/OpenGraphRESTService";
import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";
import {PostAttachment} from "../../../../post-attachment/component/Elements/PostAttachment/index";

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
    
    @Output('cancel') cancelEvent = new EventEmitter<string>();
    @Output('detach-link') detachEvent = new EventEmitter<string>();
    @Output('attach-link') attachEvent: EventEmitter<PostAttachment> = new EventEmitter<PostAttachment>();

    private loading: boolean = false;
    private url: string = '';
    private error: string;
    private interval;
    private current: PostAttachment;

    constructor(private service: OpenGraphRESTService) {}

    private fetch() {
        if(this.loading) return;

        if(! this.url.length && this.current) {
            this.cancel();
        }
        
        setTimeout(() => {
            if (validUrl.isUri(this.url)) {
                this.loading = true;

                this.service.getOpenGraph(this.url).subscribe(
                    (response) => {
                        this.attach(this.url, response.entity);
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

    private attach(origURL: string, og: OpenGraphEntity) {
        this.current = {
            id: -1,
            is_attached_to_post: true,
            attachment_type: 'link',
            date_created_on: (new Date()).toDateString(),
            post_id: -1,
            sid: 'tmp-link',
            attachment: {
                url: origURL,
                metadata: {
                    og: og
                }
            }
        };

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