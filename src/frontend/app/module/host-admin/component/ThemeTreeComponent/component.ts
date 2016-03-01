import {ThemeTree} from '../../../theme/Theme';
import {ThemeEditorService} from '../../service/ThemeEditorService';
import {Component, Input} from 'angular2/core';
import {CORE_DIRECTIVES} from 'angular2/common';

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

    constructor(public themeEditorService: ThemeEditorService) {}

    select(theme: ThemeTree) {
        this.themeEditorService.selectThemeId(theme.id);
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
}