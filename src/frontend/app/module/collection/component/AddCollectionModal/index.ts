import {Component, Injectable, ViewEncapsulation} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {ThemeService, ThemeSelect} from "../../../theme/service/ThemeService";
import {FormSubmittingIndicator} from "../../../common/component/FormSubmittingIndicator/index";
import {CollectionRESTService} from "../../service/CollectionRESTService";
import {AuthService} from "../../../auth/service/AuthService";
import {CollectionService} from "../../service/CollectionService";
import {Router} from "angular2/router";

@Injectable()
export class AddCollectionModalService
{
    requested: boolean = false;

    isOpen() {
        return this.requested;
    }

    open() {
        this.requested = true;
    }

    close() {
        this.requested = false;
    }
}

@Component({
    selector: 'collection-add-modal',
    template: require('./template.html'),
    providers: [
        CollectionRESTService,
        CORE_DIRECTIVES
    ],
    directives: [
        FormSubmittingIndicator
    ],
    encapsulation: ViewEncapsulation.None
})
export class AddCollectionModal
{
    stage: Stage = Stage.Title;
    themes: ThemeSelect[];
    model: AddCollectionModel = new AddCollectionModel();

    constructor(
        private service: AddCollectionModalService,
        private themes: ThemeService,
        private collectionService: CollectionService,
        private collectionREST: CollectionRESTService,
        private authService: AuthService,
        private router: Router
    ) {
        this.themes = themes.getThemeSelectOptions();
    }

    isTitleStage() {
        return this.stage === Stage.Title;
    }

    isThemesStage() {
        return this.stage === Stage.Themes;
    }

    isSubmittingStage() {
        return this.stage === Stage.Submitting;
    }

    ngSubmit() {
        if(this.stage === Stage.Title) {
            this.stage = Stage.Themes;
        }else if(this.stage === Stage.Themes) {
            this.stage = Stage.Submitting;
            this.submit();
        }else{
            throw new Error('Unknown stage');
        }
    }

    submitTitle() {
        return this.stage === Stage.Themes
            ? 'Create collection'
            : 'Next';
    }

    modalRequested() {
        return this.service.isOpen();
    }

    submit() {
        let profileId = this.authService.getAuthToken().getCurrentProfile().getId();
        let themeId = parseInt(this.model.themeId ? this.model.themeId : 0, 10);

        let body = {
            parent_id: 0,
            theme_id: themeId,
            title: this.model.title,
            description: this.model.description
        };

        this.collectionREST.putCreate(profileId, body).map(res => res.json()).subscribe(
            response => {
                this.collectionService.collections.push(response.entity);
                this.router.navigate(['/Profile/Collections/View', { collectionId: response.entity.id }]);
                this.close();
            },
            error => {
                this.popupEror(error);
                this.close();
            },
            () => {
                this.close();
            }
        );
    }

    popupEror(message: string) {
        alert(message);
    }

    close() {
        this.service.close();
    }
}

class AddCollectionModel
{
    title: string = '';
    description: string = '';
    themeId: any = 0;
    parentId: number = 0;
}

enum Stage {
    Title,
    Themes,
    Submitting
}