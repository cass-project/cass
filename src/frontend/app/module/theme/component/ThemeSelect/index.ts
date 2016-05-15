import {Component, EventEmitter,Output} from "angular2/core";

@Component({
    selector: 'cass-theme-select',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemeSelect
{
    searchStr: string = '';
    tmpSearchStr: string = '';
    listVisibleByClick: boolean = false;

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


        return results
    }

}

