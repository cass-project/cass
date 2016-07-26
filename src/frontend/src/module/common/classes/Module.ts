// Daily reminder: https://docs.google.com/document/d/13-LUm1QvOff2631tHz6C4goIHuMzma2_1_PFiLryoIs/edit

import {RouteDefinition} from "angular2/router";

export class Module
{
    private definition: ModuleDefinition;

    constructor(definition: ModuleDefinition) {
        this.definition = definition;
    }

    decorate(appComponent: ComponentDefinition, routeDefinitions: RouteDefinition[]) {
        if(! appComponent.providers) {
            appComponent.providers = [];
        }

        if(! appComponent.directives) {
            appComponent.directives = [];
        }

        appComponent.providers.push(this.getRESTServices());
        appComponent.providers.push(this.getProviders());
        appComponent.directives.push(this.getDirectives());
        
        if(this.getRoutes().length) {
            for(let route of this.getRoutes()) {
                routeDefinitions.push(route);
            }
        }
    }

    getProviders(): Array<any> {
        return this.definition.providers || [];
    }

    getRESTServices(): Array<any> {
        return this.definition.RESTServices || [];
    }

    getDirectives(): Array<any> {
        return this.definition.directives || [];
    }

    getRoutes(): RouteDefinition[] {
        return this.definition.routes || [];
    }
}

interface ModuleDefinition {
    name: string;
    RESTServices?: Array<any>;
    providers?: Array<any>;
    directives?: Array<any>;
    routes?:  RouteDefinition[];
}

interface ComponentDefinition {
    selector?: string;
    inputs?: string[];
    outputs?: string[];
    properties?: string[];
    events?: string[];
    host?: {
        [key: string]: string;
    };
    bindings?: any[];
    providers?: any[];
    directives?: any[];
    exportAs?: string;
    queries?: {
        [key: string]: any;
    };
}