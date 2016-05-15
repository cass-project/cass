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
    searchStr: string = '';
    tmpSearchStr: string = '';
    listVisibleByClick: boolean = false;

    ngOnInit(){
        this.getAllThemes();
    }

    showListByClick(){
        this.listVisibleByClick = !this.listVisibleByClick;
        this.tmpSearchStr = this.searchStr;
    }

    showListReturn(){
        if(this.searchStr && this.tmpSearchStr != this.searchStr){
            return true;
        } else if(this.listVisibleByClick === true){
            return true;
        } else {
            return false;
        }
    }


    getAllThemes(){
        this.themeService.getThemeListAll().subscribe(data => {
            this.themes = data;
            this.themes = JSON.parse(this.themes._body).entities;
        });
    }

    /*ToDo: Когда Theme API будет добавлено сделать нормальное отображение активного селекта через [class.active]*/
    checkActiveTheme(themeId){
        return themeId
    }

    /*ToDo: Когда Theme API будет добавлено сделать нормальный селект*/
    selectTheme(themeId){
        console.log(themeId);
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

