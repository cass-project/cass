import {Component} from 'angular2/core';
import {ThemeRESTService} from '../../../theme/service/ThemeRESTService';
import {ThemeEditorService} from '../../service/ThemeEditorService';
import {ThemeTree} from '../../../theme/Theme';
import {ThemeTreeComponent} from '../ThemeTreeComponent/component';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CreateThemeForm} from '../../form/CreateThemeForm/component';

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
        path: '/create-theme',
        name: 'Theme-Editor-Create',
        component: CreateThemeForm
    }
])
export class ThemeEditorComponent
{
    showFormContentBox: boolean = false;
    themesTree: ThemeTree[];

    constructor(
        private themeRESTService: ThemeRESTService,
        public themeEditorService: ThemeEditorService,
        private router: Router
    ) {}

    ngOnInit() {
        this.themeRESTService.getThemesTree()
            .map(res => res.json())
            .subscribe(data => {
                this.themesTree = data['entities'];
        });
    }

    getThemesTree() {
        return this.themesTree;
    }

    openCreateThemeForm() {
        this.openFormContentBox();
        this.router.navigate(['Theme-Editor-Create']);
    }

    openFormContentBox() {
        this.showFormContentBox = true;
    }

    closeFormContentBox() {
        this.showFormContentBox = false;
        this.router.navigate(['Theme-Editor']);
    }
}