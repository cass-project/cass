import {Injectable} from "@angular/core";

@Injectable()
export class    UIService
{
    public panels: {
        header: UIPanelControl,
        viewModes: UIPanelControl,
        extended: UIPanelControlExtended,
        themes: UIPanelControl
    } = {
        header: new UIPanelControl('cass.module.ui.header', true),
        viewModes: new UIPanelControl('cass.module.ui.panels.view-modes', true),
        extended: new UIPanelControlExtended('cass.module.ui.panels.extended', UIPanelControlExtendedMode.Extended),
        themes: new UIPanelControl('cass.module.ui.themes', false)
    };
}

export class UIPanelControl
{
    private enabled: boolean;

    constructor(private localStorageKey: string, defaults: boolean = false) {
        if(window.localStorage[localStorageKey] !== undefined) {
            this.enabled = window.localStorage[localStorageKey] === "true";
        }else{
            this.enabled = defaults;
            window.localStorage[this.localStorageKey] = this.enabled;
        }
    }

    isEnabled(): boolean {
        return this.enabled;
    }

    enable() {
        this.enabled = true;
        window.localStorage[this.localStorageKey] = this.enabled;
    }

    disable() {
        this.enabled = false;
        window.localStorage[this.localStorageKey] = this.enabled;
    }

    toggle() {
        this.enabled = !this.enabled;
        window.localStorage[this.localStorageKey] = this.enabled;
    }
}

export class UIPanelControlExtended
{
    private mode: UIPanelControlExtendedMode = UIPanelControlExtendedMode.Small;

    constructor(private localStorageKey: string, private defaults: UIPanelControlExtendedMode) {
        if(window.localStorage[localStorageKey] !== undefined) {
            this.mode = window.localStorage[localStorageKey];
        }else{
            this.mode = defaults;
            window.localStorage[localStorageKey] = this.mode;
        }
    }

    cycle() {
        if(this.isHidden()) {
            this.small();
        }else if(this.isSmall()) {
            this.extended();
        }else {
            this.hide();
        }
    }

    isEnabled(): boolean {
        return this.mode !== UIPanelControlExtendedMode.Hide;
    }

    isHidden(): boolean {
        return this.mode === UIPanelControlExtendedMode.Hide;
    }

    isSmall(): boolean {
        return this.mode === UIPanelControlExtendedMode.Small;
    }

    isExtended(): boolean {
        return this.mode === UIPanelControlExtendedMode.Extended;
    }

    hide() {
        this.mode = UIPanelControlExtendedMode.Hide;
        window.localStorage[this.localStorageKey] = this.mode;
    }

    small() {
        this.mode = UIPanelControlExtendedMode.Small;
        window.localStorage[this.localStorageKey] = this.mode;
    }

    extended() {
        this.mode = UIPanelControlExtendedMode.Extended;
        window.localStorage[this.localStorageKey] = this.mode;
    }
}

export enum UIPanelControlExtendedMode
{
    Hide = <any>"hide",
    Small = <any>"small",
    Extended = <any>"extended"
}