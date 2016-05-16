import {Component, EventEmitter,Output} from "angular2/core";
import {ThemeService} from "../../service/ThemeService";



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
export class ThemeSelect
{
    constructor(private themeService: ThemeService){}


    themes;
    themesTree = [
        {level: 0, themes: [], highlightActive: 0},
        {level: 1, themes: [], highlightActive: 0},
        {level: 2, themes: [], highlightActive: 0},
        {level: 3, themes: [], highlightActive: 0},
        {level: 4, themes: [], highlightActive: 0}];
    themesTreeTmp;

    selectedTheme;
    pickedThemes = [];

    searchStr: string = '';
    browserVisible: boolean = false;


    ngOnInit(){
        this.getAllThemes();
        this.getTreeThemes();
    }

    browserSwitcher(){
        this.browserVisible = !this.browserVisible;
    }

    showSearchListReturn() {
        if(this.searchStr.length){
            return (this.search().length)
        }
    }

    getTreeThemes(){
        this.themeService.getThemeTreeList().subscribe(data => {
            this.themesTreeTmp = data;
            this.themesTree[0].themes = JSON.parse(this.themesTreeTmp._body).entities;
            this.themesTree[1].themes = this.themesTree[0].themes[0].children;
        })
    }


    getAllThemes(){
        this.themeService.getThemeListAll().subscribe(data => {
            this.themes = data;
            this.themes = JSON.parse(this.themes._body).entities;
        });
    }

    deletePickTheme(value){
        let deleteThis = this.pickedThemes.indexOf(value);
        this.pickedThemes.splice(deleteThis, 1);
    }

    pickTheme(value){
        let canIAdd = true;
        if(this.pickedThemes.length > 0) {
            for(let i = 0; i < this.pickedThemes.length; i++){
                if(this.pickedThemes[i] === value){
                    canIAdd = false;
                }
            }
        }
        if(canIAdd){
            this.pickedThemes.push(value);
        }
    }


    checkActiveTheme(theme){
        if(this.selectedTheme) {
            return (theme === this.selectedTheme ||
                    theme.id === this.themesTree[2].highlightActive ||
                    theme.id === this.themesTree[3].highlightActive ||
                    theme.id === this.themesTree[4].highlightActive);
        }
    }

    selectTheme(level, theme){
        this.selectedTheme = theme;


        if(level === 1){
            this.themesTree[2].themes = this.getChildren(); this.themesTree[2].highlightActive = theme.id;
            this.themesTree[3].themes = []; this.themesTree[3].highlightActive = 0;
            this.themesTree[4].themes = []; this.themesTree[4].highlightActive = 0;
        } else if(level === 2){
            this.themesTree[3].themes = this.getChildren(); this.themesTree[3].highlightActive = theme.id;
            this.themesTree[4].themes = []; this.themesTree[4].highlightActive = 0;
        } else if(level === 3){
            this.themesTree[4].themes = this.getChildren(); this.themesTree[4].highlightActive = theme.id;
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

        for(let i = 0; i < this.themes.length; i++){
            if(this.themes[i].title.toLowerCase().indexOf(this.searchStr.toLowerCase())!=-1){
                results.push(this.themes[i])
            }
        }

        return results
    }
}

