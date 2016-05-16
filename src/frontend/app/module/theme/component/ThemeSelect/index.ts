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
    themesTree;
    themesTreeSecondEmbedded;
    themesTreeThirdEmbedded;
    themesTreeFourthEmbedded;

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
        return (this.searchStr.length > 0);
    }

    getTreeThemes(){
        this.themeService.getThemeTreeList().subscribe(data => {
            this.themesTree = data;
            this.themesTree = JSON.parse(this.themesTree._body).entities;
            this.themesTree = this.themesTree[0].children;
        })
    }


    getAllThemes(){
        this.themeService.getThemeListAll().subscribe(data => {
            this.themes = data;
            this.themes = JSON.parse(this.themes._body).entities;
        });
    }

    deletePickTheme(theme){
        let deleteThis = this.pickedThemes.indexOf(theme);
        this.pickedThemes.splice(deleteThis, 1);
    }

    pickTheme(theme){
        this.pickedThemes.push(theme);
    }


    /*ToDo: Дописать checkActiveTheme*/
    checkActiveTheme(theme){
        if(this.selectedTheme) {
            return (theme === this.selectedTheme);
        }
    }

    selectTheme(embedded, theme){
        this.selectedTheme = theme;

        if(embedded === 1){
            this.themesTreeSecondEmbedded = this.getChildren();
            this.themesTreeThirdEmbedded = [];
            this.themesTreeFourthEmbedded = [];
        } else if(embedded === 2){
            this.themesTreeThirdEmbedded = this.getChildren();
            this.themesTreeFourthEmbedded = [];
        } else if(embedded === 3){
            this.themesTreeFourthEmbedded = this.getChildren();
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

