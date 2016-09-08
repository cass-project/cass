import {NgModule}       from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from "@angular/http";
import {App}   from './app.component';
import {routing, appRoutingProviders} from "./app.routing";


@NgModule({
    declarations: [App],
    imports: [
        BrowserModule,
        routing,
        FormsModule, 
        ReactiveFormsModule,
        HttpModule
    ],
    providers: [
        appRoutingProviders
    ],
    bootstrap: [App],
})

export class AppModule {}

