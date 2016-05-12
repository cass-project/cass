import {Component} from "angular2/core";
import {Router} from 'angular2/router';
import {LoadingIndicator} from "../../../util/component/LoadingIndicator/index";
import {OAuth2Component} from "../OAuth2/index";
import {AuthComponentService} from "../Auth/service";
import {AuthService} from "../../service/AuthService";

@Component({
    selector: 'cass-auth-sign-up',
    template: require('./template-stages.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        LoadingIndicator,
        OAuth2Component
    ]
})
export class SignUpComponent
{
    private loading = false;
    private personalInfo = {
        email: '',
        password: '',
        repeat: '',
        remember: false
    };

    constructor(private authService: AuthService, private service: AuthComponentService, private router: Router){}

    attemptSignUp() {
        this.loading = true;
        this.personalInfo.remember = true;

        this.authService.attemptSignUp(this.personalInfo).add(() => {
            if(!this.authService.lastError) {
                this.router.navigate(['/']);
            }

            this.loading = false;
        });
    }

    attemptSignUpNoRemember() {
        this.loading = true;
        this.personalInfo.remember = false;

        this.authService.attemptSignUp(this.personalInfo).add(() => {
            if(!this.authService.lastError) {
                this.router.navigate(['/']);
            }

            this.loading = false;
        });
    }
}