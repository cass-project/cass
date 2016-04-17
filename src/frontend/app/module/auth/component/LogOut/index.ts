import {Component} from 'angular2/core';
import {Router} from 'angular2/router';
import {AuthService} from './../../service/AuthService';

@Component({
    template: require('./template.html')
})


export class LogOutComponent
{
    constructor(public authService: AuthService, private router: Router) {}

    ngOnInit() {
        this.authService.signOut().add(() => {
            this.router.navigate(['/Catalog']);
        });
    }
}