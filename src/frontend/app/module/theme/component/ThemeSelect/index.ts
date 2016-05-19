import {Component, EventEmitter,Output} from "angular2/core";
import {ThemeService} from "../../service/ThemeService";
import {Injectable} from 'angular2/core';


@Component({
    selector: 'cass-theme-select',
    template: require('./template.html'),
    'providers': [
        ThemeService
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})
@Injectable()
export class ThemeSelect
{
    constructor(private themeService: ThemeService){console.log('test')}


    selectedTheme;
    pickedInterestingInThemes = [];
    pickedExpertInThemes = [];

    inInterestingZone: boolean = true; //Usage: Так как мы стартуем во вкладке "Интересы" данная бул переменная будет true; ToDO: Обсудить с Димой.
    inExpertZone: boolean = false;


    searchStr: string = '';
    browserVisible: boolean = false;


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
        if(this.inInterestingZone) {
            let deleteThis = this.pickedInterestingInThemes.indexOf(value);
            this.pickedInterestingInThemes.splice(deleteThis, 1);
        } else if(this.inExpertZone){
            let deleteThis = this.pickedExpertInThemes.indexOf(value);
            this.pickedExpertInThemes.splice(deleteThis, 1);
        }
    }

    pickTheme(value){
        if(this.inInterestingZone) {
            let canIAdd = true;
            if (this.pickedInterestingInThemes.length > 0) {
                for (let i = 0; i < this.pickedInterestingInThemes.length; i++) {
                    if (this.pickedInterestingInThemes[i] === value) {
                        canIAdd = false; //ToDo: Добавить обработчик/ошибку о том что данная тематика уже выбрана.
                    }
                }
            }
            if (canIAdd) {
                this.pickedInterestingInThemes.push(value);
                this.searchStr = '';
            }
        } else if(this.inExpertZone){
            let canIAdd = true;
            if (this.pickedExpertInThemes.length > 0) {
                for (let i = 0; i < this.pickedExpertInThemes.length; i++) {
                    if (this.pickedExpertInThemes[i] === value) {
                        canIAdd = false;
                    }
                }
            }
            if (canIAdd) {
                this.pickedExpertInThemes.push(value);
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

