import {Component, Input} from "angular2/core";
import {AuthService} from "../../../../auth/service/AuthService";
import {PostRESTService} from "../service/PostRESTService";

interface PostFormModel {
    content: string;
}

interface PostFormView {
    sending: boolean;
    active: boolean;
}

@Component({
    selector: 'cass-post-form',
    template: require('./template.html'),
    providers: [
        PostRESTService
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostFormComponent
{
    @Input() collectionId: string;

    view: PostFormView = {
        sending: false,
        active: true
    };

    model: PostFormModel = {
        content: ''
    };

    constructor(private auth: AuthService, private service: PostRESTService) {}
    
    getComponentCSSClass() {
        let css = [];

        if(this.view.active) {
            css.push('active');
        }else{
            css.push('inactive');
        }

        return css.join(' ');
    }

    isSubmitAvailable() {
        let hasContent = (typeof this.model.content == "string") && (this.model.content.length > 0);
        let isNotLoading = this.view.sending == false;

        return hasContent && isNotLoading;
    }

    submit() {
        this.view.sending = true;

        let profileId = this.auth.getAuthToken().getCurrentProfile().getId();
        let request = {
            profile_id: profileId,
            collection_id: parseInt(this.collectionId, 10),
            content: this.model.content
        };

        this.service.create(request).subscribe(
            response => {
            },
            error => {
                alert(error);

                this.view.sending = false;
            },
            () => {
                this.view.active = false;
                this.view.sending = false;
                this.reset();
            }
        );
    }

    ngSubmit() {
        if(this.isSubmitAvailable()) {
            this.submit();
        }
    }

    reset() {
        this.model.content = '';
    }
}