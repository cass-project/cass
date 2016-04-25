import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {Component, Injectable} from 'angular2/core';
import {CORE_DIRECTIVES} from "angular2/common";
import {ThemeService} from "../../service/ThemeService";

@Component({
    template: require('./template.html'),
    'providers': [
    ],
    directives: [
        ROUTER_DIRECTIVES
    ]
})

export class ThemeSelector{

    constructor(public themeService: ThemeService){};

    selectedThemes = [];
    searchStr: string = '';



    deleteSelector(theme){
        let deleteThis = this.selectedThemes.indexOf(theme);
        this.selectedThemes.splice(deleteThis, 1);
    }

    addSelector(theme){
        this.selectedThemes.push(theme);
        console.log(this.selectedThemes);
    }

    showSelector(){
        if(this.searchStr){
            return true
        }
    }

    search(){
        let results = [];

        for(let i = 0; i < this.themeService.themes.length; i++){
            if (this.themeService.themes[i].title.toLowerCase().indexOf(this.searchStr.toLowerCase())!=-1){
                results.push(this.themeService.themes[i])
            }
        }
        return results
    }
}