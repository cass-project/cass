import {Component} from "angular2/core";
import {RouteConfig, ROUTER_DIRECTIVES} from "angular2/router";
import {Nothing} from "../util/component/Nothing/index";
import {ColorPickerDemo} from "./demo/ColorPickerDemo/index";

@Component({
    template: require('./template.jade'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})
@RouteConfig([
    {
        name: 'Index',
        path: '/',
        useAsDefault: true,
        component: Nothing
    },
    {
        name: 'ColorPickerDemo',
        path: '/color-picker',
        component: ColorPickerDemo
    }
])
export class HtmlComponent
{
}