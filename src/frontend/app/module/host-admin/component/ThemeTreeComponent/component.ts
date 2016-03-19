import {ThemeTree} from '../../../theme/Theme';
import {ThemeEditorService} from '../../service/ThemeEditorService';
import {Component, Input} from 'angular2/core';
import {CORE_DIRECTIVES} from 'angular2/common';
import {Theme} from "../../../theme/Theme";
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {ThemeRESTService} from '../../../theme/service/ThemeRESTService';

@Component({
    selector: 'theme-tree',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    directives: [
        CORE_DIRECTIVES,
        ThemeTreeComponent
    ]
})
export class ThemeTreeComponent
{
    @Input() public tree: ThemeTree[];

    constructor(public themeEditorService: ThemeEditorService,
                public themeRESTService: ThemeRESTService,
                public router: Router
    ) {}

    select(theme: ThemeTree) {
        this.themeEditorService.selectThemeId(theme.id);
        this.themeEditorService.theme = theme;
    }

    deleteTheme(){
        this.themeRESTService.deleteTheme(this.themeEditorService.selectedThemeId);
        this.themeRESTService.getThemesTree().map(res => res.json()).subscribe(data => this.themeEditorService.themesTree = data['entities']);
        this.router.navigate(['Theme-Cleaner']);
    }

    openCreatePostForm(){
        this.openFormContentBox();
        this.router.navigate(['Creation-Form-Post']);
    }

    openCreateThemeForm() {
        this.openFormContentBox();
        this.router.navigate(['Theme-Editor-Create']);
    }

    openUpdateThemeForm(){
        this.openFormContentBox();
        this.router.navigate(['Theme-Editor-Update']);
    }

    returnTheme(id){
        this.themeRESTService.getThemeById(id);
    }

    openFormContentBox() {
        this.themeEditorService.showFormContentBox = true;
    }

    isThemeSelected(theme: ThemeTree) {
        return this.themeEditorService.selectedThemeId == theme.id;
    }

    hasChildren(themeTree: ThemeTree): boolean {
        return themeTree.children.length > 0;
    }

    getChildren(themeTree: ThemeTree): ThemeTree[] {
        if(!this.hasChildren(themeTree)) {
            throw new Error('No children available');
        }

        return themeTree.children;
    }

    public toggle(theme:Theme) {
        theme.show=!theme.show;
    }
}