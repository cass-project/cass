import {Injectable} from 'angular2/core';
import {ThemeRESTService, Theme} from "../../theme/service/ThemerRESTService";

@Injectable()
export class ThemeEditorService
{
    constructor(public themeRESTService: ThemeRESTService) {}

    public createThree(themes: Theme[], parentId: number = null) {

    }
}