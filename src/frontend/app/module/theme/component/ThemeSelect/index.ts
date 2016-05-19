import {Component, EventEmitter,Output} from "angular2/core";
import {ThemeService} from "../../service/ThemeService";
import {Injectable} from 'angular2/core';
import {ProfileModalModel} from "../../../profile/component/ProfileModal/model";


@Component({
    selector: 'cass-theme-select',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Injectable()
export class ThemeSelect
{
    constructor(private themeService: ThemeService, private model: ProfileModalModel){}


    selectedTheme;


    searchStr: string = '';
    browserVisible: boolean = false;


    returnPickedThemesTitle(){
        let results = [];

        for(let i = 0; i < this.themeService.themes.length; i++){
            if(this.themeService.themes[i].id.indexOf(this.searchStr.toLowerCase())!=-1){
                results.push(this.themeService.themes[i])
            }
        }

        return results
    }


    returnZoneEx(){
        if(this.themeService.inExpertZone){
            return true;
        } return false;
    }

    returnZoneInt(){
        if(this.themeService.inInterestingZone){
           return true;
        } else return false;
    }

    ngOnInit(){
        this.themeService.getThemeTreeList();
        this.themeService.getThemeListAll();
    }


    browserSwitcher(){
        this.browserVisible = !this.browserVisible;
    }

    showSearchListReturn() {
        if(this.searchStr.length){
            return (this.search().length)
        }
    }


    deletePickTheme(value){
        if(this.themeService.inInterestingZone) {
            let deleteThis = this.themeService.pickedInterestingInThemes.indexOf(value);
            this.themeService.pickedInterestingInThemes.splice(deleteThis, 1);
        } else if(this.themeService.inExpertZone){
            let deleteThis = this.themeService.pickedExpertInThemes.indexOf(value);
            this.themeService.pickedExpertInThemes.splice(deleteThis, 1);
        }
    }

    pickTheme(value){
        if(this.themeService.inInterestingZone) {
            let canIAdd = true;
            if (this.themeService.pickedInterestingInThemes.length > 0) {
                for (let i = 0; i < this.themeService.pickedInterestingInThemes.length; i++) {
                    if (this.themeService.pickedInterestingInThemes[i] === value) {
                        canIAdd = false; //ToDo: Добавить обработчик/ошибку о том что данная тематика уже выбрана.
                    }
                }
            }
            if (canIAdd) {
                this.themeService.pickedInterestingInThemes.push(value);
                this.searchStr = '';

            }
        } else if(this.themeService.inExpertZone){
            let canIAdd = true;
            if (this.themeService.pickedExpertInThemes.length > 0) {
                for (let i = 0; i < this.themeService.pickedExpertInThemes.length; i++) {
                    if (this.themeService.pickedExpertInThemes[i] === value) {
                        canIAdd = false;
                    }
                }
            }
            if (canIAdd) {
                this.themeService.pickedExpertInThemes.push(value);
                this.searchStr = '';
            }
        }
    }


    checkActiveTheme(theme){
        if(this.selectedTheme) {
            return (theme === this.selectedTheme ||
                    theme.id === this.themeService.themesTree[2].highlightActive ||
                    theme.id === this.themeService.themesTree[3].highlightActive ||
                    theme.id === this.themeService.themesTree[4].highlightActive);
        }
    }

    selectTheme(level, theme){
        this.selectedTheme = theme;


        if(level === 1){
            this.themeService.themesTree[2].themes = this.getChildren(); this.themeService.themesTree[2].highlightActive = theme.id;
            this.themeService.themesTree[3].themes = []; this.themeService.themesTree[3].highlightActive = 0;
            this.themeService.themesTree[4].themes = []; this.themeService.themesTree[4].highlightActive = 0;
        } else if(level === 2){
            this.themeService.themesTree[3].themes = this.getChildren(); this.themeService.themesTree[3].highlightActive = theme.id;
            this.themeService.themesTree[4].themes = []; this.themeService.themesTree[4].highlightActive = 0;
        } else if(level === 3){
            this.themeService.themesTree[4].themes = this.getChildren(); this.themeService.themesTree[4].highlightActive = theme.id;
        }
    }

    getChildren(){
        if(this.selectedTheme) {
            if (this.selectedTheme.children.length > 0){
                return this.selectedTheme.children;
            }
        }
    }


    search(){
        let results = [];

        for(let i = 0; i < this.themeService.themes.length; i++){
            if(this.themeService.themes[i].title.toLowerCase().indexOf(this.searchStr.toLowerCase())!=-1){
                results.push(this.themeService.themes[i])
            }
        }

        return results
    }
}

