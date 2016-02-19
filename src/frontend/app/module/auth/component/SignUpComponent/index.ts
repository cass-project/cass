import {Component} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';

@Component({
    template: require('./template.html')
})

export class SignUpComponent{
    email:string;
    phone:string;
    password:string;
    passwordAgain:string;

    constructor(private http: Http) {}

    attemptSignUp(){
        let args = new URLSearchParams();
        if(this.email) args.set('email', this.email);
        if(this.phone) args.set('phone', this.phone);
        args.set('password', this.password);
        args.set('passwordAgain', this.passwordAgain);

        this.http.get('/backend/api/auth/sign-up', {search: args})
            .map(res => res.json())
            .subscribe(
                data => function(data){console.log(data)},
                err => function(data){console.log(data)},
                () => function(data){console.log(data)}
            );

    }

}