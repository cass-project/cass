import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {Component, Injectable} from 'angular2/core';
import {CORE_DIRECTIVES} from "angular2/common";
import {ThemeService} from "../../service/ThemeService";

@Component({
    template: require('./template.html'),
    'providers': [
    ],
    selector: 'theme-selector',
    directives: [
        ROUTER_DIRECTIVES
    ]
})

export class ThemeSelector{

    constructor(public themeService: ThemeService){};

    MultipleChoise: boolean = true;
    searchStr: string = '';


    onMultipleChoise(){
        this.MultipleChoise = true;
    }

    offMultipleChoise(){
        this.MultipleChoise = false;
    }


    deleteSelector(theme){
        if(this.MultipleChoise) {
            let deleteThis = this.themeService.selectedThemes.indexOf(theme);
            this.themeService.selectedThemes.splice(deleteThis, 1);
        } else {
            this.themeService.selectedThemes = [];
        }
    }

    addSelector(theme){
        if(this.MultipleChoise) {
            this.themeService.selectedThemes.push(theme);
        } else {
            this.themeService.selectedThemes = [];
            this.themeService.selectedThemes.push(theme);
        }
    }

    showSelector(){
        if(this.searchStr){
            return true;
        }
    }

    search(){
        let results = [];

        for(let i = 0; i < this.themeService.getThemeSelectOptions().length; i++){
            if (this.themeService.getThemeSelectOptions()[i].title.toLowerCase().indexOf(this.searchStr.toLowerCase())!=-1){
                results.push(this.themeService.getThemeSelectOptions()[i])
            }
        }
        return results
    }
}