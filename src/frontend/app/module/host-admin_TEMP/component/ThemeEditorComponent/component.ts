import {Component} from 'angular2/core';
import {ThemeRESTService} from '../../../theme/service/ThemeRESTService';
import {ThemeEditorService} from '../../service/ThemeEditorService';
import {ThemeTree} from '../../../theme/Theme';
import {ThemeTreeComponent} from '../ThemeTreeComponent/component';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CreateThemeForm} from '../../form/CreateThemeForm/component';
import {UpdateThemeForm} from '../../form/UpdateThemeForm/component';
import {RouterCleaner} from "../../../host-admin_TEMP/routerCleaner/component";
import {CreationFormPost} from "../../../post/form/CreationFormPost/component";



@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'directives': [
        ROUTER_DIRECTIVES,
        ThemeTreeComponent
    ],
    'providers': [
        ThemeRESTService,
        ThemeEditorService
    ]
})
@RouteConfig([
    {
        useAsDefault: true,
        path: '/',
        name: 'RouterCleaner',
        component: RouterCleaner
    },
    {

        path: '/create-theme',
        name: 'Theme-Editor-Create',
        component: CreateThemeForm
    },
    {
        path: '/update-theme',
        name: 'Theme-Editor-Update',
        component: UpdateThemeForm
    },
    {
        path: '/creation-form-post',
        name: 'Creation-Form-Post',
        component: CreationFormPost
    }
])
export class ThemeEditorComponent
{


    constructor(
        public themeRESTService: ThemeRESTService,
        public themeEditorService: ThemeEditorService,
        public router: Router
    ) {}

    ngOnInit() {
        this.themeRESTService.getThemes()
            .map(res => res.json())
            .subscribe(data => {this.themeEditorService.themes = data['entities'];
            });
        this.themeRESTService.getThemesTree()
            .map(res => res.json())
            .subscribe(data => {
                this.themeEditorService.themesTree = data['entities'];
        });
    }


    openCreateThemeForm() {
        this.themeEditorService.createFirstParent = true;
        this.router.navigate(['Theme-Editor-Create']);
    }

    clearSelection(){
        if(this.themeEditorService.selectedThemeId){
           this.themeEditorService.clear();
            console.log(this.themeEditorService.selectedThemeId);
        }
    }
}