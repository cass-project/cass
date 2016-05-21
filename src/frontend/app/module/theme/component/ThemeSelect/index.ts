import {Component, EventEmitter, Output, Input, ViewChild, ElementRef} from "angular2/core";
import {ThemeService} from "../../service/ThemeService";
import {Injectable} from 'angular2/core';
import {ControlValueAccessor} from "angular2/common";
import {ThemeTree} from "../../entity/Theme";


@Component({
    selector: 'cass-theme-select',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Injectable()

export class ThemeSelect {
    private browser:ThemeSelectBrowser = new ThemeSelectBrowser(this, this.service);
    private search:ThemeSelectSearch = new ThemeSelectSearch(this, this.service);

    @ViewChild('searchInput') searchInput:ElementRef;
    @ViewChild('scrolling') scrolling:ElementRef;

    @Input('expertIn') expertIn = [];
    @Input('interestingIn') interestingIn = [];
    @Input('multiple') multiple = "true";
    @Output('change') change = new EventEmitter<Array<number>>();

    constructor(private service:ThemeService) {
        this.browser.scrolling = this.scrolling;
    }


    returnActiveList(value){
        if(this.service.inExpertZone && value == 'expert'){
            this.expertIn = this.service.expertIn;
            console.log(this.expertIn, 'Эксперт');
            return true;
        } else if(this.service.inInterestingZone && value == 'interesting'){
            this.interestingIn = this.service.interestingIn;
            console.log(this.interestingIn, 'Интересуется');
            return true;
        }
    }

    isMultiple():boolean {
        return this.multiple === "1" || this.multiple === "true";
    }

    has(themeId:number) {
        if (this.service.inExpertZone) {
            return ~this.expertIn.indexOf(themeId);
        } else if (this.service.inInterestingZone) {
            return ~this.interestingIn.indexOf(themeId)
        }

    }

    exclude(themeId:number) {
        if (this.service.inExpertZone) {
            let index = this.service.expertIn.indexOf(themeId);
            if (~index) {
                this.expertIn.splice(index, 1);
                this.change.emit(this.expertIn);
            }
        } else if (this.service.inInterestingZone) {
            let index = this.interestingIn.indexOf(themeId);
            if (~index) {
                this.interestingIn.splice(index, 1);
                this.change.emit(this.interestingIn);
            }
        }
    }

    include(themeId:number) {
        if (this.service.inExpertZone) {
            if (!~this.expertIn.indexOf(themeId)) {
                if (this.isMultiple()) {
                    this.expertIn.push(themeId);
                    this.searchInput.nativeElement.value = '';
                    this.change.emit(this.expertIn);
                } else {
                    this.expertIn = [themeId];
                    this.change.emit(this.expertIn);
                }
            }
            } else if (this.service.inInterestingZone) {
                if (!~this.interestingIn.indexOf(themeId)) {
                    if (this.isMultiple()) {
                        this.interestingIn.push(themeId);
                        this.searchInput.nativeElement.value = '';
                        this.change.emit(this.interestingIn);
                    } else {
                        this.interestingIn = [themeId];
                        this.change.emit(this.interestingIn);
                    }
                }
        }
    }
}

class ThemeSelectSearch
{
    static MAX_RESULTS = 100;

    showThemeSelect: boolean = false;
    enabled: boolean = false;
    results: ThemeTree[] = [];
    lastInput: string;

    constructor(private themeSelect: ThemeSelect, private service: ThemeService) {}
    
    isResultsAvailable(): boolean {
        return this.enabled && (this.results.length > 0);
    }

    update(input: string) {
        this.lastInput = input;

        this.results = this.fetch(input).filter((theme: ThemeTree) => {
            return !this.themeSelect.has(theme.id);
        });
    }

    enable() {
        this.enabled = true;
    }

    disable() {
        this.enabled = false;
    }

    fetch(input: string) {
        var results = [];

        if(input.replace(/\s/g, '').length > 0) {
            this.service.each((theme: ThemeTree) => {
                if(results.length <= ThemeSelectSearch.MAX_RESULTS) {
                    if(~theme.title.toLocaleLowerCase().indexOf(input.toLocaleLowerCase()) && !this.themeSelect.has(theme.id)) {
                        results.push(theme);
                    }
                }
            });
        }
        return results;
    }

    include(theme: ThemeTree) {
        this.themeSelect.include(theme.id);
        this.themeSelect.searchInput.nativeElement.focus();
        this.update(this.lastInput);
    }
}

class ThemeSelectBrowser
{
    public visible: boolean = false;
    public columns: ThemeTree[] = [];
    public scrolling: ElementRef;

    constructor(private themeSelect: ThemeSelect, private service: ThemeService) {
        this.columns.push(service.getRoot());
    }

    isActive(compare: ThemeTree): boolean {
        for(let tree of this.columns) {
            if(tree.id === compare.id) {
                return true;
            }
        }

        return false;
    }
    
    setColumn(level: number, tree: ThemeTree) {
        for(let n = this.columns.length; n > level; n--) {
            this.columns.pop();
        }

        this.columns.push(tree);

        if(level === (this.columns.length - 1)) {
            this.themeSelect.scrolling.nativeElement.scrollLeft = 9999;
        }
    }

    show() {
        this.visible = true;
    }

    hide() {
        this.visible = false;
    }

    toggle() {
        this.visible = !this.visible;
    }
}

interface ThemeSelectBrowserColumn
{
    tree: ThemeTree;
    next?: ThemeSelectBrowserColumn;
}