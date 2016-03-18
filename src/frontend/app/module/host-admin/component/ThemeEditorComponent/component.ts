import {Component} from 'angular2/core';
import {ThemeRESTService} from '../../../theme/service/ThemeRESTService';
import {ThemeEditorService} from '../../service/ThemeEditorService';
import {ThemeTree} from '../../../theme/Theme';
import {ThemeTreeComponent} from '../ThemeTreeComponent/component';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CreateThemeForm} from '../../form/CreateThemeForm/component';
import {ThemeCleaner} from '../../component/ThemeCleaner/component'
import {UpdateThemeForm} from '../../form/UpdateThemeForm/component';
import {CreationFormPost} from  '../../form/CreationFormPost/component';



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
        name: 'Theme-Cleaner',
        component: ThemeCleaner
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
        public  themeEditorService: ThemeEditorService,
        public router: Router
    ) {}

    ngOnInit() {
        this.themeRESTService.getThemes()
            .map(res => res.json())
            .subscribe(data => {this.themeEditorService.themes = data['entities']
            });
        this.themeRESTService.getThemesTree()
            .map(res => res.json())
            .subscribe(data => {
                this.themeEditorService.themesTree = data['entities'];
        });
    }

    //deleteTheme(){
    //    this.themeRESTService.deleteTheme(this.themeEditorService.selectedThemeId);
    //    this.themeRESTService.getThemesTree().map(res => res.json()).subscribe(data => this.themeEditorService.themesTree = data['entities']);
    //    this.router.navigate(['Theme-Cleaner']);
    //}
    //
    //openCreatePostForm(){
    //    this.openFormContentBox();
    //    this.router.navigate(['Creation-Form-Post']);
    //}
    //
    openCreateThemeForm() {
        this.openFormContentBox();
        this.router.navigate(['Theme-Editor-Create']);
    }
    //
    //openUpdateThemeForm(){
    //    this.openFormContentBox();
    //    this.router.navigate(['Theme-Editor-Update']);
    //}
    //
    //returnTheme(id){
    //    this.themeRESTService.getThemeById(id);
    //}
    //
    openFormContentBox() {
        this.themeEditorService.showFormContentBox = true;
    }

    clearSelection(){
        if(this.themeEditorService.selectedThemeId){
           this.themeEditorService.clear();
            console.log(this.themeEditorService.selectedThemeId);
        }
    }
}